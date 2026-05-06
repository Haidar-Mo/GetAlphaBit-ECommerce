<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\HomePageController;
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
    Route::put('/edit', [ProfileController::class, 'update']);
   // Route::post('/profile', [ProfileController::class, 'index']); //: Why "post" ?? its get. 

    //: show my profile
    Route::get('/profile', [ProfileController::class, 'show']);

    Route::get('/WishList', [WishListController::class, 'index']);
    Route::post('/toggle/{id}', [WishListController::class, 'toggleWishList']);
});