@extends('layouts.master')

@section('title', 'Messages')

@section('content')
<div class="flex h-screen bg-gray-50 pt-16">
    <!-- Chat Sidebar -->
    <div class="w-80 bg-white border-r border-gray-200 flex flex-col">
        <!-- Search -->
        <div class="p-4 border-b border-gray-200">
            <input type="text" placeholder="Search conversations..."
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <!-- Conversations List -->
        <div class="flex-1 overflow-y-auto">
            <!-- Mark all as read -->
            <div class="px-4 py-2 flex justify-between items-center border-b border-gray-100">
                <p class="text-xs font-semibold text-gray-600">CONVERSATIONS</p>
                <button class="text-xs text-blue-600 hover:text-blue-700 font-medium">Mark all read</button>
            </div>

            <!-- Conversation Item 1 -->
            <div class="px-4 py-3 border-b border-gray-100 cursor-pointer bg-blue-50 hover:bg-blue-100 transition">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Sarah+Lee&background=0066cc&color=fff" alt="User" class="w-12 h-12 rounded-full">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-gray-900 text-sm">Sarah Lee</p>
                            <span class="text-xs text-gray-600">2m</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">Sounds good! When can we meet?</p>
                    </div>
                    <div class="w-2.5 h-2.5 bg-blue-600 rounded-full flex-shrink-0"></div>
                </div>
            </div>

            <!-- Conversation Item 2 -->
            <div class="px-4 py-3 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=0066cc&color=fff" alt="User" class="w-12 h-12 rounded-full">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-gray-900 text-sm">Michael Brown</p>
                            <span class="text-xs text-gray-600">1h</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">Is this book still available?</p>
                    </div>
                </div>
            </div>

            <!-- Conversation Item 3 -->
            <div class="px-4 py-3 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Emily+Johnson&background=0066cc&color=fff" alt="User" class="w-12 h-12 rounded-full">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-gray-900 text-sm">Emily Johnson</p>
                            <span class="text-xs text-gray-600">Yesterday</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">Thanks for the uniform set!</p>
                    </div>
                </div>
            </div>

            <!-- Conversation Item 4 -->
            <div class="px-4 py-3 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=David+Park&background=0066cc&color=fff" alt="User" class="w-12 h-12 rounded-full">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-gray-900 text-sm">David Park</p>
                            <span class="text-xs text-gray-600">2 days ago</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">What's the lowest price you'd accept?</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col">
        <!-- Chat Header -->
        <div class="bg-white border-b border-gray-200 p-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="https://ui-avatars.com/api/?name=Sarah+Lee&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full">
                <div>
                    <p class="font-semibold text-gray-900">Sarah Lee</p>
                    <p class="text-xs text-gray-600">Active now</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-gray-600 hover:text-blue-600 text-lg">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-600 text-lg">
                    <i class="fas fa-video"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-600 text-lg">
                    <i class="fas fa-info-circle"></i>
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
            <!-- Sender Message -->
            <div class="flex justify-end">
                <div class="max-w-xs">
                    <div class="bg-blue-600 text-white rounded-3xl rounded-tr-none px-4 py-3">
                        <p class="text-sm">Hi Sarah! Is the calculus book still available?</p>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 text-right">10:30 AM</p>
                </div>
            </div>

            <!-- Receiver Message -->
            <div class="flex justify-start">
                <div class="max-w-xs">
                    <div class="bg-white border border-gray-300 rounded-3xl rounded-tl-none px-4 py-3">
                        <p class="text-sm text-gray-900">Yes, it's still available! Great condition, never used.</p>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">10:32 AM</p>
                </div>
            </div>

            <!-- Receiver Multiple Messages -->
            <div class="flex justify-start space-y-2">
                <div class="max-w-xs">
                    <div class="bg-white border border-gray-300 rounded-3xl rounded-tl-none px-4 py-3">
                        <p class="text-sm text-gray-900">Would you be open to trading?</p>
                    </div>
                </div>
            </div>

            <!-- Sender Message -->
            <div class="flex justify-end">
                <div class="max-w-xs">
                    <div class="bg-blue-600 text-white rounded-3xl rounded-tr-none px-4 py-3">
                        <p class="text-sm">Yes! I'm looking for programming books and lab equipment</p>
                    </div>
                    <p class="text-xs text-gray-600 mt-1 text-right">10:35 AM</p>
                </div>
            </div>

            <!-- Receiver Message -->
            <div class="flex justify-start">
                <div class="max-w-xs">
                    <div class="bg-white border border-gray-300 rounded-3xl rounded-tl-none px-4 py-3">
                        <p class="text-sm text-gray-900">Sounds good! When can we meet?</p>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">10:37 AM</p>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="bg-white border-t border-gray-200 p-4">
            <div class="flex items-center space-x-4">
                <button class="text-gray-600 hover:text-blue-600 text-lg">
                    <i class="fas fa-paperclip"></i>
                </button>
                <input type="text" placeholder="Type your message..."
                       class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <p class="text-xs text-gray-600 mt-2">
                💡 Tip: Agree on terms before meeting. Always be respectful and honest about item condition.
            </p>
        </div>
    </div>
</div>
@endsection
