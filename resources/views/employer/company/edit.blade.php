<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Company Profile - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Company Profile</h1>
            <p class="text-gray-600 mt-2">Update your company information</p>
        </div>

        <!-- MAIN FORM -->
        <form action="{{ route('employer.company.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8 space-y-6">
            @csrf
            @method('PATCH')

            <!-- Company Logo -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Company Logo</h2>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="flex-shrink-0">
                        @if($company->logo_path)
                            @php
                                if (filter_var($company->logo_path, FILTER_VALIDATE_URL)) {
                                    $companyLogoUrl = $company->logo_path;
                                } elseif (str_starts_with($company->logo_path, 'logos/') || file_exists(public_path($company->logo_path))) {
                                    $companyLogoUrl = asset($company->logo_path);
                                } else {
                                    $companyLogoUrl = asset('storage/' . $company->logo_path);
                                }
                            @endphp
                            <img id="logoPreview" src="{{ $companyLogoUrl }}" alt="Logo" class="h-32 w-32 object-contain bg-gray-100 rounded-lg" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22128%22 height=%22128%22 viewBox=%220 0 128 128%22%3E%3Crect width=%22128%22 height=%22128%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                        @else
                            <div id="logoPreview" class="h-32 w-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                No Logo
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">Upload Logo</label>
                        <input type="file" id="logo" name="logo" accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('logo') border-red-500 @enderror">
                        <p class="text-gray-600 text-sm mt-2">PNG, JPG up to 2MB recommended</p>
                        @error('logo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        @if($company->logo_path)
                            <button type="button" id="removeLogo" class="mt-3 text-red-600 hover:text-red-700 font-medium text-sm">Remove Current Logo</button>
                        @endif
                    </div>
                </div>
            </div>
                    <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="Your Company Name">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Company Description</label>
                    <textarea id="description" name="description" rows="5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                        placeholder="Tell job seekers about your company...">{{ old('description', $company->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contact Information -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $company->email) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="company@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $company->phone) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            placeholder="+63 XXX XXX XXXX">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="md:col-span-2">
                        <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('website') border-red-500 @enderror"
                            placeholder="https://www.example.com">
                        @error('website')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between pt-6">
                <a href="{{ route('employer.company.profile') }}" class="px-6 py-3 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Hidden form for logo deletion -->
        <form id="deleteLogoForm" action="{{ route('employer.company.logo.delete') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        document.getElementById('logo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logoPreview');
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Logo" class="h-32 w-32 object-contain rounded-lg">';
                };
                reader.readAsDataURL(file);
            }
        });

        const removeBtn = document.getElementById('removeLogo');
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to remove the current logo?')) {
                    document.getElementById('deleteLogoForm').submit();
                }
            });
        }
    </script>
</body>
</html>
