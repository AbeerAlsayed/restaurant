<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('payments', [PaymentController::class, 'store']);
});

Route::get('tables', [TableController::class, 'index']);
Route::get('categories',[CategoryController::class,'index']);
Route::get('products', [ProductController::class,'index']);
Route::get('/orders', [OrderController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::patch('tables/reserve', [TableController::class, 'reserve']);
    Route::patch('tables/free', [TableController::class, 'free']);
});
