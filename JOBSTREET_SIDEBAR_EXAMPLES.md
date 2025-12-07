# JobStreet Sidebar - Code Examples & Customization

## Table of Contents

1. [Basic Usage](#basic-usage)
2. [Customization Examples](#customization-examples)
3. [Advanced Scenarios](#advanced-scenarios)
4. [API Integration Examples](#api-integration-examples)
5. [Styling Customizations](#styling-customizations)
6. [JavaScript Enhancements](#javascript-enhancements)

## Basic Usage

### Trigger Sidebar From Custom Element

Instead of job cards, you can trigger the sidebar from any element:

```html
<!-- Method 1: Direct onclick -->
<button onclick="openJobDetailSidebar(5)">View Job #5</button>

<!-- Method 2: Data attribute with JavaScript -->
<div class="job-item" data-job-id="5">
    <h3>Senior Developer</h3>
</div>

<script>
    document.querySelectorAll(".job-item").forEach((item) => {
        item.addEventListener("click", function () {
            const jobId = this.getAttribute("data-job-id");
            openJobDetailSidebar(jobId);
        });
    });
</script>

<!-- Method 3: From form submission -->
<form onsubmit="return openJobFromForm(event)">
    <input type="hidden" name="job_id" value="5" />
    <button type="submit">View Details</button>
</form>

<script>
    function openJobFromForm(event) {
        event.preventDefault();
        const jobId = event.target.querySelector('input[name="job_id"]').value;
        openJobDetailSidebar(jobId);
        return false;
    }
</script>
```

### Check If Sidebar Is Open

```javascript
if (currentJobId !== null) {
    console.log("Sidebar is open for job:", currentJobId);
} else {
    console.log("Sidebar is closed");
}
```

### Listen for Sidebar Events

```javascript
// Custom event when sidebar opens
const originalOpen = openJobDetailSidebar;
openJobDetailSidebar = function (jobId) {
    originalOpen(jobId);
    window.dispatchEvent(
        new CustomEvent("sidebarOpened", { detail: { jobId } })
    );
};

// Listen for the event
window.addEventListener("sidebarOpened", function (e) {
    console.log("Job sidebar opened for job:", e.detail.jobId);
});

// Similarly for close
const originalClose = closeJobDetailSidebar;
closeJobDetailSidebar = function () {
    originalClose();
    window.dispatchEvent(new CustomEvent("sidebarClosed"));
};

window.addEventListener("sidebarClosed", function () {
    console.log("Job sidebar closed");
});
```

## Customization Examples

### Change Sidebar Width

**Option 1: Via CSS in sidebar component**

```css
/* Default is 384px (w-96) for desktop */
@media (min-width: 768px) {
    #jobDetailSidebar {
        width: 28rem; /* 448px - slightly wider */
    }
}
```

**Option 2: Using Tailwind utility class**

```html
<div id="jobDetailSidebar" class="w-full md:w-[28rem]"></div>
```

**Option 3: Custom CSS variable**

```css
:root {
    --sidebar-width: 24rem;
}

#jobDetailSidebar {
    width: var(--sidebar-width);
}
```

### Customize Button Colors

**Apply Button (Hot Pink to Custom Color)**

```html
<!-- Original -->
<button class="w-full py-3 px-4 bg-red-500 hover:bg-red-600 text-white">
    Quick Apply
</button>

<!-- Customized (Teal) -->
<button class="w-full py-3 px-4 bg-teal-500 hover:bg-teal-600 text-white">
    Quick Apply
</button>

<!-- Customized (Purple Gradient) -->
<button
    class="w-full py-3 px-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white"
>
    Quick Apply
</button>

<!-- Customized (Custom Color via CSS) -->
<style>
    #applyBtn {
        background-color: #0f766e; /* Custom teal */
    }
    #applyBtn:hover {
        background-color: #134e4a; /* Darker teal */
    }
</style>
```

**Save Button (Gray/Yellow to Custom)**

```html
<!-- Unsaved state (custom blue) -->
<button class="w-full py-3 px-4 bg-blue-100 hover:bg-blue-200 text-blue-900">
    ☆ Save Job
</button>

<!-- Saved state (custom green) -->
<button class="w-full py-3 px-4 bg-green-400 hover:bg-green-500 text-white">
    ★ Saved
</button>
```

### Change Animation Speed

**In sidebar component CSS:**

```css
/* Fast animation (150ms) */
#jobDetailSidebar {
    transition: transform 0.15s ease-out;
}

/* Slow animation (500ms) */
#jobDetailSidebar {
    transition: transform 0.5s ease-out;
}

/* Extra smooth (800ms with ease-in-out) */
#jobDetailSidebar {
    transition: transform 0.8s ease-in-out;
}
```

### Add Loading Skeleton

Replace loading state with skeleton screen:

```html
<!-- Original Loading State -->
<div id="loadingState" class="flex flex-col items-center justify-center h-96">
    <svg class="animate-spin h-8 w-8 text-blue-600 mb-4"></svg>
    <p class="text-gray-600 font-medium">Loading job details...</p>
</div>

<!-- Skeleton Loading State -->
<div id="loadingState" class="space-y-4 p-6">
    <!-- Logo skeleton -->
    <div class="w-16 h-16 bg-gray-200 rounded-lg animate-pulse"></div>

    <!-- Title skeleton -->
    <div class="space-y-2">
        <div class="h-6 bg-gray-200 rounded animate-pulse w-3/4"></div>
        <div class="h-4 bg-gray-200 rounded animate-pulse w-1/2"></div>
    </div>

    <!-- Info skeleton -->
    <div class="space-y-3">
        <div class="h-12 bg-gray-200 rounded animate-pulse"></div>
        <div class="h-12 bg-gray-200 rounded animate-pulse"></div>
        <div class="h-12 bg-gray-200 rounded animate-pulse"></div>
    </div>

    <!-- Button skeletons -->
    <div class="space-y-2">
        <div class="h-12 bg-gray-200 rounded animate-pulse"></div>
        <div class="h-12 bg-gray-200 rounded animate-pulse"></div>
    </div>

    <!-- Description skeleton -->
    <div class="space-y-2">
        <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
        <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
        <div class="h-4 bg-gray-200 rounded animate-pulse w-2/3"></div>
    </div>
</div>
```

### Add Toast Notifications

Replace form submission behavior with toast:

```javascript
// Add this to sidebar component
document.getElementById("saveJobForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(this.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Show toast notification
                showToast(data.message, "success");

                // Update button state
                const saveBtn = document.getElementById("saveBtn");
                if (data.saved) {
                    saveBtn.classList.add(
                        "bg-yellow-400",
                        "hover:bg-yellow-500"
                    );
                    document.getElementById("saveBtnIcon").textContent = "★";
                    document.getElementById("saveBtnText").textContent =
                        "Saved";
                } else {
                    saveBtn.classList.remove(
                        "bg-yellow-400",
                        "hover:bg-yellow-500"
                    );
                    document.getElementById("saveBtnIcon").textContent = "☆";
                    document.getElementById("saveBtnText").textContent =
                        "Save Job";
                }
            }
        })
        .catch((error) => {
            showToast("Error saving job", "error");
        });
});

// Toast notification function
function showToast(message, type = "info") {
    const toast = document.createElement("div");
    const colors = {
        success: "bg-green-500",
        error: "bg-red-500",
        info: "bg-blue-500",
    };

    toast.className = `${colors[type]} text-white px-6 py-3 rounded-lg fixed bottom-4 right-4 z-50`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
```

## Advanced Scenarios

### Add Search History to Sidebar

```javascript
// Add job view tracking
function trackJobView(jobId) {
    const history = JSON.parse(localStorage.getItem("jobViewHistory") || "[]");

    if (!history.includes(jobId)) {
        history.unshift(jobId);
        history.splice(10); // Keep last 10
    }

    localStorage.setItem("jobViewHistory", JSON.stringify(history));
}

// Modify openJobDetailSidebar to call it
const originalOpen = openJobDetailSidebar;
openJobDetailSidebar = function (jobId) {
    trackJobView(jobId);
    originalOpen(jobId);
};
```

### Share Job to Social Media

Add to sidebar buttons:

```html
<!-- Add social share buttons -->
<div class="flex gap-2 mt-4">
    <button
        onclick="shareToFacebook()"
        class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded"
    >
        Facebook
    </button>
    <button
        onclick="shareToTwitter()"
        class="flex-1 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm rounded"
    >
        Twitter
    </button>
    <button
        onclick="shareToLinkedIn()"
        class="flex-1 py-2 bg-blue-900 hover:bg-blue-950 text-white text-sm rounded"
    >
        LinkedIn
    </button>
</div>

<script>
    function shareToFacebook() {
        const url = `https://www.facebook.com/sharer/sharer.php?u=${window.location.href}`;
        window.open(url, "_blank", "width=600,height=600");
    }

    function shareToTwitter() {
        const title = document.getElementById("jobTitle").textContent;
        const company = document.getElementById("companyName").textContent;
        const text = `Check out this job: ${title} at ${company}`;
        const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(
            text
        )}&url=${window.location.href}`;
        window.open(url, "_blank", "width=600,height=600");
    }

    function shareToLinkedIn() {
        const url = `https://www.linkedin.com/sharing/share-offsite/?url=${window.location.href}`;
        window.open(url, "_blank", "width=600,height=600");
    }
</script>
```

### Add Job Comparison

```javascript
// Track compared jobs
let comparedJobs = new Set();

function toggleJobComparison(jobId) {
    if (comparedJobs.has(jobId)) {
        comparedJobs.delete(jobId);
    } else {
        comparedJobs.add(jobId);
    }

    const compareBtn = document.getElementById("compareBtn");
    if (comparedJobs.size > 0) {
        compareBtn.textContent = `Compare (${comparedJobs.size})`;
        compareBtn.classList.remove("hidden");
    } else {
        compareBtn.classList.add("hidden");
    }
}

function viewComparison() {
    const jobIds = Array.from(comparedJobs).join(",");
    window.location.href = `/jobs/compare?ids=${jobIds}`;
}
```

## API Integration Examples

### Custom API Response Format

If your API returns a different format, customize the parsing:

```javascript
// In populateJobDetails function
function populateJobDetails(job) {
    // Handle different API formats

    // Format 1: Nested structure
    const title = job.data?.jobTitle || job.title;

    // Format 2: Transformed fields
    const salary = job.salaryRange
        ? `${job.salaryRange.min} - ${job.salaryRange.max}`
        : job.formatted_salary;

    // Format 3: Comma-separated strings
    const requirements =
        typeof job.requirements === "string"
            ? job.requirements.split(",")
            : job.requirements;

    // Update based on available data
    document.getElementById("jobTitle").textContent = title;
    document.getElementById("jobSalary").textContent = salary;
}
```

### Add Error Retry Logic

```javascript
async function loadJobDetailsWithRetry(jobId, maxRetries = 3) {
    let retries = 0;

    while (retries < maxRetries) {
        try {
            const response = await fetch(`/api/jobs/${jobId}`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();
            if (data.success) {
                return data.job;
            }
            throw new Error("Invalid response");
        } catch (error) {
            retries++;
            if (retries < maxRetries) {
                console.log(`Retry ${retries}/${maxRetries}...`);
                await new Promise((resolve) =>
                    setTimeout(resolve, 1000 * retries)
                );
            } else {
                throw error;
            }
        }
    }
}
```

### Cache API Responses

```javascript
// Simple cache for job details
const jobCache = new Map();

function getJobDetails(jobId) {
    // Check cache first
    if (jobCache.has(jobId)) {
        return Promise.resolve(jobCache.get(jobId));
    }

    // Fetch and cache
    return fetch(`/api/jobs/${jobId}`)
        .then((r) => r.json())
        .then((data) => {
            if (data.success) {
                jobCache.set(jobId, data.job);
                return data.job;
            }
            throw new Error("Failed to load job");
        });
}

// Clear cache
function clearJobCache() {
    jobCache.clear();
}
```

## Styling Customizations

### Dark Mode Theme

```css
@media (prefers-color-scheme: dark) {
    #jobDetailSidebar {
        background-color: #1f2937; /* Dark gray */
        color: #f3f4f6; /* Light text */
    }

    #jobDetailsContent h2,
    #jobDetailsContent h3,
    #jobDetailsContent h4 {
        color: #f9fafb;
    }

    #jobDetailsContent p {
        color: #d1d5db;
    }

    #sidebarOverlay {
        background-color: rgba(0, 0, 0, 0.8);
    }
}
```

### Custom Font Styling

```css
#jobDetailSidebar {
    font-family: "Inter", "Segoe UI", sans-serif;
}

