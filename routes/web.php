<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FreelancerProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:freelancer'])->group(function () {
    Route::get('/freelancer/dashboard', function () {
        return 'Freelancer Dashboard';
    });

    Route::get('/freelancer/profile', [FreelancerProfileController::class, 'edit'])
        ->name('freelancer.profile.edit');

    Route::post('/freelancer/profile', [FreelancerProfileController::class, 'store'])
        ->name('freelancer.profile.store');
});

Route::middleware(['auth', 'verified', 'role:employer'])->group(function () {
    Route::get('/employer/dashboard', function () {
        return 'Employer Dashboard';
    });
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Admin Dashboard';
    });
});

require __DIR__.'/auth.php';
