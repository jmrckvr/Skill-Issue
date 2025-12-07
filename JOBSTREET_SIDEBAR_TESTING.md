# JobStreet Sidebar - Testing & Troubleshooting Guide

## Testing Checklist

### ✅ Core Functionality Tests

#### Test 1: Opening Sidebar

-   [ ] Click on first job card
-   [ ] Sidebar slides in from right
-   [ ] Loading indicator appears
-   [ ] Job details load within 2 seconds
-   [ ] Sidebar content displays correctly

#### Test 2: Closing Sidebar

-   [ ] Click close button (X) in top-right
-   [ ] Sidebar slides out smoothly
-   [ ] Page returns to normal state
-   [ ] Body scroll is restored

#### Test 3: Keyboard Close

-   [ ] Open sidebar with job details
-   [ ] Press ESC key
-   [ ] Sidebar closes immediately
-   [ ] Focus returns to body

#### Test 4: Overlay Close (Mobile)

-   [ ] Resize browser to mobile view (< 768px)
-   [ ] Open sidebar
-   [ ] Click dark overlay area
-   [ ] Sidebar closes
-   [ ] On desktop: overlay is clickable but not visible

#### Test 5: Job Details Display

-   [ ] Company logo/initials appear
-   [ ] Job title displays
-   [ ] Company name displays
-   [ ] Location shows correctly
-   [ ] Salary formats properly (with currency)
-   [ ] Job type displays
-   [ ] Experience level displays
-   [ ] Posted date shows as "X days ago"

#### Test 6: Save Job Feature

-   [ ] Click "Save Job" button (unsaved)
-   [ ] Button changes to yellow with ★
-   [ ] Button text changes to "Saved"
-   [ ] Click again to unsave
-   [ ] Button reverts to gray with ☆
-   [ ] No page reload occurs
-   [ ] Works without page refresh

#### Test 7: Apply Button

-   **When logged in:**

    -   [ ] Button says "Quick Apply"
    -   [ ] Color is red/pink
    -   [ ] Clicking redirects to apply page

-   **When not logged in:**
    -   [ ] Button says "Login to Apply"
    -   [ ] Color is blue
    -   [ ] Clicking redirects to login page

#### Test 8: Job Content

-   [ ] Description displays with formatting
-   [ ] Requirements list shows (if available)
-   [ ] Benefits list shows (if available)
-   [ ] Company info displays
-   [ ] "View full details" link works

#### Test 9: Sequential Job Selection

-   [ ] Click job #1 → sidebar opens
-   [ ] While sidebar is open, click job #2
-   [ ] Job #1 details disappear
-   [ ] Job #2 details load
-   [ ] Highlight switches to job #2 card
-   [ ] No need to close/reopen sidebar

#### Test 10: Switching Between Jobs

-   [ ] Open job A
-   [ ] Click job B
-   [ ] Content switches smoothly
-   [ ] No animation glitches
-   [ ] Loading state shows briefly

### ✅ Responsive Design Tests

#### Test 11: Mobile Layout (< 768px)

-   [ ] Sidebar takes full screen width
-   [ ] Close button is visible
-   [ ] Content is readable
-   [ ] Buttons are touch-sized (min 44px)
-   [ ] Scrolling works within sidebar
-   [ ] Dark overlay appears behind sidebar

#### Test 12: Tablet Layout (768px - 1024px)

-   [ ] Sidebar is 384px wide
-   [ ] Job list visible on left
-   [ ] Sidebar doesn't cover list completely
-   [ ] Both areas scrollable independently
-   [ ] Overlay not visible but clickable

#### Test 13: Desktop Layout (> 1024px)

-   [ ] Sidebar is 384px wide
-   [ ] Job list fully visible
-   [ ] Good proportion between list and sidebar
-   [ ] All controls easily accessible
-   [ ] No horizontal scrolling

#### Test 14: Landscape Mobile

-   [ ] Sidebar still readable
-   [ ] Content doesn't get cut off
-   [ ] Scrolling works properly

### ✅ Performance Tests

#### Test 15: Load Time

-   [ ] API endpoint responds in < 1s
-   [ ] Sidebar animation is smooth (60fps)
-   [ ] No lag when scrolling content
-   [ ] Multiple job clicks don't accumulate

#### Test 16: Memory

