<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $thread->title }} - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <x-navbar />

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-24">
                    <!-- Company Info -->
                    <div class="text-center mb-6 pb-6 border-b border-gray-200">
                        @if($thread->company->logo_path)
                            @if(str_starts_with($thread->company->logo_path, 'http'))
                                <img src="{{ $thread->company->logo_path }}" 
                                     alt="{{ $thread->company->name }}"
                                     class="w-20 h-20 rounded-full mx-auto mb-3 object-cover bg-gray-100">
                            @elseif(str_starts_with($thread->company->logo_path, 'logos/'))
                                <img src="{{ asset($thread->company->logo_path) }}" 
                                     alt="{{ $thread->company->name }}"
                                     class="w-20 h-20 rounded-full mx-auto mb-3 object-cover bg-gray-100">
                            @else
                                <div class="w-20 h-20 rounded-full mx-auto mb-3 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-3xl">
                                    {{ substr($thread->company->name, 0, 1) }}
                                </div>
                            @endif
                        @else
                            <div class="w-20 h-20 rounded-full mx-auto mb-3 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-3xl">
                                {{ substr($thread->company->name, 0, 1) }}
                            </div>
                        @endif
                        <h3 class="font-bold text-gray-900 text-lg">{{ $thread->company->name }}</h3>
                    </div>

                    <!-- Thread Stats -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $thread->messages->count() }}</div>
                                <div class="text-xs text-gray-600 uppercase tracking-wide">Messages</div>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-blue-600 truncate">{{ $thread->user->name }}</div>
                                <div class="text-xs text-gray-600 uppercase tracking-wide">Started by</div>
                            </div>
                        </div>
                    </div>

                    <!-- Back to Threads -->
                    <a href="{{ route('community.index') }}" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Threads
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Thread Header -->
                <div class="bg-white rounded-lg border border-gray-200 p-8 mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $thread->title }}</h1>
                    <div class="flex items-center gap-4 text-gray-600 text-sm">
                        <span class="font-semibold">{{ $thread->company->name }}</span>
                        <span>•</span>
                        <span>Started {{ $thread->created_at->diffForHumans() }}</span>
                        <span>•</span>
                        <span>{{ $thread->messages->count() }} messages</span>
                    </div>
                </div>

            <!-- Messages -->
                <div class="space-y-4">
                    @if($thread->messages->count() > 0)
                        @foreach($thread->messages as $message)
                            <div class="bg-white rounded-lg border border-gray-200 p-6">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($message->is_from_company)
                                            @if($thread->company->logo_path)
                                                @if(str_starts_with($thread->company->logo_path, 'http'))
                                                    <img src="{{ $thread->company->logo_path }}" 
                                                         alt="{{ $thread->company->name }}"
                                                         class="w-10 h-10 rounded-full object-cover bg-gray-100">
                                                @elseif(str_starts_with($thread->company->logo_path, 'logos/'))
                                                    <img src="{{ asset($thread->company->logo_path) }}" 
                                                         alt="{{ $thread->company->name }}"
                                                         class="w-10 h-10 rounded-full object-cover bg-gray-100">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white font-bold text-sm">
                                                        {{ substr($thread->company->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white font-bold text-sm">
                                                    {{ substr($thread->company->name, 0, 1) }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($message->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Message Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="font-bold text-gray-900">
                                                @if($message->is_from_company)
                                                    {{ $thread->company->name }}
                                                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">Official</span>
                                                @else
                                                    {{ $message->user->name ?? 'User' }}
                                                @endif
                                            </span>
                                        </div>
                                        <p class="text-gray-700 mb-2">{{ $message->message }}</p>
                                        <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                            <p class="text-gray-600">No messages yet. Be the first to reply!</p>
                        </div>
                    @endif
                </div>

            <!-- Reply Form -->
            @auth
                <div class="bg-white rounded-lg border border-gray-200 p-8 mt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Reply to this thread</h3>
                    <form id="messageForm" class="space-y-4">
                        @csrf
                        <textarea 
                            id="messageText"
                            name="message" 
                            placeholder="Share your thoughts..."
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            required></textarea>
                        
                        <div class="flex gap-3">
                            <button 
                                type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                                Post Reply
                            </button>
                            <button 
                                type="reset"
                                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold rounded-lg transition duration-200">
                                Clear
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 mt-8 text-center">
                    <p class="text-gray-700 mb-4">Sign in to reply to this thread</p>
                    <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                        Sign In
                    </a>
                </div>
            @endauth
            </div>
        </div>
    </div>
</div>

<script>
    @auth
    document.getElementById('messageForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = document.getElementById('messageText').value.trim();
        if (!message) return;

        try {
            const response = await fetch('{{ route("community.store-message", $thread) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                },
                body: JSON.stringify({ message })
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to post message');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error posting message');
        }
    });
    @endauth
</script>
</body>
</html>
