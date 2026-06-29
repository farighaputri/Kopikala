<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * GET /api/transactions
     */
    public function index()
    {
        $transactions = Transaction::with('branch')->latest()->get();

        return response()->json([
            'status' => true,
            'transactions' => $transactions->map(function ($t) {
                return [
                    'order_id' => $t->order_id,
                    'pickup_code' => $t->pickup_code,
                    'customer_name' => $t->customer_name,
                    'email' => $t->email,
                    'phone' => $t->phone,
                    'quantity' => $t->quantity,
                    'status' => $t->status,
                    'branch_name' => $t->branch ? $t->branch->branch_name : '-', 
                    'location' => $t->branch
                        ? $t->branch->branch_name . ' - ' . $t->branch->location
                        : ($t->location ?? '-'),
                    'total' => $t->total,
                    'items' => is_string($t->items) ? json_decode($t->items, true) : $t->items,
                    'created_at' => $t->created_at->toIso8601String(),
                    'time' => $t->created_at->format('d/m/Y H:i'),
                ];
            })
        ], 200);
    }

    /**
     * GET /api/transactions/{order_id}
     */
    public function show($order_id)
    {
        $t = Transaction::with('branch')
            ->where('order_id', $order_id)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => [
                'order_id' => $t->order_id,
                'pickup_code' => $t->pickup_code,
                'customer_name' => $t->customer_name,
                'email' => $t->email,
                'phone' => $t->phone,
                'status' => $t->status,
                'total' => $t->total,
                'branch_name' => $t->branch ? $t->branch->branch_name : '-', 
                'location' => $t->branch
                    ? $t->branch->branch_name . ' - ' . $t->branch->location
                    : ($t->location ?? '-'),
                'items' => is_string($t->items) ? json_decode($t->items, true) : $t->items,
                'created_at' => $t->created_at->toIso8601String(),
            ]
        ], 200);
    }

    /**
     * POST /api/transactions
     */
    public function store(Request $request)
    {
        // Konversi string JSON jika masuk dari Flutter
        if (is_string($request->items)) {
            $request->merge([
                'items' => json_decode($request->items, true)
            ]);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'items' => 'required|array|min:1',
            'total' => 'required|numeric|min:0',
            'branch_id' => 'nullable|exists:branches,id',
            'location' => 'nullable|string|max:100',
        ]);

        $quantity = count($validated['items']);
        $branchId = $validated['branch_id'] ?? 1;

        $pickupCode = 'KOPIKALA-' . $branchId . '-' . now()->format('Hi');

        $transaction = Transaction::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(6)),
            'pickup_code' => $pickupCode,
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'quantity' => $quantity,
            'items' => json_encode($validated['items']), 
            'total' => $validated['total'],
            'branch_id' => $branchId,
            'location' => $validated['location'] ?? null,
            'status' => 'Waiting Confirmation',
        ]);

        $transaction->load('branch');

        
        $responseData = [
            'order_id' => $transaction->order_id,
            'pickup_code' => $transaction->pickup_code,
            'customer_name' => $transaction->customer_name,
            'status' => $transaction->status,
            'total' => $transaction->total,
            'branch_name' => $transaction->branch ? $transaction->branch->branch_name : 'Kopikala Semeru',
            'items' => $validated['items'], 
            'created_at' => $transaction->created_at->toIso8601String(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Transaction created successfully',
            'data' => $responseData
        ], 201);
    }

    /**
     * UPDATE STATUS
     */
    public function update(Request $request, $order_id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();

        $transaction->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaction status updated successfully'
        ], 200);
    }

    /**
     * CONFIRMATION PAGE (WEB BLADE)
     */
    public function confirmation($order_id)
    {
        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();
        $items = json_decode($transaction->items, true);

        return view('frontend.confirmation', compact('transaction', 'items'));
    }

    /**
     * POST /api/transactions/{order_id}/cancel
     */
    public function cancelTransaction($order_id)
    {
        $transaction = Transaction::where('order_id', $order_id)->first();

        if (!$transaction) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        if ($transaction->status !== 'Waiting Confirmation') {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan tidak dapat dibatalkan karena sudah diproses oleh Barista.'
            ], 400);
        }

        $transaction->update([
            'status' => 'Canceled'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pesanan berhasil dibatalkan.',
            'data' => [
                'order_id' => $transaction->order_id,
                'status' => 'Canceled',
                'updated_at' => $transaction->updated_at->toIso8601String() 
            ]
        ], 200);
    }

    /**
     * GET /api/my-orders?email=user@example.com
     */
    public function myOrders(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json([
                'status' => false,
                'message' => 'Email parameter is required.'
            ], 400);
        }

        $transactions = Transaction::with('branch')
            ->whereRaw('LOWER(email) = ?', [strtolower(trim($email))])
            ->whereIn('status', [
                'Waiting Confirmation',
                'Order Confirmed',
                'Order Ready',
                'Order Finished',
                'Canceled'
            ])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $transactions->map(function ($t) {
                return [
                    'order_id' => $t->order_id,
                    'pickup_code' => $t->pickup_code,
                    'customer_name' => $t->customer_name,
                    'email' => $t->email,
                    'phone' => $t->phone,
                    'quantity' => $t->quantity,
                    'status' => $t->status,
                    'branch_name' => $t->branch ? $t->branch->branch_name : 'Kopikala Semeru',
                    'location' => $t->branch 
                        ? $t->branch->branch_name . ' - ' . $t->branch->location 
                        : ($t->location ?? '-'),
                    'total' => $t->total,
                    'items' => is_string($t->items) ? json_decode($t->items, true) : $t->items,
                    'created_at' => $t->created_at->toIso8601String(),
                    'updated_at' => $t->updated_at->toIso8601String(),
             ];
            })
        ], 200);
    }
} 