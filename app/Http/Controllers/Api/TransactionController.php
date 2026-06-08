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
                    'pickup_code' => $t->pickup_code, // 🔥 ADDED
                    'customer_name' => $t->customer_name,
                    'email' => $t->email,
                    'phone' => $t->phone,
                    'quantity' => $t->quantity,
                    'status' => $t->status,
                    'location' => $t->branch
                        ? $t->branch->branch_name . ' - ' . $t->branch->location
                        : ($t->location ?? '-'),
                    'total' => $t->total,
                    'items' => json_decode($t->items, true),
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
                'pickup_code' => $t->pickup_code, // 🔥 ADDED
                'customer_name' => $t->customer_name,
                'email' => $t->email,
                'phone' => $t->phone,
                'status' => $t->status,
                'total' => $t->total,
                'location' => $t->branch
                    ? $t->branch->branch_name . ' - ' . $t->branch->location
                    : ($t->location ?? '-'),
                'items' => json_decode($t->items, true),
            ]
        ], 200);
    }

    /**
     * POST /api/transactions
     */
   public function store(Request $request)
{
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

        // 🔥 FIX PENTING INI
        'items' => json_encode($validated['items']),

        'total' => $validated['total'],
        'branch_id' => $branchId,
        'location' => $validated['location'] ?? null,
        'status' => 'Waiting Confirmation',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Transaction created successfully',
        'data' => $transaction
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
     * CONFIRMATION PAGE
     */
    public function confirmation($order_id)
    {
        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();
        $items = json_decode($transaction->items, true);

        return view('frontend.confirmation', compact('transaction', 'items'));
    }
}