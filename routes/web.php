<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

// Profile routes
Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

  // Profile Action
  Route::patch('/profile', [ProfileController::class, 'updateInfo'])->name('profile.info');
  Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
  Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.destroy');
});

// Listing routes
Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('/listing', ListingController::class)->except('index');

// Admin routes
Route::middleware(['auth', 'verified', Admin::class])->controller(AdminController::class)->group(function() {
  Route::get('/admin', 'index')->name('admin.index');
  Route::get('/users/{user}', 'show')->name('user.show');
  Route::put('/admin/{user}/role', 'role')->name('admin.role');
  Route::put('/admin/{listing}/approve', 'approve')->name('admin.approve');
});

// Auth routes
require __DIR__ . '/auth.php';