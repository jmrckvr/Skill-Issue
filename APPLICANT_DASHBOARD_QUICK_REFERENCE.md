# Applicant Dashboard - Quick Reference Guide

## 📊 Dashboard Structure

```
┌─────────────────────────────────────────────────────────────────┐
│  JobStreet Navbar                                               │
│  [Logo] [Home] [Browse Jobs] [Companies] [Community] [Profile▼] │
└─────────────────────────────────────────────────────────────────┘
                           │
                           ▼
        ┌──────────────────────────────────────────┐
        │   Applicant Dashboard Pages              │
        ├──────────────────────────────────────────┤
        │                                          │
        │  ┌─────────────┐  ┌──────────────────┐  │
        │  │   SIDEBAR   │  │   MAIN CONTENT   │  │
        │  │             │  │                  │  │
        │  │ • Profile   │  │ [Page Content]   │  │
        │  │ • Searches  │  │ [Page Content]   │  │
        │  │ • Jobs      │  │ [Page Content]   │  │
        │  │ • Apps      │  │ [Page Content]   │  │
        │  │ • Settings  │  │                  │  │
        │  │ • Sign out  │  │                  │  │
        │  │             │  │                  │  │
        │  └─────────────┘  └──────────────────┘  │
        │                                          │
        └──────────────────────────────────────────┘
```

## 🎯 Pages Available

### 1️⃣ **Profile** (`/applicant/dashboard`)

-   Edit Profile button
-   Upload/Download Resume
-   Profile Picture (clickable to upload)
-   User Information (Name, Email, Location, Contact)
-   Recent Applications section

### 2️⃣ **Saved Searches** (`/applicant/saved-searches`)

-   Empty state design
-   Call-to-action to start new search
-   Email notification info
-   Update email link

### 3️⃣ **Saved Jobs** (`/applicant/saved-jobs`)

-   **Saved Tab**: All saved jobs with company info, salary, location
-   **Applied Tab**: All job applications with status tracking
-   Fully functional with real data from database

### 4️⃣ **Job Applications** (`/applicant/job-applications`)

-   Filter by Status: All, Pending, Reviewed, Rejected, Hired
-   Application cards with:
    -   Company logo
    -   Job title & company name
    -   Applied date
    -   Status badge (color-coded)
    -   View Job button

### 5️⃣ **Settings** (`/applicant/settings`)

-   **Account Tab**:

    -   Email display with edit option
    -   Change Password option
    -   Delete Account option

-   **Visibility Tab**:

    -   Profile Visibility settings
    -   Identity Verification link

-   **Notifications Tab**:
    -   Job Alerts toggle
    -   Application Updates toggle
    -   Messages toggle
    -   Recommendations toggle

## 🎨 Design System

### Colors

-   **Primary**: Blue (#2563eb) - Buttons, Active states
-   **Success**: Green (#10b981) - Hired status
-   **Warning**: Yellow (#f59e0b) - Pending status
-   **Info**: Blue (#3b82f6) - Reviewed status
-   **Danger**: Red (#ef4444) - Rejected status
-   **Background**: Gray (#f3f4f6)
-   **Text**: Dark Gray (#111827), Light Gray (#6b7280)

### Typography

-   **Headings**: 4xl (32px), 3xl (30px), 2xl (24px), lg (18px)
-   **Body**: sm (14px), base (16px)
-   **Font**: System sans-serif stack (Tailwind default)

### Spacing

-   Card Padding: 1.5rem - 2rem (24px - 32px)
-   Section Gaps: 2rem (32px)
-   Element Gaps: 0.5rem - 1rem (8px - 16px)

### Components

-   **Cards**: White bg, gray border, subtle shadows
-   **Buttons**: Blue primary, gray secondary, red danger
-   **Badges**: Colored backgrounds with matching text
-   **Tabs**: Border-bottom active indicator
-   **Inputs**: Gray borders with blue focus ring

## 📱 Responsive Design

-   **Mobile**: 1 column (sidebar stacks above content)
-   **Tablet**: 2 columns
-   **Desktop**: 4 columns (1 sidebar, 3 content)

Grid class: `grid-cols-1 lg:grid-cols-4 gap-8`

## 🔗 Routes

| Route                         | Controller Method        | Page            |
| ----------------------------- | ------------------------ | --------------- |
| `/applicant/dashboard`        | `dashboard()`            | Profile         |
| `/applicant/saved-searches`   | `savedSearches()`        | Saved Searches  |
| `/applicant/saved-jobs`       | `savedJobs()`            | Saved Jobs      |
| `/applicant/job-applications` | `jobApplications()`      | Applications    |
| `/applicant/settings`         | `settings()`             | Settings        |
| `/applicant/profile/edit`     | `editProfile()`          | Edit Profile    |
| `/applicant/profile`          | `updateProfile()`        | Update Profile  |
| `/applicant/profile/picture`  | `uploadProfilePicture()` | Upload Avatar   |
| `/applicant/resume`           | `uploadResume()`         | Upload Resume   |
| `/applicant/resume/download`  | `downloadResume()`       | Download Resume |

## 📦 Data Relationships

```
User
├─ hasMany → JobApplication
│           ├─ belongsTo → Job
│           └─ Job.company → Company
└─ hasMany → SavedJob
            └─ belongsTo → Job
               └─ Job.company → Company
```

## ✨ Key Features

✅ **Responsive Design** - Works on mobile, tablet, desktop
✅ **Active Page Highlighting** - Sidebar shows current page
✅ **Status Filtering** - Filter applications by status
✅ **Color Coding** - Visual status indicators
✅ **Empty States** - User-friendly empty content displays
✅ **Profile Upload** - Picture and resume upload functionality
✅ **Tab Navigation** - Multi-tab settings interface
✅ **Data-driven** - Uses real database relationships
✅ **Consistent Styling** - Unified Tailwind CSS design
✅ **User Friendly** - Emoji icons and clear labels

## 🚀 How to Test

1. **Log in** as an Applicant user
2. **Click** profile avatar in top-right
3. **Select** "My Profile" from dropdown
4. **Navigate** using the sidebar to test all pages

## 📝 Files Reference

### Created Files

-   `resources/views/components/applicant-sidebar.blade.php`
-   `resources/views/applicant/saved-searches.blade.php`
-   `resources/views/applicant/saved-jobs.blade.php`
-   `resources/views/applicant/job-applications.blade.php`
-   `resources/views/applicant/settings.blade.php`

### Modified Files

-   `routes/web.php` (Added 4 routes)
-   `app/Http/Controllers/ApplicantProfileController.php` (Added 4 methods)
-   `resources/views/applicant/dashboard.blade.php` (Updated layout)

## 🎯 Next Steps (Optional)

-   [ ] Connect Settings toggles to database
-   [ ] Implement saved search functionality
-   [ ] Add notification preferences to User model
-   [ ] Create saved searches database migration
-   [ ] Add file upload progress indicators
-   [ ] Implement real-time status updates
-   [ ] Add email notification settings
-   [ ] Create user preference seeds

---

**Version**: 1.0 | **Status**: ✅ Complete | **Last Updated**: 2024
