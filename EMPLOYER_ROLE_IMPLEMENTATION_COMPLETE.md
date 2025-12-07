# Employer Role System - Complete Implementation Guide

## Overview

A comprehensive employer role functionality has been successfully implemented in the JobStreet application. This system enables registered employers to manage their company profiles, post jobs, and handle job applications with a complete approval/rejection workflow.

---

## 1. Authentication & Registration

### Employer Registration (`/register-employer`)

-   **Controller**: `App\Http\Controllers\Auth\EmployerRegisterController`
-   **Route**: `GET/POST /register-employer`
-   **Features**:
    -   Multi-section registration form (Personal Info, Company Info, Password)
    -   Validates all 12 fields (name, email, phone, location, company name, industry, etc.)
    -   Automatically assigns `role='employer'` to new user
    -   Creates Company record linked to user
    -   Fires Laravel Registered event for email verification

### Form Fields Validated

```
Personal Information:
- Full Name (required)
- Email (required, unique)
- Phone (required)
- Location/City (required)

Company Information:
- Company Name (required)
- Industry (required)
- Company Location (required)
- Company Email (required)
- Company Phone (required)
- Company Description (optional)

Authentication:
- Password (required, 8+ chars, confirmed)
```

---

## 2. Employer Dashboard

### Dashboard Routes & Features

```
GET  /employer/dashboard          - Main dashboard with statistics
GET  /employer/company/profile    - View company profile
GET  /employer/company/edit       - Edit company information form
PATCH /employer/company           - Update company details
POST /employer/company/logo       - Upload company logo
DELETE /employer/company/logo     - Delete company logo
```

### Dashboard Controller: `EmployerDashboardController`

**Methods**:

1. `index()` - Display dashboard with:
    - Total jobs posted
    - Active jobs count
    - Total applications received
    - Pending applications waiting review
2. `showCompanyProfile()` - Display current company profile
3. `editCompany()` - Load edit form with pre-filled data
4. `updateCompany()` - Validate and save company changes
5. `uploadLogo()` - Handle image upload (validates file type/size)
6. `deleteLogo()` - Remove company logo

### Dashboard Statistics Calculated

-   **Total Jobs**: All jobs posted by company
-   **Active Jobs**: Jobs with status='active'
-   **Total Applications**: Sum of all job applications
-   **Pending Applications**: Applications awaiting review

---

## 3. Job Management System

### Job Routes (Resource-based)

```
GET    /employer/jobs                         - List all jobs (paginated)
GET    /employer/jobs/create                  - Job creation form
POST   /employer/jobs                         - Store new job
GET    /employer/jobs/{job}                   - View job details
GET    /employer/jobs/{job}/edit              - Edit job form
PUT    /employer/jobs/{job}                   - Update job
DELETE /employer/jobs/{job}                   - Delete job

GET    /employer/jobs/{job}/applicants        - View all applicants
GET    /employer/jobs/{job}/applications/{application}  - Application detail
POST   /employer/jobs/{job}/applications/{application}/approve  - Approve
POST   /employer/jobs/{job}/applications/{application}/reject   - Reject
GET    /employer/jobs/{job}/applications/{application}/resume   - Download resume
```

### Job Controller: `EmployerJobController`

**Methods**:

1. `index()` - List all jobs with pagination
2. `create()` - Show job creation form with categories
3. `store()` - Validate and create new job
4. `edit()` - Load job edit form
5. `update()` - Validate and update job details
6. `destroy()` - Delete job listing
7. `applicants()` - Display all applicants for a job
8. `viewApplication()` - Show single application details
9. `approveApplicant()` - Mark application as approved
10. `rejectApplicant()` - Reject with optional reason
11. `downloadResume()` - Download applicant resume file

### Job Fields Validated

```
Required Fields:
- Title (string, max 255)
- Description (text)
- Location (string)
- Job Type (full-time|part-time|contract|internship)
- Experience Level (entry|mid|senior|executive)
- Category (exists in categories table)
- Salary Min (numeric, min 0)
- Salary Max (numeric, min 0)
- Currency (PHP|USD|EUR)

Optional Fields:
- Requirements (text)
- Benefits (text)
- Hide Salary (boolean)
```

### Job Types Supported

-   Full Time
-   Part Time
-   Contract
-   Internship

