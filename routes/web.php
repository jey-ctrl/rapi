
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
// Kalender publik menjadi halaman pertama
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

    // Form pengajuan peminjaman untuk Guru/Organisasi
    Route::get('/booking', [EventsController::class, 'create'])
        ->middleware('role:3')
        ->name('booking.index');

    // Menyimpan pengajuan peminjaman
    Route::post('/events', [EventsController::class, 'store'])
        ->middleware('role:3')
        ->name('events.store');

    // Daftar pengaduan
    Route::get('/complaints', [ComplaintController::class, 'index'])
        ->name('complaints.index');

    // Menyimpan pengaduan
    Route::post('/complaints', [ComplaintController::class, 'store'])
        ->name('complaints.store');
});

// =====================================================
// ADMIN / WAKA
// =====================================================

Route::middleware(['auth', 'role:1'])
    ->prefix('admin')
    ->group(function () {

        // Dashboard Admin/Waka
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // -------------------------------------------------
        // PERSETUJUAN PEMINJAMAN
        // -------------------------------------------------

        // Menyetujui pengajuan
        Route::put('/events/{id}/approve', [
            EventsController::class,
            'approve'
        ])->name('admin.events.approve');

        // Menolak pengajuan
        Route::put('/events/{id}/reject', [
            EventsController::class,
            'reject'
        ])->name('admin.events.reject');

        // -------------------------------------------------
        // PEMINDAHAN RUANGAN
        // -------------------------------------------------

        // Menampilkan agenda untuk pengelolaan pemindahan
        Route::get('/pemindahan-ruang', [
            EventsController::class,
            'manageOverride'
        ])->name('admin.events.manage');

        // Form pemindahan ruangan
        Route::get('/events/{id}/move', [
            EventsController::class,
            'moveForm'
        ])->name('admin.events.move.form');

        // Menyimpan perubahan ruangan
        Route::put('/events/{id}/override', [
            EventsController::class,
            'overrideRoom'
        ])->name('admin.events.override');

        // -------------------------------------------------
        // PENGADUAN
        // -------------------------------------------------

        // Mengirim peringatan WhatsApp
        Route::get('/complaints/{id}/warn', [
            ComplaintController::class,
            'sendWaWarning'
        ])->name('admin.complaints.warn');

        // -------------------------------------------------
        // KELOLA RUANGAN
        // -------------------------------------------------

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

        // -------------------------------------------------
        // KELOLA PENGGUNA
        // -------------------------------------------------

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

        // Dashboard PIC
        Route::get('/dashboard', [PicController::class, 'index'])
            ->name('pic.dashboard');

        // Memperbarui status pengaduan
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

        // Dashboard Guru/Organisasi
        Route::get('/dashboard', [GuruController::class, 'index'])
            ->name('guru.dashboard');
    });
