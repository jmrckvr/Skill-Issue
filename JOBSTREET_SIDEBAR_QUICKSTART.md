# JobStreet Sidebar - Quick Start Guide

## What Was Added

A professional JobStreet-style right-side sliding sidebar modal that displays job details when users click on job cards in the search page.

## Features at a Glance

✅ **Smooth Slide-in Animation** - Sidebar slides in from the right with CSS transitions  
✅ **Keep List Visible** - Job list remains visible on desktop (hidden on mobile)  
✅ **Full Job Details** - Company logo, salary, location, description, requirements, benefits  
✅ **Save/Unsave Jobs** - Toggle favorite status without page refresh  
✅ **Quick Apply** - One-click apply button (or redirect to login)  
✅ **Responsive Design** - Full-screen on mobile, sidebar on desktop  
✅ **Close Options** - ESC key, close button, or click overlay  
✅ **Dark Overlay** - Semi-transparent background on mobile/overlay

## Files Created/Modified

### New Files

-   `resources/views/components/job-detail-sidebar.blade.php` - Main sidebar component

### Modified Files

-   `resources/views/jobs/search.blade.php` - Integrated sidebar, simplified job card handlers
-   `app/Http/Controllers/JobController.php` - Updated `saveJob()` for AJAX requests

### Documentation

-   `JOBSTREET_SIDEBAR_IMPLEMENTATION.md` - Complete technical documentation

## How It Works

1. **User clicks a job card** → Sidebar opens and loads job details
2. **Details load via AJAX** → `/api/jobs/{jobId}` endpoint returns JSON
3. **Sidebar populates** → All job information displays smoothly
4. **User can interact** → Save, apply, view details, or close
5. **Smooth animations** → Professional slide-in/out transitions

## Testing the Feature

### Test in Browser

1. **Navigate to job search**

    ```
    Visit: http://yoursite.com/search
    ```

2. **Click any job card**

    - Sidebar should slide in from the right
    - Job details should load and display
    - Company logo/initials show at top

3. **Test save button**

    - Click "Save Job" → turns yellow with ★
    - Click again → reverts to gray with ☆
    - No page refresh!

4. **Test responsive**

    - On desktop: Sidebar is side-by-side with job list
    - On mobile: Sidebar is full-screen with dark overlay
    - Click overlay to close (mobile only)

5. **Test keyboard**

    - Press ESC → Sidebar closes

6. **Test without login**
    - Log out and click a job
    - "Apply" button shows "Login to Apply"
    - Clicking redirects to login page

## API Response Format

The sidebar expects the API to return this structure:

```javascript
{
  success: true,
  job: {
    id: 1,
    title: "Job Title",
    description: "Full job description...",
    location: "City, Country",
    job_type: "full-time",
    experience_level: "senior",
    category: "IT",
    salary_min: 50000,
    salary_max: 80000,
    formatted_salary: "₱50,000 - ₱80,000",
    posted_at: "2 days ago",
    requirements: ["Skill 1", "Skill 2"],  // Array or JSON string
    benefits: ["Benefit 1", "Benefit 2"],  // Array or JSON string
    is_saved: false,
    company: {
      id: 1,
      name: "Company Name",
      logo_path: "path/to/logo.jpg",
      industry: "IT Services",
      employee_count: 150,
      website: "https://company.com"
    }
  }
}
```

The API endpoint is: `GET /api/jobs/{jobId}`

## JavaScript Functions Reference

### Open Sidebar

```javascript
openJobDetailSidebar(jobId); // Opens sidebar and loads job
```

### Close Sidebar

```javascript
closeJobDetailSidebar(); // Closes with animation
```

### Manual Trigger (if needed)

```javascript
// Open sidebar for job ID 5
openJobDetailSidebar(5);

// Close sidebar
closeJobDetailSidebar();
```

## CSS Classes

### Sidebar

-   `#jobDetailSidebar` - Main sidebar container
-   `#jobDetailSidebar.active` - Sidebar is visible
-   `#sidebarOverlay.active` - Overlay is visible

### Content States

-   `#loadingState` - Shows while loading
-   `#jobDetailsContent` - Shows when loaded
-   `#errorState` - Shows on error

## Customization Guide

### Change Sidebar Width

