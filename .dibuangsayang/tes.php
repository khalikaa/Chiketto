<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

// guest controller pun gak perlu 
Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/events/explore', [GuestController::class, 'explore'])->name('guest.explore');
Route::get('/event/{id}', [GuestController::class, 'show'])->name('guest.show');
// Route::get('/events/{event}', [GuestController::class, 'show'])->name('guest.show');
Route::get('/search', [GuestController::class, 'search'])->name('guest.search');


Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// gk pke ini krn mau diatur satu2 yg mana mau pakai middleware yg mana egk
Route::resource('events', EventController::class)
->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route untuk semua user (guest dan login)
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Detail event hanya untuk user login
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
});