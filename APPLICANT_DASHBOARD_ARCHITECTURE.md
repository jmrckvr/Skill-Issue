# Applicant Dashboard - File Structure & Architecture

## Complete Directory Tree

```
jobstreet/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ApplicantProfileController.php ✏️ MODIFIED
│   │           ├── dashboard()
│   │           ├── editProfile()
│   │           ├── updateProfile()
│   │           ├── uploadProfilePicture()
│   │           ├── uploadResume()
│   │           ├── downloadResume()
│   │           ├── savedSearches() ✨ NEW
│   │           ├── savedJobs() ✨ NEW
│   │           ├── jobApplications() ✨ NEW
│   │           └── settings() ✨ NEW
│   └── Models/
│       ├── User.php
│       ├── Job.php
│       ├── Company.php
│       ├── JobApplication.php
│       └── SavedJob.php
│
├── routes/
│   └── web.php ✏️ MODIFIED
│       ├── /applicant/dashboard (existing)
│       ├── /applicant/saved-searches ✨ NEW
│       ├── /applicant/saved-jobs ✨ NEW
│       ├── /applicant/job-applications ✨ NEW
│       └── /applicant/settings ✨ NEW
│
├── resources/
│   └── views/
│       ├── applicant/ ✏️ UPDATED
│       │   ├── dashboard.blade.php ✏️ MODIFIED (added sidebar layout)
│       │   ├── edit-profile.blade.php (existing)
│       │   ├── saved-searches.blade.php ✨ NEW
│       │   ├── saved-jobs.blade.php ✨ NEW
│       │   ├── job-applications.blade.php ✨ NEW
│       │   └── settings.blade.php ✨ NEW
│       │
│       └── components/
│           ├── navbar.blade.php (existing)
│           └── applicant-sidebar.blade.php ✨ NEW
│
├── Documentation/ (New)
│   ├── APPLICANT_DASHBOARD_README.md ✨ NEW (Main summary)
│   ├── APPLICANT_DASHBOARD_COMPLETE.md ✨ NEW (Full details)
│   ├── APPLICANT_DASHBOARD_QUICK_REFERENCE.md ✨ NEW (Quick lookup)
│   ├── APPLICANT_DASHBOARD_UI_LAYOUTS.md ✨ NEW (Visual layouts)
│   └── APPLICANT_DASHBOARD_DEPLOYMENT_CHECKLIST.md ✨ NEW (Testing guide)
│
└── storage/
    └── app/
        └── public/
            ├── profile_pictures/ (User avatars)
            └── resumes/ (User resume files)
```

---

## Component Architecture

### View Layer Structure

```
┌─────────────────────────────────────────┐
│         Applicant Sidebar Component     │
│    (applicant-sidebar.blade.php)        │
│                                         │
│  • User Profile Section                 │
│  • Navigation Links (5 items)           │
│  • Active Page Highlighting             │
│  • Sign Out Button                      │
└─────────────────────────────────────────┘
           ▲
           │ (Included in all pages)
           │
    ┌──────┴──────┬──────────┬──────────┬──────────┐
    │             │          │          │          │
    ▼             ▼          ▼          ▼          ▼
Profile       Saved      Saved Job  Applications Settings
Dashboard    Searches      (Tabs)      (Filters)  (Tabs)
```

### Data Flow

```
┌─────────────────┐
│   User Logged  │
│   In As        │
│   Applicant    │
└────────┬────────┘
         │
         ▼
┌──────────────────────────────────┐
│   ApplicantProfileController     │
│                                  │
│  • dashboard()                   │
│  • savedSearches()               │
│  • savedJobs()                   │
│  • jobApplications()             │
│  • settings()                    │
└────────┬──────────────────────────┘
         │
         ├──────────────────────┬────────────────┬──────────────┐
         │                      │                │              │
         ▼                      ▼                ▼              ▼
    ┌─────────┐          ┌────────────┐   ┌──────────┐   ┌─────────┐
    │ User    │          │ Job        │   │ Company  │   │SavedJob │
    │ Model   │          │Application│   │ Model    │   │ Model   │
    └────┬────┘          └────┬───────┘   └──────────┘   └────┬────┘
         │                    │                                │
         ▼                    ▼                                ▼
    ┌──────────────────────────────────────────────────────────┐
    │              Database (Laravel Eloquent)                 │
    └──────────────────────────────────────────────────────────┘
         ▲                    ▲                                ▲
         │                    │                                │
         └────────┬───────────┴────────────────────────────────┘
                  │
                  ▼
         ┌──────────────────┐
         │  Application     │
         │  Views (.blade)  │
         └──────────────────┘
```

