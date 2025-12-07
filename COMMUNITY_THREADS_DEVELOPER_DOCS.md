# Community Threads - Developer Documentation

## Overview

This document provides technical details for developers working with the Community Threads system.

## Architecture

### Models

#### CommunityThread

```php
class CommunityThread extends Model {
    // Relationships
    public function company(): BelongsTo
    public function user(): BelongsTo
    public function messages(): HasMany
    public function latestMessage()

    // Accessors
    public function getReplyCountAttribute()
    public function getLastMessagePreviewAttribute()

    // Attributes
    - id: int (primary key)
    - company_id: int (foreign key)
    - user_id: int (foreign key)
    - title: string
    - last_activity_at: timestamp
    - created_at: timestamp
    - updated_at: timestamp
}
```

#### CommunityMessage

```php
class CommunityMessage extends Model {
    // Relationships
    public function thread(): BelongsTo
    public function user(): BelongsTo

    // Attributes
    - id: int (primary key)
    - community_thread_id: int (foreign key)
    - user_id: int (foreign key)
    - message: text
    - is_from_company: boolean
    - created_at: timestamp
    - updated_at: timestamp
}
```

### Controller

#### CommunityThreadController

**Route Methods:**

```php
public function index()
// GET /community
// Returns: Paginated list of threads with eager-loaded relationships
// Pagination: 15 per page
// Sorting: By last_activity_at DESC
// View: community.threads

public function show(CommunityThread $communityThread)
// GET /community/{communityThread}
// Returns: Single thread with all messages, ordered chronologically
// View: community.show

public function create()
// GET /community/create
// Returns: Form to create new thread
// View: community.create

public function store(Request $request)
// POST /community
// Validates: company_id (exists), title (max 255), message (max 1000)
// Creates: New thread and initial message
// Redirects: To community.show route

public function storeMessage(Request $request, CommunityThread $communityThread)
// POST /community/{communityThread}/message
// Validates: message (max 1000)
// Creates: New message in thread
// Updates: Thread's last_activity_at timestamp
// Response: JSON or redirect (based on Accept header)
```

## Query Examples

### Get all threads with latest message

```php
$threads = CommunityThread::with(['company', 'latestMessage', 'user'])
    ->orderBy('last_activity_at', 'desc')
    ->paginate(15);
```

### Get single thread with all messages

```php
$thread = CommunityThread::with(['company', 'messages.user'])
    ->findOrFail($id);
```

### Get company messages only

```php
$companyMessages = CommunityMessage::where('community_thread_id', $threadId)
    ->where('is_from_company', true)
    ->get();
```

### Get message count for thread

```php
$count = CommunityMessage::where('community_thread_id', $threadId)->count();
// Or use: $thread->messages()->count()
```

### Get recent threads from specific company

```php
$threads = CommunityThread::where('company_id', $companyId)
    ->orderBy('last_activity_at', 'desc')
    ->limit(10)
    ->get();
```

## API Endpoints

### Public Endpoints (No Authentication Required)

```
GET    /community                    List all threads
GET    /community/{id}               View single thread
```

### Authenticated Endpoints (Requires Login)

```
GET    /community/create             Show create form
POST   /community                    Create new thread
POST   /community/{id}/message       Post message to thread
```

## Request/Response Examples

### POST /community (Create Thread)

**Request:**

```json
{
    "company_id": 1,
    "title": "Is the Junior Developer role still open?",
    "message": "Hi! I applied last week. Is the Junior Developer position still accepting applicants?"
}
```

**Response:**

-   On success: Redirects to `/community/{threadId}`
-   On validation error: Redirects back with validation messages

### POST /community/{id}/message (Post Message)

**Request (JSON):**

```json
{
    "message": "Thank you for the information!"
}
```

**Response (JSON):**

```json
{
    "id": 123,
    "community_thread_id": 45,
    "user_id": 7,
    "message": "Thank you for the information!",
    "is_from_company": false,
    "created_at": "2025-12-06T10:30:00Z",
    "updated_at": "2025-12-06T10:30:00Z",
    "user": {
        "id": 7,
        "name": "John Jobseeker",
        "email": "jobseeker@example.com"
    }
}
```

## Validation Rules

### Create Thread

```php
'company_id' => 'required|exists:companies,id',
'title' => 'required|string|max:255',
'message' => 'required|string|max:1000',
```

### Post Message

```php
'message' => 'required|string|max:1000',
```

## Middleware

Community threads routes use:

-   `auth` (optional for viewing)
-   `auth` (required for creating/posting)
-   `verified` (required if email verification is enforced)

Protected routes are under the authenticated group:

```php
Route::middleware('applicant')->group(function () {
    Route::get('/community/create', ...);
    Route::post('/community', ...);
    Route::post('/community/{communityThread}/message', ...);
});
```

## Views

### community.threads (Index)

**Passes:**

