<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for {{ $job->title }} - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Job Header Card -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-start gap-6">
                    <!-- Company Logo -->
                    <div>
                        @if($job->company->logo_path)
                            @if(filter_var($job->company->logo_path, FILTER_VALIDATE_URL))
                                <img src="{{ $job->company->logo_path }}" alt="{{ $job->company->name }}" class="w-24 h-24 rounded-lg object-cover">
                            @else
                                <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" class="w-24 h-24 rounded-lg object-cover">
                            @endif
                        @else
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-3xl">{{ substr($job->company->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Job Info -->
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 font-semibold mb-2">APPLYING FOR</p>
                        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $job->title }}</h1>
                        <p class="text-lg text-gray-700 mb-4">{{ $job->company->name }}</p>
                        <a href="{{ route('jobs.show', $job) }}" class="inline-block text-blue-600 hover:text-blue-800 font-medium underline">View job description →</a>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Submit Your Application</h2>
                
                <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Your Information Section -->
                    <div class="mb-12">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-gray-200">Your Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="applicant_name" class="block text-sm font-semibold text-gray-900 mb-2">Full Name *</label>
                                <input type="text" id="applicant_name" name="applicant_name" value="{{ auth()->user()->name }}" required
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition {{ $errors->has('applicant_name') ? 'border-red-500' : '' }}"
                                    placeholder="Your full name">
                                @error('applicant_name')
                                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="applicant_email" class="block text-sm font-semibold text-gray-900 mb-2">Email *</label>
                                <input type="email" id="applicant_email" name="applicant_email" value="{{ auth()->user()->email }}" readonly
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="applicant_phone" class="block text-sm font-semibold text-gray-900 mb-2">Phone Number</label>
                                <input type="tel" id="applicant_phone" name="applicant_phone" value="{{ auth()->user()->contact_number ?? '' }}"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition {{ $errors->has('applicant_phone') ? 'border-red-500' : '' }}"
                                    placeholder="+63 9XX XXX XXXX">
                                @error('applicant_phone')
                                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="applicant_location" class="block text-sm font-semibold text-gray-900 mb-2">Location</label>
                                <input type="text" id="applicant_location" name="applicant_location" value="{{ auth()->user()->location ?? '' }}"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition {{ $errors->has('applicant_location') ? 'border-red-500' : '' }}"
                                    placeholder="City, Country">
                                @error('applicant_location')
                                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mt-6">
                            <label for="applicant_skills" class="block text-sm font-semibold text-gray-900 mb-2">Key Skills</label>
                            <textarea id="applicant_skills" name="applicant_skills" rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition {{ $errors->has('applicant_skills') ? 'border-red-500' : '' }}"
                                placeholder="e.g., Laravel, JavaScript, MySQL (comma-separated)">{{ auth()->user()->skills ?? '' }}</textarea>
                            @error('applicant_skills')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Professional Summary -->
                        <div class="mt-6">
                            <label for="applicant_bio" class="block text-sm font-semibold text-gray-900 mb-2">Professional Summary</label>
                            <textarea id="applicant_bio" name="applicant_bio" rows="4"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition {{ $errors->has('applicant_bio') ? 'border-red-500' : '' }}"
                                placeholder="Tell us about your professional background, experience, and achievements...">{{ auth()->user()->bio ?? '' }}</textarea>
                            @error('applicant_bio')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Application Documents Section -->
                    <div class="mb-12">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-gray-200">Application Documents</h3>

                        <!-- Resume Upload -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-900 mb-3">Resume * (PDF, DOC, DOCX - Max 5MB)</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer" id="resumeDropzone">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-3-3m3 3l3-3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="text-gray-700 font-medium mb-2">
                                    <label for="resume" class="text-blue-600 hover:text-blue-700 cursor-pointer">Upload a file</label>
                                    <span class="text-gray-600"> or drag and drop</span>
                                </div>
                                <input type="file" id="resume" name="resume" required accept=".pdf,.doc,.docx" class="hidden">
                            </div>
                            <div id="resumeFileName" class="mt-2 text-sm text-green-600 font-semibold hidden">
                                ✓ <span id="fileName"></span>
                            </div>
                            @error('resume')
                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Letter -->
                        <div>
                            <label for="cover_letter" class="block text-sm font-semibold text-gray-900 mb-3">Cover Letter (Optional)</label>
                            <textarea id="cover_letter" name="cover_letter" rows="6"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition {{ $errors->has('cover_letter') ? 'border-red-500' : '' }}"
                                placeholder="Tell the employer why you're a great fit for this position..."></textarea>
                            @error('cover_letter')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-8 border-t-2 border-gray-200">
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition shadow-md">
                            Submit Application
                        </button>
                        <a href="{{ route('jobs.show', $job) }}" class="px-8 py-3 border-2 border-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        const resumeDropzone = document.getElementById('resumeDropzone');
        const resumeInput = document.getElementById('resume');
        const resumeFileName = document.getElementById('resumeFileName');
        const fileName = document.getElementById('fileName');

        if (resumeInput) {
            resumeInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    resumeFileName.classList.remove('hidden');
                }
            });
        }

        if (resumeDropzone) {
            resumeDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-blue-500', 'bg-blue-50');
            });

            resumeDropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500', 'bg-blue-50');
            });

            resumeDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500', 'bg-blue-50');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    resumeInput.files = files;
                    fileName.textContent = files[0].name;
                    resumeFileName.classList.remove('hidden');
                }
            });

            resumeDropzone.addEventListener('click', function() {
                resumeInput.click();
            });
        }
    </script>
</body>
</html>