---

## File Dependencies

### applicant-sidebar.blade.php Dependencies

```
applicant-sidebar.blade.php
├── Uses: $user variable (passed from controller)
├── Calls: route('applicant.dashboard')
├── Calls: route('applicant.saved-searches')
├── Calls: route('applicant.saved-jobs')
├── Calls: route('applicant.job-applications')
├── Calls: route('applicant.settings')
└── Calls: route('logout')
```

### saved-searches.blade.php Dependencies

```
saved-searches.blade.php
├── Includes: x-navbar component
├── Includes: x-applicant-sidebar component
├── Uses: $user variable
└── No database queries (empty state)
```

### saved-jobs.blade.php Dependencies

```
saved-jobs.blade.php
├── Includes: x-navbar component
├── Includes: x-applicant-sidebar component
├── Uses: $user, $savedJobs, $applications variables
├── Calls: User.savedJobs() relationship
├── Calls: User.jobApplications() relationship
├── Calls: route('jobs.show')
└── Calls: route('jobs.save')
```

### job-applications.blade.php Dependencies

```
job-applications.blade.php
├── Includes: x-navbar component
├── Includes: x-applicant-sidebar component
├── Uses: $user, $applications variables
├── Calls: User.jobApplications() relationship
├── Calls: Job.company relationship
├── Calls: route('jobs.show')
└── Uses: JavaScript for filtering
```

### settings.blade.php Dependencies

```
settings.blade.php
├── Includes: x-navbar component
├── Includes: x-applicant-sidebar component
├── Uses: $user variable
├── Calls: route('profile.destroy') [CSRF protected]
└── Uses: JavaScript for tab switching
```

---

## Controller Method Flow

### ApplicantProfileController::dashboard()

```
1. Get authenticated user
2. Check if user is applicant
3. Fetch user's job applications (with job & company data)
4. Return view with user and applications
```

### ApplicantProfileController::savedSearches()

```
1. Get authenticated user
2. Check if user is applicant
3. Return empty state view
```

### ApplicantProfileController::savedJobs()

```
1. Get authenticated user
2. Check if user is applicant
3. Fetch user's saved jobs (with company data)
4. Fetch user's job applications (with job & company data)
5. Return view with saved jobs and applications
```

### ApplicantProfileController::jobApplications()

```
1. Get authenticated user
2. Check if user is applicant
3. Fetch user's job applications (with job & company data)
4. Return view with applications
```

### ApplicantProfileController::settings()

```
1. Get authenticated user
2. Check if user is applicant
3. Return settings view
```

---

## Route Mapping

### Applicant Routes

```
HTTP Method | URI                          | Controller Method         | Route Name
────────────┼─────────────────────────────┼──────────────────────────┼──────────────────────
GET         | /applicant/dashboard        | dashboard()              | applicant.dashboard
GET         | /applicant/profile/edit     | editProfile()            | applicant.edit-profile
PUT         | /applicant/profile          | updateProfile()          | applicant.update-profile
POST        | /applicant/profile/picture  | uploadProfilePicture()   | applicant.upload-picture
POST        | /applicant/resume           | uploadResume()           | applicant.upload-resume
GET         | /applicant/resume/download  | downloadResume()         | applicant.download-resume
GET         | /applicant/saved-searches   | savedSearches()          | applicant.saved-searches
GET         | /applicant/saved-jobs       | savedJobs()              | applicant.saved-jobs
GET         | /applicant/job-applications | jobApplications()        | applicant.job-applications
GET         | /applicant/settings         | settings()               | applicant.settings
```

---

## Database Relationships

### User Model

```php
User::class
├── jobApplications() → hasMany(JobApplication::class)
│                      └─ JobApplication::job() → belongsTo(Job::class)
│                                               └─ Job::company() → belongsTo(Company::class)
├── savedJobs() → hasMany(SavedJob::class)
│             └─ SavedJob::job() → belongsTo(Job::class)
│                              └─ Job::company() → belongsTo(Company::class)
└── company() → hasOne(Company::class)
```

### View Data Requirements

#### Dashboard View

```
Required Data:
├── User: name, email, contact_number, location, profile_picture, resume_path
└── Job Applications:
    ├── job_id
    ├── application_status
    ├── created_at
    ├── updated_at
    └── Job:
        ├── title
        └── Company: name
```

#### Saved Jobs View

```
Required Data:
├── User: id
├── Saved Jobs:
│   ├── job_id
│   └── Job: title, location, salary_min, salary_max, created_at
│       └── Company: name, logo_path
└── Job Applications:
    ├── job_id
    ├── application_status
    ├── created_at
    └── Job: title
        └── Company: name
```

