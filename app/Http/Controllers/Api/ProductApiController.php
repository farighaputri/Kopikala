<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        // Ambil hanya produk yang available
        $products = Product::where('status', 'available')->get();

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }
}
