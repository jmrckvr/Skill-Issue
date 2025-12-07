<!-- JobStreet-Style Right Sidebar Modal -->
<div id="jobDetailSidebar" style="position: fixed; right: 0; top: 64px; height: 100vh; width: 100%; max-width: 400px; display: block; visibility: visible; opacity: 1; background: white; box-shadow: -4px 0 20px rgba(0,0,0,0.15); transform: translateX(100%); transition: transform 300ms ease-out; z-index: 9999; overflow-y: auto;">
    <!-- Close Button -->
    <button onclick="closeJobDetailSidebar()" class="absolute top-4 right-4 p-2 hover:bg-gray-100 rounded-lg z-50 transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Sidebar Content -->
    <div id="sidebarContent" style="padding: 1.5rem; padding-bottom: 3rem;">
        <!-- Loading State -->
        <div id="loadingState" class="flex flex-col items-center justify-center h-96 hidden">
            <svg class="animate-spin h-8 w-8 text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600 font-medium">Loading job details...</p>
        </div>

        <!-- Job Details Template (hidden initially) -->
        <div id="jobDetailsContent" style="display: none;">
            <!-- Company Logo & Title Section -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <div id="companyLogo" class="mb-4">
                    <!-- Logo will be inserted here -->
                </div>
                <h2 id="jobTitle" class="text-xl font-bold text-gray-900 mb-2"></h2>
                <p id="companyName" class="text-gray-600 text-sm font-medium"></p>
            </div>

            <!-- Key Information Section -->
            <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                <!-- Location -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-lg">📍</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Location</p>
                        <p id="jobLocation" class="font-semibold text-gray-900 mt-1"></p>
                    </div>
                </div>

                <!-- Salary -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-lg">💰</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Salary</p>
                        <p id="jobSalary" class="font-semibold text-green-600 mt-1"></p>
                    </div>
                </div>

                <!-- Job Type -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-lg">💼</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Job Type</p>
                        <p id="jobType" class="font-semibold text-gray-900 mt-1"></p>
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-lg">📚</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Experience</p>
                        <p id="experienceLevel" class="font-semibold text-gray-900 mt-1"></p>
                    </div>
                </div>

                <!-- Posted Date -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 text-lg">⏱️</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Posted</p>
                        <p id="postedDate" class="font-semibold text-gray-900 mt-1"></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                <button type="button" id="applyBtn" class="w-full py-3 px-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <span>📝</span>
                    <span>Quick Apply</span>
                </button>
                
                <form id="saveJobForm" method="POST" class="w-full">
                    <?php echo csrf_field(); ?>
                    <button type="submit" id="saveBtn" class="w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <span id="saveBtnIcon">☆</span>
                        <span id="saveBtnText">Save Job</span>
                    </button>
                </form>
            </div>

            <!-- Job Description Section -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3">About This Job</h3>
                <div id="jobDescription" class="text-sm text-gray-700 leading-relaxed space-y-4"></div>
            </div>

            <!-- Requirements Section -->
            <div id="requirementsSection" class="mb-6 pb-6 border-b border-gray-200 hidden">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3">Requirements</h3>
                <ul id="requirementsList" class="space-y-2 text-sm text-gray-700"></ul>
            </div>

            <!-- Benefits Section -->
            <div id="benefitsSection" class="mb-6 pb-6 border-b border-gray-200 hidden">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3">Benefits</h3>
                <ul id="benefitsList" class="space-y-2 text-sm text-gray-700"></ul>
            </div>

            <!-- Company Info Section -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-3">Company Info</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p id="companyIndustry"></p>
                    <p id="companySize"></p>
                    <p id="companyWebsite"></p>
                </div>
            </div>

            <!-- View Full Details Link -->
            <div class="text-center">
                <a id="viewFullDetailsLink" href="#" target="_blank" class="inline-block text-blue-600 hover:text-blue-800 font-semibold text-sm">
                    View full job details →
                </a>
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" style="display: none;" class="flex flex-col items-center justify-center h-96 text-center">
            <svg class="w-16 h-16 text-red-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-red-600 font-medium">Error loading job details</p>
            <p class="text-gray-500 text-sm mt-2">Please try again</p>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-0 transition-opacity duration-300 ease-out z-30 cursor-pointer pointer-events-none" onclick="closeJobDetailSidebar()"></div>

<style>
    /* Smooth scrolling */
    #sidebarContent {
        scroll-behavior: smooth;
    }

    /* Description formatting */
    #jobDescription p {
        margin-bottom: 0.75rem;
    }

    #jobDescription ul, #jobDescription ol {
        margin-left: 1rem;
        margin-bottom: 0.75rem;
    }

    #jobDescription li {
        margin-bottom: 0.5rem;
    }
</style>

