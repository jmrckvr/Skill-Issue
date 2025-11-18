# JobStreet Philippines - Job Board Application

A production-ready job board built with Laravel 10 and Tailwind CSS, matching the look and functionality of JobStreet.ph. Features include job search, applications, employer dashboard, and admin panel.

## Features

### For Job Seekers
- ✅ Browse and search job listings with advanced filters
- ✅ Filter by keyword, location, category, job type, and experience level
- ✅ View detailed job descriptions with company information
- ✅ Apply to jobs with resume and cover letter
- ✅ Track application status
- ✅ Save jobs for later
- ✅ User profile management
- ✅ Email verification

### For Employers
- ✅ Company profile management
- ✅ Post and manage job listings (draft, publish, close)
- ✅ View applicants and their resumes
- ✅ Download applicant resumes
- ✅ Track application status
- ✅ Manage job status

### For Administrators
- ✅ Manage users and companies
- ✅ Soft-delete and restore jobs
- ✅ Deactivate user accounts
- ✅ View platform statistics
- ✅ Manage job categories

## Tech Stack

- **Framework**: Laravel 10+
- **Frontend**: Blade templates + Tailwind CSS
- **Database**: SQLite (development) / MariaDB (production)
- **Authentication**: Laravel Breeze with email verification
- **File Storage**: Local filesystem + S3-compatible
- **Testing**: PHPUnit + Laravel Dusk
- **API**: RESTful API with token authentication

## Quick Start

### Installation (Local Development)

```bash
# Clone and navigate
cd "c:\Users\jmrck\Project Folder\Skill1ssue\jobstreet"

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed demo data
php artisan migrate
php artisan db:seed

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

**Visit**: http://127.0.0.1:8000

### Demo Credentials

**Admin Account**
- Email: `admin@jobstreet.local`
- Password: `password`

**Employer Account**
- Email: `juan@acmetech.com`
- Password: `password`

**Jobseeker Account**
- Email: `rosa.fernandez@email.com`
- Password: `password`

All demo accounts have email verified automatically.

## Database Schema

### Tables
- **users**: User accounts (role: jobseeker, employer, admin)
- **companies**: Employer company profiles
- **jobs**: Job listings
- **job_applications**: Job applications
- **categories**: Job categories  
- **saved_jobs**: Bookmarked jobs

### Key Columns
- Users: `email_verified_at`, `role`, `is_active`
- Jobs: `status` (draft/published/closed), `published_at`, `salary_min/max`
- Applications: `status` (pending/reviewed/accepted/rejected), `resume_path`

## API Endpoints

### Public
- `GET /api/jobs` - List jobs with filters
- `GET /api/jobs/{id}` - Get job details
- `GET /api/categories` - List categories

### Authenticated (Jobseeker)
- `POST /api/applications` - Submit application
- `GET /api/applications` - View my applications
- `POST /api/jobs/{id}/save` - Save job

### Employer
- `POST /api/jobs` - Create job
- `PATCH /api/jobs/{id}` - Update job
- `POST /api/jobs/{id}/publish` - Publish job
- `GET /api/jobs/{id}/applications` - View applicants

### Admin
- `GET /api/users` - List users
- `PATCH /api/users/{id}/status` - Change user status
- `DELETE /api/jobs/{id}` - Soft delete job

## Testing

```bash
# Run all tests
php artisan test

# Run Dusk E2E tests
php artisan dusk

# Generate coverage report
php artisan test --coverage
```

## Deployment

### Using Docker
```bash
docker-compose up -d
```

### Traditional Server
```bash
# Install
composer install --no-dev
npm install --production && npm run build

# Setup
php artisan migrate --force
php artisan db:seed --class=CategorySeeder

# Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data .
```

## Security Features

- ✅ CSRF protection
- ✅ XSS prevention (Blade escaping)
- ✅ SQL injection prevention (Eloquent)
- ✅ Password hashing (bcrypt)
- ✅ Email verification required
- ✅ File upload validation
- ✅ Role-based access (Policies)
- ✅ Rate limiting

## Project Structure

```
jobstreet/
├── app/Models/                  # Eloquent models
├── app/Http/Controllers/        # Controllers
├── app/Policies/                # Authorization policies
├── database/migrations/         # Database migrations
├── database/seeders/            # Demo data
├── resources/views/             # Blade templates
└── tests/                       # Unit & E2E tests
```

## Requirements

- PHP 8.1+
- Composer
- Node.js & npm
- MariaDB/MySQL or SQLite

## Configuration

Edit `.env` for:
- Database connection
- Mail settings (SMTP)
- File storage (S3)
- App URL and timezone

## Troubleshooting

### Migrations fail
```bash
php artisan migrate:reset --force
php artisan migrate
```

### File uploads not working
```bash
php artisan storage:link
chmod -R 775 storage
```

### Assets not loading
```bash
npm run build
php artisan cache:clear
```

## License

MIT License - See LICENSE file

## Support

- 📧 Email: support@jobstreet.com.ph
- 📖 Docs: `/docs`
- 🐛 Issues: GitHub Issues

---

**JobStreet Philippines v1.0** - Built with Laravel 10 ❤️

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
