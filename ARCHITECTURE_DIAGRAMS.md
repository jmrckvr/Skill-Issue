# System Architecture & Flow Diagrams

## 1. Logo Upload Flow

```
┌─────────────────────────────────────────────────────────────┐
│                  EMPLOYER UPLOADS LOGO                       │
└─────────────────────────────────────────────────────────────┘
         │
         ├─→ Navigate to /company/{id}/edit
         │
         ├─→ [CompanyController@edit]
         │   └─→ Verify user owns company (auth check)
         │   └─→ Load company-edit.blade.php
         │
         └─→ [FORM: company-edit.blade.php]
             ├─→ Display current logo (if exists)
             ├─→ Drag-drop upload area
             └─→ Form submission


    ┌────────────────────────────────────┐
    │  USER SELECTS/DRAGS LOGO FILE     │
    └────────────────────────────────────┘
              │
              └─→ JavaScript Preview
                  ├─→ Read file
                  ├─→ Create preview
                  └─→ Display before submit


    ┌────────────────────────────────────┐
    │  USER CLICKS "SAVE CHANGES"        │
    └────────────────────────────────────┘
              │
              └─→ POST /company/{id} [PATCH method]
                  │
                  ├─→ [CompanyController@update]
                  │   ├─→ Validate input
                  │   ├─→ If new logo:
                  │   │   ├─→ Delete old logo from storage
                  │   │   ├─→ Store new logo to storage/app/public/company-logos/
                  │   │   └─→ Get relative path
                  │   ├─→ Update company record
                  │   │   └─→ companies.logo_path = 'company-logos/abc123.jpg'
                  │   └─→ Save to database
                  │
                  └─→ Redirect back with success message


    ┌────────────────────────────────────┐
    │  LOGO STORED & READY TO USE        │
    └────────────────────────────────────┘
              │
              ├─→ storage/app/public/company-logos/abc123.jpg
              ├─→ Accessible via: /storage/company-logos/abc123.jpg
              └─→ Display in views: asset('storage/' . $company->logo_path)
```

---

## 2. Database Storage Architecture

```
┌──────────────────────────────────────────────────────┐
│                DATABASE (SQLite/MariaDB)              │
├──────────────────────────────────────────────────────┤
│  Table: companies                                    │
├─────────┬──────────────┬──────────────────────────────┤
│ id      │ type         │ Example                      │
├─────────┼──────────────┼──────────────────────────────┤
│ 1       │ INT          │ PRIMARY KEY                  │
│ name    │ VARCHAR(255) │ "ACME Tech Solutions"        │
│ logo_path  │ VARCHAR(255)│ "company-logos/acme.jpg" │ ← NEW
│ ...     │ ...          │ ...                          │
└─────────┴──────────────┴──────────────────────────────┘
                  │
                  └─→ Stores RELATIVE PATH only
                      (not full URL)

┌──────────────────────────────────────────────────────┐
│              FILE SYSTEM STORAGE                     │
├──────────────────────────────────────────────────────┤
│  storage/app/public/company-logos/                   │
│  ├── acme.jpg (150KB)                               │
│  ├── global-finance.png (200KB)                     │
│  └── other-company.webp (100KB)                     │
└──────────────────────────────────────────────────────┘
       ↓ Symlink ↓
┌──────────────────────────────────────────────────────┐
│        public/storage → storage/app/public           │
└──────────────────────────────────────────────────────┘
       ↓ Web Access ↓
┌──────────────────────────────────────────────────────┐
│  /storage/company-logos/acme.jpg (Public URL)       │
└──────────────────────────────────────────────────────┘
```

---

## 3. Job Search Three-Column Layout

