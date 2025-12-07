# Admin Access & Dashboard Setup Guide

## ✅ Your Admin Account is Ready!

Your JobStreet application now has a fully functional admin account and dashboard. Here's everything you need to know:

---

## 📋 Admin Account Credentials

| Field        | Value                        |
| ------------ | ---------------------------- |
| **Email**    | `jmrckvr@gmail.com`          |
| **Password** | `admin123`                   |
| **Role**     | Admin (Full Platform Access) |
| **Status**   | Active & Email Verified      |

---

## 🚀 Getting Started

### Step 1: Start the Laravel Server

```bash
cd "c:\Users\jmrck\Project Folder\Skill1ssue\jobstreet"
php artisan serve
```

The server will start at: **http://127.0.0.1:8000**

### Step 2: Log In to Your Account

1. Open your browser and go to: **http://127.0.0.1:8000**
2. Click **Login** (usually in the top navigation)
3. Enter your credentials:
    - Email: `jmrckvr@gmail.com`
    - Password: `admin123`
4. Click **Login**

### Step 3: Access the Admin Dashboard

After logging in, navigate to the **Admin Dashboard**:

-   Direct URL: **http://127.0.0.1:8000/admin/dashboard**
-   Or look for "Admin Dashboard" link in the navigation menu

---

## 📊 Admin Dashboard Features

Your admin dashboard provides complete platform management:

### Dashboard Stats (Overview)

-   **Total Users**: See all registered users (applicants, employers, admins)
-   **Total Jobs**: Count of all job listings
-   **Published Jobs**: Active job listings available to applicants
-   **Applications**: Total job applications submitted
-   **Companies**: Count of registered companies

### Management Tools

The dashboard includes quick access to:

1. **Manage Users** (`/admin/users`)

    - View all users on the platform
    - Search by name or email
    - Filter by role (applicant, employer, admin)
    - Deactivate/activate user accounts
    - Manage user status

2. **Manage Jobs** (`/admin/jobs`)

    - Browse all job listings
    - Search jobs by title
    - Filter by status (published, draft, closed)
    - Restore soft-deleted jobs
    - Permanently delete jobs
    - Monitor job postings

3. **Categories** (`/admin/categories`)

    - View all job categories
    - See job count per category
    - Manage category icons

4. **New Category** (`/admin/categories/create`)
    - Create new job categories
    - Set category name and icon
    - Organize job listings

### Recent Activity Panels

**Recent Jobs**: Last 10 posted jobs with:

-   Job title
-   Company name
-   Job status
-   Creation date

**Recent Users**: Last 10 registered users with:

-   User name
-   Email address
-   User role
-   Registration date

---

## 🔗 Admin Routes Available

| Route           | URL                            | Function              |
| --------------- | ------------------------------ | --------------------- |
| Admin Dashboard | `/admin/dashboard`             | Main admin panel      |
| User Management | `/admin/users`                 | View & manage users   |
| Job Management  | `/admin/jobs`                  | Manage all jobs       |
| Categories      | `/admin/categories`            | Manage job categories |
| Create Category | `/admin/categories/create`     | Add new category      |
| Edit Category   | `/admin/categories/{id}/edit`  | Edit category         |
| Deactivate User | `/admin/users/{id}/deactivate` | Deactivate user       |
| Activate User   | `/admin/users/{id}/activate`   | Activate user         |
| Restore Job     | `/admin/jobs/{id}/restore`     | Restore deleted job   |
| Delete Job      | `/admin/jobs/{id}/permanent`   | Permanently delete    |

---

## 🛡️ Admin Permissions

As an admin, you have full access to:

✅ **User Management**

-   View all users
-   Search and filter users
-   Deactivate/activate accounts
-   Monitor user activity

✅ **Job Management**

-   View all job listings
-   Manage job status
-   Restore deleted jobs
-   Permanently delete jobs
-   Monitor postings

✅ **Category Management**

-   Create job categories
-   Edit categories
-   Delete categories
-   Manage category icons

✅ **Platform Statistics**

-   View platform overview
-   Monitor recent activities
-   Track user registrations
-   Monitor job applications

---

## 🔐 Security Tips

1. **Change Your Password**: After first login, change your password:

    - Navigate to `/profile`
    - Click "Update Password"
    - Enter new secure password

2. **Keep Credentials Safe**:

    - Don't share your admin credentials
    - Use a strong password in production

3. **Regular Monitoring**:
    - Check the admin dashboard regularly
    - Monitor user activities
    - Review job postings

---

## 🛠️ Customizing Admin Credentials

You can customize the admin credentials in your `.env` file:

```env
# Admin Credentials
ADMIN_EMAIL=your-email@example.com
ADMIN_PASSWORD=your-secure-password
ADMIN_NAME="Your Name"
```

Then run:

```bash
php artisan db:seed --class=AdminSeeder
```

---

## 🐛 Troubleshooting

### "I forgot my admin password"

1. Stop the server
2. Edit your `.env` file and change `ADMIN_PASSWORD`
3. Run: `php artisan db:seed --class=AdminSeeder`
4. Restart the server

### "I can't access the admin dashboard"

1. Make sure you're logged in
2. Verify your user role is 'admin'
3. Check the URL: `http://127.0.0.1:8000/admin/dashboard`

### "Login page keeps showing"

1. Verify your email and password are correct
2. Check that your account exists in the database
3. Ensure email verification is set (it's done automatically)

---

## 📚 Additional Resources

-   **User Model** Location: `app/Models/User.php`
-   **Admin Controller** Location: `app/Http/Controllers/AdminController.php`
-   **Admin Middleware** Location: `app/Http/Middleware/AdminMiddleware.php`
-   **Admin Views** Location: `resources/views/admin/`
-   **Routes** Location: `routes/web.php`

---

## ✨ Next Steps

1. **Log in** to your admin account
2. **Explore** the dashboard and familiarize yourself
3. **Change** your password to something secure
4. **Create** job categories (if not already done)
5. **Monitor** users and job listings regularly

---

## 📞 Need Help?

If you encounter any issues:

1. Check that the Laravel server is running
2. Verify your database is set up (`php artisan migrate`)
3. Ensure all seeds are applied (`php artisan db:seed`)
4. Check Laravel logs: `storage/logs/laravel.log`

Enjoy managing your JobStreet platform! 🎉
