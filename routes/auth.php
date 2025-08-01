<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function() {
  // Register routes
  Route::inertia('/register', 'Auth/Register')->name('register');
  Route::post('/register', [AuthController::class, 'register']);

  
  // Login routes
  Route::get('/login', function() {
    return Inertia::render('Auth/Login', ['status' => session('status')]);
  })->name('login');
  Route::post('/login', [AuthController::class, 'login']);


  // Forgot Password routes
  Route::get('/forgot-password', function() {
    return Inertia::render('Auth/ForgotPassword', ["status" => session('status')]);
  })->name('password.request');

  Route::post('/forgot-password', [PasswordController::class, 'resetLink'])->name('password.email');

  Route::get('reset-password/{token}', [PasswordController::class, 'createNewPassword'])->name('password.reset');

  Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function() {
  // Logout route
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


  // Email  Verification routes
  Route::get('/email/verify', function() {
    return Inertia::render("Auth/VerifyEmail", ['message' => session('message')]);
  })->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerificationHandler'])->middleware('signed')->name('verification.verify');
  Route::post('/email/verification-notification', [AuthController::class, 'resendEmail'])->middleware('throttle:6,1')->name('verification.send');

  
  // Confirm Password routes
  Route::get('/confirm-password', [PasswordController::class, 'confirmPasswordView'])->name('password.confirm');
  Route::post('/confirm-password', [PasswordController::class, 'confirmPassword'])->middleware('throttle:6,1');
});