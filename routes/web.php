<?php
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [EventController::class, 'home'])->name('home');
Route::get('/explore-events', [EventController::class, 'sorting'])->name('explore-events');

Route::get('/search', [EventController::class, 'search'])->name('events.search');
Route::get('/sorting', [EventController::class, 'sorting'])->name('sort.events');

// Auth Routes
Route::middleware('auth')->group(function () {
    // Bookings Routes
    Route::post('/bookings/select', [BookingController::class, 'select'])->name('bookings.select');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/index', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
});

// Public Event Routes (must be after the more specific routes)
Route::get('events', [EventController::class, 'index'])->name('events.index');
Route::get('events/{id}', [EventController::class, 'show'])->name('events.show');

// Other Routes
// Route::get('/dashboard', [HomeController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');


Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';