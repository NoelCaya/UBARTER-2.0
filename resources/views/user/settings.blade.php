@extends('layouts.master')

@section('title', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Settings</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Settings Menu -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow border border-gray-200 sticky top-20">
                <nav class="space-y-0">
                    <a href="#account" class="block px-6 py-4 text-[#7b0f10] font-bold border-l-4 border-[#7b0f10] bg-blue-50 hover:bg-gray-50">
                        <i class="fas fa-user mr-3"></i>Account
                    </a>
                    <a href="#notifications" class="block px-6 py-4 text-gray-700 border-l-4 border-transparent hover:bg-gray-50">
                        <i class="fas fa-bell mr-3"></i>Notifications
                    </a>
                    <a href="#privacy" class="block px-6 py-4 text-gray-700 border-l-4 border-transparent hover:bg-gray-50">
                        <i class="fas fa-lock mr-3"></i>Privacy
                    </a>
                    <a href="#preferences" class="block px-6 py-4 text-gray-700 border-l-4 border-transparent hover:bg-gray-50">
                        <i class="fas fa-sliders-h mr-3"></i>Preferences
                    </a>
                    <a href="#danger" class="block px-6 py-4 text-red-600 border-l-4 border-transparent hover:bg-red-50">
                        <i class="fas fa-exclamation-triangle mr-3"></i>Danger Zone
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="md:col-span-3 space-y-6">
            <!-- Account Settings -->
            <div id="account" class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Account Settings</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518] focus:border-transparent">
                            <option>Engineering</option>
                            <option>Business</option>
                            <option>Liberal Arts</option>
                            <option>Science</option>
                        </select>
                    </div>
                    <button class="bg-[#7b0f10] text-white font-bold px-6 py-2 rounded-lg hover:bg-[#5a0a0b] transition">
                        Save Changes
                    </button>
                </div>
            </div>

            <!-- Notification Settings -->
            <div id="notifications" class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Notification Settings</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <div>
                            <p class="font-medium text-gray-900">Trade Notifications</p>
                            <p class="text-sm text-gray-600">Get notified when someone sends you a trade proposal</p>
                        </div>
                        <input type="checkbox" checked class="w-5 h-5 text-[#7b0f10]">
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <div>
                            <p class="font-medium text-gray-900">Message Notifications</p>
                            <p class="text-sm text-gray-600">Get notified when you receive a new message</p>
                        </div>
                        <input type="checkbox" checked class="w-5 h-5 text-[#7b0f10]">
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <div>
                            <p class="font-medium text-gray-900">Weekly Digest</p>
                            <p class="text-sm text-gray-600">Receive a weekly summary of your trading activity</p>
                        </div>
                        <input type="checkbox" class="w-5 h-5 text-[#7b0f10]">
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div id="privacy" class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Privacy & Security</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <div>
                            <p class="font-medium text-gray-900">Profile Visibility</p>
                            <p class="text-sm text-gray-600">Allow other users to see your profile</p>
                        </div>
                        <input type="checkbox" checked class="w-5 h-5 text-[#7b0f10]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Change Password</label>
                        <button class="bg-gray-200 text-gray-900 font-bold px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                            Update Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div id="danger" class="bg-red-50 border-2 border-red-200 rounded-lg p-6">
                <h2 class="text-2xl font-bold text-red-900 mb-6">Danger Zone</h2>
                <div class="space-y-4">
                    <div class="py-3 border-b border-red-200">
                        <p class="font-medium text-red-900 mb-2">Deactivate Account</p>
                        <p class="text-sm text-red-700 mb-3">Temporarily deactivate your account. You can reactivate anytime.</p>
                        <button class="bg-yellow-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-yellow-700 transition">
                            Deactivate Account
                        </button>
                    </div>
                    <div class="py-3">
                        <p class="font-medium text-red-900 mb-2">Delete Account</p>
                        <p class="text-sm text-red-700 mb-3">Permanently delete your account and all associated data. This action cannot be undone.</p>
                        <button class="bg-red-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-red-700 transition">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
