<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionsExport;
use App\Models\Product;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    /* ================= EXPORT ================= */

    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }

    public function exportPdf()
    {
        $transactions = Transaction::with('branch')->latest()->get();

        $pdf = Pdf::loadView('transactions.index-pdf', compact('transactions'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('transactions.pdf');
    }

    /* ================= FRONTEND ================= */

    public function createFrontend()
    {
        $products = Product::where('status', 1)->latest()->get();
        $branches = Branch::all();

        return view('frontend.order', compact('products', 'branches'));
    }

    public function storeFrontend(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'items' => 'required|array|min:1',
            'total' => 'required|numeric|min:0',
            'branch_id' => 'required|exists:branches,id',
        ]);

     
        $pickupCode = $this->generatePickupCode($validated['branch_id']);
$transaction = Transaction::create([
    'user_id' => auth()->id(),
    'order_id' => 'ORD-' . now()->format('YmdHis') . '-' . rand(100, 999),

    'customer_name' => $validated['customer_name'],
    'email' => $validated['email'],
    'phone' => $validated['phone'],

    'items' => $validated['items'],
    'quantity' => collect($validated['items'])->sum('qty'),
    'total' => $validated['total'],
    'status' => 'Waiting Confirmation',
    'branch_id' => $validated['branch_id'],

    'pickup_code' => $pickupCode,
]);
foreach ($validated['items'] as $item) {

    TransactionDetail::create([
        'transaction_id' => $transaction->id,

        'product_id' => $item['product_id'],

        'qty' => $item['qty'],

        'price' => $item['price'],

        'subtotal' => $item['qty'] * $item['price']
    ]);
}

        return response()->json([
            'status' => true,
            'message' => 'Order berhasil dibuat',
            'order_id' => $transaction->order_id,
            'pickup_code' => $transaction->pickup_code,
        ]);
    }

    public function confirmation($order_id)
    {
        $order = Transaction::where('order_id', $order_id)->firstOrFail();

        $items = $order->items;

        if (is_string($items)) {
            $items = json_decode($items, true);
        }

        return view('frontend.confirmation', compact('order', 'items'));
    }

    public function orderDetail($id)
    {
        $transaction = Transaction::with([
    'branch',
    'details.product'
])->findOrFail($id);

        $items = $transaction->items;

        if (is_string($items)) {
            $items = json_decode($items, true);
        }

        if (!$items) {
            $items = [];
        }

        return view('frontend.orders.order_detail', compact('transaction', 'items'));
    }
    public function downloadReceipt($id)
{
    $transaction = Transaction::with('branch')
        ->findOrFail($id);

    $items = $transaction->items;

    if (is_string($items)) {
        $items = json_decode($items, true);
    }

    if (!$items) {
        $items = [];
    }

    return view(
        'frontend.orders.receipt',
        compact('transaction', 'items')
    );
}

    /* ================= BACKEND ================= */

    public function index()
    {
        $transactions = Transaction::with('branch')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function show($order_id)
    {
        $transaction = Transaction::with(['branch', 'customerPhotos'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        $items = $transaction->items;

        if (is_string($items)) {
            $items = json_decode($items, true);
        }

        return view('transactions.detail', compact('transaction', 'items'));
    }

    public function updateStatus(Request $request, $order_id)
    {
        $request->validate([
            'status' => 'required|in:Waiting Confirmation,Order Confirmed,Order Ready,Order Finished'
        ]);

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();
        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status updated');
    }

    /* ================= CABANG ================= */

    public function djuandaTransactions()
    {
        $branch = Branch::where('branch_name', 'djuanda')->firstOrFail();

        $transactions = Transaction::with('branch')
            ->where('branch_id', $branch->id)
            ->latest()
            ->get();

        return view('djuanda.transaction', compact('transactions', 'branch'));
    }

    public function semeruTransactions()
    {
        $branch = Branch::where('branch_name', 'semeru')->firstOrFail();

        $transactions = Transaction::with('branch')
            ->where('branch_id', $branch->id)
            ->latest()
            ->get();

        return view('semeru.transaction', compact('transactions', 'branch'));
    }

    public function destroy($id)
    {
        $trx = Transaction::findOrFail($id);
        $trx->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction successfully deleted!');
    }

    /* ================= PESANAN SAYA ================= */

    public function myOrders()
    {
        $email = null;

        if (auth()->check()) {
            $email = auth()->user()->email;
        } elseif (session()->has('staff')) {
            $staffId = session('staff.id');
            $staff = \App\Models\Staff::find($staffId);
            $email = $staff ? $staff->email : null;
        }

        if (!$email) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $transactions = Transaction::with('branch')
            ->whereRaw('LOWER(email) = ?', [strtolower(trim($email))])
            ->whereIn('status', [
                'Waiting Confirmation',
                'Order Confirmed',
                'Order Ready',
                'Order Finished'
            ])
            ->latest()
            ->get();

        $branches = Branch::all();

return view('frontend.orders.my', compact(
    'transactions',
    'branches'
));
    }

    /* ================= API CHECK STATUS ================= */

    public function checkStatus($order_id)
    {
        $transaction = Transaction::where('order_id', $order_id)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'status' => $transaction->status
        ]);
    }

    /* ================= PICKUP CODE GENERATOR ================= */

   private function generatePickupCode($branch_id)
{
    $code = 'KOPIKALA-' .
            $branch_id . '-' .
            now()->format('Hi');

    return $code;
}
}