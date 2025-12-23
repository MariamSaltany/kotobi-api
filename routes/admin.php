<?php

use App\Http\Controllers\Admin\Book\BookController;
use App\Http\Controllers\Admin\Book\CategoryBookController;
use App\Http\Controllers\Admin\Order\AdminOrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\Users\Author\AuthorController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryBookController::class);

Route::apiResource('books', BookController::class)->only(['index','show']);

Route::apiResource('payment-methods', PaymentMethodController::class);

Route::prefix('/users/authors')->group(function () {
    Route::patch('{user}/approve', [AuthorController::class, 'approve']);
    Route::patch('{user}/block', [AuthorController::class, 'block']);
    Route::get('/', [AuthorController::class, 'index']);
});

Route::get('orders', [AdminOrderController::class, 'index']);
Route::get('users/{user}/orders', [AdminOrderController::class, 'getUserOrders']);
Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus']);