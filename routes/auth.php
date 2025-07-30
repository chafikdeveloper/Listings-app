<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function() {
  Route::inertia('/register', 'Auth/Register')->name('register');
  Route::post('/register', [AuthController::class, 'register']);
  
  Route::get('/login', function() {
    return Inertia::render('Auth/Login', ['status' => session('status')]);
  })->name('login');
  Route::post('/login', [AuthController::class, 'login']);

  Route::get('/forgot-password', function() {
    return Inertia::render('Auth/ForgotPassword', ["status" => session('status')]);
  })->name('password.request');

  Route::post('/forgot-password', [AuthController::class, 'resetLink'])->name('password.email');

  Route::get('reset-password/{token}', function(Request $request) {
    return Inertia::render('Auth/ResetPassword', ['email' => $request->email, 'token' => $request->route('token')]);
  })->name('password.reset');

  Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function() {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  // Email verification
  Route::get('/email/verify', function() {
    return Inertia::render("Auth/VerifyEmail", ['message' => session('message')]);
  })->name('verification.notice');

  Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerificationHandler'])->middleware('signed')->name('verification.verify');

  Route::post('/email/verification-notification', [AuthController::class, 'resendEmail'])->middleware('throttle:6,1')->name('verification.send');
});