-   `$threads` - Paginated collection of CommunityThread
    -   Includes: company, latestMessage, user
    -   Method: `->links()` for pagination

### community.show (Single Thread)

**Passes:**

-   `$thread` - CommunityThread instance
    -   Includes: company, user, messages with user
    -   Messages ordered by created_at ASC

### community.create (Create Form)

**Data:**

-   Company list from `Company::orderBy('name')->get()`

## Blade Helpers/Patterns

### Logo Loading

```blade
@if(str_starts_with($company->logo_path, 'http'))
    {{ $company->logo_path }}
@elseif(str_starts_with($company->logo_path, 'logos/'))
    asset($company->logo_path)
@else
    asset('storage/' . $company->logo_path)
@endif
```

### Relative Timestamps

```blade
{{ $thread->last_activity_at->diffForHumans() }}
// Output: "2 hours ago", "just now", etc.
```

### Message Preview

```blade
{{ $thread->last_message_preview }}
// Returns: First 60 characters of latest message + "..."
```

### Line Clamping (CSS)

```blade
<p class="line-clamp-2">{{ $text }}</p>
// Limits to 2 lines with ellipsis
```

## Seeding

### Run CommunityThreadSeeder Only

```bash
php artisan db:seed --class=CommunityThreadSeeder
```

### Seed Fresh Database

```bash
php artisan migrate:fresh --seed
```

### Seeder Features

-   Creates 5 companies if they don't exist
-   Creates 11 sample threads
-   Creates 37 sample messages
-   Assigns correct logo paths
-   Sets proper timestamps
-   Uses realistic job-related content

### Seeder Structure

```php
$threadsData = [
    'Company Name' => [
        [
            'title' => '...',
            'messages' => [
                ['text' => '...', 'is_from_company' => false],
                ['text' => '...', 'is_from_company' => true],
            ]
        ]
    ]
];
```

## AJAX Implementation

### Message Submission (JavaScript)

```javascript
fetch("/community/{threadId}/message", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken,
        Accept: "application/json",
    },
    body: JSON.stringify({ message: message }),
})
    .then((response) => response.json())
    .then((data) => {
        // Handle new message data
        // Update DOM, scroll, clear input
    });
```

## Performance Optimizations

### Database Indexes

```
community_threads:
- company_id
- user_id
- last_activity_at

community_messages:
- community_thread_id
- user_id
```

### Eager Loading

```php
CommunityThread::with(['company', 'messages.user'])
```

### Pagination

-   15 threads per page (prevent large queries)
-   Offset-based pagination

### Query Optimization

-   Use `first()` instead of `get()` when single result expected
-   Use `count()` on collection, not query after fetching

## Security Considerations

### CSRF Protection

All forms and AJAX requests include `@csrf` token

### Input Validation

-   All inputs validated server-side
-   Max lengths enforced
-   Company existence verified

### Authorization

-   Only authenticated users can post messages
-   User can post to any thread (no ownership checks)
-   No sensitive data in responses

### SQL Injection Protection

-   Uses Eloquent ORM with parameter binding
-   No raw queries

### XSS Protection

-   All user input escaped in views
-   Blade auto-escapes by default

## Testing Checklist

```
✓ Can view all threads without authentication
✓ Can view single thread without authentication
✓ Cannot create thread without authentication
✓ Cannot post message without authentication
✓ Thread title and preview display correctly
✓ Company logos load from correct path
✓ Message count shows correct number
✓ Last activity timestamp updates on new message
✓ Messages ordered chronologically
✓ Company/user message distinction works
✓ Form validation prevents empty messages
✓ Form validation prevents >1000 char messages
✓ AJAX message posting works
✓ Pagination works on thread list
✓ Navigation between pages works
✓ Timestamps format correctly
```

## Extending the System

### Add Message Reactions

```php
// Create new table: community_message_reactions
$table->foreignId('message_id');
$table->foreignId('user_id');
$table->string('reaction'); // emoji
```

### Add Thread Categories

```php
// Update threads table
$table->foreignId('category_id')->nullable();

// Query: $threads = CommunityThread::where('category_id', $id)
```

### Add Search Functionality

```php
$threads = CommunityThread::where('title', 'LIKE', "%{$query}%")
    ->orWhereHas('messages', function($q) use ($query) {
        $q->where('message', 'LIKE', "%{$query}%");
    });
```

### Add Moderation Features

```php
// Add to CommunityMessage:
- is_flagged: boolean
- flag_reason: string
- is_approved: boolean
- moderated_at: timestamp
```

### Add Thread Following

```php
// Create new table: community_thread_followers
$table->foreignId('thread_id');
$table->foreignId('user_id');
$table->unique(['thread_id', 'user_id']);

// Notify followers of new messages
```

---

**Last Updated:** December 6, 2025
**Version:** 1.0.0
**Status:** Production Ready ✅