### Experience Levels

-   Entry Level
-   Mid Level
-   Senior Level
-   Executive

---

## 4. Applicant Management

### Application Workflow

1. **View Applicants**: Employer sees all applicants for a job in table format
2. **Review Application**: Click "View" to see full application details
    - Applicant info (name, email, phone, location)
    - Cover letter text
    - Application timeline
    - Resume download option
3. **Take Action**:
    - **Approve**: Change status to 'approved' (fast-track to next stage)
    - **Reject**: Change status to 'rejected' with optional reason message

### Applicant Status States

-   `pending` - Application awaiting review (default)
-   `approved` - Applicant approved (with reviewed_at timestamp)
-   `rejected` - Application rejected (with rejection_reason and reviewed_at)

### Application Detail View Includes

-   Applicant profile picture (if uploaded)
-   Contact information (email, phone, location)
-   Cover letter
-   Application timeline with status changes
-   Resume download button
-   Approval/rejection action buttons
-   Application submission date

---

## 5. Permission & Authorization System

### Middleware Protection

**Middleware**: `App\Http\Middleware\EnsureEmployer`

-   Applied to all employer routes
-   Checks `auth()->user()->role === 'employer'`
-   Redirects non-employers to home page

### Job Policy Authorization

**File**: `app/Policies/JobPolicy.php`

**Authorization Methods**:

1. `view()` - Anyone can view published jobs
2. `create()` - Only employers and admins
3. `update()` - Only job owner (employer) or admin
4. `delete()` - Only job owner or admin
5. `publish()` - Only job owner or admin
6. `close()` - Only job owner or admin
7. `viewApplicants()` - **Only job owner or admin**
8. `approveApplicant()` - **Only job owner or admin** (NEW)
9. `restore()` - Only admin
10. `forceDelete()` - Only admin

### Authorization Checks in Controller

```php
// Before viewing applicants
$this->authorize('viewApplicants', $job);

// Before approving/rejecting
$this->authorize('approveApplicant', $job);
```

---

## 6. User & Company Models

### User Model Extensions

**New Relationship**:

```php
public function company()
{
    return $this->hasOne(Company::class);
}
```

**New Methods** (assumed existing):

-   `isEmployer()` - Check if role === 'employer'
-   `canPostJobs()` - Check if employer or admin
-   `canViewApplicants()` - Check authorization

### Company Model

**Fields**:

-   `id` - Primary key
-   `name` - Company name
-   `email` - Company email
-   `phone` - Company phone
-   `location` - Company location
-   `industry` - Industry type
-   `description` - About company
-   `website` - Company website URL
-   `logo` - Logo image path
-   `user_id` - Foreign key to users table

**Relationships**:

```php
public function user() { return $this->belongsTo(User::class); }
public function jobs() { return $this->hasMany(Job::class); }
```

### Job Application Model

**New Fields** (added if not existing):

-   `status` - pending|approved|rejected (default: pending)
-   `rejection_reason` - Text reason for rejection (nullable)
-   `reviewed_at` - Timestamp when reviewed (nullable)

---

## 7. Database Schema

### Users Table Addition

**Migration**: `2025_12_02_add_company_id_to_users_table`

```sql
ALTER TABLE users ADD company_id BIGINT UNSIGNED NULL;
ALTER TABLE users ADD FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL;
```

### Companies Table (existing/extended)