Edit in `job-detail-sidebar.blade.php`:

```css
@media (min-width: 768px) {
    #jobDetailSidebar {
        width: 30rem; /* Change from 24rem (384px) */
    }
}
```

### Change Animation Speed

Edit in `job-detail-sidebar.blade.php`:

```css
transition: transform 0.5s ease-out; /* Change from 0.3s */
```

### Change Button Colors

Edit button styles in the template. Examples:

```html
<!-- Apply button color -->
<button class="bg-red-500 hover:bg-red-600">Quick Apply</button>

<!-- Save button colors -->
<!-- Unsaved -->
<button class="bg-gray-100 hover:bg-gray-200">Save Job</button>

<!-- Saved -->
<button class="bg-yellow-400 hover:bg-yellow-500">Saved</button>
```

### Add New Fields

1. Update `apiShow()` in JobController to return field
2. Add display code in `populateJobDetails()` function
3. Add HTML in sidebar template

Example - Add salary currency symbol:

```javascript
// In populateJobDetails function
document.getElementById("jobSalary").textContent = job.formatted_salary;
```

## Troubleshooting

### Issue: Sidebar doesn't open

-   **Check**: Job card has `data-job-id` attribute
-   **Check**: Console for JavaScript errors
-   **Check**: API endpoint `/api/jobs/{id}` returns valid JSON

### Issue: Job details don't load

-   **Check**: API returns all required fields
-   **Check**: Network tab shows 200 response
-   **Check**: Job is published (status = 'published')

### Issue: Save button doesn't work

-   **Check**: User is authenticated
-   **Check**: `/jobs/{id}/save` route exists
-   **Check**: CSRF token is in page meta tag

### Issue: Mobile layout broken

-   **Check**: `max-width: 767px` media query applies
-   **Check**: Sidebar has `width: 100%` on mobile
-   **Check**: Overlay has proper z-index

## Browser DevTools Tips

### Test API Response

```javascript
// In browser console
fetch("/api/jobs/1")
    .then((r) => r.json())
    .then((d) => console.log(d));
```

### Manually Open Sidebar

```javascript
// In browser console
openJobDetailSidebar(1); // Opens job 1
```

### Check Current Job ID

```javascript
// In browser console
console.log(currentJobId); // Shows which job is open
```

## Performance Tips

-   Sidebar HTML loads once with page
-   Job details only fetch when clicked
-   Images are lazy-loaded by default
-   CSS animations use GPU acceleration
-   No unnecessary DOM manipulations

## Security Considerations

-   API requires published status (soft delete safe)
-   User authentication checked for save/apply
-   CSRF token required for form submissions
-   XSS protection via text escaping in JSON

## Mobile User Experience

-   **Swipe to dismiss**: Not implemented yet (future enhancement)
-   **Pull to refresh**: Works on entire page
-   **Bottom sheet**: Currently full-screen (could be customized)
-   **Gesture support**: Could add swipe-down to close

## Accessibility

-   Keyboard navigation: TAB, ENTER, ESC
-   Screen reader support via semantic HTML
-   Focus management when sidebar opens/closes
-   Form labels and ARIA attributes

## Related Files

-   Job search page: `resources/views/jobs/search.blade.php`
-   Job model: `app/Models/Job.php`
-   Company model: `app/Models/Company.php`
-   Job controller: `app/Http/Controllers/JobController.php`
-   Sidebar component: `resources/views/components/job-detail-sidebar.blade.php`

## Next Steps

1. ✅ Test the feature thoroughly
2. ✅ Customize colors/styling to match brand
3. ✅ Implement apply modal (currently alerts)
4. ✅ Add analytics tracking
5. ✅ Add share functionality
6. ✅ Show similar/related jobs

## Questions & Support

For issues or questions about this implementation, refer to:

1. `JOBSTREET_SIDEBAR_IMPLEMENTATION.md` - Full technical docs
2. Component code comments in `job-detail-sidebar.blade.php`
3. Browser console for JavaScript debugging

## Version Info

-   **Implementation Date**: December 1, 2025
-   **Laravel Version**: 10.x
-   **Blade Components**: Yes
-   **AJAX**: Yes (Fetch API)
-   **CSS Framework**: Tailwind CSS
