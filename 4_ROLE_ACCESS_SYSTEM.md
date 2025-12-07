# 4-Role Access Control System

## Overview

This document describes the complete implementation of a 4-role access control system for the JobStreet platform. The system enforces role-based access at middleware, policy, and controller levels.

## Roles

### 1. **Guest** (First-time or Not Logged-In Users)

-   **Permissions:**
    -   Browse and view all published jobs
    -   View job details
    -   Search jobs by keyword, location, category, etc.
    -   View company profiles
-   **Restrictions:**

    -   ❌ Cannot apply for jobs
    -   ❌ Cannot save jobs
    -   ❌ Cannot post jobs
    -   ❌ Cannot access any protected routes without logging in

-   **Status Value:** `'guest'`

---

### 2. **Applicant** (Job Seekers)

-   **Permissions:**
    -   Browse all published jobs
    -   View job details
    -   **Apply for jobs** (requires verified email)
    -   **Save/bookmark jobs**
    -   View their own job applications
    -   Withdraw applications
    -   Download resumes from their own applications
-   **Restrictions:**

    -   ❌ Cannot post jobs
    -   ❌ Cannot edit jobs
    -   ❌ Cannot view other applicants' information
    -   ❌ Cannot access employer dashboard
    -   ❌ Cannot access admin panel

-   **Status Value:** `'applicant'`

---

### 3. **Employer**

-   **Permissions:**
    -   Browse all published jobs
    -   **Create/post new jobs**
    -   **Edit their own jobs**
    -   **Publish/draft jobs**
    -   **Close job postings**
    -   **Delete their own jobs**
    -   **View applicants for their jobs**
    -   **Manage application status** (pending → reviewed → accepted/rejected)
    -   **Hire or reject applicants**
    -   Download resumes from applicants for their jobs
    -   Manage company profile/logo
-   **Restrictions:**

    -   ❌ Cannot edit other employers' jobs
    -   ❌ Cannot view applicants for other employers' jobs
    -   ❌ Cannot apply for jobs
    -   ❌ Cannot save jobs
    -   ❌ Cannot manage other users/employers
    -   ❌ Cannot access admin panel

-   **Status Value:** `'employer'`

---

### 4. **Admin**

-   **Permissions:**
    -   **Full system access**
    -   Browse all jobs
    -   **Manage all users** (activate/deactivate)
    -   **Manage all jobs** (restore/permanently delete)
    -   **Manage all categories**
    -   View platform statistics
    -   Manage platform settings
-   **Restrictions:**

    -   None (full access to everything)

-   **Status Value:** `'admin'`

---

## Implementation Details

### Database Schema

The `users` table contains a `role` column with ENUM values:

```php
enum('guest', 'applicant', 'employer', 'admin')
```

Default role for new registrations: `'guest'` (users must upgrade to applicant)

### Migration

-   **File:** `2025_12_02_000000_update_users_table_with_guest_role.php`
-   Updates the role enum to include 'guest' and 'applicant' instead of 'jobseeker'

### User Model Methods

The `User` model includes role checking methods:

```php
// Role checking
$user->isGuest()      // Check if guest
$user->isApplicant()  // Check if applicant
$user->isEmployer()   // Check if employer
$user->isAdmin()      // Check if admin

// Permission checking
$user->canApply()              // Can apply for jobs
$user->canSaveJobs()           // Can save jobs
$user->canPostJobs()           // Can post jobs
$user->canManageApplications() // Can manage applications
$user->canManageUsers()        // Can manage all users (admin only)
$user->canManagePlatform()     // Can manage platform settings (admin only)
```

### Middleware

All middleware classes are registered in `bootstrap/app.php`:

1. **GuestMiddleware** (`guest`)

    - Prevents guest users from accessing protected routes
    - Redirects with error message

2. **ApplicantMiddleware** (`applicant`)

    - Restricts routes to applicants only
    - Used for: applying, saving jobs, withdrawing applications

3. **JobSeekerMiddleware** (`jobseeker`)

    - Legacy middleware, now checks for `isApplicant()` role
    - Backward compatible with existing routes

4. **EmployerMiddleware** (`employer`)

    - Restricts routes to employers only
    - Used for: job posting, management, viewing applicants

