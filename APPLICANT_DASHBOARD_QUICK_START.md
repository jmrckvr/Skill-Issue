a# Applicant Dashboard - Quick Start Guide

## 🚀 What's New

A complete applicant profile and dashboard system with:

-   ✅ Profile picture upload
-   ✅ Resume upload (PDF only)
-   ✅ Edit profile (name, contact, skills, bio, social links)
-   ✅ Application tracking
-   ✅ Employer visibility of applicant data

## 📋 Quick Navigation

### Applicant Pages

-   **Dashboard**: `/applicant/dashboard` - View profile, applications, upload files
-   **Edit Profile**: `/applicant/profile/edit` - Update personal information
-   **Profile Dropdown**: Click your avatar → "My Dashboard" (new!)

### File Storage

-   **Resumes**: `storage/app/public/resumes/`
-   **Profile Pictures**: `storage/app/public/profile_pictures/`

## ⚡ Key Features

### 1. Profile Picture

-   Click the avatar on dashboard
-   Hover effect shows camera icon
-   Supports: JPEG, PNG, GIF
-   Max size: 5MB
-   Replaces automatically

### 2. Resume Upload

-   PDF only (10MB max)
-   One active resume at a time
-   Download anytime
-   Automatically stored when applying

### 3. Profile Editing

-   Full name, email (required)
-   Phone, location, skills, bio (optional)
-   LinkedIn, GitHub, Portfolio URLs
-   All validations built-in

### 4. Application Tracking

-   See all submitted applications
-   View job title & company
-   Check status (Pending, Reviewed, Rejected, Hired)
-   Color-coded status badges

## 🔐 Access Control

-   **Only applicants** can access `/applicant/*` routes
-   **Auto-redirects** unauthorized users
-   **Login required** for dashboard
-   **Email verification** required to apply

## 📊 Data Snapshot Feature

When applicant applies for a job:

-   Name, email, phone captured
-   Location & skills saved
-   Profile picture path stored
-   Employers see **static snapshot** (not live profile)
-   Allows applicant to change profile later without affecting past applications

## 💾 Database Changes

### Users Table

-   `contact_number`, `location`, `skills`, `bio`
-   `profile_picture`, `resume_path`
-   `linkedin_url`, `github_url`, `portfolio_url`
-   `is_applicant`, `is_employer` flags

### Job Applications Table

-   `applicant_name` through `applicant_bio` (snapshots)
-   `applicant_profile_picture`, `application_status`
-   Stores data exactly as applicant had when applying

## 🧪 Testing

1. **Sign up as Applicant**

    - Register with applicant role
    - Verify email

2. **Complete Profile**

    - Upload profile picture
    - Upload resume
    - Edit profile with details

3. **Apply for Job**

    - Browse jobs
    - Click apply
    - See in dashboard

4. **Check Employer View**
    - Login as employer
    - View job applicants
    - See applicant profile snapshot

## 📁 File Upload Examples

### Resume

-   Format: PDF
-   Max: 10MB
-   Saved as: `resumes/{user_id}_{timestamp}.pdf`

### Profile Picture

-   Formats: JPEG, PNG, GIF
-   Max: 5MB
-   Saved as: `profile_pictures/{user_id}_{timestamp}.ext`

## 🔗 Related Features

-   **Community**: `/community` - Connect with other applicants
-   **Saved Jobs**: Jobs page → Save button
-   **Browse Jobs**: `/jobs` - Search and apply
-   **Employer Site**: For posting jobs

## ✨ Design & UX

-   Clean card-based layout
-   Mobile responsive
-   Blue theme (matches JobStreet)
-   Inline validation
-   Success/error notifications
-   Empty states with helpful messages

## 📚 Documentation

Full technical documentation: `APPLICANT_DASHBOARD_DOCUMENTATION.md`

## 🛠️ Troubleshooting

### Profile Picture Not Showing

-   Check storage symlink exists: `public/storage/`
-   Verify image uploaded to: `storage/app/public/profile_pictures/`
-   Clear browser cache

### Resume Won't Upload

-   Must be PDF format
-   Check file size < 10MB
-   Ensure storage is writable

### Can't Access Dashboard

-   Must be logged in
-   Must have applicant role
-   Email must be verified

### Routes Not Working

-   Run: `php artisan migrate` (if not already done)
-   Clear route cache: `php artisan route:clear`
-   Check middleware is applied

## 💡 Tips

1. **Multiple Applications**

    - Resume is shared
    - Profile can change
    - Past applications keep original snapshot

2. **Social Links**

    - Completely optional
    - Employers can't see unless you add them
    - Great for portfolios

3. **Skills**

    - Use comma-separated format
    - Employers see exactly as you entered
    - Update anytime in profile

4. **Privacy**
    - Only employers can see applicant data
    - Only when applying for their jobs
    - Community doesn't show profile

---

**Questions?** Check the full documentation or contact support.
