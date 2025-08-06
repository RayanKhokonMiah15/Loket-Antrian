<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// User routes
Route::get('/', [UserController::class, 'index'])->name('user.index');
Route::post('/create-ticket', [UserController::class, 'createTicket'])->name('user.create-ticket');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::patch('/tickets/{ticket}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
});
