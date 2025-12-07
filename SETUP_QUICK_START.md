# Quick Setup Instructions

## Initial Setup (Run Once)

### 1. Create Storage Symlink

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`, allowing web access to uploaded logos.

### 2. Set Permissions

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 3. Database Migration (Already Done)

The `companies` table already has the `logo_path` column. No migration needed.

---

## Testing the System

### For Employers:

1. Log in as an employer
2. Go to **Employer Dashboard**
3. Click **"Edit Company Profile"**
4. Upload a company logo (drag-drop or click)
5. Preview displays before saving
6. Click **"Save Changes"**

### For Job Seekers:

1. Go to **"Browse Jobs"** → `/search`
2. Use left sidebar filters to search jobs
3. Click any job in the center column
4. Right panel loads job details dynamically
5. Company logo displays in both center and right panels

---

## File Locations

| File                                              | Purpose                        |
| ------------------------------------------------- | ------------------------------ |
| `app/Http/Controllers/CompanyController.php`      | Handle logo uploads            |
| `resources/views/employer/company-edit.blade.php` | Company edit form              |
| `resources/views/jobs/search.blade.php`           | Three-column job search layout |
| `routes/web.php`                                  | Company routes                 |
| `storage/app/public/company-logos/`               | Logo storage directory         |

---

## Deployment Notes

-   ✅ CompanyController created
-   ✅ Company routes added
-   ✅ Company edit form created
-   ✅ Job search redesigned (3-column layout)
-   ✅ Logo preview in job forms
-   ✅ Storage configuration ready

**No database changes needed** - logo_path column already exists.

---

## Key Features

### Logo Upload System

-   ✅ Drag-and-drop upload
-   ✅ Real-time preview
-   ✅ Automatic old logo deletion
-   ✅ File validation (2MB max, JPEG/PNG/GIF/WebP)
-   ✅ Delete logo button

### JobStreet-Style Search

-   ✅ Three-column responsive layout
-   ✅ Left sidebar with filters
-   ✅ Center job list
-   ✅ Right dynamic detail panel
-   ✅ AJAX job loading
-   ✅ Mobile responsive

### Company Profile

-   ✅ Edit all company info
-   ✅ Logo upload/update/delete
-   ✅ Validation and error messages
-   ✅ Success notifications

---

## Troubleshooting

**Logo not showing?**

```bash
php artisan storage:link
chmod -R 775 storage/
```

**Upload fails?**

-   Check max file size (2MB limit)
-   Verify file type (JPEG, PNG, GIF, WebP)
-   Check storage permissions

**Right panel not loading?**

-   Check browser console for errors
-   Verify `/api/jobs/{id}` endpoint works
-   Check CSRF token in forms

---

**Ready to go!** 🚀