#jobDetailSidebar h2 {
    font-family: "Poppins", "Arial", sans-serif;
    font-weight: 700;
}

/* System font stack */
#jobDetailSidebar {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
        "Helvetica Neue", Arial, sans-serif;
}
```

### Custom Border and Shadow

```css
/* Minimal style */
#jobDetailSidebar {
    border-left: 1px solid #e5e7eb;
    box-shadow: -4px 0 6px rgba(0, 0, 0, 0.05);
}

/* Bold style */
#jobDetailSidebar {
    border-left: 4px solid #2563eb;
    box-shadow: -12px 0 20px rgba(0, 0, 0, 0.2);
}

/* Glassmorphism style */
#jobDetailSidebar {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.8);
}
```

## JavaScript Enhancements

### Debounce Job Loading

Prevent rapid API calls when clicking multiple times:

```javascript
const debounceLoadJob = (function () {
    let timeout;
    return function (jobId) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            loadJobDetailsData(jobId);
        }, 300);
    };
})();
```

### Add Keyboard Navigation Between Jobs

```javascript
let jobIndex = -1;
const allJobs = [];

function initKeyboardNavigation() {
    const jobCards = document.querySelectorAll(".job-card");
    allJobs.length = 0;
    jobCards.forEach((card) => allJobs.push(card));

    document.addEventListener("keydown", function (e) {
        if (!currentJobId) return;

        if (e.key === "ArrowDown") {
            jobIndex = Math.min(jobIndex + 1, allJobs.length - 1);
            const nextJobId = allJobs[jobIndex].dataset.jobId;
            openJobDetailSidebar(nextJobId);
        } else if (e.key === "ArrowUp") {
            jobIndex = Math.max(jobIndex - 1, 0);
            const prevJobId = allJobs[jobIndex].dataset.jobId;
            openJobDetailSidebar(prevJobId);
        }
    });
}
```

### Add Sidebar Swipe Close (Mobile)

```javascript
let touchStartX = 0;
let touchEndX = 0;

const sidebar = document.getElementById("jobDetailSidebar");

sidebar.addEventListener(
    "touchstart",
    function (e) {
        touchStartX = e.changedTouches[0].screenX;
    },
    false
);

sidebar.addEventListener(
    "touchend",
    function (e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    },
    false
);

function handleSwipe() {
    const swipeThreshold = 50;
    if (touchEndX < touchStartX - swipeThreshold) {
        // Swiped left - close sidebar
        closeJobDetailSidebar();
    }
}
```

---

## Summary

These examples show how to:

-   ✅ Trigger sidebar from various sources
-   ✅ Customize appearance and animation
-   ✅ Add advanced features (sharing, comparison, history)
-   ✅ Handle different API formats
-   ✅ Improve UX with skeleton, toasts, keyboard navigation
-   ✅ Add dark mode and custom styling
-   ✅ Cache and retry logic for reliability

Pick and choose based on your needs!
