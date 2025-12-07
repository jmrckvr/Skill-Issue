# Logo Upload System & JobStreet-Style Search Layout - Implementation Guide

## Overview

This implementation adds a complete company logo upload system and redesigns the job search page with a modern three-column JobStreet-style layout.

---

## 🏗️ Architecture & Storage Configuration

### Storage Path Structure

All company logos are stored in a dedicated directory:

```
storage/app/public/company-logos/
├── company-1-logo.jpg
├── company-2-logo.png
└── company-3-webp
```

### Key Paths

| Item                 | Path                                      |
| -------------------- | ----------------------------------------- |
| **Storage Location** | `storage/app/public/company-logos/`       |
| **Web Access**       | `/storage/company-logos/[filename]`       |
| **Database Field**   | `companies.logo_path`                     |
| **Blade Usage**      | `asset('storage/' . $company->logo_path)` |

### Setup Requirements

Before using the logo system, run the following command to create the storage symlink:

```bash
php artisan storage:link
```

This command creates a symbolic link from `public/storage` to `storage/app/public`, enabling direct web access to uploaded files.

**Permissions:**

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 📝 Company Logo Upload System

### 1. Database Column

The `companies` table already has the `logo_path` column:

```php
$table->string('logo_path')->nullable();
```

### 2. Controller: `CompanyController`

Located at: `app/Http/Controllers/CompanyController.php`

**Methods:**

#### `edit(Company $company)`

-   Shows the company edit form
-   Displays current logo preview
-   Authorization: Company must belong to current user

#### `update(Request $request, Company $company)`

-   Updates company information including logo
-   Validates logo: `image|mimes:jpeg,png,jpg,gif,webp|max:2048` (2MB max)
-   Automatically deletes old logo when new one uploaded
-   Stores in `storage/app/public/company-logos/`
-   Authorization: Company must belong to current user

#### `deleteLogo(Company $company)`

-   Removes logo from storage and database
-   Sets `logo_path` to null
-   Authorization: Company must belong to current user

### 3. Routes

All routes are protected by `employer` middleware:

```php
Route::middleware('employer')->group(function () {
    Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::patch('/company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('/company/{company}/logo', [CompanyController::class, 'deleteLogo'])->name('company.logo.delete');
});
```

### 4. View: `employer/company-edit.blade.php`

Complete company profile editing form with:

-   **Logo Preview Section:**

    -   Current logo display with remove button
    -   Drag-and-drop upload area
    -   Real-time preview before upload
    -   File size and name display

-   **Company Information Fields:**

    -   Company Name (required)
    -   Description
    -   Website URL
    -   Email & Phone
    -   Industry, City, State, Country
    -   Employee Count

-   **Features:**
    -   Drag-and-drop logo upload
    -   Click-to-upload input
    -   Real-time image preview
    -   Error messages and validation feedback
    -   Success confirmation message

### 5. Usage in Views

**Display company logo in templates:**

```blade
@if($company->logo_path)
    <img src="{{ asset('storage/' . $company->logo_path) }}"
         alt="{{ $company->name }}"
         class="w-32 h-32 rounded-lg object-cover">
@else
    <div class="w-32 h-32 rounded-lg bg-blue-100 flex items-center justify-center">
        <span class="text-blue-600 font-bold text-2xl">{{ substr($company->name, 0, 1) }}</span>
    </div>
@endif
```

---

## 🎨 JobStreet-Style Search Layout

### Layout Architecture

The new job search page uses a three-column responsive layout:

```
┌─────────────────────────────────────────────────────────┐
│                        Navbar                            │
├──────────────┬─────────────────────────┬────────────────┤
│   LEFT       │       CENTER            │     RIGHT      │
│  SIDEBAR     │    JOB LIST             │  JOB DETAILS   │
│  (Filters)   │  (Scrollable)           │  (Dynamic)     │
│              │                          │                │
│  • Search    │  [Job Card 1]          │  [Details]     │
│  • Category  │  [Job Card 2]          │  [Apply]       │
│  • Type      │  [Job Card 3]          │  [Save]        │
│  • Level     │  ...                    │  [Company]     │
│              │                          │                │
└──────────────┴─────────────────────────┴────────────────┘
```