5. **AdminMiddleware** (`admin`)
    - Restricts routes to admins only
    - Used for: user management, job moderation, category management

### Authorization Policies

Authorization policies define fine-grained access control:

#### **JobPolicy** (`app/Policies/JobPolicy.php`)

Controls access to job-related actions:

-   `view()` - Anyone can view published jobs, owners can view their own
-   `create()` - Only employers can create
-   `update()` - Only job owner or admin
-   `delete()` - Only job owner or admin
-   `publish()` - Only job owner or admin
-   `close()` - Only job owner or admin
-   `viewApplicants()` - Only job owner or admin
-   `restore()` - Only admin
-   `forceDelete()` - Only admin

#### **JobApplicationPolicy** (`app/Policies/JobApplicationPolicy.php`)

Controls access to application-related actions:

-   `view()` - Applicant (their own), employer (for their jobs), admin
-   `create()` - Only applicants
-   `updateStatus()` - Only employer (for their jobs) or admin
-   `withdraw()` - Only the applicant who applied
-   `hire()` - Only employer (for their jobs) or admin
-   `reject()` - Only employer (for their jobs) or admin

#### **SavedJobPolicy** (`app/Policies/SavedJobPolicy.php`)

Controls access to saved jobs:

-   `viewSaved()` - Only applicants
-   `save()` - Only applicants
-   `delete()` - Only the applicant who saved

### Controllers

#### **JobController** (`app/Http/Controllers/JobController.php`)

Updated with authorization checks:

```php
// Public methods (anyone)
show($id)      // View published jobs
apiShow($id)   // API endpoint for jobs

// Employer methods (with authorization)
create()       // Show job creation form
store()        // Store new job
edit($id)      // Edit job (policy check)
update()       // Update job (policy check)
publish()      // Publish job (policy check)
close()        // Close job (policy check)
destroy()      // Delete job (policy check)
applicants()   // View applicants (policy check)

// Applicant methods (with role check)
saveJob()      // Save/unsave job (canSaveJobs check)

// Employer methods (with authorization)
dashboard()    // Employer dashboard (middleware check)
```

#### **JobApplicationController** (`app/Http/Controllers/JobApplicationController.php`)

Updated with authorization checks:

```php
store()        // Apply for job (isApplicant check)
withdraw()     // Withdraw application (policy check)
updateStatus() // Update status (policy check)
downloadResume() // Download resume (authorization check)
```

### Routes

Routes are organized by role requirements:

```php
// Public routes (no authentication needed)
GET  /                      - Home page
GET  /search                - Job search
GET  /jobs/{job}           - View job details
GET  /api/jobs/{job}       - API endpoint

// Authenticated routes (auth + verified email)
GET  /dashboard            - User dashboard
GET  /profile              - Edit profile
PATCH /profile             - Update profile
DELETE /profile            - Delete profile

// Applicant-only routes (applicant middleware)
POST /jobs/{job}/save                         - Save job
POST /jobs/{job}/apply                        - Apply for job
POST /applications/{app}/withdraw             - Withdraw application
GET  /applications/{app}/resume/download      - Download resume
GET  /applications                            - View my applications

// Employer-only routes (employer middleware)
GET  /employer/dashboard                      - Employer dashboard
GET  /company/{company}/edit                  - Edit company
PATCH /company/{company}                      - Update company
DELETE /company/{company}/logo               - Delete logo
GET  /jobs/create                            - Job creation form
POST /jobs                                    - Create job
GET  /jobs/{job}/edit                        - Edit job form
PATCH /jobs/{job}                            - Update job
POST /jobs/{job}/publish                     - Publish job
POST /jobs/{job}/close                       - Close job
DELETE /jobs/{job}                           - Delete job
GET  /jobs/{job}/applicants                  - View applicants
PATCH /applications/{app}/status             - Update application status

// Admin-only routes (admin middleware)
GET  /admin/dashboard                        - Admin dashboard
GET  /admin/users                            - User management
POST /admin/users/{user}/deactivate          - Deactivate user
POST /admin/users/{user}/activate            - Activate user
GET  /admin/jobs                             - Job management
POST /admin/jobs/{job}/restore               - Restore job
DELETE /admin/jobs/{job}/permanent           - Permanent delete
GET  /admin/categories                       - Category management
GET  /admin/categories/create                - Create category form
POST /admin/categories                       - Store category
GET  /admin/categories/{cat}/edit            - Edit category form
PATCH /admin/categories/{cat}                - Update category
DELETE /admin/categories/{cat}               - Delete category
```