```
┌─────────────────────────────────────────────────────────────────┐
│                         NAVBAR (w-full)                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────────┬──────────────────────┬──────────────────────┐  │
│  │  LEFT       │                      │     RIGHT           │  │
│  │  SIDEBAR    │    CENTER COLUMN     │     PANEL           │  │
│  │  w-96       │    flex-1            │     w-96            │  │
│  │             │                      │                     │  │
│  │  • Search   │  JOB CARDS LIST      │  [DETAILS]          │  │
│  │  • Filters  │  ┌────────────────┐  │  ┌──────────────┐   │  │
│  │  • Category │  │ [Logo] Job 1   │  │  │ Company Logo │   │  │
│  │  • Type     │  │ Click →        │  │  │ Job Title    │   │  │
│  │  • Level    │  │ [Highlights]   │  │  │ Company Name │   │  │
│  │  • Quick    │  ├────────────────┤  │  ├──────────────┤   │  │
│  │    Links    │  │ [Logo] Job 2   │  │  │ Location ✓   │   │  │
│  │             │  │                │  │  │ Salary ✓     │   │  │
│  │ ┌─────────┐ │  ├────────────────┤  │  │ Job Type ✓   │   │  │
│  │ │ Search  │ │  │ [Logo] Job 3   │  │  │ Posted ✓     │   │  │
│  │ │ Button  │ │  │                │  │  ├──────────────┤   │  │
│  │ └─────────┘ │  ├────────────────┤  │  │ [APPLY BTN]  │   │  │
│  │             │  │ [Logo] Job 4   │  │  │ [SAVE BTN]   │   │  │
│  │ Dark Theme  │  │                │  │  ├──────────────┤   │  │
│  │ bg-slate-900│  └────────────────┘  │  │ Description  │   │  │
│  │             │  Light Theme          │  │ Company Info │   │  │
│  │             │  bg-gray-50           │  │ View Details │   │  │
│  │             │                       │  │              │   │  │
│  │             │ Scrollable            │  │ Dynamic AJAX │   │  │
│  │             │ Shows all jobs        │  │ Loading      │   │  │
│  │             │                       │  │ White Theme  │   │  │
│  │             │                       │  │ bg-white     │   │  │
│  │             │                       │  │              │   │  │
│  └─────────────┴──────────────────────┴──────────────────────┘  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
        lg breakpoint: LEFT hidden
        xl breakpoint: All visible
```

---

## 4. Job Details Dynamic Loading

```
USER CLICKS JOB CARD
     │
     └─→ JavaScript: initJobCards()
         │
         ├─→ Add click listener to all .job-card elements
         └─→ Get jobId from data-job-id attribute


    ┌──────────────────────────┐
    │  User Clicks Job Card    │
    └──────────────────────────┘
              │
              └─→ JavaScript: loadJobDetails(jobId)
                  │
                  ├─→ Highlight selected job
                  │   └─→ Add blue background & border
                  │
                  └─→ Fetch data from API
                      │
                      └─→ GET /api/jobs/{jobId}
                          │
                          ├─→ [JobController@apiShow]
                          │   ├─→ Fetch job with relations
                          │   ├─→ Build JSON response
                          │   └─→ Include company logo
                          │
                          └─→ Return JSON:
                              {
                                "success": true,
                                "job": {
                                  "id": 1,
                                  "title": "...",
                                  "company": {
                                    "logo_path": "company-logos/acme.jpg"
                                  },
                                  ...
                                }
                              }


    ┌──────────────────────────┐
    │  RIGHT PANEL UPDATES     │
    └──────────────────────────┘
         │
         └─→ displayJobDetails(job)
             │
             ├─→ Generate HTML with:
             │   ├─→ Company logo (or initials)
             │   ├─→ Job details
             │   ├─→ Action buttons
             │   └─→ Company info
             │
             └─→ Inject into #jobDetailsPanel
                 │
                 └─→ User sees details on RIGHT
                     No page refresh needed!
```

---

## 5. File Upload Process

