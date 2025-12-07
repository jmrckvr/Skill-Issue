<!-- Apply Panel Container -->
<div id="applyPanelContainer" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 999; background-color: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s ease;">
    <!-- Apply Panel Slide-in from Right -->
    <div id="applyPanel" style="position: fixed; top: 0; right: 0; bottom: 0; width: 100%; max-width: 400px; background-color: white; box-shadow: -4px 0 12px rgba(0,0,0,0.15); z-index: 1000; overflow-y: auto; transform: translateX(100%); transition: transform 0.3s ease;">
        <!-- Header -->
        <div style="position: sticky; top: 0; background-color: white; border-bottom: 1px solid #e5e7eb; padding: 24px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 20px; font-weight: bold; color: #111827; margin: 0; padding: 0;">Apply for Job</h2>
                <p id="applyJobTitle" style="font-size: 14px; color: #4b5563; margin: 8px 0 0 0; padding: 0;">Job Title</p>
            </div>
            <button onclick="window.closeApplyPanel()" style="background: none; border: none; font-size: 28px; color: #6b7280; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                ×
            </button>
        </div>

        <!-- Content -->
        <div style="padding: 24px; overflow-y: auto;">
            <!-- Job Summary -->
            <div style="background-color: #f0f9ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <h3 id="panelJobTitle" style="font-weight: bold; color: #111827; margin: 0; font-size: 16px;">Job Title</h3>
                <p id="panelCompanyName" style="font-size: 14px; color: #4b5563; margin: 8px 0 0 0;">Company Name</p>
            </div>

            <!-- Application Form -->
            <form id="applyForm" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf

                <!-- Full Name -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Full Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="applicant_name" id="applicantName" required
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                        placeholder="Your full name">
                </div>

                <!-- Email -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Email <span style="color: #ef4444;">*</span></label>
                    <input type="email" name="applicant_email" id="applicantEmail" required readonly
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; background-color: #f3f4f6; font-size: 14px; box-sizing: border-box;">
                </div>

                <!-- Phone -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Phone Number</label>
                    <input type="tel" name="applicant_phone" id="applicantPhone"
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                        placeholder="+63 9XX XXX XXXX">
                </div>

                <!-- Location -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Location</label>
                    <input type="text" name="applicant_location" id="applicantLocation"
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;"
                        placeholder="City, Country">
                </div>

                <!-- Skills -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Key Skills</label>
                    <textarea name="applicant_skills" id="applicantSkills" rows="3"
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; font-family: inherit;"
                        placeholder="e.g., Laravel, JavaScript, MySQL"></textarea>
                </div>

                <!-- Bio -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Professional Summary</label>
                    <textarea name="applicant_bio" id="applicantBio" rows="3"
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; font-family: inherit;"
                        placeholder="Brief professional background"></textarea>
                </div>

                <!-- Resume -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Resume <span style="color: #ef4444;">*</span></label>
                    <div id="resumeDropzone" style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.3s;">
                        <svg style="height: 48px; width: 48px; margin: 0 auto 12px; color: #9ca3af;" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-3-3m3 3l3-3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div style="font-size: 14px; color: #4b5563;">
                            <label style="color: #2563eb; cursor: pointer; font-weight: 500;">
                                <span>Upload a file</span>
                                <input type="file" name="resume" id="resumeInput" required accept=".pdf,.doc,.docx" style="display: none;">
                            </label>
                            <span style="color: #4b5563;"> or drag</span>
                        </div>
                        <p style="font-size: 12px; color: #9ca3af; margin: 8px 0 0 0;">PDF, DOC, DOCX - Max 5MB</p>
                    </div>
                    <div id="resumeFileName" style="margin-top: 12px; font-size: 14px; color: #16a34a; font-weight: 600; display: none;">
                        ✓ <span id="fileName"></span>
                    </div>
                </div>

                <!-- Cover Letter -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 8px;">Cover Letter</label>
                    <textarea name="cover_letter" id="coverLetter" rows="4"
                        style="width: 100%; padding: 10px 16px; border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; font-family: inherit;"
                        placeholder="Tell the employer why you're interested..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" style="background-color: #f53a6b; color: white; padding: 12px 16px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: background-color 0.3s; font-size: 15px; margin-top: 12px;">
                    Submit Application
                </button>

                <!-- Cancel Button -->
                <button type="button" onclick="window.closeApplyPanel()" style="background-color: white; color: #111827; padding: 12px 16px; border-radius: 6px; font-weight: 600; width: 100%; border: 2px solid #d1d5db; cursor: pointer; transition: all 0.3s; font-size: 15px;">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Store user data -->
