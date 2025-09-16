<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PasswordConfirmController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', [ListingController::class, 'index'])->name('home');

Route::resource('listing', ListingController::class)->except('index');

Route::middleware('guest')->group(function () {
	//Authentication
	Route::get('/register', [RegisterController::class, 'create'])->name('register');
	Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [LoginController::class, 'create'])->name('login');
	Route::post('/login', [LoginController::class, 'store']);
	//Reset Password
	Route::get('/forgot-password', [PasswordResetController::class, 'sendIndex'])->name('password.request');
	Route::post('/forgot-password', [PasswordResetController::class, 'send'])->name('password.email');
	Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetIndex'])->name('password.reset');
	Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
	//Logout
	Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
	//Email Verification
	Route::get('/email/verify', [EmailVerifyController::class, 'notice'])->name('verification.notice');
	Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])->middleware('signed')->name('verification.verify');
	Route::post('/email/verification-notification', [EmailVerifyController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
	//Password Confirmation
	Route::get('/confirm-password', [PasswordConfirmController::class, 'create'])->name('password.confirm');
	Route::post('/confirm-password', [PasswordConfirmController::class, 'store'])->middleware('throttle:6,1');
	//Dashboard
	Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
	//Profile
	Route::get('/profile', [ProfileController::class, 'edit'])->middleware('password.confirm')->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'updateInfo'])->name('profile.info');
	Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
	Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
});

//Admin Panel
Route::middleware(['auth', 'verified', AdminMiddleware::class])->controller(AdminController::class)->group(function () {
	Route::get('/admin', 'index')->name('admin.index');
	Route::get('/admin/users/{user}', 'show')->name('admin.show');
	Route::patch('/admin/{user}/role', 'role')->name('admin.role');
	Route::patch('/admin/listing/{listing}/approve', 'approve')->name('admin.approve');
});