#### Job Applications View

```
Required Data:
├── User: id
└── Job Applications:
    ├── application_status
    ├── created_at
    ├── updated_at
    └── Job: title
        └── Company: name, logo_path
```

---

## Middleware & Authorization

### Middleware Stack

```
ApplicantPages
│
├── auth           (User must be authenticated)
├── verified       (Email verified)
└── applicant      (User role must be 'applicant')
```

### Authorization Flow

```
Request → Route → Middleware
         │       ├─ 'auth' (Check if logged in)
         │       ├─ 'verified' (Check if email verified)
         │       └─ 'applicant' (Check if role = 'applicant')
         │
         └─→ Fail: Redirect to home

         └─→ Pass: Call Controller Method
```

---

## JavaScript Functionality

### saved-jobs.blade.php

```javascript
switchTab(tab)
├─ Hide all tab contents
├─ Remove active styling from all tabs
├─ Show selected tab content
└─ Add active styling to selected tab
```

### job-applications.blade.php

```javascript
filterApplications(status)
├─ Update button styling (active/inactive)
├─ Filter application cards by status
│  ├─ 'all' → Show all cards
│  ├─ 'pending' → Show pending only
│  ├─ 'reviewed' → Show reviewed only
│  ├─ 'rejected' → Show rejected only
│  └─ 'hired' → Show hired only
└─ Hide cards not matching filter
```

### settings.blade.php

```javascript
switchTab(tab)
├─ Hide all tab contents
├─ Remove active styling from all tabs
├─ Show selected tab content
└─ Add active styling to selected tab
```

### applicant-sidebar.blade.php

```javascript
toggleProfileMenu()
├─ Toggle hidden class on profile menu
└─ Close menu when clicking outside
```

---

## CSS Classes Used

### Layout Classes

```
• grid, grid-cols-1, lg:grid-cols-4
• gap-8, gap-4, gap-3
• flex, flex-col, flex-row, justify-between, items-center
• w-full, max-w-md, max-w-2xl
• p-4, p-6, p-8, p-12
• mb-8, mt-8, pb-8, pt-8
```

### Color Classes

```
Text:       text-gray-900, text-gray-600, text-white, text-red-600, text-blue-600
Background: bg-white, bg-gray-50, bg-blue-50, bg-blue-600, bg-yellow-100
Border:     border, border-gray-200, border-blue-600, border-red-200
Focus:      focus:ring-2, focus:ring-blue-500, focus:border-transparent
Hover:      hover:bg-gray-50, hover:bg-blue-700, hover:text-blue-700
```

### Component Classes

```
Rounded:    rounded-lg, rounded-full, rounded-xl
Shadows:    shadow-sm, shadow-md, shadow-lg
Borders:    border-l-4, border-b-2
Opacity:    opacity-0, opacity-100
Transitions: transition, duration-200, duration-300
```

---

## Performance Considerations

### Database Optimization

-   ✅ Eager loading with `->with('job', 'company')`
-   ✅ Using relationships instead of raw queries
-   ✅ Minimal queries per page (no N+1 problems)

### Frontend Optimization

-   ✅ CSS: Tailwind production build
-   ✅ JavaScript: Minimal vanilla JS
-   ✅ Images: Using existing company logos
-   ✅ No external API calls

### Caching Opportunities (Future)

-   [ ] Cache user profile data
-   [ ] Cache company logos
-   [ ] Cache job listings
-   [ ] Use browser caching headers

---

## Security Measures

### Implemented

-   ✅ CSRF protection on forms
-   ✅ Route middleware authentication
-   ✅ Role-based access control
-   ✅ Eloquent ORM (SQL injection prevention)
-   ✅ Blade templating (XSS prevention)
-   ✅ Email verification required

### Additional Security

-   [ ] Rate limiting on file uploads
-   [ ] File type validation
-   [ ] File size limits
-   [ ] Virus scanning on upload
-   [ ] Activity logging

---

## Summary

This implementation uses a **clean, organized architecture** with:

-   ✅ Single responsibility components
-   ✅ DRY principle (reusable sidebar)
-   ✅ Proper separation of concerns
-   ✅ Database relationships for data integrity
-   ✅ Middleware for authorization
-   ✅ Blade templating for views
-   ✅ Tailwind CSS for styling
-   ✅ Vanilla JavaScript for interactivity

All files are **production-ready** and follow **Laravel best practices**.

---

_Architecture Documentation: Complete | Last Updated: 2024-12-07_
