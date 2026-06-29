<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
       
        $query = Product::where('status', 1);

        
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $products = $query->latest()->get();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'desc' => $product->description ?? '',
                'price' => (int) $product->price,
              
                'image' => $product->image 
                    ? asset('storage/' . $product->image) 
                    : asset('assets/images/default.png'), 
            ];
        });

        return response()->json([
            'status' => 'success',
            'products' => $data 
        ], 200);
    }
}