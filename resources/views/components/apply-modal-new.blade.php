<!-- Apply Modal - New Implementation -->
<div id="applyModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 50; overflow-y: auto;">
    <div style="position: relative; background: white; max-width: 500px; margin: 60px auto; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <!-- Close Button -->
        <button onclick="closeApplyModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 28px; cursor: pointer; color: #6b7280;">×</button>

        <!-- Header -->
        <div style="padding: 30px 30px 0; border-bottom: 1px solid #e5e7eb;">
            <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: #111827;">Apply for this job</h2>
            <p id="jobTitleModal" style="margin: 8px 0 0; color: #6b7280; font-size: 14px;">Job Title</p>
        </div>

        <!-- Form Content -->
        <form id="applyFormModal" method="POST" enctype="multipart/form-data" style="padding: 30px;">
            @csrf

            <!-- Full Name -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Full Name <span style="color: #ef4444;">*</span></label>
                <input type="text" name="applicant_name" id="nameModal" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;">
            </div>

            <!-- Email -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Email <span style="color: #ef4444;">*</span></label>
                <input type="email" name="applicant_email" id="emailModal" required readonly style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; background-color: #f3f4f6; font-size: 14px; box-sizing: border-box;">
            </div>

            <!-- Phone -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Phone Number</label>
                <input type="tel" name="applicant_phone" id="phoneModal" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;" placeholder="+63 9XX XXX XXXX">
            </div>

            <!-- Location -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Location</label>
                <input type="text" name="applicant_location" id="locationModal" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;" placeholder="City, Country">
            </div>

            <!-- Skills -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Key Skills</label>
                <textarea name="applicant_skills" id="skillsModal" rows="2" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; font-family: inherit;" placeholder="e.g., Laravel, JavaScript, MySQL"></textarea>
            </div>

            <!-- Bio -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Professional Summary</label>
                <textarea name="applicant_bio" id="bioModal" rows="2" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; font-family: inherit;" placeholder="Brief professional background"></textarea>
            </div>

            <!-- Resume Upload -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Resume <span style="color: #ef4444;">*</span></label>
                <div style="border: 2px dashed #d1d5db; border-radius: 6px; padding: 20px; text-align: center; cursor: pointer; background-color: #f9fafb;" id="dropzoneModal" onclick="document.getElementById('resumeModal').click();">
                    <svg style="width: 40px; height: 40px; margin: 0 auto 8px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p style="margin: 0; color: #6b7280; font-size: 14px;">Click to upload or drag and drop</p>
                    <p style="margin: 4px 0 0; color: #9ca3af; font-size: 12px;">PDF, DOC, DOCX - Max 5MB</p>
                    <input type="file" name="resume" id="resumeModal" required accept=".pdf,.doc,.docx" style="display: none;">
                </div>
                <div id="resumeNameModal" style="margin-top: 8px; font-size: 13px; color: #16a34a; display: none;">
                    ✓ <span id="resumeFileNameModal"></span>
                </div>
            </div>

            <!-- Cover Letter -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #111827;">Cover Letter (Optional)</label>
                <textarea name="cover_letter" id="coverLetterModal" rows="3" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; font-family: inherit;" placeholder="Tell the employer why you're interested..."></textarea>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px;">
                <button type="submit" style="flex: 1; background-color: #f53a6b; color: white; padding: 12px 16px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">
                    Submit Application
                </button>
                <button type="button" onclick="closeApplyModal()" style="flex: 1; background-color: #f3f4f6; color: #111827; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 14px;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Store current job data
    let currentJob = {};

    // Open apply modal
    function openApplyModal(jobId, jobTitle, companyName, actionUrl) {
        // Check authentication
        const email = document.querySelector('[data-user-email]');
        if (!email) {
            alert('Please login to apply for this job');
            window.location.href = '/login';
            return;
        }

        currentJob = { jobId, jobTitle, companyName, actionUrl };

        // Update modal with job info
        document.getElementById('jobTitleModal').textContent = jobTitle + ' at ' + companyName;
        document.getElementById('applyFormModal').action = actionUrl;

        // Pre-fill form with user data
        const userData = {
            name: email.dataset.userName || '',
            email: email.dataset.userEmail || '',
            phone: email.dataset.userPhone || '',
            location: email.dataset.userLocation || '',
            skills: email.dataset.userSkills || '',
            bio: email.dataset.userBio || ''
        };

        document.getElementById('nameModal').value = userData.name;
        document.getElementById('emailModal').value = userData.email;
        document.getElementById('phoneModal').value = userData.phone;
        document.getElementById('locationModal').value = userData.location;
        document.getElementById('skillsModal').value = userData.skills;
        document.getElementById('bioModal').value = userData.bio;

        // Show modal
        document.getElementById('applyModal').style.display = 'block';
    }

    // Close apply modal
    function closeApplyModal() {
        document.getElementById('applyModal').style.display = 'none';
        document.getElementById('applyFormModal').reset();
        document.getElementById('resumeNameModal').style.display = 'none';
    }

    // Resume file handling
    document.getElementById('resumeModal').addEventListener('change', function(e) {
        if (this.files.length > 0) {
            document.getElementById('resumeFileNameModal').textContent = this.files[0].name;
            document.getElementById('resumeNameModal').style.display = 'block';
        }
    });

    // Drag and drop
    const dropzone = document.getElementById('dropzoneModal');
    if (dropzone) {
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.backgroundColor = '#f0f9ff';
            this.style.borderColor = '#3b82f6';
        });

        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.backgroundColor = '#f9fafb';
            this.style.borderColor = '#d1d5db';
        });

        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.backgroundColor = '#f9fafb';
            this.style.borderColor = '#d1d5db';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('resumeModal').files = files;
                document.getElementById('resumeFileNameModal').textContent = files[0].name;
                document.getElementById('resumeNameModal').style.display = 'block';
            }
        });
    }

    // Form submission
    document.getElementById('applyFormModal').addEventListener('submit', function(e) {
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
                closeApplyModal();
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to submit'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApplyModal();
        }
    });

    // Close on modal background click
    document.getElementById('applyModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeApplyModal();
        }
    });
</script>
