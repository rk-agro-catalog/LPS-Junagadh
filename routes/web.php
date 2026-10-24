<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
Route::post('/bhumidan', [HomeController::class, 'storeBhumidan'])->middleware('throttle:20,1')->name('bhumidan.store');
Route::get('/bhumidan/receipt/{receiptNumber}', [HomeController::class, 'receipt'])->name('receipt');

// Booking Inquiries
Route::get('/booking', [HomeController::class, 'booking'])->name('booking');
Route::post('/booking', [HomeController::class, 'storeBooking'])->middleware('throttle:20,1')->name('booking.store');

// Leadership & Trustees
Route::get('/trustees', [HomeController::class, 'trustees'])->name('trustees');

// Samaj Events (કાર્યક્રમો / ઇવેન્ટ્સ)
Route::get('/events', [HomeController::class, 'events'])->name('events');

// Gallery & Media (Reels, Videos, Photos)
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

// Samaj Directory & Membership
Route::get('/membership', [HomeController::class, 'membership'])->name('membership');
Route::post('/membership', [HomeController::class, 'storeMembership'])->middleware('throttle:20,1')->name('membership.store');

// Contact & Location
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->middleware('throttle:20,1')->name('contact.store');

/*
|--------------------------------------------------------------------------
| Back-Office Admin & Authentication Routes
|--------------------------------------------------------------------------
*/
// Guest Authentication Routes (Brute-force protected: max 5 attempts/minute)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');
});

// Global login fallback for auth middleware
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Protected Admin Routes (Requires Authentication)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Bhumidan Donors CRUD
    Route::get('/bhumidans', [AdminController::class, 'bhumidans'])->name('bhumidans');
    Route::get('/bhumidans/create', [AdminController::class, 'createBhumidan'])->name('bhumidans.create');
    Route::post('/bhumidans/store', [AdminController::class, 'storeBhumidan'])->name('bhumidans.store');
    Route::get('/bhumidans/{id}/edit', [AdminController::class, 'editBhumidan'])->name('bhumidans.edit');
    Route::post('/bhumidans/{id}/update', [AdminController::class, 'updateBhumidanRecord'])->name('bhumidans.updateRecord');
    Route::post('/bhumidans/{id}/status', [AdminController::class, 'updateBhumidanStatus'])->name('bhumidans.update');
    Route::delete('/bhumidans/{id}', [AdminController::class, 'deleteBhumidan'])->name('bhumidans.destroy');

    // Hall & Plot Booking Inquiries CRUD
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/create', [AdminController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings/store', [AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/bookings/{id}/edit', [AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::post('/bookings/{id}/update', [AdminController::class, 'updateBookingRecord'])->name('bookings.updateRecord');
    Route::post('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update');
    Route::delete('/bookings/{id}', [AdminController::class, 'deleteBooking'])->name('bookings.destroy');

    // Samaj Members Directory CRUD
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/members/create', [AdminController::class, 'createMember'])->name('members.create');
    Route::post('/members/store', [AdminController::class, 'storeMember'])->name('members.store');
    Route::get('/members/{id}/edit', [AdminController::class, 'editMember'])->name('members.edit');
    Route::post('/members/{id}/update', [AdminController::class, 'updateMemberRecord'])->name('members.updateRecord');
    Route::delete('/members/{id}', [AdminController::class, 'deleteMember'])->name('members.destroy');

    // Gallery Items CRUD
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
    Route::get('/gallery/create', [AdminController::class, 'createGallery'])->name('gallery.create');
    Route::post('/gallery/store', [AdminController::class, 'storeGallery'])->name('gallery.store');
    Route::get('/gallery/{id}/edit', [AdminController::class, 'editGallery'])->name('gallery.edit');
    Route::post('/gallery/{id}/update', [AdminController::class, 'updateGallery'])->name('gallery.update');
    Route::delete('/gallery/{id}', [AdminController::class, 'deleteGallery'])->name('gallery.destroy');

    // Events & Functions CRUD
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::get('/events/create', [AdminController::class, 'createEvent'])->name('events.create');
    Route::post('/events/store', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{id}/edit', [AdminController::class, 'editEvent'])->name('events.edit');
    Route::post('/events/{id}/update', [AdminController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('events.destroy');

    // Contact Messages
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');

    // Admin Security & Password
    Route::get('/security', [AdminController::class, 'securitySettings'])->name('security');
    Route::post('/security/password', [AdminController::class, 'updatePassword'])->name('security.password');

    // Activity & Audit Logs
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    Route::delete('/logs/{id}', [AdminController::class, 'deleteLog'])->name('logs.destroy');
    Route::post('/logs/clear-old', [AdminController::class, 'clearOldLogs'])->name('logs.clearOld');
});