<script>
    let currentJobId = null;

    function openJobDetailSidebar(jobId) {
        const sidebar = document.getElementById('jobDetailSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Set current job ID for apply button
        currentJobId = jobId;

        // Show sidebar with animation - pure inline styles
        sidebar.style.transform = 'translateX(0)';
        sidebar.style.display = 'block';
        sidebar.style.visibility = 'visible';
        
        overlay.style.opacity = '0.5';
        overlay.style.pointerEvents = 'auto';
        overlay.style.display = 'block';

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Load job details
        loadJobDetailsData(jobId);
    }

    function closeJobDetailSidebar() {
        const sidebar = document.getElementById('jobDetailSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Hide sidebar with animation - pure inline styles
        sidebar.style.transform = 'translateX(100%)';
        
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
        overlay.style.display = 'none';

        // Restore body scroll
        document.body.style.overflow = 'auto';
    }

    function loadJobDetailsData(jobId) {
        const loadingState = document.getElementById('loadingState');
        const detailsContent = document.getElementById('jobDetailsContent');
        const errorState = document.getElementById('errorState');
        const sidebarContent = document.getElementById('sidebarContent');

        // Show loading state
        loadingState.style.display = 'flex';
        detailsContent.style.display = 'none';
        errorState.style.display = 'none';

        // Fetch job details
        fetch(`/api/jobs/${jobId}`)
            .then(response => {
                if (!response.ok) throw new Error('Failed to load job details');
                return response.json();
            })
            .then(data => {
                if (data.success && data.job) {
                    populateJobDetails(data.job);
                    loadingState.style.display = 'none';
                    detailsContent.style.display = 'block';
                    
                    const sidebar = document.getElementById('jobDetailSidebar');
                    setTimeout(() => {
                        sidebar.scrollTop = 0;
                        sidebarContent.scrollTop = 0;
                    }, 50);
                } else {
                    throw new Error('Invalid job data');
                }
            })
            .catch(error => {
                console.error('Error loading job details:', error);
                loadingState.style.display = 'none';
                errorState.style.display = 'flex';
            });
    }

    function populateJobDetails(job) {
        try {
            // Company logo
            const logoContainer = document.getElementById('companyLogo');
            let logoUrl = null;
            
            if (job.logo) {
                // Check if logo is an external URL or local file
                logoUrl = job.logo.startsWith('http') ? job.logo : `/storage/${job.logo}`;
                logoContainer.innerHTML = `<img src="${logoUrl}" alt="${job.company.name}" class="w-16 h-16 rounded-lg object-cover shadow-sm" loading="lazy" onerror="this.parentElement.innerHTML='<div class=\\"w-16 h-16 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm\\"><span class=\\"text-white font-bold text-2xl\\">${job.company.name.charAt(0)}</span></div>'">`;
            } else if (job.company.logo_path) {
                // Check if logo_path is an external URL or local file
                logoUrl = job.company.logo_path.startsWith('http') ? job.company.logo_path : `/storage/${job.company.logo_path}`;
                logoContainer.innerHTML = `<img src="${logoUrl}" alt="${job.company.name}" class="w-16 h-16 rounded-lg object-cover shadow-sm" loading="lazy" onerror="this.parentElement.innerHTML='<div class=\\"w-16 h-16 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm\\"><span class=\\"text-white font-bold text-2xl\\">${job.company.name.charAt(0)}</span></div>'">`;
            } else {
                logoContainer.innerHTML = `<div class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm"><span class="text-white font-bold text-2xl">${job.company.name.charAt(0)}</span></div>`;
            }

            // Basic info
            document.getElementById('jobTitle').textContent = job.title;
            document.getElementById('companyName').textContent = job.company.name;
            document.getElementById('jobLocation').textContent = job.location;
            document.getElementById('jobSalary').textContent = job.formatted_salary;
            document.getElementById('jobType').textContent = job.job_type.charAt(0).toUpperCase() + job.job_type.slice(1).replace('-', ' ');
            document.getElementById('experienceLevel').textContent = job.experience_level ? job.experience_level.charAt(0).toUpperCase() + job.experience_level.slice(1) : 'Not specified';
            document.getElementById('postedDate').textContent = job.posted_at;

            // Description
            const descriptionContainer = document.getElementById('jobDescription');
            if (job.description) {
                descriptionContainer.innerHTML = job.description.replace(/\n/g, '<p></p>');
            }

            // Requirements
            if (job.requirements) {
                const reqSection = document.getElementById('requirementsSection');
                const reqList = document.getElementById('requirementsList');
                let requirements = [];
                
                if (Array.isArray(job.requirements)) {
                    requirements = job.requirements;
                } else if (typeof job.requirements === 'string') {
                    requirements = job.requirements.split(',').map(r => r.trim()).filter(r => r.length > 0);
                }
                
                if (requirements.length > 0) {
                    reqList.innerHTML = requirements.map(req => `<li class="flex gap-2"><span class="text-blue-600">✓</span><span>${req}</span></li>`).join('');
                    reqSection.style.display = 'block';
                }
            }

            // Benefits
            if (job.benefits) {
                const benSection = document.getElementById('benefitsSection');
                const benList = document.getElementById('benefitsList');
                let benefits = [];
                
                if (Array.isArray(job.benefits)) {
                    benefits = job.benefits;
                } else if (typeof job.benefits === 'string') {
                    benefits = job.benefits.split(',').map(b => b.trim()).filter(b => b.length > 0);
                }
                
                if (benefits.length > 0) {
                    benList.innerHTML = benefits.map(ben => `<li class="flex gap-2"><span class="text-green-600">★</span><span>${ben}</span></li>`).join('');
                    benSection.style.display = 'block';
                }
            }

            // Company info
            document.getElementById('companyIndustry').textContent = job.company.industry ? `📊 ${job.company.industry}` : '';
            document.getElementById('companySize').textContent = job.company.employee_count ? `👥 ${job.company.employee_count}+ employees` : '';
            document.getElementById('companyWebsite').textContent = job.company.website ? `🌐 ${job.company.website}` : '';

            // View full details link
            document.getElementById('viewFullDetailsLink').href = `/jobs/${job.id}`;

            // Update save button state
            const saveBtn = document.getElementById('saveBtn');
            const saveBtnIcon = document.getElementById('saveBtnIcon');
            const saveBtnText = document.getElementById('saveBtnText');

            if (job.is_saved) {
                saveBtn.classList.add('bg-yellow-400', 'hover:bg-yellow-500');
                saveBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                saveBtnIcon.textContent = '★';
                saveBtnText.textContent = 'Saved';
            } else {
                saveBtn.classList.remove('bg-yellow-400', 'hover:bg-yellow-500');
                saveBtn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                saveBtnIcon.textContent = '☆';
                saveBtnText.textContent = 'Save Job';
            }

            // Handle authentication for apply button
            const isLoggedIn = <?php echo e(auth()->check() ? 'true' : 'false'); ?>;
            const applyBtn = document.getElementById('applyBtn');
            
            if (!isLoggedIn) {
                applyBtn.onclick = function() {
                    window.location.href = '/login';
                };
                applyBtn.innerHTML = '<span>🔓</span><span>Login to Apply</span>';
            }
            
        } catch (error) {
            console.error('Error in populateJobDetails:', error);
            throw error;
        }
    }

    // Handle apply button click with event listener
    document.addEventListener('DOMContentLoaded', function() {
        const applyBtn = document.getElementById('applyBtn');
        if (applyBtn) {
            applyBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Apply button clicked, currentJobId:', currentJobId);
                if (currentJobId) {
                    console.log('Navigating to /jobs/' + currentJobId + '/apply');
                    // Navigate to apply page - will show job details and form
                    window.location.href = '/jobs/' + currentJobId + '/apply';
                } else {
                    console.error('currentJobId is null!');
                    alert('Error: Job ID not found. Please try clicking on the job again.');
                }
            });
        }
    });

    // Close sidebar when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeJobDetailSidebar();
        }
    });

    // Handle save job form submission
    document.addEventListener('DOMContentLoaded', function() {
        const saveJobForm = document.getElementById('saveJobForm');
        if (saveJobForm) {
            saveJobForm.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const jobId = currentJobId;
                
                console.log('Saving job ID:', jobId);
                
                if (!jobId) {
                    alert('Error: Job ID not found. Please try again.');
                    return;
                }
                
                // Send POST request to save job
                fetch(`/jobs/${jobId}/save`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Save job response:', data);
                    if (data.success) {
                        // Update button state
                        const saveBtn = document.getElementById('saveBtn');
                        const saveBtnIcon = document.getElementById('saveBtnIcon');
                        const saveBtnText = document.getElementById('saveBtnText');
                        
                        if (data.saved) {
                            // Job was saved
                            saveBtn.classList.add('bg-yellow-400', 'hover:bg-yellow-500');
                            saveBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                            saveBtnIcon.textContent = '★';
                            saveBtnText.textContent = 'Saved';
                        } else {
                            // Job was removed from saved
                            saveBtn.classList.remove('bg-yellow-400', 'hover:bg-yellow-500');
                            saveBtn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                            saveBtnIcon.textContent = '☆';
                            saveBtnText.textContent = 'Save Job';
                        }
                    } else if (data.error) {
                        // Handle error response
                        if (data.error.includes('login')) {
                            alert('Please log in to save jobs');
                        } else {
                            alert('Error: ' + data.error);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error saving job:', error);
                    alert('Error saving job. Please try again.');
                });
            });
        }
    });
</script>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/components/job-detail-sidebar.blade.php ENDPATH**/ ?>