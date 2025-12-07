# Community Threads Quick Reference

## Access Points

-   **View all threads:** `http://localhost:8000/community`
-   **View single thread:** `http://localhost:8000/community/{id}`
-   **Create new thread:** `http://localhost:8000/community/create`

## Features Available

### Community Threads List Page

-   ✅ Browse all discussion threads in vertical card layout
-   ✅ See company logo, thread title, preview, reply count, and last activity time
-   ✅ Click any thread to open the full conversation
-   ✅ Pagination (15 threads per page)
-   ✅ "Start a Thread" button (authenticated users only)
-   ✅ Empty state with helpful guidance

### Conversation Page

-   ✅ Fixed header with company name and thread title
-   ✅ Chat bubbles with proper left/right alignment
-   ✅ User messages (gray) vs Company messages (red)
-   ✅ Message timestamps
-   ✅ User avatars with initials
-   ✅ Text input box for new messages
-   ✅ Auto-scroll to latest message
-   ✅ Real-time message posting (AJAX)
-   ✅ Back button to return to threads list

### Create Thread Form

-   ✅ Select company from dropdown
-   ✅ Enter thread title (max 255 characters)
-   ✅ Write message (max 1000 characters with counter)
-   ✅ Tips section for best practices
-   ✅ Form validation
-   ✅ Cancel button to go back

## Sample Companies & Threads

### ACME Tech Solutions

1. "Is the Junior Developer role still open?" (4 messages)
2. "Tech stack for current projects?" (3 messages)

### Global Finance PH

1. "Hiring Timeline for Accounting Assistant" (4 messages)
2. "CPA requirement for Analyst role" (3 messages)

### InnovateHub

1. "Work-from-home setup for UI/UX roles?" (3 messages)
2. "Portfolio requirements for design positions" (4 messages)

### SoftCloud Systems

1. "Interview process details" (3 messages)
2. "Salary negotiation after offer" (4 messages)
3. "Benefits package details" (2 messages)

### Prime Logistics

1. "Driver position requirements" (3 messages)
2. "Vehicle inspection and insurance" (4 messages)

**Total: 11 threads with 37 messages**

## Logo Paths

All company logos are stored in `/public/logos/`:

-   `acme-tech.svg` - ACME Tech Solutions
-   `global-finance.jpg` - Global Finance PH
-   `startuphub.jpg` - InnovateHub
-   `infotech.jpg` - SoftCloud Systems
-   `logistics.jpg` - Prime Logistics

## Message Types

-   **User Messages:** Posted by jobseekers (gray bubbles, left side)
-   **Company Messages:** Posted by company representatives (red bubbles, right side)
-   Both tracked with timestamps and user information

## Authentication

-   Community threads list: ✅ Public (no login required)
-   Viewing conversations: ✅ Public (no login required)
-   Posting messages: 🔒 Requires authentication
-   Creating threads: 🔒 Requires authentication

## Message Format

-   Max 1000 characters per message
-   Plain text only (no markdown)
-   Automatic timestamp assignment
-   Real-time display on form submission

## Database Schema

### community_threads table

```
id (PK)
company_id (FK)
user_id (FK)
title (string)
last_activity_at (timestamp)
created_at
updated_at
```

### community_messages table

```
id (PK)
community_thread_id (FK)
user_id (FK)
message (text)
is_from_company (boolean)
created_at
updated_at
```

## Common Tasks

### To add a new thread manually:

1. Visit `/community/create`
2. Select company
3. Enter title and message
4. Click "Create Thread"

### To post a message to existing thread:

1. Click a thread from the list
2. Scroll to bottom of conversation
3. Type message in text box
4. Click "Send" button
5. Message appears instantly

### To seed fresh data:

```bash
php artisan db:seed --class=CommunityThreadSeeder
```

### To view all threads in database:

```bash
php artisan tinker
> App\Models\CommunityThread::with('company', 'messages')->get()
```

## Styling & Customization

### Colors Used

-   Primary (Red): `#EF4444` - Buttons, company messages
-   Gray: `#6B7280` - Secondary text
-   White: `#FFFFFF` - Backgrounds
-   Blue: `#3B82F6` - Gradients in fallback avatars

### Responsive Breakpoints

-   Mobile: < 640px (single column)
-   Tablet: 640-1024px (adjusted padding)
-   Desktop: > 1024px (full layout)

### Tailwind CSS Classes Used

-   `flex`, `flex-col`, `flex-1` - Layout
-   `rounded-lg`, `rounded-2xl` - Borders
-   `shadow-sm`, `shadow-md` - Shadows
-   `hover:` - Interactive states
-   `transition` - Smooth animations
-   `gap-`, `px-`, `py-` - Spacing

---

**Last Updated:** December 6, 2025
**Status:** Production Ready ✅