### Responsive Behavior

| Screen Size      | Layout                                        |
| ---------------- | --------------------------------------------- |
| **Mobile**       | Center column only (full width)               |
| **Tablet**       | Left sidebar hidden, Center column full width |
| **Desktop (lg)** | Left + Center visible                         |
| **Desktop (xl)** | All three columns visible                     |

### Components

#### Left Sidebar (Search Filters)

-   File: `resources/views/jobs/search.blade.php` (Lines 1-88)
-   Dark theme (`bg-gradient-to-b from-slate-900...`)
-   Search form with filters:
    -   Keyword search
    -   Location search
    -   Category dropdown
    -   Job type dropdown
    -   Experience level dropdown
-   Quick links for popular filters
-   Clear filters button

#### Center Column (Job List)

-   File: `resources/views/jobs/search.blade.php` (Lines 89-165)
-   Light background (`bg-gray-50`)
-   Job card list showing:
    -   Company logo
    -   Job title
    -   Company name
    -   Location, job type, posted date
    -   Salary range
    -   Application count
-   Hover effects and selection highlighting
-   Loading states

#### Right Panel (Job Details)

-   File: `resources/views/jobs/search.blade.php` (Lines 166-250)
-   White background
-   Loads dynamically via AJAX
-   Shows:
    -   Company logo
    -   Job title and company name
    -   Location, salary, job type, posted date
    -   Quick apply button
    -   Save job button
    -   Full description
    -   Company info (industry, size)
    -   Link to full job details page

### JavaScript Functionality

#### Job Card Selection

```javascript
document.querySelectorAll(".job-card").forEach((card) => {
    card.addEventListener("click", function (e) {
        e.preventDefault();
        const jobId = this.getAttribute("data-job-id");

        // Highlight selected job
        document.querySelectorAll(".job-card").forEach((c) => {
            c.classList.remove("bg-blue-50", "border-blue-600");
            c.classList.add("border-transparent");
        });
        this.classList.add("bg-blue-50", "border-blue-600");

        // Load job details
        loadJobDetails(jobId);
    });
});
```

#### Dynamic Content Loading

```javascript
function loadJobDetails(jobId) {
    fetch(`/api/jobs/${jobId}`)
        .then((response) => response.json())
        .then((data) => displayJobDetails(data.job))
        .catch((error) => console.error("Error:", error));
}
```

#### Display Job Details

The `displayJobDetails()` function renders the right panel with:

-   Company logo (or initials fallback)
-   Job information
-   Action buttons (apply/save)
-   Company details
-   Link to full job page

---

## 📋 Job Creation/Edit Forms

### Updated Job Form

Location: `resources/views/employer/job-form.blade.php`

**New Feature: Company Logo Preview Section**

At the top of the form, displays:

-   Company name, industry, location
-   Current company logo with fallback
-   Link to update company profile and logo

This provides context to employers about whose name the job will be posted under.

---

## 🔄 API Endpoint

The right panel loads job details via the existing API endpoint:

```
GET /api/jobs/{job}
```

**Response Format:**

```json
{
    "success": true,
    "job": {
        "id": 1,
        "title": "Senior PHP Developer",
        "description": "...",
        "location": "Manila",
        "job_type": "full-time",
        "experience_level": "senior",
        "salary_min": 150000,
        "salary_max": 200000,
        "hide_salary": false,
        "formatted_salary": "PHP 150,000 - 200,000",
        "posted_at": "2 days ago",
        "requirements": "PHP 8+, Laravel, MySQL",
        "benefits": "Health Insurance, Gym Membership",
        "is_saved": false,
        "company": {
            "id": 1,
            "name": "ACME Tech Solutions",
            "logo_path": "company-logos/acme-logo.jpg",
            "industry": "Information Technology",
            "employee_count": 150
        }
    }
}
```

---

## 🚀 How to Use

### For Employers: Upload/Update Logo

1. Go to **Employer Dashboard**
2. Click **"Edit Company Profile"** button
3. In the company edit form:
    - Scroll to "Company Logo" section
    - Either:
        - Click in the upload area to select a file
        - Drag and drop an image onto the area
    - See real-time preview
    - Click **"Save Changes"**
