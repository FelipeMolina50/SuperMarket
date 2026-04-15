<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas Protegidas
Route::middleware('auth')->group(function () {
    
    // Dashboard & Reports
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index');

    // CRUD Inventario & Pedidos
    Route::resource('inventory', ProductController::class)->parameters(['inventory' => 'product'])->except(['create', 'show', 'edit']);
    Route::resource('orders', OrderController::class)->only(['index', 'store']);

    // Settings & Profile
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/profile/setup', [SettingsController::class, 'setupProfile'])->name('profile.setup');
    Route::post('/profile/update', [SettingsController::class, 'updateProfile'])->name('profile.update');

    // Rutas de administración
    Route::post('/settings/approve/{id}', [SettingsController::class, 'approve'])->name('settings.approve');
    Route::post('/settings/reject/{id}', [SettingsController::class, 'reject'])->name('settings.reject');
});