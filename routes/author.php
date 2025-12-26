<?php

use App\Http\Controllers\Author\Auth\RegisterController;
use App\Http\Controllers\Author\Book\CategoryController;
use App\Http\Controllers\Author\Order\AuthorOrderController;
use App\Http\Controllers\Author\PaymentMethod\PaymentMethodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//  Route::post('register', [RegisterController::class, 'register']);
 
//  Route::apiResource('payment-methods', PaymentMethodController::class)->only(['index']);

//  Route::apiResource('categories', CategoryController::class)->only(['index']);

//  Route::get('sales', [AuthorOrderController::class, 'index']);