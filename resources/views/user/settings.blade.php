@extends('layouts.master')

@section('title', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Settings</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Settings Menu -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-20 overflow-hidden">
                <nav>
                    <a href="#account" class="flex items-center px-4 py-3 text-sm text-[#7b0f10] font-bold border-l-4 border-[#7b0f10] bg-[#7b0f10]/5 hover:bg-gray-50 transition">
                        <i class="fas fa-user w-4 mr-3 text-sm"></i>Account
                    </a>
                    <a href="#notifications" class="flex items-center px-4 py-3 text-sm text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:text-[#7b0f10] transition">
                        <i class="fas fa-bell w-4 mr-3 text-sm"></i>Notifications
                    </a>
                    <a href="#privacy" class="flex items-center px-4 py-3 text-sm text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:text-[#7b0f10] transition">
                        <i class="fas fa-lock w-4 mr-3 text-sm"></i>Privacy
                    </a>
                    <a href="#preferences" class="flex items-center px-4 py-3 text-sm text-gray-600 border-l-4 border-transparent hover:bg-gray-50 hover:text-[#7b0f10] transition">
                        <i class="fas fa-sliders-h w-4 mr-3 text-sm"></i>Preferences
                    </a>
                    <a href="#danger" class="flex items-center px-4 py-3 text-sm text-red-600 border-l-4 border-transparent hover:bg-red-50 transition">
                        <i class="fas fa-exclamation-triangle w-4 mr-3 text-sm"></i>Danger Zone
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="md:col-span-3 space-y-5">
            <!-- Account Settings -->
            <div id="account" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Account Settings</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] focus:outline-none text-sm bg-gray-50" readonly>
                        <p class="text-xs text-gray-400 mt-1">Email is managed through your UB account</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                        <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] focus:outline-none text-sm">
                            <option>Engineering</option>
                            <option>Business</option>
                            <option>Liberal Arts</option>
                            <option>Science</option>
                        </select>
                    </div>
                    <button class="bg-[#7b0f10] text-white font-bold px-5 py-2.5 rounded-lg hover:bg-[#5a0a0b] transition text-sm">
                        Save Changes
                    </button>
                </div>
            </div>

            <!-- Notification Settings -->
            <div id="notifications" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Notification Settings</h2>
                <div class="space-y-1 divide-y divide-gray-50">
                    <div class="flex justify-between items-center py-3">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Trade Notifications</p>
                            <p class="text-xs text-gray-500 mt-0.5">Get notified when someone sends you a trade proposal</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-[#7b0f10] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Message Notifications</p>
                            <p class="text-xs text-gray-500 mt-0.5">Get notified when you receive a new message</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-[#7b0f10] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Weekly Digest</p>
                            <p class="text-xs text-gray-500 mt-0.5">Receive a weekly summary of your trading activity</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-[#7b0f10] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div id="privacy" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Privacy & Security</h2>
                <div class="space-y-1 divide-y divide-gray-50">
                    <div class="flex justify-between items-center py-3">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">Profile Visibility</p>
                            <p class="text-xs text-gray-500 mt-0.5">Allow other users to see your profile</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-[#7b0f10] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="py-3">
                        <p class="font-medium text-gray-900 text-sm mb-2">Change Password</p>
                        <button class="bg-gray-100 text-gray-700 font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                            Update Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div id="danger" class="bg-red-50 border border-red-200 rounded-xl p-5">
                <h2 class="text-lg font-bold text-red-900 mb-4">Danger Zone</h2>
                <div class="space-y-1 divide-y divide-red-100">
                    <div class="py-3">
                        <p class="font-medium text-red-900 text-sm mb-1">Deactivate Account</p>
                        <p class="text-xs text-red-600 mb-3">Temporarily deactivate your account. You can reactivate anytime.</p>
                        <button style="background:#d97706;color:#fff;font-weight:700;padding:8px 16px;border-radius:8px;border:none;cursor:pointer;font-size:0.82rem;transition:background 0.15s;"
                                onmouseover="this.style.background='#b45309'" onmouseout="this.style.background='#d97706'">
                            Deactivate Account
                        </button>
                    </div>
                    <div class="py-3">
                        <p class="font-medium text-red-900 text-sm mb-1">Delete Account</p>
                        <p class="text-xs text-red-600 mb-3">Permanently delete your account and all associated data. This cannot be undone.</p>
                        <button class="bg-red-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
