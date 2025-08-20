<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DisplayController;

// ✅ User routes
Route::get('/', [UserController::class, 'index'])->name('user.index');
Route::post('/create-ticket', [UserController::class, 'createTicket'])->name('user.create-ticket');

// ✅ Admin login routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');   
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ✅ Protected admin routes
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::patch('/tickets/{ticket}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
});

//Display routes
Route::get('/display', [DisplayController::class, 'index'])->name('display.index');
Route::get('/display/updates', [DisplayController::class, 'getUpdates'])->name('display.updates');

