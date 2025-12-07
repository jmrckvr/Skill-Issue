# Applicant Dashboard System - Complete Implementation

## Overview

A comprehensive applicant profile and dashboard system for job seekers with resume uploads, profile picture management, profile editing, and application tracking.

## Components Built

### 1. Database Migrations

#### Migration 1: `2025_12_06_add_applicant_fields_to_users.php`

Added 11 new columns to the `users` table:

-   `contact_number` - Phone number for applicants
-   `location` - City/Country information
-   `skills` - Comma-separated skills
-   `bio` - About/Bio section
-   `profile_picture` - Path to profile photo
-   `resume_path` - Path to uploaded PDF resume
-   `linkedin_url` - LinkedIn profile URL
-   `github_url` - GitHub profile URL
-   `portfolio_url` - Portfolio website URL
-   `is_applicant` - Boolean flag for applicants
-   `is_employer` - Boolean flag for employers

#### Migration 2: `2025_12_06_add_applicant_snapshot_to_job_applications.php`

Added 9 new columns to `job_applications` table to store applicant data at time of application:

-   `applicant_name` - Snapshot of applicant name
-   `applicant_email` - Snapshot of applicant email
-   `applicant_phone` - Snapshot of applicant phone
-   `applicant_location` - Snapshot of applicant location
-   `applicant_skills` - Snapshot of applicant skills
-   `applicant_bio` - Snapshot of applicant bio
-   `applicant_profile_picture` - Snapshot of applicant profile picture
-   `resume_path` - Resume path (if different)
-   `application_status` - Application status (pending, reviewed, rejected, hired)

### 2. Models

#### User Model Updates

-   Added new fields to `$fillable` array for mass assignment
-   Added `getProfilePictureUrlAttribute()` accessor - returns asset URL or placeholder
-   Added `getResumeUrlAttribute()` accessor - returns download URL or null

#### JobApplication Model Updates

-   Added new snapshot fields to `$fillable` array

### 3. Controller

#### ApplicantProfileController

Location: `app/Http/Controllers/ApplicantProfileController.php`

**Methods:**

-   `dashboard()` - Show applicant dashboard with profile and applications
-   `editProfile()` - Show edit profile form
-   `updateProfile()` - Update profile fields (name, email, contact, location, skills, bio, social links)
-   `uploadProfilePicture()` - Handle profile picture upload (JPEG, PNG, GIF, max 5MB)
-   `uploadResume()` - Handle resume upload (PDF only, max 10MB)
-   `downloadResume()` - Download applicant's resume

**Features:**

-   Role-based access control (applicants only)
-   Automatic file storage in `storage/app/public/resumes/` and `storage/app/public/profile_pictures/`
-   Automatic cleanup of old files when replaced
-   Validation for all inputs
-   Direct file submission via hidden file inputs

### 4. Views

#### Applicant Dashboard (`resources/views/applicant/dashboard.blade.php`)

**Sections:**

1. **Profile Header**

    - Profile picture with hover upload button
    - Name, email, phone, location display
    - Action buttons: Edit Profile, Upload Resume, Download Resume

2. **Resume Section**

    - Shows uploaded resume filename and type
    - Download button for existing resume
    - Warning message if no resume uploaded

3. **Applications List**
    - Grid of submitted applications
    - Shows job title, company name, application date
    - Status badge (Pending, Reviewed, Rejected, Hired)
    - Color-coded status indicators
    - Empty state with link to browse jobs

**Design:**

-   Professional card-based layout
-   Responsive design (mobile, tablet, desktop)
-   Modern styling with Tailwind CSS
-   Blue color scheme matching JobStreet

#### Edit Profile (`resources/views/applicant/edit-profile.blade.php`)

**Form Fields:**

-   Full Name (required)
-   Email Address (required, unique)
-   Contact Number (optional)
-   Location (optional)
-   Skills (textarea, comma-separated)
-   Bio / About (textarea, 1000 chars max)

**Social Links Section (optional):**

-   LinkedIn URL
-   GitHub URL
-   Portfolio URL

**Features:**

-   Form validation feedback
-   Back link to dashboard
-   Cancel button
-   Professional form styling
-   Character limits on text areas

### 5. Routes

Routes in `routes/web.php` (protected by `applicant` middleware):

```php
Route::get('/applicant/dashboard', 'ApplicantProfileController@dashboard')->name('applicant.dashboard');
Route::get('/applicant/profile/edit', 'ApplicantProfileController@editProfile')->name('applicant.edit-profile');
Route::put('/applicant/profile', 'ApplicantProfileController@updateProfile')->name('applicant.update-profile');
Route::post('/applicant/profile/picture', 'ApplicantProfileController@uploadProfilePicture')->name('applicant.upload-picture');
Route::post('/applicant/resume', 'ApplicantProfileController@uploadResume')->name('applicant.upload-resume');
Route::get('/applicant/resume/download', 'ApplicantProfileController@downloadResume')->name('applicant.download-resume');
```

### 6. Middleware & Security

**ApplicantMiddleware** (already exists):

-   Ensures only users with `isApplicant()` role can access applicant pages
-   Redirects unauthorized users to home page

