<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES (tanpa login) =====
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');

// Auth routes (Breeze)
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    // Role-based redirect after login
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // ===== ADMIN ROUTES =====
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('field-types', Admin\FieldTypeController::class);
        Route::resource('fields', Admin\FieldController::class);

        Route::get('/bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}', [Admin\BookingController::class, 'update'])->name('bookings.update');

        Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export-pdf', [Admin\ReportController::class, 'exportPdf'])->name('reports.pdf');
    });

    // ===== USER ROUTES =====
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/fields', [User\FieldCatalogController::class, 'index'])->name('fields.index');
        Route::get('/fields/{field}', [User\FieldCatalogController::class, 'show'])->name('fields.show');

        Route::get('/booking/{field}', [User\BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking/{field}', [User\BookingController::class, 'store'])->name('booking.store');

        Route::get('/my-bookings', [User\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/my-bookings/{booking}', [User\BookingController::class, 'show'])->name('bookings.show');
        Route::post('/my-bookings/{booking}/cancel', [User\BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::post('/my-bookings/{booking}/payment', [User\BookingController::class, 'uploadPayment'])->name('bookings.payment');
    });

    // Catalog accessible by all authenticated users
    Route::get('/fields-catalog', [User\FieldCatalogController::class, 'index'])->name('fields.catalog');
});
