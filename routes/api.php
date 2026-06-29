<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BranchApiController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{order_id}', [TransactionController::class, 'show']);
Route::put('/transactions/{order_id}', [TransactionController::class, 'update']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::post('/transactions/{order_id}/cancel', [TransactionController::class, 'cancelTransaction']);
Route::get('/my-orders', [ApiTransactionController::class, 'myOrders']);

Route::get('/products', [ProductApiController::class, 'index']);

Route::get('/branches', [BranchApiController::class, 'index']);
Route::get('/branches/{id}', [BranchApiController::class, 'show']);