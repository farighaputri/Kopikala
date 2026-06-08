<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class CartController extends Controller
{
    public function index()
    {
        // ambil cart dari session
        $cart = session()->get('cart', []);

        // ambil semua cabang
        $branches = Branch::all();

        // subtotal
        $subtotal = 0;

        foreach ($cart as $item) {

            $subtotal +=
                $item['price'] * $item['qty'];
        }

        return view(
            'frontend.cart',
            compact(
                'cart',
                'branches',
                'subtotal'
            )
        );
    }

    public function updateBranch(Request $request)
    {
        session([
            'selected_branch' => $request->branch_id
        ]);

        return back();
    }

    public function updateQty(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->cart_id;

        if (isset($cart[$id])) {

            $cart[$id]['qty'] =
                $request->qty;

            // hapus kalau qty <= 0
            if ($cart[$id]['qty'] <= 0) {

                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true
        ]);
    }
  public function addToCart(Request $request)
{
    $cart = session()->get('cart', []);

    $cartId = md5(
        $request->product_id .
        json_encode($request->options ?? [])
    );

    if (isset($cart[$cartId])) {

        $cart[$cartId]['qty'] += (int) $request->qty;

    } else {

        $cart[$cartId] = [
            'id'         => $cartId,
            'product_id' => $request->product_id,
            'name'       => $request->name,
            'price'      => $request->price,
            'qty'        => (int) $request->qty,
            'image'      => $request->image,
            'options'    => $request->options ?? []
        ];
    }

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'cart_count' => collect($cart)->sum('qty')
    ]);
}
}