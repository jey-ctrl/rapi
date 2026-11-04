<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;

// =====================================================
// HALAMAN UTAMA
// =====================================================

Route::get('/', function () {
    return redirect()->route('calendar');
})->name('home');

// =====================================================
// AUTENTIKASI
// =====================================================

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// =====================================================
// KALENDER PUBLIK
// =====================================================

Route::get('/calendar', [CalendarController::class, 'index'])
    ->name('calendar');

Route::get('/calendar/events', [CalendarController::class, 'events'])
    ->name('calendar.events');

// =====================================================
// BOOKING DAN PENGADUAN
// =====================================================

Route::middleware(['auth'])->group(function () {

    Route::get('/booking', [EventsController::class, 'create'])
        ->middleware('role:3')
        ->name('booking.index');

    Route::post('/events', [EventsController::class, 'store'])
        ->middleware('role:3')
        ->name('events.store');

    Route::get('/complaints', [ComplaintController::class, 'index'])
        ->name('complaints.index');

    Route::post('/complaints', [ComplaintController::class, 'store'])
        ->name('complaints.store');
});

// =====================================================
// ADMIN / WAKA
// =====================================================

Route::middleware(['auth', 'role:1'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        Route::put('/events/{id}/approve', [
            EventsController::class,
            'approve'
        ])->name('admin.events.approve');

        Route::put('/events/{id}/reject', [
            EventsController::class,
            'reject'
        ])->name('admin.events.reject');

        Route::get('/pemindahan-ruang', [
            EventsController::class,
            'manageOverride'
        ])->name('admin.events.manage');

        Route::get('/events/{id}/move', [
            EventsController::class,
            'moveForm'
        ])->name('admin.events.move.form');

        Route::put('/events/{id}/override', [
            EventsController::class,
            'overrideRoom'
        ])->name('admin.events.override');

        Route::get('/complaints/{id}/warn', [
            ComplaintController::class,
            'sendWaWarning'
        ])->name('admin.complaints.warn');

        Route::get('/rooms', [
            AdminController::class,
            'manageRooms'
        ])->name('admin.rooms.index');

        Route::post('/rooms', [
            RoomController::class,
            'store'
        ])->name('rooms.store');

        Route::put('/rooms/{id}', [
            RoomController::class,
            'update'
        ])->name('rooms.update');

        Route::delete('/rooms/{id}', [
            RoomController::class,
            'destroy'
        ])->name('rooms.destroy');

        Route::get('/users', [
            UserController::class,
            'index'
        ])->name('admin.users.index');

        Route::post('/users', [
            UserController::class,
            'store'
        ])->name('users.store');

        Route::put('/users/{id}', [
            UserController::class,
            'update'
        ])->name('users.update');

        Route::delete('/users/{id}', [
            UserController::class,
            'destroy'
        ])->name('users.destroy');
    });

// =====================================================
// PIC RUANGAN
// =====================================================

Route::middleware(['auth', 'role:2'])
    ->prefix('pic')
    ->group(function () {

        Route::get('/dashboard', [PicController::class, 'index'])
            ->name('pic.dashboard');

        Route::put('/complaints/{id}/status', [
            ComplaintController::class,
            'updateStatus'
        ])->name('pic.complaints.update');
    });

// =====================================================
// GURU / ORGANISASI
// =====================================================

Route::middleware(['auth', 'role:3'])
    ->prefix('guru')
    ->group(function () {

        Route::get('/dashboard', [GuruController::class, 'index'])
            ->name('guru.dashboard');
    });

// =====================================================
// TEMPORARY COOKIE TEST
// HAPUS SETELAH PENGUJIAN SELESAI
// =====================================================

Route::get('/cookie-probe-laravel', function () {
    return response('Laravel cookie test berhasil')
        ->cookie(
            'laravel_probe',
            'success',
            5,
            '/',
            null,
            true,
            true,
            false,
            'lax'
        );
});
