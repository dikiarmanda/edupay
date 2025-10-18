<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CreatePinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\SecurityController;

Route::get('/', [HomeController::class, 'splash'])->name('splash');

// Login Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Create PIN Routes
Route::get('/create-pin', [CreatePinController::class, 'index'])->name('pin.create');
Route::post('/create-pin', [CreatePinController::class, 'store'])->name('pin.store');
Route::post('/verify-pin', [CreatePinController::class, 'verify'])->name('pin.verify');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/semua-menu', [HomeController::class, 'semuaMenu'])->name('semua-menu');
Route::get('/mutasi', [HomeController::class, 'mutasi'])->name('mutasi');
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

// Security Routes
Route::group(['prefix' => 'security'], function () {
    Route::get('/', [SecurityController::class, 'index'])->name('security.index');
    Route::put('/password', [SecurityController::class, 'updatePassword'])->name('security.updatePassword');
    Route::put('/pin', [SecurityController::class, 'updatePin'])->name('security.updatePin');
});
