<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [ItemController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Static pages
    Route::get('/sustainability-leaderboard', function () {
        return view('sustainability-leaderboard');
    })->name('sustainability-leaderboard');

    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');

    // Trade history & trade actions
    Route::get('/trade-history', [TradeController::class, 'index'])->name('trade-history');
    Route::post('/trade-history/export', [TradeController::class, 'export'])->name('trade-history.export');
    Route::post('/trades/propose', [TradeController::class, 'propose'])->name('trades.propose');
    Route::post('/trades/{trade}/accept', [TradeController::class, 'accept'])->name('trades.accept');
    Route::post('/trades/{trade}/reject', [TradeController::class, 'reject'])->name('trades.reject');
    Route::post('/trades/{trade}/complete', [TradeController::class, 'complete'])->name('trades.complete');
    Route::post('/trades/{trade}/cancel', [TradeController::class, 'cancel'])->name('trades.cancel');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');

    // Items
    Route::get('/items/browse', [ItemController::class, 'browse'])->name('items.browse');
    Route::get('/items/my-items', [ItemController::class, 'myItems'])->name('items.my-items');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::patch('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::post('/items/{item}/cancel', [ItemController::class, 'cancel'])->name('items.cancel');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{item}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{item}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist/check/{item}', [WishlistController::class, 'check'])->name('wishlist.check');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    Route::get('/reviews/create/{item}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{item}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Admin (role check inside controller)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/items/{item}/approve', [AdminController::class, 'approveItem'])->name('items.approve');
        Route::post('/items/{item}/reject', [AdminController::class, 'rejectItem'])->name('items.reject');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
        Route::post('/users/{user}/reactivate', [AdminController::class, 'reactivateUser'])->name('users.reactivate');
    });
});

require __DIR__.'/auth.php';
