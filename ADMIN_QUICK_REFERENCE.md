# 🎯 Admin Quick Start Card

## Login & Access (30 seconds)

```
Website: http://127.0.0.1:8000
Email:   jmrckvr@gmail.com
Pass:    admin123
Dashboard: http://127.0.0.1:8000/admin/dashboard
```

## Run Server

```bash
cd c:\Users\jmrck\Project Folder\Skill1ssue\jobstreet
php artisan serve
```

## What You Can Do

### 👥 User Management

-   View all users
-   Search by name/email
-   Deactivate accounts
-   Filter by role

### 📋 Job Management

-   View all jobs
-   Search by title
-   Filter by status
-   Delete/restore jobs

### 📂 Categories

-   Create new categories
-   Edit existing
-   Delete categories
-   Manage icons

### 📊 Dashboard Stats

-   Total users
-   Total jobs
-   Published jobs
-   Applications count
-   Companies count

## Key URLs

| Feature         | URL                        |
| --------------- | -------------------------- |
| Dashboard       | `/admin/dashboard`         |
| Users           | `/admin/users`             |
| Jobs            | `/admin/jobs`              |
| Categories      | `/admin/categories`        |
| Create Category | `/admin/categories/create` |

## Emergency Password Reset

1. Edit `.env` - change `ADMIN_PASSWORD`
2. Run: `php artisan db:seed --class=AdminSeeder`
3. Restart server

## Logs

Check for errors: `storage/logs/laravel.log`

---

**Admin account is fully set up and ready to use!** ✅
