# 🎯 Admin Account - Quick Start (5 Minutes)

## Your Admin Details

```
Email:    jmrckvr@gmail.com
Password: admin123
```

## Step 1: Start Server (30 seconds)

Open PowerShell and run:

```powershell
cd "c:\Users\jmrck\Project Folder\Skill1ssue\jobstreet"
php artisan serve
```

You'll see:

```
INFO  Server running on [http://127.0.0.1:8000]
```

## Step 2: Open Website (10 seconds)

Open your browser and go to:

```
http://127.0.0.1:8000
```

## Step 3: Click Login

You'll see the JobStreet homepage. Click the **Login** button in the top-right corner.

## Step 4: Enter Admin Credentials

```
Email:    jmrckvr@gmail.com
Password: admin123
```

Then click **Login**

## Step 5: Access Admin Dashboard

After login, click **Admin Dashboard** link or go to:

```
http://127.0.0.1:8000/admin/dashboard
```

## 🎉 Done!

You now have access to:

-   👥 User Management
-   📋 Job Management
-   📂 Category Management
-   📊 Platform Statistics

---

## Where to Go Next

| Need to...      | Go to...                   |
| --------------- | -------------------------- |
| Manage Users    | `/admin/users`             |
| Manage Jobs     | `/admin/jobs`              |
| Create Category | `/admin/categories/create` |
| View Categories | `/admin/categories`        |
| Change Password | `/profile`                 |

---

## 🛑 Common Issues

### Server won't start?

-   Make sure you're in the correct directory
-   Check if port 8000 is in use
-   Try: `php artisan serve --port=8001`

### Can't log in?

-   Check email: `jmrckvr@gmail.com` (exact spelling)
-   Check password: `admin123` (case-sensitive)
-   Make sure you clicked Login button

### Page shows error?

-   Make sure server is still running
-   Refresh the page (Ctrl+R)
-   Check browser console for errors

---

**✅ Server Status**: Running on http://127.0.0.1:8000
**✅ Admin Account**: Active
**✅ Dashboard**: Ready to use