```
COMPANY UPLOAD WORKFLOW
═════════════════════════════════════════════════════════════

1. USER INTERFACE
   ┌─────────────────────────────────────┐
   │  company-edit.blade.php             │
   │  ┌───────────────────────────────┐  │
   │  │  Drag-Drop Upload Area        │  │
   │  │  ✓ Click to select            │  │
   │  │  ✓ Drag & drop support        │  │
   │  │  ✓ Real-time preview          │  │
   │  │  ✓ File size check            │  │
   │  └───────────────────────────────┘  │
   └─────────────────────────────────────┘

2. JAVASCRIPT PROCESSING (CLIENT-SIDE)
   ┌─────────────────────────────────────┐
   │  previewLogo() function             │
   │  ├─ Read file                       │
   │  ├─ Check type (JPEG/PNG/GIF/WebP) │
   │  ├─ Check size (< 2MB)             │
   │  ├─ Create preview image           │
   │  └─ Display preview in form         │
   └─────────────────────────────────────┘

3. FORM SUBMISSION
   ┌─────────────────────────────────────┐
   │  PATCH /company/{id}                │
   │  Multipart Form-Data                │
   │  ├─ _token (CSRF)                   │
   │  ├─ name                            │
   │  ├─ description                     │
   │  ├─ logo (FILE)  ← KEY PART        │
   │  └─ other fields...                 │
   └─────────────────────────────────────┘

4. LARAVEL VALIDATION
   ┌─────────────────────────────────────┐
   │  $request->validate([               │
   │    'logo' =>                        │
   │      'nullable|                     │
   │       image|                        │
   │       mimes:jpeg,png,jpg,gif,webp| │
   │       max:2048'                     │
   │  ])                                 │
   └─────────────────────────────────────┘

5. FILE STORAGE
   ┌─────────────────────────────────────┐
   │  $request->file('logo')->store(     │
   │    'company-logos',                 │
   │    'public'                         │
   │  )                                  │
   │  Returns:                           │
   │  'company-logos/abc123.jpg'         │
   └─────────────────────────────────────┘

6. OLD FILE CLEANUP
   ┌─────────────────────────────────────┐
   │  if ($company->logo_path) {         │
   │    Storage::disk('public')          │
   │      ->delete($old_path)            │
   │  }                                  │
   │  ✓ Prevents storage bloat           │
   │  ✓ Keeps system clean               │
   └─────────────────────────────────────┘

7. DATABASE UPDATE
   ┌─────────────────────────────────────┐
   │  $company->update([                 │
   │    'logo_path' =>                   │
   │      'company-logos/abc123.jpg',    │
   │    'name' => $request->name,        │
   │    ...                              │
   │  ])                                 │
   └─────────────────────────────────────┘

8. REDIRECT
   ┌─────────────────────────────────────┐
   │  return back()->with('success',     │
   │    'Company profile updated!'       │
   │  )                                  │
   │  ✓ User sees success message        │
   │  ✓ Logo now visible in forms        │
   └─────────────────────────────────────┘
```

---

## 6. Data Flow: From Upload to Display

```
UPLOADING FLOW (Employer)
══════════════════════════════════════════════════════

1. Upload Form
   ├─→ File selected: "company-logo.jpg"
   └─→ Submit to PATCH /company/1

2. Server Processing
   ├─→ Validate file
   ├─→ Store to storage/app/public/company-logos/
   │   Result: "company-logos/abc1234567.jpg"
   ├─→ Delete old file if exists
   └─→ Update companies.logo_path = "company-logos/abc1234567.jpg"

3. In Database
   ├─→ companies table, company_id=1
   └─→ logo_path="company-logos/abc1234567.jpg"


DISPLAY FLOW (Job Seeker Viewing Search Page)
═══════════════════════════════════════════════════════

1. User loads /search
   ├─→ HomeController@search
   ├─→ Fetch jobs: Job::published()->get()
   └─→ Pass to view

2. Blade Template Rendering
   ├─→ Loop through jobs
   │   @foreach($jobs as $job)
   ├─→ For each job, access company:
   │   $job->company->logo_path
   ├─→ Check if exists:
   │   @if($job->company->logo_path)
   └─→ If yes, render:
       <img src="{{ asset('storage/' . $job->company->logo_path) }}">

3. Asset Helper Processing
   ├─→ asset('storage/company-logos/abc1234567.jpg')
   └─→ Returns: /storage/company-logos/abc1234567.jpg

4. Browser HTTP Request
   ├─→ GET /storage/company-logos/abc1234567.jpg
   └─→ Symlink routes to: storage/app/public/company-logos/abc1234567.jpg

5. File Served
   ├─→ Web server returns file
   ├─→ Browser renders as <img>
   └─→ User sees company logo! ✓

6. AJAX Display (Right Panel)
   ├─→ User clicks job
   ├─→ JavaScript calls: loadJobDetails(jobId)
   ├─→ Fetch /api/jobs/{jobId}
   ├─→ Response includes: company.logo_path
   ├─→ JavaScript builds HTML:
   │   <img src="/storage/company-logos/abc1234567.jpg">
   └─→ Inject into right panel
```

