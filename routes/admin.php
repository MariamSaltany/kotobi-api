<?php

use App\Http\Controllers\Admin\Book\BookController;
use App\Http\Controllers\Admin\Order\AdminOrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\Book\CategoryBookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryBookController::class);

Route::apiResource('books', BookController::class);

Route::apiResource('payment-methods', PaymentMethodController::class);

Route::prefix('authors')->group(function () {
    Route::get('/', ['App\Http\Controllers\Admin\Users\Author\AuthorController', 'index']);
    Route::post('/', ['App\Http\Controllers\Admin\Users\Author\AuthorController', 'store']);
    Route::patch('{user}/approve', ['App\Http\Controllers\Admin\Users\Author\AuthorController', 'approve']);
    Route::patch('{user}/block', ['App\Http\Controllers\Admin\Users\Author\AuthorController', 'block']);
});

Route::get('orders', [AdminOrderController::class, 'index']);
Route::get('users/{user}/orders', [AdminOrderController::class, 'getUserOrders']);
Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus']);