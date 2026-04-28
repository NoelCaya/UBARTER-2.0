@extends('layouts.master')

@section('title', 'My Profile')

@section('content')
<div class="p-6 md:p-8">
    <!-- Profile Header -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Profile Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-8">
                <div class="flex flex-col md:flex-row md:items-end md:space-x-6 mb-8 pb-8 border-b border-gray-200">
                    <!-- Avatar -->
                    <img src="https://ui-avatars.com/api/?name=John+Doe&size=120&background=0066cc&color=fff" alt="John Doe" class="w-32 h-32 rounded-full border-4 border-blue-600 mb-6 md:mb-0">
                    
                    <!-- Profile Info -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900">John Doe</h1>
                        <p class="text-gray-600 mb-3">Engineering Student • University of Batangas</p>
                        
                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold flex items-center space-x-1">
                                <i class="fas fa-check-circle"></i>
                                <span>Trusted Trader</span>
                            </span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold flex items-center space-x-1">
                                <i class="fas fa-lightning"></i>
                                <span>Quick Responder</span>
                            </span>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center space-x-4">
                            <div>
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <span>★★★★★</span>
                                </div>
                                <p class="text-sm text-gray-600">4.8 rating (156 reviews)</p>
                            </div>
                            <div class="border-l border-gray-300 pl-4">
                                <p class="text-2xl font-bold text-gray-900">23</p>
                                <p class="text-sm text-gray-600">Successful Trades</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Edit Profile
                    </button>
                </div>

                <!-- Bio -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">About</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Third-year engineering student with a passion for sustainability and helping classmates. I love bartering for resources and helping the community through donations. Always available to assist fellow UB students.
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-8 border-b border-gray-200 mb-8">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">john.doe@ub.edu.ph</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Member Since</p>
                        <p class="font-semibold text-gray-900">January 15, 2024</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Location</p>
                        <p class="font-semibold text-gray-900">University of Batangas, Batangas City</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Response Rate</p>
                        <p class="font-semibold text-gray-900">99% (typically replies in 2 hours)</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
                        <p class="text-2xl font-bold text-blue-600">12</p>
                        <p class="text-sm text-gray-600">Items Posted</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
                        <p class="text-2xl font-bold text-green-600">8</p>
                        <p class="text-sm text-gray-600">Donations Made</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center border border-purple-200">
                        <p class="text-2xl font-bold text-purple-600">15</p>
                        <p class="text-sm text-gray-600">Items Received</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                        <i class="fas fa-plus mr-2"></i>Post New Item
                    </button>
                    <button class="w-full px-4 py-3 bg-gray-100 text-gray-900 rounded-lg hover:bg-gray-200 transition font-medium text-sm">
                        <i class="fas fa-box mr-2"></i>My Listings
                    </button>
                    <button class="w-full px-4 py-3 bg-gray-100 text-gray-900 rounded-lg hover:bg-gray-200 transition font-medium text-sm">
                        <i class="fas fa-heart mr-2"></i>Wishlist
                    </button>
                </div>
            </div>

            <!-- Verification Status -->
            <div class="bg-green-50 rounded-xl shadow-sm p-6 border-l-4 border-green-600">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center space-x-2">
                    <i class="fas fa-shield-alt text-green-600"></i>
                    <span>Verification Status</span>
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center space-x-2 text-green-700">
                        <i class="fas fa-check-circle"></i>
                        <span>Email Verified</span>
                    </div>
                    <div class="flex items-center space-x-2 text-green-700">
                        <i class="fas fa-check-circle"></i>
                        <span>University ID Verified</span>
                    </div>
                    <div class="flex items-center space-x-2 text-gray-600">
                        <i class="fas fa-circle"></i>
                        <span>Phone Verified</span>
                    </div>
                </div>
                <button class="mt-4 text-sm text-green-700 hover:text-green-800 font-medium">
                    Verify Phone →
                </button>
            </div>

            <!-- Reputation -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Reputation Score</h3>
                <div class="text-center mb-4">
                    <p class="text-4xl font-bold text-blue-600">94</p>
                    <p class="text-sm text-gray-600">Excellent</p>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Positive ratings</span>
                        <span class="font-semibold">156</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Neutral ratings</span>
                        <span class="font-semibold">2</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Negative ratings</span>
                        <span class="font-semibold">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Reviews from Other Users</h2>
                
                <div class="space-y-6">
                    <!-- Review 1 -->
                    <div class="border-b border-gray-200 pb-6 last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-4">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Lee&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900">Sarah Lee</p>
                                    <p class="text-xs text-gray-600">2 weeks ago</p>
                                </div>
                            </div>
                            <div class="text-yellow-400">★★★★★</div>
                        </div>
                        <p class="text-gray-700">Excellent trade! The calculus book was in perfect condition. John was very professional and responsive. Would definitely trade with again!</p>
                        <div class="mt-3 flex items-center space-x-4 text-xs text-gray-600">
                            <button class="hover:text-blue-600">👍 Helpful</button>
                            <button class="hover:text-blue-600">💬 Reply</button>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="border-b border-gray-200 pb-6 last:border-b-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-4">
                                <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900">Michael Brown</p>
                                    <p class="text-xs text-gray-600">1 month ago</p>
                                </div>
                            </div>
                            <div class="text-yellow-400">★★★★☆</div>
                        </div>
                        <p class="text-gray-700">Good condition uniform set. Pickup was easy. Wish communication could have been faster, but overall a smooth transaction.</p>
                        <div class="mt-3 flex items-center space-x-4 text-xs text-gray-600">
                            <button class="hover:text-blue-600">👍 Helpful</button>
                            <button class="hover:text-blue-600">💬 Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Activity</h2>
            
            <div class="space-y-4">
                <div class="flex space-x-4">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm">Posted new item</p>
                        <p class="text-xs text-gray-600">Programming Book Set</p>
                        <p class="text-xs text-gray-500">Today, 10:30 AM</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm">Trade completed</p>
                        <p class="text-xs text-gray-600">with Sarah Lee</p>
                        <p class="text-xs text-gray-500">2 days ago</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="w-2 h-2 bg-yellow-600 rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm">Received donation</p>
                        <p class="text-xs text-gray-600">University Uniform</p>
                        <p class="text-xs text-gray-500">5 days ago</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="w-2 h-2 bg-purple-600 rounded-full mt-2 flex-shrink-0"></div>
                    <div>
                        <p class="font-medium text-gray-900 text-sm">Reached 20 trades</p>
                        <p class="text-xs text-gray-600">Achievement unlocked!</p>
                        <p class="text-xs text-gray-500">1 week ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