-   [ ] No memory leaks on repeated open/close
-   [ ] Switching jobs doesn't accumulate memory
-   [ ] Page performance remains stable

#### Test 17: Network Errors

-   [ ] Offline: Shows error state
-   [ ] Slow network: Loading state shows
-   [ ] Failed request: Error message displays
-   [ ] Can retry by clicking job again

### ✅ Browser Compatibility Tests

#### Test 18: Chrome/Edge

-   [ ] All animations work
-   [ ] All buttons functional
-   [ ] No console errors
-   [ ] Responsive design works

#### Test 19: Firefox

-   [ ] Sidebar slides smoothly
-   [ ] All features work
-   [ ] No visual glitches
-   [ ] Forms submit correctly

#### Test 20: Safari (Mac & iOS)

-   [ ] Animations smooth
-   [ ] Touch interactions work (iOS)
-   [ ] Overlay closes properly
-   [ ] Keyboard support works

#### Test 21: Mobile Browsers

-   [ ] Android Chrome: All features work
-   [ ] iOS Safari: Touch events work
-   [ ] Touch scroll works smoothly
-   [ ] Overlay clickable on mobile

### ✅ Accessibility Tests

#### Test 22: Keyboard Navigation

-   [ ] TAB navigates through buttons
-   [ ] ENTER activates buttons
-   [ ] ESC closes sidebar
-   [ ] Focus visible on all interactive elements

#### Test 23: Screen Reader (NVDA/JAWS)

-   [ ] Sidebar purpose announced
-   [ ] Form fields labeled correctly
-   [ ] Button purposes clear
-   [ ] Links have descriptive text

#### Test 24: Color Contrast

-   [ ] All text meets WCAG AA standard
-   [ ] Button text contrasts with background
-   [ ] Links are distinguishable

### ✅ Authentication Tests

#### Test 25: Logged In User

-   [ ] Save button works
-   [ ] Apply button shows
-   [ ] Can apply to jobs
-   [ ] Saved jobs persist

#### Test 26: Guest User

-   [ ] Save button disabled or redirects
-   [ ] Apply button redirects to login
-   [ ] Cannot save jobs
-   [ ] Cannot apply to jobs

#### Test 27: Session Expiry

-   [ ] User session expires
-   [ ] Attempting to save shows login redirect
-   [ ] No silent failures

---

## Troubleshooting Guide

### Problem: Sidebar doesn't appear when clicking job

**Symptoms:**

-   Click job card, nothing happens
-   Sidebar doesn't slide in

**Diagnosis:**

1. Check browser console (F12) for JavaScript errors
2. Verify job card has `data-job-id` attribute
3. Check that `openJobDetailSidebar()` function exists

**Solutions:**

```javascript
// Test in console
openJobDetailSidebar(1); // Should open sidebar for job 1

// Check if element exists
document.getElementById("jobDetailSidebar"); // Should return element

// Check click handler
document.querySelector(".job-card").onclick; // Should show handler
```

### Problem: API returns 404 error

**Symptoms:**

-   Sidebar opens but shows loading indefinitely
-   Console shows 404 error
-   Network tab shows `/api/jobs/1` → 404

**Diagnosis:**

1. API endpoint not defined in routes
2. Job doesn't exist
3. Job not published (status != 'published')

**Solutions:**

```php
// In routes/web.php - verify this route exists:
Route::get('/api/jobs/{job}', [JobController::class, 'apiShow'])->name('jobs.api.show');

// In JobController - verify apiShow method:
public function apiShow($id) {
    $job = Job::published()  // Only published jobs
        ->with(['company', 'category'])
        ->findOrFail($id);
    // ...
}
```

### Problem: Job details don't load (infinite loading)

**Symptoms:**

-   Sidebar opens
-   Loading spinner continues indefinitely
-   Details never appear

**Diagnosis:**

1. API endpoint not returning JSON
2. Network request hanging
3. Invalid JSON response

**Solutions:**

```javascript
// Test API endpoint in console
fetch("/api/jobs/1")
    .then((r) => r.json())
    .then((d) => console.log(d))
    .catch((e) => console.error("Error:", e));

// Check network timing
// Should complete in < 2 seconds
```

### Problem: Save button doesn't work

**Symptoms:**

-   Click save button
-   Nothing happens
-   No error message

**Diagnosis:**

1. CSRF token missing
2. Form submission fails silently
3. User not authenticated

