<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <x-navbar />

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <!-- Main Layout: Sidebar + Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-applicant-sidebar :user="$user" />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6">Settings</h1>

                        <!-- Tabs -->
                        <div class="flex gap-8 border-b border-gray-200">
                            <button onclick="switchTab('account')" 
                                    id="accountTab"
                                    class="px-4 py-3 font-medium border-b-2 border-blue-600 text-blue-600 transition">
                                👤 Account
                            </button>
                            <button onclick="switchTab('visibility')" 
                                    id="visibilityTab"
                                    class="px-4 py-3 font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 transition">
                                👁️ Visibility
                            </button>
                            <button onclick="switchTab('notifications')" 
                                    id="notificationsTab"
                                    class="px-4 py-3 font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 transition">
                                🔔 Notifications
                            </button>
                        </div>
                    </div>

                    <!-- Account Tab -->
                    <div id="accountContent" class="tab-content">
                        <div class="bg-white rounded-lg border border-gray-200 p-8">
                            <!-- Email Setting -->
                            <div class="mb-8 pb-8 border-b border-gray-200">
                                <label class="block text-sm font-bold text-gray-900 mb-3">Email</label>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                                    <button class="text-blue-600 hover:text-blue-700 font-medium">✏️ Edit</button>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-gray-900 mb-3">Password</label>
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                    <p class="text-gray-600 mb-4">Keep your account secure with a strong password.</p>
                                    <a href="#" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                        Change Password
                                    </a>
                                </div>
                            </div>

                            <!-- Delete Account -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Delete Account</label>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-red-800 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visibility Tab -->
                    <div id="visibilityContent" class="tab-content hidden">
                        <div class="bg-white rounded-lg border border-gray-200 p-8">
                            <!-- Profile Visibility -->
                            <div class="mb-8 pb-8 border-b border-gray-200">
                                <label class="block text-sm font-bold text-gray-900 mb-3">Profile Visibility</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                        <input type="radio" name="profile_visibility" value="standard" class="w-4 h-4" checked>
                                        <div class="ml-4">
                                            <p class="font-medium text-gray-900">Standard</p>
                                            <p class="text-sm text-gray-600">Your profile is visible to all employers</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                        <input type="radio" name="profile_visibility" value="private" class="w-4 h-4">
                                        <div class="ml-4">
                                            <p class="font-medium text-gray-900">Private</p>
                                            <p class="text-sm text-gray-600">Only employers you apply to will see your profile</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Visibility Info -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-blue-900 text-sm">Profiles with verifications are more likely to be selected. <a href="#" class="font-semibold hover:underline">Verify your identity</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div id="notificationsContent" class="tab-content hidden">
                        <div class="bg-white rounded-lg border border-gray-200 p-8">
                            <!-- Email Notifications -->
                            <div class="mb-8 pb-8 border-b border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Email Notifications</h3>
                                
                                <div class="space-y-4">
                                    <!-- Job Alerts -->
                                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <div>
                                            <p class="font-medium text-gray-900">Job Alerts</p>
                                            <p class="text-sm text-gray-600">Get notified about new jobs matching your searches</p>
                                        </div>
                                        <input type="checkbox" class="w-5 h-5 rounded" checked>
                                    </label>

                                    <!-- Application Updates -->
                                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <div>
                                            <p class="font-medium text-gray-900">Application Updates</p>
                                            <p class="text-sm text-gray-600">Get notified when your application status changes</p>
                                        </div>
                                        <input type="checkbox" class="w-5 h-5 rounded" checked>
                                    </label>

                                    <!-- Messages -->
                                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <div>
                                            <p class="font-medium text-gray-900">Messages</p>
                                            <p class="text-sm text-gray-600">Get notified when employers message you</p>
                                        </div>
                                        <input type="checkbox" class="w-5 h-5 rounded" checked>
                                    </label>

                                    <!-- Recommendations -->
                                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <div>
                                            <p class="font-medium text-gray-900">Recommendations</p>
                                            <p class="text-sm text-gray-600">Get personalized job recommendations</p>
                                        </div>
                                        <input type="checkbox" class="w-5 h-5 rounded">
                                    </label>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="flex gap-3">
                                <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                    Save Preferences
                                </button>
                                <button class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold rounded-lg transition">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all tab contents
            document.getElementById('accountContent').classList.add('hidden');
            document.getElementById('visibilityContent').classList.add('hidden');
            document.getElementById('notificationsContent').classList.add('hidden');

            // Remove active state from all tabs
            document.getElementById('accountTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('accountTab').classList.add('border-transparent', 'text-gray-600');
            document.getElementById('visibilityTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('visibilityTab').classList.add('border-transparent', 'text-gray-600');
            document.getElementById('notificationsTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('notificationsTab').classList.add('border-transparent', 'text-gray-600');

            // Show selected tab content
            if (tab === 'account') {
                document.getElementById('accountContent').classList.remove('hidden');
                document.getElementById('accountTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('accountTab').classList.add('border-blue-600', 'text-blue-600');
            } else if (tab === 'visibility') {
                document.getElementById('visibilityContent').classList.remove('hidden');
                document.getElementById('visibilityTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('visibilityTab').classList.add('border-blue-600', 'text-blue-600');
            } else if (tab === 'notifications') {
                document.getElementById('notificationsContent').classList.remove('hidden');
                document.getElementById('notificationsTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('notificationsTab').classList.add('border-blue-600', 'text-blue-600');
            }
        }
    </script>
</body>
</html>
