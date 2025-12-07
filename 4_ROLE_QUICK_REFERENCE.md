# 4-Role Access System - Quick Reference Guide

## Role Permissions Matrix

| Feature                       | Guest | Applicant | Employer | Admin |
| ----------------------------- | :---: | :-------: | :------: | :---: |
| **Browse Jobs**               |  ✅   |    ✅     |    ✅    |  ✅   |
| **View Job Details**          |  ✅   |    ✅     |    ✅    |  ✅   |
| **Search Jobs**               |  ✅   |    ✅     |    ✅    |  ✅   |
| **Apply for Jobs**            |  ❌   |    ✅     |    ❌    |  ❌   |
| **Save Jobs**                 |  ❌   |    ✅     |    ❌    |  ❌   |
| **Withdraw Applications**     |  ❌   |    ✅     |    ❌    |  ❌   |
| **Post Jobs**                 |  ❌   |    ❌     |    ✅    |  ✅   |
| **Edit Own Jobs**             |  ❌   |    ❌     |    ✅    |  ✅   |
| **Publish/Close Jobs**        |  ❌   |    ❌     |    ✅    |  ✅   |
| **View Applicants**           |  ❌   |    ❌     |    ✅    |  ✅   |
| **Review Applications**       |  ❌   |    ❌     |    ✅    |  ✅   |
| **Manage Company Profile**    |  ❌   |    ❌     |    ✅    |  ✅   |
| **Access Employer Dashboard** |  ❌   |    ❌     |    ✅    |  ✅   |
| **Manage All Users**          |  ❌   |    ❌     |    ❌    |  ✅   |
| **Manage All Jobs**           |  ❌   |    ❌     |    ❌    |  ✅   |
| **Manage Categories**         |  ❌   |    ❌     |    ❌    |  ✅   |
| **Access Admin Panel**        |  ❌   |    ❌     |    ❌    |  ✅   |

---

## Application Status Lifecycle

```
Application Created (pending)
    ↓
Employer Reviews (pending → reviewed)
    ↓
    ├─→ Accepted/Hired (reviewed → accepted)
    │      ↓
    │   [Applicant Hired]
    │
    └─→ Rejected (reviewed → rejected)
           ↓
        [Applicant Notified]

Applicant Can Withdraw at Any Stage
    ↓
[Application Withdrawn]
```

**Status Values:** `pending` | `reviewed` | `accepted` | `rejected` | `withdrawn`

---

## Route Protection Overview

```
PUBLIC ROUTES (No Auth Required)
├── GET  /                    → Home page
├── GET  /search             → Search jobs
├── GET  /jobs/{id}          → View job details
└── GET  /api/jobs/{id}      → API endpoint

AUTHENTICATED ROUTES (Auth Required)
├── GET  /dashboard          → User dashboard
├── GET  /profile            → Edit profile
├── PATCH /profile           → Update profile
└── DELETE /profile          → Delete profile

APPLICANT ROUTES (Role: applicant)
├── POST /jobs/{id}/save     → Save job
├── POST /jobs/{id}/apply    → Apply for job
├── POST /applications/{id}/withdraw
├── GET  /applications/{id}/resume/download
└── GET  /applications       → My applications

EMPLOYER ROUTES (Role: employer)
├── GET  /employer/dashboard → Dashboard
├── POST /jobs               → Create job
├── GET  /jobs/{id}/edit     → Edit job
├── PATCH /jobs/{id}         → Update job
├── POST /jobs/{id}/publish  → Publish job
├── POST /jobs/{id}/close    → Close job
├── DELETE /jobs/{id}        → Delete job
├── GET  /jobs/{id}/applicants → View applicants
└── PATCH /applications/{id}/status → Update status

ADMIN ROUTES (Role: admin)
├── GET  /admin/dashboard    → Admin dashboard
├── GET  /admin/users        → User management
├── POST /admin/users/{id}/deactivate
├── POST /admin/users/{id}/activate
├── GET  /admin/jobs         → Job management
├── POST /admin/jobs/{id}/restore
├── DELETE /admin/jobs/{id}/permanent
├── GET  /admin/categories   → Category management
├── POST /admin/categories   → Create category
├── PATCH /admin/categories/{id} → Update category
└── DELETE /admin/categories/{id} → Delete category
```

---

## Code Examples

### Check User Role

```php
// In controller or blade template
if (auth()->user()->isApplicant()) {
    // Applicant-specific code
}

if (auth()->user()->isEmployer()) {
    // Employer-specific code
}

if (auth()->user()->isAdmin()) {
    // Admin-specific code
}

if (auth()->user()->isGuest()) {
    // Guest-specific code (rarely used)
}
```

### Check User Permissions

```php
// Can they perform an action?
if (auth()->user()->canApply()) {
    // Show apply button
}

if (auth()->user()->canSaveJobs()) {
    // Show save button
}

if (auth()->user()->canPostJobs()) {
    // Show job posting interface
}

if (auth()->user()->canManageApplications()) {
    // Show application management
}
```

### Use Authorization Policies

