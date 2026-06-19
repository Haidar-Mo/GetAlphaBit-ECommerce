<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
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

Route::get('/HomePage', [HomePageController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'show']);

// Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/main-categories', [CategoryController::class, 'indexWithChildren']); //: All main categories with their children
Route::get('/sub-categories', [CategoryController::class, 'indexWithParent']); //: All sub categories with their parent
Route::get('category/{id}', [CategoryController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // profile
    Route::put('/profile/edit', [ProfileController::class, 'update']);
    Route::get('/profile', [ProfileController::class, 'index']);

    //: show my profile
    Route::get('/profile', [ProfileController::class, 'show']);

    Route::get('/WishList', [WishListController::class, 'index']);
    Route::post('/toggle/{id}', [WishListController::class, 'toggleWishList']);

    // cart

    Route::post('/add-to-cart', [CartController::class, 'store']);
    Route::put('/change-quantity/{cartItem}', [CartController::class, 'update']);
    Route::put('/remove-item/{cartItem}', [CartController::class, 'removeItem']);
    Route::put('/apply-coupon', [CartController::class, 'applyCoupon']);
    Route::put('cancel-cart', [CartController::class, 'cancel']);

    //Order

    Route::post('/check-out', [OrderController::class, 'checkout']);
    Route::get('/history', [OrderController::class, 'history']);
    Route::get('/show/{order}', [OrderController::class, 'show']);

});