# JobStreet-Style Job Detail Sidebar Implementation

## Overview

This document describes the JobStreet-style right-side sliding sidebar modal that displays job details when users click on job cards. The sidebar slides in from the right side of the screen, keeping the job list visible on the left, providing a seamless browsing experience.

## Architecture

### Components

#### 1. **Job Detail Sidebar Component** (`resources/views/components/job-detail-sidebar.blade.php`)

A reusable Blade component that contains:

-   Fixed sidebar HTML structure
-   Smooth CSS animations for slide-in/out effects
-   Complete JavaScript functionality for interactions
-   Responsive design (full-screen on mobile, sidebar on desktop)

#### 2. **Job Search Page** (`resources/views/jobs/search.blade.php`)

Updated to:

-   Include the sidebar component
-   Add click handlers to job cards
-   Trigger sidebar opening when job cards are clicked
-   Remove the old three-column right panel

#### 3. **JobController API** (`app/Http/Controllers/JobController.php`)

Contains:

-   `apiShow($id)`: Returns job details in JSON format
-   `saveJob($request, $jobId)`: Handles both form and AJAX save requests with JSON responses

## Features

### Visual Design

-   **Slide-in Animation**: Sidebar smoothly slides in from the right with CSS transitions
-   **Dark Overlay**: Semi-transparent black overlay appears behind sidebar on mobile
-   **Company Logo**: Large logo/initials display at top of sidebar
-   **Metadata Grid**: Location, salary, job type, experience level, posted date
-   **Rich Description**: Full job description with formatting support
-   **Requirements & Benefits**: Collapsible sections for job requirements and benefits
-   **Company Info**: Industry, employee count, website

### Interactive Elements

-   **Quick Apply Button**: Red CTA button for applying to jobs (requires authentication)
-   **Save Job Button**: Toggle-able button to save/unsave jobs
-   **View Full Details Link**: Link to complete job details page
-   **Close Button**: X button at top-right to dismiss sidebar
-   **Escape Key Support**: Press ESC to close sidebar
-   **Click Outside**: Click overlay to close sidebar (mobile)

### Responsive Behavior

**Mobile (< 768px)**:

-   Sidebar takes full screen width
-   Dark overlay becomes visible and clickable
-   Prevents body scroll when open
-   Easy to dismiss by tapping overlay or close button

**Tablet/Desktop (≥ 768px)**:

-   Sidebar is 24rem (384px) wide
-   Job list remains visible on the left
-   Smooth slide animation
-   Dark overlay hidden but can be clicked

## API Endpoints

### GET `/api/jobs/{jobId}`

Returns complete job details in JSON format.

**Response:**

```json
{
    "success": true,
    "job": {
        "id": 1,
        "title": "Senior Laravel Developer",
        "description": "We are looking for...",
        "location": "Manila, Philippines",
        "job_type": "full-time",
        "experience_level": "senior",
        "category": "IT",
        "salary_min": 50000,
        "salary_max": 80000,
        "hide_salary": false,
        "formatted_salary": "₱50,000 - ₱80,000 per month",
        "posted_at": "2 days ago",
        "requirements": [
            "5+ years experience",
            "Laravel expertise",
            "MySQL knowledge"
        ],
        "benefits": ["Health insurance", "Flexible hours", "Remote work"],
        "is_saved": false,
        "company": {
            "id": 1,
            "name": "TechCorp Philippines",
            "logo_path": "company-logos/techcorp.jpg",
            "industry": "Information Technology",
            "employee_count": 150,
            "website": "https://techcorp.ph"
        }
    }
}
```

### POST `/jobs/{jobId}/save`

Toggles job saved status.

**Request:**

```
POST /jobs/1/save
Content-Type: application/json
X-CSRF-TOKEN: [token]
```

**Response (AJAX):**

```json
{
    "success": true,
    "message": "Job saved successfully!",
    "saved": true
}
```

**Response (Form):**

-   Redirects back with success/info message in session

## Component Structure

### HTML Structure

