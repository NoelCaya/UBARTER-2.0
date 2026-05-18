<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/sustainability-leaderboard', function () {
        return view('sustainability-leaderboard');
    })->name('sustainability-leaderboard');
    
    Route::get('/trade-history', function () {
        return view('trade-history');
    })->name('trade-history');
    
    Route::post('/trade-history/export', [TradeController::class, 'export'])->name('trade-history.export');
    
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
    
    // Items routes
    Route::get('/items/browse', [ItemController::class, 'browse'])->name('items.browse');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{item}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{item}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist/check/{item}', [WishlistController::class, 'check'])->name('wishlist.check');
    
    // Reviews routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    Route::get('/reviews/create/{item}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{item}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Settings
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');
});

require __DIR__.'/auth.php';
