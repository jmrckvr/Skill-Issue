# 4-Role Access System - Implementation Checklist

## What Was Implemented

This checklist shows all the components implemented for the 4-role access control system.

### 1. Database & Migrations ✅

-   [x] Migration file created: `2025_12_02_000000_update_users_table_with_guest_role.php`
    -   Updates role enum from `['jobseeker', 'employer', 'admin']` to `['guest', 'applicant', 'employer', 'admin']`
    -   Sets default role to 'guest'

### 2. User Model ✅

-   [x] `app/Models/User.php` updated with:
    -   Role checking methods: `isGuest()`, `isApplicant()`, `isEmployer()`, `isAdmin()`
    -   Permission methods: `canApply()`, `canSaveJobs()`, `canPostJobs()`, `canManageApplications()`, etc.
    -   Maintains backward compatibility with `isJobseeker()` alias

### 3. Middleware ✅

All middleware registered in `bootstrap/app.php`:

-   [x] **GuestMiddleware** (`app/Http/Middleware/GuestMiddleware.php`)

    -   Prevents guest users from accessing protected routes
    -   Alias: `'guest'`

-   [x] **ApplicantMiddleware** (`app/Http/Middleware/ApplicantMiddleware.php`)

    -   Restricts routes to applicants only
    -   Alias: `'applicant'`

-   [x] **JobSeekerMiddleware** (`app/Http/Middleware/JobSeekerMiddleware.php`)

    -   Updated to use `isApplicant()` check
    -   Alias: `'jobseeker'` (for backward compatibility)

-   [x] **EmployerMiddleware** (`app/Http/Middleware/EmployerMiddleware.php`)

    -   Updated to use `isEmployer()` check
    -   Alias: `'employer'`

-   [x] **AdminMiddleware** (`app/Http/Middleware/AdminMiddleware.php`)
    -   Updated to use `isAdmin()` check
    -   Alias: `'admin'`

### 4. Authorization Policies ✅

-   [x] `app/Policies/JobPolicy.php`

    -   Controls: view, create, update, delete, publish, close, viewApplicants, restore, forceDelete

-   [x] `app/Policies/JobApplicationPolicy.php`

    -   Controls: view, create, updateStatus, withdraw, hire, reject

-   [x] `app/Policies/SavedJobPolicy.php`
    -   Controls: viewSaved, save, delete

### 5. Service Provider ✅

-   [x] `app/Providers/AppServiceProvider.php`
    -   Registers all authorization policies using Gate::policy()

### 6. Authorization Helper Trait ✅

-   [x] `app/Traits/AuthorizesRequests.php`
    -   Provides helper methods for role checking in controllers

### 7. Controllers Updated ✅

-   [x] `app/Http/Controllers/JobController.php`

    -   Added documentation comments for each method
    -   Updated all authorization checks to use policies
    -   Added checks for `canSaveJobs()` in saveJob()

-   [x] `app/Http/Controllers/JobApplicationController.php`
    -   Uses `$this->authorize()` for policy checks
    -   Updated documentation
    -   Removed inline authorization checks in favor of policies

### 8. Routes Updated ✅

-   [x] `routes/web.php`
    -   Reorganized routes with clear comments
    -   Moved save job route inside applicant middleware
    -   Moved application routes inside applicant middleware
    -   Separated employer and admin routes clearly
    -   Added descriptive comments for each section

### 9. Documentation ✅

-   [x] `4_ROLE_ACCESS_SYSTEM.md` - Comprehensive documentation
    -   Complete overview of 4 roles
    -   Permissions and restrictions for each role
    -   Implementation details
    -   Database schema
    -   User model methods
    -   Middleware descriptions
    -   Authorization policies
    -   Controller changes
    -   Route organization
    -   Testing guidelines
    -   Migration instructions

---

## How to Use This System

### For New User Registration

When registering a new user, set their role:

```php
// Guest user (can browse but not interact)
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
    'role' => 'guest', // Default
]);

// Applicant (can apply and save jobs)
$user = User::create([
    'name' => 'Jane Seeker',
    'email' => 'jane@example.com',
    'password' => Hash::make('password'),
    'role' => 'applicant',
]);

// Employer (can post and manage jobs)
$user = User::create([
    'name' => 'Bob Company',
    'email' => 'bob@company.com',
    'password' => Hash::make('password'),
    'role' => 'employer',
]);

// Admin (full access)
$user = User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
]);
```

### For Checking Permissions in Controllers

