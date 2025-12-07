<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployerDashboardController;
use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\CommunityThreadController;
use App\Http\Controllers\ApplicantProfileController;
use Illuminate\Support\Facades\Route;

// Public routes - accessible to all (guest, applicant, employer, admin)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('jobs.search');
Route::get('/companies', [HomeController::class, 'companies'])->name('companies.browse');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/api/jobs/{job}', [JobController::class, 'apiShow'])->name('jobs.api.show');
Route::get('/api/applications/{application}', [JobApplicationController::class, 'showAPI'])->name('applications.api.show');
Route::get('/api/jobs/{job}/saved-status', [SavedJobController::class, 'check'])->name('jobs.saved-status');

// Community Threads - Public Routes
Route::get('/community', [CommunityThreadController::class, 'index'])->name('community.index');
Route::get('/community/{communityThread}', [CommunityThreadController::class, 'show'])->name('community.show');

// Authenticated routes
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes - all authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Save jobs - only applicants (formerly jobseekers)
    Route::middleware('applicant')->group(function () {
        // Applicant Profile & Dashboard
        Route::get('/applicant/dashboard', [ApplicantProfileController::class, 'dashboard'])->name('applicant.dashboard');
        Route::get('/applicant/profile/edit', [ApplicantProfileController::class, 'editProfile'])->name('applicant.edit-profile');
        Route::put('/applicant/profile', [ApplicantProfileController::class, 'updateProfile'])->name('applicant.update-profile');
        Route::post('/applicant/profile/picture', [ApplicantProfileController::class, 'uploadProfilePicture'])->name('applicant.upload-picture');
        Route::post('/applicant/resume', [ApplicantProfileController::class, 'uploadResume'])->name('applicant.upload-resume');
        Route::get('/applicant/resume/download', [ApplicantProfileController::class, 'downloadResume'])->name('applicant.download-resume');
        Route::get('/applicant/saved-searches', [ApplicantProfileController::class, 'savedSearches'])->name('applicant.saved-searches');
        Route::get('/applicant/saved-jobs', [ApplicantProfileController::class, 'savedJobs'])->name('applicant.saved-jobs');
        Route::get('/applicant/job-applications', [ApplicantProfileController::class, 'jobApplications'])->name('applicant.job-applications');
        Route::get('/applicant/settings', [ApplicantProfileController::class, 'settings'])->name('applicant.settings');

        // Job save routes - API
        Route::post('/api/jobs/{job}/save', [SavedJobController::class, 'store'])->name('jobs.save.api');
        Route::delete('/api/jobs/{job}/save', [SavedJobController::class, 'destroy'])->name('jobs.unsave.api');
        Route::get('/api/saved-jobs', [SavedJobController::class, 'index'])->name('jobs.saved.index.api');

        // Legacy save route
        Route::post('/jobs/{job}/save', [JobController::class, 'saveJob'])->name('jobs.save');

        // Job application routes
        Route::get('/jobs/{job}/apply', [JobApplicationController::class, 'apply'])->name('applications.apply');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
        Route::get('/applications/{application}/success', [JobApplicationController::class, 'success'])->name('applications.success');
        Route::post('/applications/{application}/withdraw', [JobApplicationController::class, 'withdraw'])->name('applications.withdraw');
        Route::get('/applications/{application}/resume/download', [JobApplicationController::class, 'downloadResume'])->name('application.download-resume');
        Route::get('/applications', [JobSeekerController::class, 'applications'])->name('jobseeker.applications');

        // Community Thread Routes
        Route::get('/community/create', [CommunityThreadController::class, 'create'])->name('community.create');
        Route::post('/community', [CommunityThreadController::class, 'store'])->name('community.store');
        Route::post('/community/{communityThread}/message', [CommunityThreadController::class, 'storeMessage'])->name('community.store-message');
    });

    // Employer routes
    Route::middleware('employer')->group(function () {
        // New Employer Dashboard & Company Management
        Route::get('/employer/dashboard', [EmployerDashboardController::class, 'index'])->name('employer.dashboard');
        Route::get('/employer/company/profile', [EmployerDashboardController::class, 'showCompanyProfile'])->name('employer.company.profile');
        Route::get('/employer/company/edit', [EmployerDashboardController::class, 'editCompany'])->name('employer.company.edit');
        Route::patch('/employer/company', [EmployerDashboardController::class, 'updateCompany'])->name('employer.company.update');
        Route::get('/employer/logo-upload', function () {
            return view('employer.logo-upload-simple');
        })->name('employer.logo.upload-page');
        Route::post('/employer/company/logo', [EmployerDashboardController::class, 'uploadLogo'])->name('employer.company.logo.upload');
        Route::delete('/employer/company/logo', [EmployerDashboardController::class, 'deleteLogo'])->name('employer.company.logo.delete');

        // Job management routes
        Route::resource('employer/jobs', EmployerJobController::class, ['as' => 'employer']);
        Route::post('/employer/jobs/{job}/publish', [EmployerJobController::class, 'publish'])->name('employer.jobs.publish');
        Route::post('/employer/jobs/{job}/close', [EmployerJobController::class, 'close'])->name('employer.jobs.close');
        Route::get('/employer/jobs/{job}/applicants', [EmployerJobController::class, 'applicants'])->name('employer.jobs.applicants');
        Route::get('/employer/jobs/{job}/applications/{application}', [EmployerJobController::class, 'viewApplication'])->name('employer.jobs.application-detail');
        Route::post('/employer/jobs/{job}/applications/{application}/approve', [EmployerJobController::class, 'approveApplicant'])->name('employer.applicants.approve');
        Route::post('/employer/jobs/{job}/applications/{application}/reject', [EmployerJobController::class, 'rejectApplicant'])->name('employer.applicants.reject');
        Route::get('/employer/jobs/{job}/applications/{application}/resume', [EmployerJobController::class, 'downloadResume'])->name('employer.application.download-resume');

        // Legacy routes for backward compatibility
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::patch('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{job}/publish', [JobController::class, 'publish'])->name('jobs.publish');
        Route::post('/jobs/{job}/close', [JobController::class, 'close'])->name('jobs.close');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{job}/applicants', [JobController::class, 'applicants'])->name('jobs.applicants');
        Route::patch('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('application.update-status');

        // Company management (legacy)
        Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::patch('/company/{company}', [CompanyController::class, 'update'])->name('company.update');
        Route::delete('/company/{company}/logo', [CompanyController::class, 'deleteLogo'])->name('company.logo.delete');
    });

    // Admin routes - full platform access
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