```php
// In controller
public function hire(JobApplication $application)
{
    $this->authorize('hire', $application);

    $application->update(['status' => 'accepted']);
    return back()->with('success', 'Applicant hired!');
}

public function reject(JobApplication $application)
{
    $this->authorize('reject', $application);

    $application->update(['status' => 'rejected']);
    return back()->with('success', 'Applicant rejected.');
}
```

### In Blade Templates

```blade
<!-- Only show to applicants -->
@if(auth()->user()?->canApply())
    <button class="apply-btn">Apply Now</button>
@endif

<!-- Only show to employers -->
@if(auth()->user()?->canPostJobs())
    <a href="{{ route('jobs.create') }}" class="btn-primary">Post a Job</a>
@endif

<!-- Only show to admins -->
@if(auth()->user()?->isAdmin())
    <a href="{{ route('admin.dashboard') }}" class="btn-danger">Admin Panel</a>
@endif

<!-- Show message if guest -->
@guest
    <p>Please <a href="/login">login</a> to apply for jobs</p>
@endguest
```

---

## Middleware Usage

### Protect a Route

```php
Route::middleware('auth', 'verified', 'applicant')->group(function () {
    // Only logged-in, verified applicants can access
    Route::post('/jobs/{job}/apply', [...]);
});

Route::middleware('auth', 'verified', 'employer')->group(function () {
    // Only logged-in, verified employers can access
    Route::post('/jobs', [...]);
});

Route::middleware('auth', 'verified', 'admin')->group(function () {
    // Only logged-in, verified admins can access
    Route::get('/admin/dashboard', [...]);
});
```

### Middleware Aliases (in `bootstrap/app.php`)

```php
'guest'     → GuestMiddleware
'applicant' → ApplicantMiddleware
'jobseeker' → JobSeekerMiddleware (backward compat)
'employer'  → EmployerMiddleware
'admin'     → AdminMiddleware
```

---

## Policy Usage in Controllers

```php
// Check if user can perform action
if ($this->authorize('update', $job)) {
    // User can update this job
}

// Gate checks with throw exception on failure
$this->authorize('delete', $job); // Throws AuthorizationException if fails

// In services or traits
Gate::authorize('hire', $application);
Gate::can('publish', $job);
Gate::cannot('accept', $job);
```

---

## Error Messages

When access is denied:

```
Middleware Errors:
- "You must be an applicant to access this resource."
- "You must be an employer to access this resource."
- "Unauthorized access. Admin privileges required."
- "Guests cannot access this resource. Please register or log in as an applicant."

Policy Errors:
- "This action is unauthorized." (generic)
- Custom messages via policy methods
```

---

## Migration Steps

### 1. Run Migration

```bash
cd c:\Users\jmrck\Project Folder\Skill1ssue\jobstreet
php artisan migrate
```

### 2. Update Existing Users (Optional)

```bash
php artisan tinker

# In tinker
User::where('role', 'jobseeker')->update(['role' => 'applicant']);
exit
```

### 3. Create Test Users

```bash
php artisan tinker

User::create([
    'name' => 'Test Guest',
    'email' => 'guest@test.com',
    'password' => Hash::make('password'),
    'role' => 'guest',
]);

User::create([
    'name' => 'Test Applicant',
    'email' => 'applicant@test.com',
    'password' => Hash::make('password'),
    'role' => 'applicant',
    'email_verified_at' => now(),
]);

User::create([
    'name' => 'Test Employer',
    'email' => 'employer@test.com',
    'password' => Hash::make('password'),
    'role' => 'employer',
    'email_verified_at' => now(),
]);

User::create([
    'name' => 'Test Admin',
    'email' => 'admin@test.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

---

## Testing Checklist

-   [ ] Guest can browse jobs
-   [ ] Guest cannot apply for jobs
-   [ ] Guest cannot save jobs
-   [ ] Applicant can apply for jobs
-   [ ] Applicant can save jobs
-   [ ] Applicant cannot post jobs
-   [ ] Employer can post jobs
-   [ ] Employer can view applicants
-   [ ] Employer can change application status
-   [ ] Employer cannot apply for jobs
-   [ ] Employer cannot access admin panel
-   [ ] Admin can access all features
-   [ ] Admin can manage users
-   [ ] Admin can manage categories
-   [ ] Unauthorized access shows error message

---

## Role Enum Values

```php
// In database users table
'guest'     // Can browse, cannot interact
'applicant' // Can apply, save jobs
'employer'  // Can post, manage jobs
'admin'     // Full access
```

**Default for new registrations:** 'guest' (must be changed by user or admin)

---

## File Locations

| Component        | Location                                    |
| ---------------- | ------------------------------------------- |
| User Model       | `app/Models/User.php`                       |
| Middleware       | `app/Http/Middleware/`                      |
| Policies         | `app/Policies/`                             |
| Traits           | `app/Traits/AuthorizesRequests.php`         |
| Service Provider | `app/Providers/AppServiceProvider.php`      |
| Routes           | `routes/web.php`                            |
| Bootstrap Config | `bootstrap/app.php`                         |
| Migration        | `database/migrations/2025_12_02_000000_...` |
| Documentation    | `4_ROLE_ACCESS_SYSTEM.md`                   |