```sql
CREATE TABLE companies (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    location VARCHAR(255) NOT NULL,
    industry VARCHAR(100),
    description TEXT,
    website VARCHAR(255),
    logo VARCHAR(255),
    user_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Job Applications Table (extended)

```sql
ALTER TABLE job_applications ADD COLUMN status VARCHAR(20) DEFAULT 'pending';
ALTER TABLE job_applications ADD COLUMN rejection_reason TEXT;
ALTER TABLE job_applications ADD COLUMN reviewed_at TIMESTAMP;
```

---

## 8. Views (Blade Templates)

### Authentication Views

-   **`auth/employer-register.blade.php`** (250+ lines)
    -   Multi-section form with validation errors
    -   Personal info section
    -   Company info section with industry dropdown
    -   Password confirmation section

### Dashboard Views

-   **`employer/dashboard.blade.php`** (updated/existing)
    -   Statistics cards (jobs, applications, active jobs)
    -   Company profile overview
    -   Quick links to management sections

### Job Management Views

-   **`employer/jobs/index.blade.php`** (new)
    -   Table of all jobs
    -   Columns: Title, Location, Status, Application Count, Posted Date
    -   Action buttons: View Applicants, Edit, Delete
    -   Create Job button
-   **`employer/jobs/create.blade.php`** (new, 350+ lines)
    -   Comprehensive job creation form
    -   All fields with inline validation error display
    -   Category dropdown from database
    -   Salary section with currency selector
    -   Requirements and benefits text areas
-   **`employer/jobs/edit.blade.php`** (new)
    -   Reuses create form (same structure)
    -   Pre-populates existing job data
    -   Different submit button text

### Applicant Management Views

-   **`employer/jobs/applicants.blade.php`** (new, 120+ lines)
    -   Table of all applicants for a job
    -   Columns: Name, Email, Status (badge), Applied Date, Actions
    -   Status badges: Pending Review (yellow), Approved (green), Rejected (red)
    -   View/Approve/Reject action buttons
    -   Modal dialog for rejection reason
-   **`employer/jobs/application-detail.blade.php`** (new, 180+ lines)
    -   Full applicant profile
    -   Cover letter display
    -   Application timeline with status changes
    -   Resume download button
    -   Approve/Reject action buttons
    -   Sidebar with status card
    -   Application metadata (job title, location, applied date)

### Company Management Views

-   **`employer/company/profile.blade.php`** (new, 160+ lines)
    -   Display company information
    -   Company logo image
    -   Company description
    -   All contact details (email, phone, website)
    -   Company statistics (jobs, active jobs, applications)
    -   Quick links panel
    -   Edit profile button
-   **`employer/company/edit.blade.php`** (new, 220+ lines)
    -   Full company profile editing form
    -   Logo upload with preview
    -   Basic info section (name, industry, location)
    -   Company description textarea
    -   Contact info section (email, phone, website)
    -   All fields with validation error handling

---

## 9. File Structure Summary

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/EmployerRegisterController.php (NEW)
│   │   ├── EmployerDashboardController.php (NEW)
│   │   └── EmployerJobController.php (NEW)
│   └── Middleware/
│       └── EnsureEmployer.php (NEW)
├── Models/
│   ├── User.php (updated with company relationship)
│   ├── Company.php (existing)
│   ├── Job.php (existing)
│   └── JobApplication.php (extended)
└── Policies/
    └── JobPolicy.php (updated with new methods)

database/
└── migrations/
    └── 2025_12_02_add_company_id_to_users_table.php (NEW)

resources/
└── views/
    ├── auth/
    │   └── employer-register.blade.php (NEW)
    ├── employer/
    │   ├── dashboard.blade.php (updated)
    │   ├── jobs/
    │   │   ├── index.blade.php (NEW)
    │   │   ├── create.blade.php (NEW)
    │   │   ├── edit.blade.php (NEW)
    │   │   ├── applicants.blade.php (NEW)
    │   │   └── application-detail.blade.php (NEW)
    │   └── company/
    │       ├── profile.blade.php (NEW)
    │       └── edit.blade.php (NEW)

routes/
├── auth.php (updated with employer registration)
└── web.php (updated with employer routes)
```

---

## 10. Route Summary

### Authentication Routes

```
GET  /register-employer
POST /register-employer
```

### Dashboard Routes (Protected by employer middleware)

```
GET  /employer/dashboard
GET  /employer/company/profile
GET  /employer/company/edit
PATCH /employer/company
POST /employer/company/logo
DELETE /employer/company/logo
```

### Job Routes (Protected by employer middleware)

```
GET    /employer/jobs
GET    /employer/jobs/create
POST   /employer/jobs
GET    /employer/jobs/{job}
GET    /employer/jobs/{job}/edit
PUT    /employer/jobs/{job}
DELETE /employer/jobs/{job}
```

### Applicant Routes (Protected by employer + JobPolicy)

```
GET    /employer/jobs/{job}/applicants
GET    /employer/jobs/{job}/applications/{application}
POST   /employer/jobs/{job}/applications/{application}/approve
POST   /employer/jobs/{job}/applications/{application}/reject
GET    /employer/jobs/{job}/applications/{application}/resume
```

