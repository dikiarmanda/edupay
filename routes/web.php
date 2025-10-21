<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

Route::get('/', [HomeController::class, 'splash'])->name('splash');

// Login Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Create PIN Routes
Route::get('/create-pin', [SecurityController::class, 'createPin'])->name('security.createPin');
Route::post('/create-pin', [SecurityController::class, 'storePin'])->name('security.storePin');
Route::post('/verify-pin', [SecurityController::class, 'verifyPin'])->name('security.verifyPin');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/semua-menu', [HomeController::class, 'semuaMenu'])->name('semua-menu');
Route::get('/mutasi', [DashboardController::class, 'mutasi'])->middleware('auth')->name('mutasi');
Route::get('/tentang', [DashboardController::class, 'tentang'])->middleware('auth')->name('tentang');
Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');

// Profile Routes
Route::group(['prefix' => 'profil'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profil.index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/', [ProfileController::class, 'update'])->name('profil.update');
});

// Bill Routes
Route::get('/tagihan', [BillController::class, 'index'])->name('tagihan.index');

// Topup Routes
Route::get('/isi-saldo', [TopupController::class, 'index'])->name('topup.index');
Route::post('/topup/create-invoice', [TopupController::class, 'createInvoice'])->name('topup.createInvoice');
Route::post('/topup/check-status', [TopupController::class, 'checkStatus'])->name('topup.checkStatus');
Route::post('/topup/webhook', [TopupController::class, 'webhook'])->name('topup.webhook');

// Security Routes
Route::group(['prefix' => 'security'], function () {
    Route::get('/', [SecurityController::class, 'index'])->name('security.index');
    Route::put('/password', [SecurityController::class, 'updatePassword'])->name('security.updatePassword');
    Route::put('/pin', [SecurityController::class, 'updatePin'])->name('security.updatePin');
});

// Notification Routes
Route::group(['prefix' => 'notifikasi', 'middleware' => 'auth'], function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifikasi.show');
    Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifikasi.mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifikasi.destroy');
});

// API Routes untuk notifikasi
Route::group(['prefix' => 'api/notifikasi', 'middleware' => 'auth'], function () {
    Route::get('/latest', [NotificationController::class, 'getLatest'])->name('api.notifikasi.latest');
    Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('api.notifikasi.unread-count');
});
