<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\TransactionDetail;
use App\Models\Product;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1 - REVIEW PESANAN
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $cart = session()->get('cart', []);

        $branches = Branch::all();

        return view(
            'frontend.payment.payment1',
            compact('cart', 'branches')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2 - DATA DIRI
    |--------------------------------------------------------------------------
    */
    public function data()
{
    $cart = session()->get('cart', []);

    $branches = Branch::all();

    return view(
        'frontend.payment.data',
        compact('cart', 'branches')
    );
}

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA DIRI
    |--------------------------------------------------------------------------
    */
    public function storeData(Request $request)
    {
        $request->validate([

            'name'  => 'required',
            'email' => 'required|email',
            'phone' => 'required',

        ]);

        session([
            'customer_data' => [

                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,

            ]
        ]);

        return redirect()->route('payment.method');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 - PEMBAYARAN
    |--------------------------------------------------------------------------
    */
   public function method()
{
    $cart = session()->get('cart', []);

    $branches = Branch::all();

    $customer =
        session()->get('customer_data');

    $subtotal = 0;

    foreach($cart as $item){

        $subtotal +=
            $item['price'] * $item['qty'];
    }

    \Midtrans\Config::$serverKey =
        config('midtrans.server_key');

    \Midtrans\Config::$isProduction =
        config('midtrans.is_production');

    \Midtrans\Config::$isSanitized = true;

    \Midtrans\Config::$is3ds = true;

    $params = [

        'transaction_details' => [

            'order_id' => 'KOPI-' . date('YmdHis'),

            'gross_amount' => $subtotal,

        ],

        'customer_details' => [

            'first_name' =>
                $customer['name'] ?? 'Customer',

            'email' =>
                $customer['email'] ?? 'customer@gmail.com',

            'phone' =>
                $customer['phone'] ?? '08123456789',

        ]

    ];

    $snapToken =
        \Midtrans\Snap::getSnapToken($params);

    return view(
        'frontend.payment.payment3',
        compact(
            'cart',
            'branches',
            'customer',
            'snapToken'
        )
    );
}
public function success(Request $request)
{
    // Mencatat data kiriman Midtrans ke storage/logs/laravel.log untuk kebutuhan debug
    \Log::info('SUCCESS HIT', $request->all());

    $cart = session()->get('cart', []);
    $customer = session()->get('customer_data');

    // Menangkap detail transaksi dari payload objek respon Midtrans Snap secara presisi
    $midtransOrderId = $request->input('order_id');
    
    // Fallback: Midtrans terkadang mengirim nilai gross_amount sebagai string / integer langsung
    $subtotal = $request->input('gross_amount');

    // Perbaikan typo fatal pada namespace Str
    if (!$midtransOrderId) {
        $midtransOrderId = 'ORD-' . strtoupper(\Illuminate\Support\Str::random(8));
    }

    // Jika gross_amount dari request tidak terbaca/kosong, hitung dari isi Cart atau ambil default session
    if (!$subtotal || $subtotal <= 0) {
        $subtotal = !empty($cart) ? collect($cart)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['qty'] ?? 0);
        }) : 0;
    }

    // 1. Antisipasi jika data keranjang kosong (misal akibat timeout session saat proses bayar)
    if (empty($cart)) {
        $cart = [
            [
                'id' => 1,
                'name' => 'Menu Pesanan Coffee Shop',
                'price' => (int)$subtotal,
                'qty' => 1
            ]
        ];
    }

    try {
        // 2. Tentukan ID Cabang (Branch ID) secara aman. 
        // Pastikan default value (angka 1) adalah ID yang benar-benar ada di tabel branches database Anda
        $branchId = session('selected_branch') ?? session('selected_branch_id') ?? 1;

        // 3. Eksekusi penyimpanan data ke tabel transactions
        $transaction = Transaction::create([
            'order_id'      => $midtransOrderId, 
            'customer_name' => $customer['name'] ?? 'Guest Customer',
            'email'         => $customer['email'] ?? 'customer@mail.com',
            'phone'         => $customer['phone'] ?? '-',
            'quantity'      => collect($cart)->sum('qty'),
            'status'        => 'Order Confirmed', // Pastikan status ini ada di enum migrasi database Anda
            'total'         => (int)$subtotal,
            'items'         => $cart, // Array akan otomatis diubah ke JSON oleh model cast
            'branch_id'     => $branchId, 
            'location'      => null,
        ]);
       foreach ($cart as $item) {

    $product = Product::find($item['product_id'] ?? null);

    if (!$product) {
        continue;
    }

    TransactionDetail::create([
        'transaction_id' => $transaction->id,
        'product_id'     => $product->id,
        'qty'            => $item['qty'] ?? 1,
        'price'          => $item['price'] ?? $product->price,
        'subtotal'       => ($item['qty'] ?? 1) * ($item['price'] ?? $product->price),
    ]);
}
        // 4. Bersihkan Sesi setelah data sukses tersimpan di database
        session()->forget('cart');
        session()->forget('customer_data');
        session()->forget('selected_branch');

        return response()->json([
            'success'  => true,
            'redirect' => route('orders.my'),
            'message'  => 'Transaksi berhasil disimpan ke database.'
        ], 200);

    } catch (\Exception $e) {
        // Mencatat error spesifik MySQL ke file log proyek Anda
        \Log::error('GAGAL SIMPAN DATABASE: ' . $e->getMessage());

        // Mengembalikan pesan error SQL asli ke browser Anda agar kelihatan bagian mana yang ditolak DB
        return response()->json([
            'success' => false,
            'message' => 'Gagal simpan di DB. Detail: ' . $e->getMessage()
        ], 500);
    }
}
}