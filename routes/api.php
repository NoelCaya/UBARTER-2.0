<?php

use App\Http\Controllers\Api\ItemApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\WishlistApiController;
use App\Http\Controllers\Api\TradeApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'message' => 'API is running']);
});

// Public routes (no authentication required)
Route::get('/items', [ItemApiController::class, 'index']);
Route::get('/items/search', [ItemApiController::class, 'search']);
Route::get('/items/filters', [ItemApiController::class, 'getFilterOptions']);
Route::get('/items/{item}', [ItemApiController::class, 'show']);
Route::get('/users/{user}', [UserApiController::class, 'show']);
Route::get('/users/{user}/items', [UserApiController::class, 'items']);
Route::get('/users/{user}/rating', [UserApiController::class, 'rating']);

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', [UserApiController::class, 'me']);
    Route::patch('/user', [UserApiController::class, 'update']);

    // Item routes
    Route::post('/items', [ItemApiController::class, 'store']);
    Route::patch('/items/{item}', [ItemApiController::class, 'update']);
    Route::delete('/items/{item}', [ItemApiController::class, 'destroy']);

    // Wishlist routes
    Route::get('/wishlist', [WishlistApiController::class, 'index']);
    Route::post('/wishlist/{item}', [WishlistApiController::class, 'add']);
    Route::delete('/wishlist/{item}', [WishlistApiController::class, 'remove']);
    Route::get('/wishlist/check/{item}', [WishlistApiController::class, 'check']);

    // Review routes
    Route::get('/reviews/my', [ReviewApiController::class, 'userReviews']);
    Route::get('/items/{item}/reviews', [ReviewApiController::class, 'index']);
    Route::post('/items/{item}/reviews', [ReviewApiController::class, 'store']);
    Route::patch('/reviews/{review}', [ReviewApiController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewApiController::class, 'destroy']);

    // Trade routes
    Route::get('/trades', [TradeApiController::class, 'index']);
    Route::post('/trades', [TradeApiController::class, 'store']);
    Route::get('/trades/{trade}', [TradeApiController::class, 'show']);
    Route::patch('/trades/{trade}', [TradeApiController::class, 'update']);
    Route::post('/trades/{trade}/cancel', [TradeApiController::class, 'cancel']);
});