```html
<div id="jobDetailSidebar">
    <!-- Close button -->
    <button onclick="closeJobDetailSidebar()">...</button>

    <!-- Content container -->
    <div id="sidebarContent">
        <!-- Loading state -->
        <div id="loadingState">...</div>

        <!-- Job details template -->
        <div id="jobDetailsContent">
            <!-- Company logo/title -->
            <!-- Key info grid -->
            <!-- Action buttons -->
            <!-- Description -->
            <!-- Requirements -->
            <!-- Benefits -->
            <!-- Company info -->
            <!-- View details link -->
        </div>

        <!-- Error state -->
        <div id="errorState">...</div>
    </div>
</div>

<!-- Dark overlay -->
<div id="sidebarOverlay" onclick="closeJobDetailSidebar()"></div>
```

## CSS Animation Details

### Slide-in Animation

```css
#jobDetailSidebar {
    transform: translateX(100%); /* Off-screen initially */
    transition: transform 0.3s ease-out; /* Smooth slide */
}

#jobDetailSidebar.active {
    transform: translateX(0); /* Slides to visible */
}
```

### Overlay Animation

```css
#sidebarOverlay {
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease-out;
}

#sidebarOverlay.active {
    opacity: 0.5;
    pointer-events: auto;
}
```

### Mobile Full-Screen

```css
@media (max-width: 767px) {
    #jobDetailSidebar {
        width: 100%; /* Full screen width */
    }
}
```

## JavaScript Functions

### `openJobDetailSidebar(jobId)`

Opens the sidebar and loads job details.

**Flow:**

1. Sets `currentJobId` variable
2. Adds 'active' class to sidebar and overlay
3. Disables body scroll
4. Calls `loadJobDetailsData(jobId)`

### `closeJobDetailSidebar()`

Closes the sidebar with animation.

**Flow:**

1. Removes 'active' class from sidebar and overlay
2. Re-enables body scroll
3. Clears `currentJobId`

### `loadJobDetailsData(jobId)`

Fetches job details from API.

**Flow:**

1. Shows loading state
2. Fetches from `/api/jobs/{jobId}`
3. On success: calls `populateJobDetails(job)`
4. On error: shows error state

### `populateJobDetails(job)`

Populates sidebar with job data.

**Populated Fields:**

-   Company logo/initials
-   Job title
-   Company name
-   Location, salary, job type, experience level, posted date
-   Job description
-   Requirements (if available)
-   Benefits (if available)
-   Company info
-   Save button state
-   Authentication status for apply button

### Save Job Form Handler

```javascript
document.getElementById("saveJobForm").addEventListener("submit", function (e) {
    e.preventDefault();
    // Submits via fetch to API
    // Updates button state based on response
});
```

## Data Flow Diagram

```
User clicks job card
        ↓
openJobDetailSidebar(jobId)
        ↓
Sidebar slides in with animation
        ↓
loadJobDetailsData(jobId)
        ↓
Fetch /api/jobs/{jobId}
        ↓
populateJobDetails(job)
        ↓
Display complete job information
        ↓
User can: Apply, Save, View Details, Close
```

## Integration Points

### 1. Job Card Click Handler

Located in `search.blade.php`:

```javascript
document.querySelectorAll(".job-card").forEach((card) => {
    card.addEventListener("click", function (e) {
        e.preventDefault();
        const jobId = this.getAttribute("data-job-id");
        openJobDetailSidebar(jobId); // Opens sidebar
    });
});
```

### 2. API Response Integration

The sidebar automatically formats:

-   Salary ranges with currency symbol
-   Job type with proper capitalization
-   Experience levels
-   Posted date as "time ago" format

### 3. Authentication Integration

-   Checks `auth()->check()` in JavaScript
-   Shows "Login to Apply" for guests
-   Shows "Quick Apply" for authenticated users
-   Shows appropriate save button state

## State Management

### Sidebar States

1. **Closed**: `translateX(100%)`, `opacity: 0`
2. **Opening**: Animated transition
3. **Open**: `translateX(0)`, `opacity: 0.5` (overlay)
4. **Closing**: Animated transition

