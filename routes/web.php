<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TradeController;
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
    
    // Navbar routes
    Route::get('/wishlist', function () {
        return view('user.wishlist');
    })->name('wishlist');
    
    Route::get('/reviews', function () {
        return view('user.reviews');
    })->name('reviews');
    
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');
    
    Route::get('/items/search', function () {
        $query = request('q');
        return view('items.search', ['query' => $query]);
    })->name('items.search');
});

require __DIR__.'/auth.php';
