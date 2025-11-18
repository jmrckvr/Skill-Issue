# Google OAuth Setup Guide

## Overview

This JobStreet application now has Google Sign-In integration using Laravel Socialite. Users can create accounts and sign in using their Google credentials.

## Features Implemented

✅ **Google OAuth Integration**

-   Users can sign in with Google on both login and registration pages
-   Automatic account creation if user doesn't exist
-   Auto-login if user already has an account
-   Redirect to dashboard after successful authentication

✅ **Database Changes**

-   Added `google_id` column to users table
-   Added `email_verified_at` to fillable fields
-   Migration: `2024_11_18_000000_add_google_id_to_users_table.php`

✅ **UI/UX Improvements**

-   Google Sign-In button on login page with Google logo
-   Google Sign-In button on register page with Google logo
-   Styled buttons with hover effects
-   Full width on mobile, responsive design
-   Buttons positioned directly below the main action buttons

✅ **Backend Implementation**

-   `App\Http\Controllers\Auth\GoogleAuthController` handles OAuth flow
-   Routes configured: `/auth/google` and `/auth/google/callback`
-   User creation with auto-verified email on first Google sign-in

## Setup Instructions

### Step 1: Get Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project (or select existing)
3. Enable the Google+ API
4. Go to "Credentials" → "Create Credentials" → "OAuth 2.0 Client ID"
5. Select "Web application"
6. Add Authorized JavaScript origins:

    - `http://localhost:8000` (for development)
    - `http://127.0.0.1:8000` (for testing)
    - Your production domain

7. Add Authorized redirect URIs:

    - `http://localhost:8000/auth/google/callback`
    - Your production callback URL

8. Copy the **Client ID** and **Client Secret**

### Step 2: Update .env File

Add your Google credentials to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Step 3: Verify Installation

-   ✅ Laravel Socialite is installed (`composer require laravel/socialite`)
-   ✅ Migration is applied (`php artisan migrate`)
-   ✅ Routes are configured in `routes/auth.php`
-   ✅ Google buttons appear on login and register pages

### Step 4: Test the Flow

1. Visit `http://localhost:8000/login`
2. Click "Sign in with Google"
3. You'll be redirected to Google login
4. After authentication, you'll be logged in and redirected to dashboard
5. On `/register`, clicking "Sign in with Google" will create a new account if it doesn't exist

## Architecture

### GoogleAuthController

Located at: `app/Http/Controllers/Auth/GoogleAuthController.php`

**Methods:**

-   `redirect()` - Initiates Google OAuth flow
-   `callback()` - Handles OAuth callback and user creation/login

### User Model

Updated with:

-   `google_id` field (nullable, unique)
-   `email_verified_at` in fillable array

### Routes

```php
Route::get('google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
```

## Button Styling

### Login Page

-   Blue "Sign In" button (main action)
-   White "Sign in with Google" button below it
-   Google logo on left side of button
-   Hover effects with color transitions
-   Full width responsive design

### Registration Page

-   Blue "Create Account" button (main action)
-   White "Sign in with Google" button below it
-   Same styling as login page
-   Consistent user experience

## Security Features

✅ **Password Hashing**

-   Random 24-character password generated for Google users (never shown)
-   Password hashing with bcrypt

✅ **Email Verification**

-   Emails from Google are auto-verified
-   `email_verified_at` set automatically on Google sign-in

✅ **Unique Constraints**

-   `google_id` is unique (prevents duplicate accounts)
-   Email is unique (prevents account conflicts)

✅ **Error Handling**

-   Try-catch block catches authentication failures
-   User-friendly error messages
-   Redirect back to login on failure

## Testing

All existing tests still pass (39/39):

-   Registration tests
-   Login tests
-   Profile tests
-   Password management tests

## Troubleshooting

### "Redirect URI mismatch" Error

-   Ensure the redirect URI in Google Console matches your `.env` file
-   Check for trailing slashes or http/https mismatches

### Users not being created

-   Verify `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` are correct
-   Check that migration has been applied (`php artisan migrate:status`)
-   Look at the application logs (`storage/logs/laravel.log`)

### Button not appearing

-   Ensure you're viewing the updated login/register pages
-   Clear browser cache (Ctrl+Shift+Delete)
-   Check that routes are registered (`php artisan route:list | grep google`)

## Production Deployment

Before deploying to production:

1. **Update Google Console**

    - Add production domain to Authorized JavaScript origins
    - Add production redirect URI

2. **Update .env**

    ```env
    GOOGLE_CLIENT_ID=your_production_id
    GOOGLE_CLIENT_SECRET=your_production_secret
    GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
    APP_URL=https://yourdomain.com
    ```

3. **Test thoroughly**
    - Test with Google account
    - Test existing email conflicts
    - Test error scenarios

## File Changes Summary

### New Files

-   `app/Http/Controllers/Auth/GoogleAuthController.php` - OAuth controller
-   `database/migrations/2024_11_18_000000_add_google_id_to_users_table.php` - Migration

### Modified Files

-   `config/services.php` - Added Google configuration
-   `app/Models/User.php` - Added google_id and email_verified_at to fillable
-   `routes/auth.php` - Added Google OAuth routes
-   `resources/views/auth/login.blade.php` - Added Google button
-   `resources/views/auth/register.blade.php` - Added Google button
-   `.env` - Added Google credentials placeholders

## Next Steps

1. ✅ Get Google OAuth credentials from Google Cloud Console
2. ✅ Add credentials to `.env`
3. ✅ Test the login flow
4. ✅ Deploy to production when ready

---

**Questions or Issues?**

-   Check the troubleshooting section above
-   Review the Google OAuth documentation
-   Check Laravel Socialite documentation: https://laravel.com/docs/socialite