### Authorization Trait

`app/Traits/AuthorizesRequests.php` provides helper methods:

```php
$this->authorizeApplicant()    // Check applicant role
$this->authorizeEmployer()     // Check employer role
$this->authorizeAdmin()        // Check admin role
$this->authorizeAuthenticated() // Check authenticated
$this->authorizeNotGuest()     // Check not guest
```

---

## User Flow Examples

### Example 1: Guest User Flow

1. ✅ User visits homepage (no auth required)
2. ✅ User searches for jobs (no auth required)
3. ✅ User clicks "View Details" on a job
4. ✅ User sees "Login to Apply" button
5. ❌ User tries to apply → Redirected to login

### Example 2: Applicant User Flow

1. ✅ User registers as applicant (role = 'applicant')
2. ✅ User searches for jobs
3. ✅ User applies for job (email must be verified)
4. ✅ User saves job to list
5. ✅ User withdraws application later
6. ❌ User tries to post job → Access denied

### Example 3: Employer User Flow

1. ✅ User registers as employer (role = 'employer')
2. ✅ User creates company profile
3. ✅ User posts new job (draft)
4. ✅ User publishes job
5. ✅ User views applicants
6. ✅ User reviews and accepts/rejects applicants
7. ❌ User tries to apply for other jobs → Access denied

### Example 4: Admin User Flow

1. ✅ User registers (admin role assigned by system)
2. ✅ Admin accesses admin dashboard
3. ✅ Admin deactivates user
4. ✅ Admin restores deleted job
5. ✅ Admin manages categories
6. ✅ Admin views all applications
7. ✅ Can perform any action on the platform

---

## Security Features

1. **Middleware Layer:**

    - Route-level protection before controller execution
    - Early rejection for unauthorized roles

2. **Policy Layer:**

    - Fine-grained permission checking
    - Used with `$this->authorize()` in controllers
    - Separate logic from controllers

3. **Controller Layer:**

    - Additional checks for data ownership
    - Validation of request data
    - Error handling and feedback

4. **Database Layer:**

    - Role enum values (restricted to 4 options)
    - Foreign key constraints for ownership
    - Soft deletes for data safety

5. **Email Verification:**
    - Applicants must verify email before applying
    - Prevents spam applications

---

## Testing Access Control

### Test Guest Access

```bash
# Should allow (no auth)
GET /
GET /search
GET /jobs/1

# Should deny (requires auth)
POST /jobs/1/apply    → 401 Unauthorized
POST /jobs/1/save     → 401 Unauthorized
```

### Test Applicant Access

```bash
# Should allow
POST /jobs/1/apply
POST /jobs/1/save
GET /applications

# Should deny
POST /jobs (create job)
GET /employer/dashboard
```

### Test Employer Access

```bash
# Should allow
POST /jobs (create)
GET /jobs/1/edit
GET /jobs/1/applicants
PATCH /applications/1/status

# Should deny
POST /jobs/1/apply (cannot apply)
GET /admin/users
```

### Test Admin Access

```bash
# Should allow all
POST /jobs
GET /admin/dashboard
GET /admin/users
POST /admin/users/1/deactivate
```

---

## Migration & Setup

1. **Run migration:**

    ```bash
    php artisan migrate
    ```

2. **Update existing users:**

    ```php
    // Convert 'jobseeker' role to 'applicant'
    User::where('role', 'jobseeker')
        ->update(['role' => 'applicant']);
    ```

3. **Test the system:**
    - Create test users for each role
    - Verify access restrictions
    - Check authorization policies

---

## Future Enhancements

1. **Permission-based system:**

    - More granular control using permissions table
    - Roles can have multiple permissions

2. **Approval workflows:**

    - Employer/admin verification for new accounts
    - Account approval before activation

3. **Activity logging:**

    - Track all role-based actions
    - Audit trail for security

4. **Two-factor authentication:**

    - Additional security for admin and employer accounts

5. **Rate limiting:**
    - Limit job applications per applicant
    - Prevent spam/abuse