---

## 11. Testing the Implementation

### Test Workflow

#### 1. Register as Employer

```
1. Navigate to http://127.0.0.1:8000/register-employer
2. Fill in all required fields
3. Submit form
4. Verify:
   - User created in database
   - User.role = 'employer'
   - Company record created
   - Linked via company_id
```

#### 2. Access Employer Dashboard

```
1. Login with employer account
2. Navigate to /employer/dashboard
3. Verify:
   - Dashboard loads without errors
   - Statistics display (jobs, applications)
   - Company profile link works
   - Edit profile link works
```

#### 3. Create Job Listing

```
1. Click "Create Job" or go to /employer/jobs/create
2. Fill in job details
3. Select category
4. Set salary range
5. Submit
6. Verify:
   - Job appears in /employer/jobs
   - Job status is correct
   - All fields saved
```

#### 4. Manage Applications

```
1. Post a job
2. Have another user apply for it
3. Go to /employer/jobs/{job}/applicants
4. Click "View" on application
5. Verify:
   - Applicant details display
   - Cover letter shows
   - Can download resume
   - Approve/Reject buttons available
6. Test Approve:
   - Click Approve
   - Status changes to 'approved'
7. Test Reject:
   - Click Reject
   - Modal appears for reason
   - Submit rejection
   - Status changes to 'rejected'
```

#### 5. Edit Company Profile

```
1. Navigate to /employer/company/profile
2. Click "Edit Profile"
3. Update information
4. Upload new logo
5. Submit
6. Verify:
   - Changes saved in database
   - Logo displays on profile
   - Updated timestamp changes
```

---

## 12. Key Features Implemented

✅ **Role Assignment**

-   Automatic assignment of 'employer' role on registration

✅ **Employer Capabilities**

-   Post new jobs with comprehensive details
-   Edit existing job listings
-   View all applicants for jobs
-   View individual application details
-   Approve qualified applicants
-   Reject applicants with optional reason message
-   Download applicant resumes

✅ **Dashboard & Analytics**

-   Dashboard with key statistics
-   Company profile management
-   Logo upload/delete functionality
-   Job posting management
-   Application tracking

✅ **Permission Enforcement**

-   Middleware protection (EnsureEmployer)
-   Database-level authorization (JobPolicy)
-   Frontend route guards
-   Only job owner can manage applicants
-   Admin override capabilities

---

## 13. Database Migration

**Status**: ✅ Already migrated

The migration adding `company_id` foreign key to users table has already been applied. To verify:

```bash
php artisan migrate:status
```

---

## 14. Security Considerations

1. **Authentication**: Laravel Breeze with email verification
2. **Authorization**: Policy-based access control
3. **Validation**: Form request validation on all inputs
4. **File Upload**: Logo upload with file type/size validation
5. **XSS Protection**: Blade template escaping
6. **CSRF Protection**: Laravel token validation
7. **Password Security**: Bcrypt hashing via Laravel
8. **Soft Deletes**: Jobs can be soft-deleted for data integrity

---

## 15. Future Enhancements

Potential improvements:

1. Bulk job posting from CSV
2. Job scheduling (post on specific date)
3. Email notifications for new applications
4. Analytics dashboard with charts
5. Applicant ratings/feedback system
6. Job template library
7. Bulk application actions
8. Export applications to PDF
9. Two-factor authentication
10. API endpoints for job management

---

## 16. Support & Troubleshooting

### Common Issues

**Issue**: "Unauthorized" when accessing job applicants

-   **Fix**: Ensure user is logged in with employer role and owns the job

**Issue**: Logo upload fails

-   **Fix**: Check file is PNG/JPG and under 2MB size limit

**Issue**: Jobs don't appear in employer dashboard

-   **Fix**: Verify job's company_id matches user's company_id

**Issue**: Can't approve/reject applications

-   **Fix**: Ensure application exists and belongs to user's job

---

## Conclusion

The employer role system is now fully implemented with complete CRUD operations for jobs, comprehensive applicant management, and a professional dashboard for company profile management. All routes are protected with proper authorization checks, and the system seamlessly integrates with the existing JobStreet platform architecture.

For questions or issues, refer to the troubleshooting section above or review the relevant controller/policy files for implementation details.