4. Logo is now stored and displayed in:
    - Job postings
    - Job search page
    - Job detail pages

### For Job Seekers: Browse Jobs

1. Navigate to **"Browse Jobs"** or `/search`
2. **Left sidebar:** Use filters to narrow down jobs
3. **Center column:** Click any job card to see details
4. **Right panel:** Job details load dynamically
    - Click **"Quick apply"** to apply
    - Click **"Save"** to bookmark
5. Click **"View full details"** to see complete job page

---

## 📁 File Structure

```
app/Http/Controllers/
├── CompanyController.php (NEW)
└── JobController.php (MODIFIED - added company logo to API response)

resources/views/employer/
├── company-edit.blade.php (NEW)
├── dashboard.blade.php (existing - shows company profile)
└── job-form.blade.php (MODIFIED - added logo preview section)

resources/views/jobs/
└── search.blade.php (COMPLETELY REDESIGNED - three-column layout)

routes/
└── web.php (MODIFIED - added company routes)

storage/app/public/
└── company-logos/ (Storage directory for logos)
```

---

## 🔐 Security & Authorization

### Authorization Checks

All company routes enforce ownership:

```php
if ($company->user_id !== auth()->id()) {
    abort(403);
}
```

Only the user who owns the company can:

-   Edit company profile
-   Upload/update logo
-   Delete logo

### File Validation

Logo uploads are validated:

-   **Types:** JPEG, PNG, GIF, WebP
-   **Max Size:** 2MB
-   **Stored securely** in non-public directory, accessed via symlink

### Storage Security

-   Files stored in `storage/app/public/` (outside public root)
-   Accessed via symlink at `public/storage/`
-   Laravel handles proper permissions

---

## 🐛 Troubleshooting

### Logo Not Displaying

1. **Check symlink:**

    ```bash
    php artisan storage:link
    ```

2. **Check file permissions:**

    ```bash
    chmod -R 775 storage/
    ```

3. **Verify database:**
    ```sql
    SELECT * FROM companies WHERE logo_path IS NOT NULL;
    ```

### Upload Fails

1. **Check file size:** Max 2MB
2. **Check file type:** Must be JPEG, PNG, GIF, or WebP
3. **Check storage permissions:** `chmod 775 storage/`
4. **Check disk space:** Ensure sufficient disk space

### Right Panel Not Loading

1. **Check API endpoint:** `GET /api/jobs/{id}` should return JSON
2. **Check browser console:** Look for JavaScript errors
3. **Check CSRF token:** Should be included in forms

---

## 📊 Database

### Companies Table

```sql
ALTER TABLE companies ADD COLUMN logo_path VARCHAR(255) NULLABLE;
-- Already exists in migration: 2025_11_18_133615_create_companies_table.php
```

### Migration

File: `database/migrations/2025_11_18_133615_create_companies_table.php`

```php
$table->string('logo_path')->nullable();
```

---

## ✅ Testing Checklist

-   [ ] Run `php artisan storage:link`
-   [ ] Set storage permissions: `chmod -R 775 storage/`
-   [ ] Create test company with logo
-   [ ] Verify logo displays in search page
-   [ ] Verify logo displays in job form
-   [ ] Test job search with filters
-   [ ] Test clicking job cards
-   [ ] Verify right panel loads job details
-   [ ] Test apply and save buttons
-   [ ] Test logo update and deletion
-   [ ] Test responsive layout on mobile/tablet

---

## 🎯 Summary of Changes

| Feature                  | File                                  | Type       |
| ------------------------ | ------------------------------------- | ---------- |
| Logo upload              | CompanyController.php                 | NEW        |
| Company edit form        | company-edit.blade.php                | NEW        |
| Company routes           | routes/web.php                        | MODIFIED   |
| Three-column layout      | resources/views/jobs/search.blade.php | REDESIGNED |
| Logo preview in job form | employer/job-form.blade.php           | MODIFIED   |
| API response             | JobController.php                     | ENHANCED   |

---

## 📞 Support

For issues or questions:

1. Check the troubleshooting section above
2. Review file permissions and storage setup
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify database migrations: `php artisan migrate:status`

---

**Implementation Date:** November 24, 2025
**Status:** ✅ Complete and Ready for Production
