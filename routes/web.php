<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\JobManagementController;
use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboardController;
use App\Http\Controllers\Freelancer\JobController as FreelancerJobController;
use App\Http\Controllers\Freelancer\ProfileController as FreelancerProfileController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\Employer\CompanyController;

// ── Public ──
Route::get('/', fn() => redirect()->route('login'));
Route::get('/freelancer/profile/{id}', [FreelancerProfileController::class, 'show'])
    ->name('freelancer.profile.public');

// ── Guest ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// ── Auth ──
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');

    Route::middleware('verified')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.delete');

        // ── Profile Photo ──
        Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
        Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');

        // ── Resume ──
        Route::post('/profile/resume', [ProfileController::class, 'uploadResume'])->name('profile.resume.upload');
        Route::delete('/profile/resume', [ProfileController::class, 'removeResume'])->name('profile.resume.remove');

        // ── Skills ──
        Route::post('/profile/skills', [ProfileController::class, 'addSkill'])->name('profile.skills.add');
        Route::delete('/profile/skills/{skill}', [ProfileController::class, 'removeSkill'])->name('profile.skills.remove');

        // ── Work Experience ──
        Route::post('/profile/experience', [ProfileController::class, 'storeExperience'])->name('profile.experience.store');
        Route::put('/profile/experience/{experience}', [ProfileController::class, 'updateExperience'])->name('profile.experience.update');
        Route::delete('/profile/experience/{experience}', [ProfileController::class, 'destroyExperience'])->name('profile.experience.destroy');

        // ── Education ──
        Route::post('/profile/education', [ProfileController::class, 'storeEducation'])->name('profile.education.store');
        Route::put('/profile/education/{education}', [ProfileController::class, 'updateEducation'])->name('profile.education.update');
        Route::delete('/profile/education/{education}', [ProfileController::class, 'destroyEducation'])->name('profile.education.destroy');

        // ── Portfolio ──
        Route::post('/profile/portfolio', [ProfileController::class, 'storePortfolio'])->name('profile.portfolio.store');
        Route::delete('/profile/portfolio/{portfolio}', [ProfileController::class, 'destroyPortfolio'])->name('profile.portfolio.destroy');

        // ── Submit for Review ──
        Route::post('/profile/submit-review', [ProfileController::class, 'submitForReview'])->name('profile.submit-review');
    });
});

// ── Admin ──
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ── Users ──
    Route::get('/users', [UserManagementController::class, 'allUsers'])->name('users.all');
    Route::get('/users/freelancers', [UserManagementController::class, 'freelancers'])->name('users.freelancers');
    Route::get('/users/employers', [UserManagementController::class, 'employers'])->name('users.employers');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // ── NEW: Profile Status Management ──
    Route::patch('/users/{user}/profile-status', [UserManagementController::class, 'updateProfileStatus'])->name('users.profile-status');
    Route::post('/users/bulk-status', [UserManagementController::class, 'bulkUpdateStatus'])->name('users.bulk-status');

    // ── Admins (existing) ──
    Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');
    Route::delete('/admins/{admin}', [AdminManagementController::class, 'destroy'])->name('admins.destroy');

    // ── Jobs (existing) ──
    Route::get('/jobs', [JobManagementController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobManagementController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/block', [JobManagementController::class, 'block'])->name('jobs.block');
    Route::post('/jobs/{job}/unblock', [JobManagementController::class, 'unblock'])->name('jobs.unblock');
    Route::delete('/jobs/{job}', [JobManagementController::class, 'destroy'])->name('jobs.destroy');
});

// ── Employer ──
Route::middleware(['auth', 'verified', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');

    // ── Company Profile ──
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
    Route::put('/company', [CompanyController::class, 'update'])->name('company.update');
    Route::post('/company/upload-logo', [CompanyController::class, 'uploadLogo'])->name('company.upload-logo');
    Route::delete('/company/remove-logo', [CompanyController::class, 'removeLogo'])->name('company.remove-logo');

    Route::get('/jobs', [EmployerJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [EmployerJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [EmployerJobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}', [EmployerJobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/edit', [EmployerJobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [EmployerJobController::class, 'update'])->name('jobs.update');
    Route::patch('/jobs/{job}/toggle-status', [EmployerJobController::class, 'toggleStatus'])->name('jobs.toggle-status');
    Route::delete('/jobs/{job}', [EmployerJobController::class, 'destroy'])->name('jobs.destroy');

    Route::patch('/applications/{application}', [EmployerJobController::class, 'updateApplication'])->name('applications.update');
});

// ── Freelancer ──
Route::middleware(['auth', 'verified', 'role:freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/dashboard', [FreelancerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/jobs', [FreelancerJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [FreelancerJobController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/apply', [FreelancerJobController::class, 'apply'])->name('jobs.apply');

    Route::get('/my-applications', [FreelancerJobController::class, 'myApplications'])->name('applications.index');
    Route::delete('/applications/{application}/withdraw', [FreelancerJobController::class, 'withdrawApplication'])->name('applications.withdraw');
    // ── My Public Profile & Share ──
    Route::get('/my-profile', [FreelancerProfileController::class, 'myProfile'])->name('profile.my');
    Route::get('/share-profile', [FreelancerProfileController::class, 'shareLink'])->name('profile.share');
});
