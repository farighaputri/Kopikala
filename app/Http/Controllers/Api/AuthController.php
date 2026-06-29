<?php


// app/Http/Controllers/Api/AuthController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi data yang dikirim dari Flutter
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:100',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6', 
        ]);

        // 2. Simpan ke database MySQL
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']), 
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil disinkronkan ke MySQL',
            'user' => $user
        ], 201);
    }
}