---

## 7. Component Hierarchy

```
search.blade.php (Main View)
│
├── Layout Container
│   ├── Left Sidebar (Search Filters)
│   │   ├── Header
│   │   ├── Search Form
│   │   │   ├── Keyword Input
│   │   │   ├── Location Input
│   │   │   ├── Category Select
│   │   │   ├── Job Type Select
│   │   │   ├── Experience Level Select
│   │   │   └── Submit Button
│   │   ├── Quick Links
│   │   └── Clear Filters Link
│   │
│   ├── Center Column (Job List)
│   │   ├── Header
│   │   └── Job Cards (Loop)
│   │       ├── Company Logo
│   │       ├── Job Title
│   │       ├── Company Name
│   │       ├── Meta Info (location, type, date)
│   │       └── Salary & Applications
│   │
│   └── Right Panel (Job Details - JavaScript)
│       ├── Empty State (initial)
│       └── Job Details (after AJAX load)
│           ├── Company Logo
│           ├── Job Title
│           ├── Key Info Section
│           ├── Action Buttons
│           ├── Description
│           ├── Company Info
│           └── View Full Details Link
│
└── JavaScript
    ├── initJobCards() - Initialize listeners
    ├── loadJobDetails() - Fetch via AJAX
    └── displayJobDetails() - Render response
```

---

## 8. Security & Authorization Flow

```
UPLOAD AUTHORIZATION
═══════════════════════════════════════════════════════

Request: PATCH /company/{id}
     │
     └─→ Route Middleware: ['auth', 'verified']
         │
         └─→ Auth check: User logged in? ✓
             │
             └─→ Route Middleware: ['employer']
                 │
                 └─→ Role check: User is employer? ✓
                     │
                     └─→ Controller: CompanyController@update
                         │
                         └─→ Authorization Check:
                             if ($company->user_id !== auth()->id()) {
                                 abort(403)  ← Forbidden!
                             }
                         │
                         └─→ User owns company? ✓
                             │
                             └─→ Process upload
                                 ├─→ Validate file
                                 ├─→ Store file
                                 ├─→ Update database
                                 └─→ Return success ✓


LOGO DISPLAY (PUBLIC)
═══════════════════════════════════════════════════════

Symlink Route: /storage/company-logos/{file}
     │
     └─→ No auth required
         │
         └─→ File served publicly ✓
             (Already stored in public directory via symlink)


VIEWING OWN COMPANY LOGO
═════════════════════════════════════════════════════════

GET /company/{id}/edit
     │
     └─→ Route Middleware: ['employer']
         │
         └─→ Controller: CompanyController@edit
             │
             └─→ Authorization Check:
                 if ($company->user_id !== auth()->id()) {
                     abort(403)  ← Only owner can view!
                 }
             │
             └─→ Load form with current logo ✓
```

---

## 9. Error Handling Flow

```
LOGO UPLOAD ERROR SCENARIOS
═════════════════════════════════════════════════════════

Invalid File Type
├─→ User selects .exe file
├─→ Laravel validation catches it
└─→ Returns error message
    "The logo must be an image."

File Too Large
├─→ User selects 5MB file
├─→ Laravel validation catches it
└─→ Returns error message
    "The logo may not be greater than 2048 kilobytes."

Storage Permission Error
├─→ storage/ directory not writable
├─→ PHP throws exception
└─→ Laravel logs error
    → User sees "Upload failed" message

Old Logo Not Found
├─→ logo_path in DB but file missing
├─→ Storage::delete() doesn't throw error
├─→ Upload proceeds normally ✓

Symlink Not Created
├─→ /storage directory not accessible
├─→ Logo URL appears broken
├─→ Solution: php artisan storage:link
```

---

This is the complete system architecture! 🎉