```php
// Using helper methods
if (auth()->user()->isApplicant()) {
    // Applicant-specific logic
}

if (auth()->user()->canPostJobs()) {
    // Show job posting interface
}

// Using policies
$this->authorize('apply', $application);
$this->authorize('publish', $job);
$this->authorize('updateStatus', $application);
```

### For Protecting Routes

All middleware is already configured. Just use in route groups:

```php
// Applicant-only
Route::middleware('applicant')->group(function () {
    Route::post('/jobs/{job}/apply', ...);
});

// Employer-only
Route::middleware('employer')->group(function () {
    Route::post('/jobs', ...);
});

// Admin-only
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', ...);
});
```

---

## Next Steps

### 1. Database Migration

Run the migration to update the users table:

```bash
php artisan migrate
```

### 2. Convert Existing Users

If you have existing users with 'jobseeker' role, convert them:

```php
// In artisan tinker or seeders
User::where('role', 'jobseeker')->update(['role' => 'applicant']);
```

### 3. Create Admin User

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('securepassword'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

### 4. Test Each Role

-   Register test accounts for each role
-   Test access restrictions
-   Verify error messages

### 5. Frontend Updates (Recommended)

Consider updating your Blade templates to:

-   Hide "Apply" button from guests
-   Hide "Save Job" button from non-applicants
-   Show "Post Job" button only to employers
-   Show admin panel only to admins

Example:

```blade
@if(auth()->user()?->canApply())
    <button class="apply-btn">Apply Now</button>
@else
    <p>Please log in as an applicant to apply</p>
@endif
```

### 6. API Endpoints (Optional)

For API responses, include user role:

```php
return response()->json([
    'user' => auth()->user(),
    'can_apply' => auth()->user()?->canApply(),
    'can_post_jobs' => auth()->user()?->canPostJobs(),
]);
```

---

## File Summary

| File                                                       | Type          | Status     |
| ---------------------------------------------------------- | ------------- | ---------- |
| `2025_12_02_000000_update_users_table_with_guest_role.php` | Migration     | ✅ Created |
| `app/Models/User.php`                                      | Model         | ✅ Updated |
| `app/Http/Middleware/GuestMiddleware.php`                  | Middleware    | ✅ Created |
| `app/Http/Middleware/ApplicantMiddleware.php`              | Middleware    | ✅ Created |
| `app/Http/Middleware/JobSeekerMiddleware.php`              | Middleware    | ✅ Updated |
| `app/Http/Middleware/EmployerMiddleware.php`               | Middleware    | ✅ Updated |
| `app/Http/Middleware/AdminMiddleware.php`                  | Middleware    | ✅ Updated |
| `app/Policies/JobPolicy.php`                               | Policy        | ✅ Created |
| `app/Policies/JobApplicationPolicy.php`                    | Policy        | ✅ Created |
| `app/Policies/SavedJobPolicy.php`                          | Policy        | ✅ Created |
| `app/Providers/AppServiceProvider.php`                     | Provider      | ✅ Updated |
| `app/Traits/AuthorizesRequests.php`                        | Trait         | ✅ Created |
| `app/Http/Controllers/JobController.php`                   | Controller    | ✅ Updated |
| `app/Http/Controllers/JobApplicationController.php`        | Controller    | ✅ Updated |
| `bootstrap/app.php`                                        | Configuration | ✅ Updated |
| `routes/web.php`                                           | Routes        | ✅ Updated |
| `4_ROLE_ACCESS_SYSTEM.md`                                  | Documentation | ✅ Created |

---

## Troubleshooting

### Issue: "Unauthorized action" error

**Solution:** Check that the user has the required role using:

```php
auth()->user()->role // Should be 'guest', 'applicant', 'employer', or 'admin'
```

### Issue: Policies not working

**Solution:** Ensure policies are registered in AppServiceProvider:

```php
Gate::policy(Job::class, JobPolicy::class);
```

### Issue: Middleware not blocking access

**Solution:** Verify middleware is properly registered in bootstrap/app.php:

```php
$middleware->alias([
    'applicant' => ApplicantMiddleware::class,
    'employer' => EmployerMiddleware::class,
    'admin' => AdminMiddleware::class,
]);
```

### Issue: Old 'jobseeker' route still works

**Solution:** Update route middleware from 'jobseeker' to 'applicant', or keep both for backward compatibility (already done).

---

## Support & Questions

For detailed information, see `4_ROLE_ACCESS_SYSTEM.md` for:

-   Complete role specifications
-   Authorization policy details
-   Route organization
-   User flow examples
-   Testing guidelines
