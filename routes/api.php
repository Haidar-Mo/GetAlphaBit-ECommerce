<?php

use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // profile
    Route::put('/edit', [ProfileController::class, 'update']);
    Route::post('/profile', [ProfileController::class, 'index']);

    Route::get('/WishList', [WishListController::class, 'index']);
    Route::post('/toggle/{id}', [WishListController::class, 'toggleWishList']);
});