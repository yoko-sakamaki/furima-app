<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{id}', [ItemController::class, 'show']);

Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    });
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [UserController::class, 'index']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('/mypage/profile', [UserController::class, 'update']);
    Route::post('/like/{id}', [LikeController::class, 'toggle']);
    Route::post('/comment/{id}', [CommentController::class, 'store']);
    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);
});