**Solutions:**

```html
<!-- Verify CSRF token exists in HTML -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Check in console -->
document.querySelector('meta[name="csrf-token"]').content
```

```php
// In saveJob controller - verify it handles AJAX:
if ($request->expectsJson()) {
    return response()->json([...]);
}
```

### Problem: Sidebar doesn't close on ESC

**Symptoms:**

-   Press ESC key
-   Sidebar remains open
-   Nothing happens

**Diagnosis:**

1. JavaScript event listener not attached
2. Event not firing
3. Function not called

**Solutions:**

```javascript
// Verify event listener exists
// Look for: document.addEventListener('keydown', function(event)...)

// Test in console
document.dispatchEvent(new KeyboardEvent("keydown", { key: "Escape" }));
// Should close sidebar

// Check if function exists
typeof closeJobDetailSidebar; // Should be 'function'
```

### Problem: Overlay doesn't close sidebar on mobile

**Symptoms:**

-   Mobile view
-   Dark overlay visible
-   Click overlay, nothing happens

**Diagnosis:**

1. Overlay has `pointer-events: none`
2. Overlay not detecting clicks
3. CSS media query not applying

**Solutions:**

```css
/* Verify mobile CSS */
@media (max-width: 767px) {
    #sidebarOverlay.active {
        pointer-events: auto; /* Must be auto for clicking */
        opacity: 0.5; /* Must be visible */
    }
}
```

### Problem: Sidebar appears off-screen or wrong position

**Symptoms:**

-   Sidebar partially visible
-   Sidebar on wrong side
-   Sidebar overlaps navbar

**Diagnosis:**

1. Transform CSS not applied
2. Z-index too low
3. Position not fixed

**Solutions:**

```css
/* Verify sidebar CSS */
#jobDetailSidebar {
    position: fixed; /* Must be fixed */
    right: 0; /* Right side */
    top: 64px; /* Below navbar */
    height: 100%;
    transform: translateX(100%); /* Off-screen initially */
    transition: transform 0.3s;
    z-index: 40; /* Above content */
}

#jobDetailSidebar.active {
    transform: translateX(0); /* Visible when active */
}
```

### Problem: Animation is choppy/stutters

**Symptoms:**

-   Sidebar animation not smooth
-   Jerky movement
-   CPU usage high

**Diagnosis:**

1. `will-change` not set
2. Too many DOM updates
3. Browser rendering issue

**Solutions:**

```css
/* Add GPU acceleration */
#jobDetailSidebar {
    will-change: transform;
    transform: translateX(100%) translateZ(0);
    backface-visibility: hidden;
}
```

### Problem: Content scrolls with sidebar (mobile)

**Symptoms:**

-   Mobile view
-   Open sidebar
-   Page scrolls behind sidebar
-   Content visible under overlay

**Diagnosis:**

-   Body `overflow: hidden` not applied
-   Script not running on open

**Solutions:**

```javascript
// Verify body scroll is disabled
function openJobDetailSidebar(jobId) {
    // ...
    document.body.style.overflow = "hidden"; // This line required
}

// Verify body scroll is restored
function closeJobDetailSidebar() {
    // ...
    document.body.style.overflow = "auto"; // This line required
}
```

### Problem: Save button state doesn't update

**Symptoms:**

-   Click save
-   Button color doesn't change
-   State not reflected

**Diagnosis:**

1. Response not returning `saved` status
2. Button classes not updated
3. Fetch error silently failing

**Solutions:**

```javascript
// Verify API response includes saved status
fetch("/api/jobs/1/save", { method: "POST" })
    .then((r) => r.json())
    .then((d) => console.log("Saved?", d.saved)); // Should show true/false

// Check button update code
if (data.saved) {
    document
        .getElementById("saveBtn")
        .classList.add("bg-yellow-400", "hover:bg-yellow-500");
}
```

### Problem: Wrong job details displayed

**Symptoms:**

-   Click job #1, shows job #2 details
-   Details don't match card
-   Inconsistent data

**Diagnosis:**

1. Job ID passed incorrectly
2. Cache returning wrong data
3. Race condition in API calls

**Solutions:**

```javascript
// Verify job ID passed correctly
console.log("Opening job:", jobId); // Check in console

// Clear any cache
jobCache.clear(); // If using cache function

// Verify API returns correct job
fetch(`/api/jobs/${jobId}`)
    .then((r) => r.json())
    .then((d) => console.log("Job ID:", d.job.id));
```

