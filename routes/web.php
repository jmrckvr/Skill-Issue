<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Authenticated routes
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/jobs/{job}/save', [JobController::class, 'saveJob'])->name('jobs.save');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employer routes
    Route::middleware('employer')->group(function () {
        Route::get('/employer/dashboard', [JobController::class, 'dashboard'])->name('employer.dashboard');

        // Job management
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::patch('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{job}/publish', [JobController::class, 'publish'])->name('jobs.publish');
        Route::post('/jobs/{job}/close', [JobController::class, 'close'])->name('jobs.close');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');

        // Applicants
        Route::get('/jobs/{job}/applicants', [JobController::class, 'applicants'])->name('jobs.applicants');
        Route::patch('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('application.update-status');
    });

    // Job Seeker routes
    Route::middleware('jobseeker')->group(function () {
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
        Route::post('/applications/{application}/withdraw', [JobApplicationController::class, 'withdraw'])->name('applications.withdraw');
        Route::get('/applications/{application}/resume/download', [JobApplicationController::class, 'downloadResume'])->name('application.download-resume');
        Route::get('/applications', [JobSeekerController::class, 'applications'])->name('jobseeker.applications');
    });

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User management
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/admin/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');
        Route::post('/admin/users/{user}/activate', [AdminController::class, 'activateUser'])->name('admin.users.activate');

        // Job management
        Route::get('/admin/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
        Route::post('/admin/jobs/{job}/restore', [AdminController::class, 'restoreJob'])->name('admin.jobs.restore');
        Route::delete('/admin/jobs/{job}/permanent', [AdminController::class, 'deleteJob'])->name('admin.jobs.permanent-delete');

        // Category management
        Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/admin/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
        Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/admin/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::patch('/admin/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    });
});

require __DIR__ . '/auth.php';