### Content States

1. **Loading**: Shows spinner
2. **Content**: Shows job details
3. **Error**: Shows error message

### Save Button States

-   **Unsaved**: Gray button, "☆ Save Job"
-   **Saved**: Yellow button, "★ Saved"

## Browser Compatibility

-   **Modern Browsers**: Full support (Chrome, Firefox, Safari, Edge)
-   **Mobile Browsers**: Full support with responsive design
-   **IE11**: No CSS transform animations, falls back to instant display

## Performance Considerations

### Optimization

-   CSS `will-change` property on sidebar for GPU acceleration
-   Smooth scrolling within sidebar
-   Minimal DOM manipulation
-   Event delegation for click handlers

### Load Time

-   Sidebar HTML loads with page
-   Job details fetched on demand via API
-   No pre-loading of all job details

## Accessibility

### Keyboard Navigation

-   ESC key closes sidebar
-   Tab navigation through buttons and links
-   Proper focus management

### Screen Readers

-   Proper ARIA labels
-   Semantic HTML structure
-   Form labels for save button

## Error Handling

### API Errors

```javascript
.catch(error => {
  console.error('Error loading job details:', error);
  // Shows error state
});
```

### Missing Data

-   Company logo defaults to initials
-   Optional fields show "Not specified"
-   Graceful degradation for missing arrays

## Testing Checklist

-   [ ] Click job card opens sidebar
-   [ ] Sidebar slides in smoothly
-   [ ] Job details load and display
-   [ ] Company logo shows correctly
-   [ ] Salary formats properly
-   [ ] Save/unsave works
-   [ ] Apply button redirects (or triggers modal)
-   [ ] Close button works
-   [ ] ESC key closes sidebar
-   [ ] Click overlay closes sidebar (mobile)
-   [ ] Mobile responsive layout works
-   [ ] No layout shift when sidebar opens

## Common Issues & Solutions

### Issue: Sidebar doesn't slide in

**Solution**: Check that sidebar has `transform: translateX(100%)` and `transition` CSS

### Issue: Job details don't load

**Solution**: Verify `/api/jobs/{id}` endpoint returns correct JSON format

### Issue: Save button doesn't update

**Solution**: Ensure `is_saved` field is returned from API and form submission uses AJAX

### Issue: Mobile overlay not clickable

**Solution**: Check `pointer-events` is set to `auto` when overlay has `active` class

## Future Enhancements

1. **Share Job**: Add social sharing buttons
2. **Similar Jobs**: Show related jobs from same company
3. **Apply Modal**: Replace alert with proper application form
4. **Animations**: Add page transitions, loading skeleton
5. **Offline Support**: Cache job details for offline viewing
6. **Notifications**: Toast messages for save/apply actions
7. **Analytics**: Track job detail views and applies
8. **Favorites**: User-specific job recommendations

## Files Modified

1. `resources/views/components/job-detail-sidebar.blade.php` - **NEW**
2. `resources/views/jobs/search.blade.php` - Updated to use sidebar
3. `app/Http/Controllers/JobController.php` - Updated `saveJob()` for AJAX

## Setup Instructions

### 1. Verify API Endpoint

Ensure route exists in `routes/web.php`:

```php
Route::get('/api/jobs/{job}', [JobController::class, 'apiShow'])->name('jobs.api.show');
```

### 2. Include Sidebar Component

Already included in `search.blade.php`:

```php
@include('components.job-detail-sidebar')
```

### 3. Update Job Cards

Job cards already have `data-job-id` attribute and click handlers configured.

### 4. Test the Feature

-   Navigate to `/search`
-   Click any job card
-   Sidebar should slide in from right
-   Job details should load from API
-   Save/unsave should work without page refresh

## Version History

-   **v1.0** (December 1, 2025): Initial implementation
    -   Slide-in sidebar from right
    -   Job detail display
    -   Save/unsave functionality
    -   AJAX API integration
    -   Responsive mobile design
    -   Keyboard and overlay close support
