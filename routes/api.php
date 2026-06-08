<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ProductApiController;


Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{order_id}', [TransactionController::class, 'show']);
Route::put('/transactions/{order_id}', [TransactionController::class, 'update']);
Route::post('/transactions', [TransactionController::class, 'store']);

Route::get('/products', [ProductApiController::class, 'index']);