<div id="userData" style="display: none;" 
    data-name="@auth{{ auth()->user()->name }}@endauth"
    data-email="@auth{{ auth()->user()->email }}@endauth"
    data-phone="@auth{{ auth()->user()->contact_number ?? '' }}@endauth"
    data-location="@auth{{ auth()->user()->location ?? '' }}@endauth"
    data-skills="@auth{{ auth()->user()->skills ?? '' }}@endauth"
    data-bio="@auth{{ auth()->user()->bio ?? '' }}@endauth">
</div>

<!-- Drag and drop file handling & Form submission -->
<script>
    // Initialize on DOM ready
    function initializeApplyPanel() {
        const resumeDropzone = document.getElementById('resumeDropzone');
        const resumeInput = document.getElementById('resumeInput');
        const resumeFileName = document.getElementById('resumeFileName');
        const fileName = document.getElementById('fileName');

        if (resumeDropzone && resumeInput) {
            resumeInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    resumeFileName.style.display = 'block';
                }
            });

            resumeDropzone.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    resumeInput.click();
                }
            });

            resumeDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#3b82f6';
                this.style.backgroundColor = '#f0f9ff';
            });

            resumeDropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#d1d5db';
                this.style.backgroundColor = 'transparent';
            });

            resumeDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#d1d5db';
                this.style.backgroundColor = 'transparent';
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    resumeInput.files = files;
                    fileName.textContent = files[0].name;
                    resumeFileName.style.display = 'block';
                }
            });
        }

        // Form submission
        const applyForm = document.getElementById('applyForm');
        if (applyForm) {
            applyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Application submitted successfully!');
                        closeApplyPanel();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to submit application'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            });
        }

        // Close on backdrop click
        const container = document.getElementById('applyPanelContainer');
        if (container) {
            container.addEventListener('click', function(e) {
                if (e.target === container) {
                    closeApplyPanel();
                }
            });
        }
    }

    // Open Apply Panel function - GLOBAL
    function openApplyPanel(jobId, jobTitle, companyName, actionUrl) {
        console.log('Opening apply panel for:', jobTitle, 'Action:', actionUrl);
        
        // Check if user is authenticated
        const userDataElement = document.getElementById('userData');
        const isAuthenticated = userDataElement && userDataElement.dataset.email && userDataElement.dataset.email.length > 0;
        
        if (!isAuthenticated) {
            alert('Please login to apply for this job');
            window.location.href = '/login';
            return;
        }
        
        const container = document.getElementById('applyPanelContainer');
        const panel = document.getElementById('applyPanel');
        const form = document.getElementById('applyForm');
        const nameInput = document.getElementById('applicantName');
        const emailInput = document.getElementById('applicantEmail');
        const phoneInput = document.getElementById('applicantPhone');
        const locationInput = document.getElementById('applicantLocation');
        const skillsInput = document.getElementById('applicantSkills');
        const bioInput = document.getElementById('applicantBio');

        // Set job info
        document.getElementById('panelJobTitle').textContent = jobTitle;
        document.getElementById('panelCompanyName').textContent = companyName;
        document.getElementById('applyJobTitle').textContent = jobTitle;

        // Set form action
        form.action = actionUrl;

        // Pre-fill with user data
        nameInput.value = userDataElement.dataset.name || '';
        emailInput.value = userDataElement.dataset.email || '';
        phoneInput.value = userDataElement.dataset.phone || '';
        locationInput.value = userDataElement.dataset.location || '';
        skillsInput.value = userDataElement.dataset.skills || '';
        bioInput.value = userDataElement.dataset.bio || '';

        // Show panel with animation
        container.style.display = 'block';
        setTimeout(() => {
            container.style.opacity = '0.5';
            panel.style.transform = 'translateX(0)';
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    // Close Apply Panel function - GLOBAL
    function closeApplyPanel() {
        const container = document.getElementById('applyPanelContainer');
        const panel = document.getElementById('applyPanel');
        const form = document.getElementById('applyForm');

        // Hide with animation
        container.style.opacity = '0';
        panel.style.transform = 'translateX(100%)';
        
        setTimeout(() => {
            container.style.display = 'none';
        }, 300);
        
        document.body.style.overflow = 'auto';
        form.reset();
        document.getElementById('resumeFileName').style.display = 'none';
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApplyPanel();
        }
    });

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeApplyPanel);
    } else {
        initializeApplyPanel();
    }
</script>
