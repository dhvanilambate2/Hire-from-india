<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboardController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (only for non-authenticated users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Email Verification Routes
    Route::get('/email/verify', [VerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [UserManagementController::class, 'allUsers'])->name('users.all');
    Route::get('/users/freelancers', [UserManagementController::class, 'freelancers'])->name('users.freelancers');
    Route::get('/users/employers', [UserManagementController::class, 'employers'])->name('users.employers');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // Admin Management
    Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');
    Route::delete('/admins/{admin}', [AdminManagementController::class, 'destroy'])->name('admins.destroy');
});

/*
|--------------------------------------------------------------------------
| Freelancer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dashboard', [FreelancerDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Employer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
});