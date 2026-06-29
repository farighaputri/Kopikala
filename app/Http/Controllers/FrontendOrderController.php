<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Branch;

class FrontendOrderController extends Controller
{
    public function index()
    {
        // Ambil semua produk aktif beserta relasi customizations dan options
        $products = Product::with([
            'customizations' => function ($query) {
                $query->with('options');
            }
        ])
        ->where('status', 1)
        ->get();

        // Ambil cabang pertama
        $branch = Branch::first();

        return view('frontend.order', [
            'products' => $products,
            'branch'   => $branch,
        ]);
    }
   public function pesananSaya()
{
    // Ambil customer yang sedang login
    $customer = auth()->guard('customer')->user();

    // Jika belum login, arahkan ke halaman login
    if (!$customer) {
        return redirect()->route('login');
    }

    // Ambil transaksi milik customer yang sudah berhasil dibayar
    $transactions = \App\Models\Transaction::with('branch')
        ->where('customer_id', $customer->id)
        ->whereIn('payment_status', ['paid', 'settlement', 'capture'])
        ->latest()
        ->get();

    // Ambil semua branch
    $branches = Branch::all();

    return view('frontend.pesanan', compact(
        'transactions',
        'branches'
    ));
}
}