### Problem: AJAX form submission doesn't work

**Symptoms:**

-   Click save job
-   Page reloads
-   Should not reload

**Diagnosis:**

1. Form doesn't prevent default
2. Not using AJAX submission
3. Content-Type header incorrect

**Solutions:**

```javascript
// Verify form handler
document.getElementById("saveJobForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Must prevent default

    fetch(this.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: new FormData(this),
    });
    // ...
});
```

---

## Debug Checklist

When something isn't working:

1. **Check Browser Console**

    ```
    F12 → Console tab
    Look for red error messages
    ```

2. **Check Network Tab**

    ```
    F12 → Network tab
    Look for failed requests
    Check response status codes
    ```

3. **Verify JavaScript**

    ```javascript
    // In console
    typeof openJobDetailSidebar; // Should be 'function'
    typeof closeJobDetailSidebar; // Should be 'function'
    currentJobId; // Should be a number or null
    ```

4. **Check HTML Elements**

    ```javascript
    // In console
    document.getElementById("jobDetailSidebar"); // Should return element
    document.getElementById("sidebarContent"); // Should return element
    document.getElementById("sidebarOverlay"); // Should return element
    ```

5. **Test API Endpoint**

    ```javascript
    // In console
    fetch("/api/jobs/1")
        .then((r) => r.json())
        .then((d) => console.table(d.job));
    ```

6. **Check CSS**
    ```javascript
    // In console
    const sidebar = document.getElementById("jobDetailSidebar");
    window.getComputedStyle(sidebar).transform;
    window.getComputedStyle(sidebar).zIndex;
    ```

---

## Performance Benchmarks

### Expected Performance

| Metric               | Target  | Status |
| -------------------- | ------- | ------ |
| API Response Time    | < 500ms | ✅     |
| Sidebar Animation    | 300ms   | ✅     |
| FPS During Animation | 60 FPS  | ✅     |
| Job Load Time        | < 2s    | ✅     |
| Memory per Sidebar   | < 2MB   | ✅     |

### Measuring Performance

```javascript
// Measure API response time
const start = performance.now();
fetch("/api/jobs/1")
    .then((r) => r.json())
    .then((d) => {
        const end = performance.now();
        console.log(`API took ${(end - start).toFixed(2)}ms`);
    });

// Measure animation smoothness
let frames = 0;
let lastTime = performance.now();

function countFrames() {
    frames++;
    const now = performance.now();
    if (now - lastTime >= 1000) {
        console.log(`FPS: ${frames}`);
        frames = 0;
        lastTime = now;
    }
    requestAnimationFrame(countFrames);
}

countFrames();
openJobDetailSidebar(1); // FPS should stay at 60
```

---

## Common Issues Summary

| Issue                | Cause                    | Solution                        |
| -------------------- | ------------------------ | ------------------------------- |
| Sidebar doesn't open | Missing click handler    | Add event listener to job cards |
| API 404 error        | Route not defined        | Add route in web.php            |
| Infinite loading     | API not returning JSON   | Fix API response format         |
| Save doesn't work    | CSRF token missing       | Add meta csrf-token tag         |
| Choppy animation     | No GPU acceleration      | Add will-change CSS             |
| Body scrolls         | overflow not hidden      | Add to openJobDetailSidebar()   |
| ESC doesn't close    | Keydown listener missing | Verify event listener           |
| Mobile overlay stuck | pointer-events: none     | Change to pointer-events: auto  |

---

## When to Seek Help

If none of the above solutions work:

1. **Check documentation:**

    - `JOBSTREET_SIDEBAR_IMPLEMENTATION.md` - Full technical docs
    - `JOBSTREET_SIDEBAR_EXAMPLES.md` - Code examples

2. **Review code:**

    - `resources/views/components/job-detail-sidebar.blade.php`
    - `resources/views/jobs/search.blade.php`
    - `app/Http/Controllers/JobController.php`

3. **Check browser:**

    - Console for errors
    - Network for failed requests
    - Performance for bottlenecks

4. **Common fixes:**
    - Hard refresh (Ctrl+Shift+R)
    - Clear browser cache
    - Verify Laravel `php artisan cache:clear`
    - Check CSRF token exists
