<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// --- ROUTE REVIEW & RATING ---
Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');
// -----------------------------

Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// --- ROUTE SOCIALITE GOOGLE SSO ---
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
// ---------------------------------

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])
    ->name('checkout.payment');

Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])
    ->name('checkout.success');

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.alias');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        
        Route::resource('events', EventAdminController::class);

        Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
        Route::get('partners/create', [PartnerController::class, 'create'])->name('partners.create');
        Route::post('partners', [PartnerController::class, 'store'])->name('partners.store');
    });
});