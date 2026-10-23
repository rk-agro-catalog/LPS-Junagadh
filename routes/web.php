<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes - Shree Samast Leuva Patel Samaj Trust (LPS Junagadh)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sankalp', [HomeController::class, 'sankalp'])->name('sankalp');

// Bhumidan (1 sq. yard = Rs. 2500)
Route::get('/bhumidan', [HomeController::class, 'bhumidan'])->name('bhumidan');
Route::post('/bhumidan', [HomeController::class, 'storeBhumidan'])->name('bhumidan.store');
Route::get('/bhumidan/receipt/{receiptNumber}', [HomeController::class, 'receipt'])->name('receipt');

// Booking Inquiries
Route::get('/booking', [HomeController::class, 'booking'])->name('booking');
Route::post('/booking', [HomeController::class, 'storeBooking'])->name('booking.store');

// Leadership & Trustees
Route::get('/trustees', [HomeController::class, 'trustees'])->name('trustees');

// Gallery & Media (Reels, Videos, Photos)
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

// Samaj Directory & Membership
Route::get('/membership', [HomeController::class, 'membership'])->name('membership');
Route::post('/membership', [HomeController::class, 'storeMembership'])->name('membership.store');

// Contact & Location
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Back-Office Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bhumidans', [AdminController::class, 'bhumidans'])->name('bhumidans');
    Route::post('/bhumidans/{id}/status', [AdminController::class, 'updateBhumidanStatus'])->name('bhumidans.update');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::post('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
});
