<?php

use App\Http\Controllers\Admin\Book\BookController;
use App\Http\Controllers\Admin\Book\CategoryBookController as AdminCategoryController;
use App\Http\Controllers\Admin\Order\AdminOrderController;
use App\Http\Controllers\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Admin\Users\Author\AuthorController;
use App\Http\Controllers\Author\Auth\RegisterController as AuthorRegisterController;
use App\Http\Controllers\Author\Book\CategoryController as AuthorCategoryController;
use App\Http\Controllers\Author\Order\AuthorOrderController;
use App\Http\Controllers\Author\PaymentMethod\PaymentMethodController as AuthorPaymentMethodController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthGenController;
use App\Http\Controllers\Customer\Auth\RegisterController as CustomerRegisterController;
use App\Http\Controllers\Customer\Book\CategoryBookController as CustomerCategoryController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\PaymentMethod\PaymentMethodController as CustomerPaymentMethodController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthGenController::class, 'login']);
    Route::post('register/customer', [CustomerRegisterController::class, 'register']);
    Route::post('register/author', [AuthorRegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthGenController::class, 'logout']);
});