**Access Control:**

-   Applicants only: Dashboard, profile edit, file uploads
-   Employers: Cannot access applicant pages
-   Guests: Redirected to login
-   Admin: Can view all (not restricted by role)

### 7. Navigation Updates

Updated `resources/views/components/navbar.blade.php`:

-   Added "My Dashboard" link in profile dropdown for applicants
-   Added logic to show appropriate dashboard link based on user role:
    -   Applicants: "My Dashboard" → `/applicant/dashboard`
    -   Employers: "Employer Dashboard" → `/employer/dashboard`
    -   Admins: "Admin Dashboard" → `/admin/dashboard`

### 8. Job Application Workflow Integration

When an applicant submits a job application:

1. **Applicant Data Snapshot** - The following data is captured:

    - Applicant name
    - Email
    - Phone
    - Location
    - Skills
    - Bio
    - Profile picture path
    - Resume path

2. **Employer Visibility** - Employers see:

    - Applicant name and profile picture
    - Contact information
    - Skills and bio
    - Resume with download button
    - Application status (Pending, Reviewed, Rejected, Hired)

3. **Updated JobApplicationController**:
    - Captures user data when storing application
    - Stores snapshot in job_applications table
    - Maintains data integrity for historical applications

## File Locations

### Directories Created

-   `storage/app/public/resumes/` - Uploaded PDF resumes
-   `storage/app/public/profile_pictures/` - Profile images

### Key Files

-   `app/Http/Controllers/ApplicantProfileController.php`
-   `app/Models/User.php` (updated)
-   `app/Models/JobApplication.php` (updated)
-   `resources/views/applicant/dashboard.blade.php`
-   `resources/views/applicant/edit-profile.blade.php`
-   `resources/views/components/navbar.blade.php` (updated)
-   `database/migrations/2025_12_06_add_applicant_fields_to_users.php`
-   `database/migrations/2025_12_06_add_applicant_snapshot_to_job_applications.php`
-   `routes/web.php` (updated)

## Usage Instructions

### For Applicants

1. **Access Dashboard**

    - Log in as applicant
    - Click "My Dashboard" in profile dropdown
    - Or navigate to `/applicant/dashboard`

2. **Upload Profile Picture**

    - Hover over profile picture
    - Click camera icon
    - Select image (JPEG, PNG, GIF)
    - Auto-uploaded

3. **Upload Resume**

    - Click "Upload Resume" button
    - Select PDF file (max 10MB)
    - Auto-uploaded, replaces previous resume

4. **Edit Profile**

    - Click "Edit Profile" button
    - Update any fields
    - Add optional social links
    - Click "Save Changes"

5. **View Applications**
    - Dashboard shows all submitted applications
    - See application status
    - Click to view job details

### For Employers

1. **View Applicant Info**

    - Navigate to job's applicant list
    - Click on applicant
    - See full profile snapshot
    - Download resume

2. **Update Application Status**
    - Set status to: Pending, Reviewed, Rejected, Hired
    - Applicant can see status updates

## Security Features

1. **File Validation**

    - Resume: PDF only, max 10MB
    - Picture: Image types only, max 5MB

2. **Access Control**

    - Applicant middleware ensures role-based access
    - Users can only view/edit their own data
    - Employers cannot access applicant edit pages

3. **Data Protection**
    - Old files automatically deleted when replaced
    - Email verification required for applications
    - Validation on all inputs

## Database Schema

### New Users Table Columns

```sql
contact_number VARCHAR(20) NULL
location VARCHAR(255) NULL
skills TEXT NULL
bio TEXT NULL
profile_picture VARCHAR(255) NULL
resume_path VARCHAR(255) NULL
linkedin_url VARCHAR(255) NULL
github_url VARCHAR(255) NULL
portfolio_url VARCHAR(255) NULL
is_applicant BOOLEAN DEFAULT FALSE
is_employer BOOLEAN DEFAULT FALSE
```

### New Job Applications Columns

```sql
applicant_name VARCHAR(255) NULL
applicant_email VARCHAR(255) NULL
applicant_phone VARCHAR(20) NULL
applicant_location VARCHAR(255) NULL
applicant_skills TEXT NULL
applicant_bio TEXT NULL
applicant_profile_picture VARCHAR(255) NULL
resume_path VARCHAR(255) NULL
application_status ENUM('pending', 'reviewed', 'rejected', 'hired') DEFAULT 'pending'
```

## Testing Checklist

-   [ ] Create applicant account
-   [ ] Upload profile picture
-   [ ] Upload resume PDF
-   [ ] Edit profile with all fields
-   [ ] Add social links
-   [ ] Apply for job (captures snapshot)
-   [ ] View application in dashboard
-   [ ] Check employer sees applicant info
-   [ ] Download resume from employer dashboard
-   [ ] Update application status
-   [ ] Verify permissions (applicant can't access employer pages)

## Future Enhancements

1. Image resizing for profile pictures
2. Resume preview/annotation
3. Application notifications
4. Email alerts for profile updates
5. Download application history
6. Skills endorsements
7. Portfolio project showcase
8. Interview scheduling integration
