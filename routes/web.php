<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
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
});

require __DIR__.'/auth.php';
