@extends('layouts.master')

@section('title', 'My Profile')

@section('content')
<div class="px-4 md:px-6 py-6 max-w-6xl mx-auto">
    <!-- Profile Header -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
        <!-- Profile Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-5 mb-5 pb-5 border-b border-gray-100">
                    <!-- Avatar -->
                    <img src="https://ui-avatars.com/api/?name=John+Doe&size=120&background=7b0f10&color=fff"
                         alt="John Doe" class="w-24 h-24 rounded-full border-4 border-[#f5c518] mb-4 sm:mb-0 flex-shrink-0">

                    <!-- Profile Info -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">John Doe</h1>
                                <p class="text-gray-500 text-sm">Engineering Student · University of Batangas</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex-shrink-0 px-4 py-2 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition font-semibold text-sm">
                                Edit Profile
                            </a>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mt-3 mb-3">
                            <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold flex items-center gap-1">
                                <i class="fas fa-check-circle text-xs"></i> Trusted Trader
                            </span>
                            <span class="px-2.5 py-1 bg-[#f5c518]/20 text-[#7b0f10] rounded-full text-xs font-semibold flex items-center gap-1">
                                <i class="fas fa-bolt text-xs"></i> Quick Responder
                            </span>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center gap-4">
                            <div>
                                <div class="flex items-center gap-1 text-[#f5c518] text-sm">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-0.5">4.8 rating (156 reviews)</p>
                            </div>
                            <div class="border-l border-gray-200 pl-4">
                                <p class="text-xl font-bold text-gray-900">23</p>
                                <p class="text-xs text-gray-500">Successful Trades</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <div class="mb-5">
                    <h2 class="text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">About</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Third-year engineering student with a passion for sustainability and helping classmates. I love bartering for resources and helping the community through donations.
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Email</p>
                        <p class="font-semibold text-gray-900 text-sm">john.doe@ub.edu.ph</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Member Since</p>
                        <p class="font-semibold text-gray-900 text-sm">January 15, 2024</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Location</p>
                        <p class="font-semibold text-gray-900 text-sm">University of Batangas, Batangas City</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Response Rate</p>
                        <p class="font-semibold text-gray-900 text-sm">99% · replies in ~2 hours</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-[#7b0f10]/5 rounded-lg p-3 text-center border border-[#7b0f10]/10">
                        <p class="text-xl font-bold text-[#7b0f10]">12</p>
                        <p class="text-xs text-gray-500 mt-0.5">Items Posted</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center border border-green-100">
                        <p class="text-xl font-bold text-green-600">8</p>
                        <p class="text-xs text-gray-500 mt-0.5">Donations Made</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-3 text-center border border-purple-100">
                        <p class="text-xl font-bold text-purple-600">15</p>
                        <p class="text-xs text-gray-500 mt-0.5">Items Received</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('items.create') }}" class="flex items-center w-full px-4 py-2.5 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition font-semibold text-sm">
                        <i class="fas fa-plus mr-2 text-xs"></i>Post New Item
                    </a>
                    <a href="{{ route('items.browse') }}" class="flex items-center w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold text-sm">
                        <i class="fas fa-box mr-2 text-xs"></i>My Listings
                    </a>
                    <a href="{{ route('wishlist') }}" class="flex items-center w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold text-sm">
                        <i class="fas fa-heart mr-2 text-xs"></i>Wishlist
                    </a>
                </div>
            </div>

            <!-- Verification Status -->
            <div class="bg-green-50 rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-green-600"></i> Verification Status
                </h3>
                <div class="space-y-2 text-xs">
                    <div class="flex items-center gap-2 text-green-700">
                        <i class="fas fa-check-circle"></i><span>Email Verified</span>
                    </div>
                    <div class="flex items-center gap-2 text-green-700">
                        <i class="fas fa-check-circle"></i><span>University ID Verified</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <i class="far fa-circle"></i><span>Phone Not Verified</span>
                    </div>
                </div>
                <button class="mt-3 text-xs text-green-700 hover:text-green-800 font-semibold">Verify Phone →</button>
            </div>

            <!-- Reputation -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3">Reputation Score</h3>
                <div class="text-center mb-3">
                    <p class="text-4xl font-bold text-[#7b0f10]">94</p>
                    <p class="text-xs text-gray-500">Excellent</p>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Positive ratings</span>
                        <span class="font-semibold text-gray-900">156</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Neutral ratings</span>
                        <span class="font-semibold text-gray-900">2</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Negative ratings</span>
                        <span class="font-semibold text-gray-900">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-5">Reviews from Other Users</h2>

                <div class="space-y-5">
                    <!-- Review 1 -->
                    <div class="border-b border-gray-100 pb-5 last:border-b-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Lee&background=7b0f10&color=fff" alt="Sarah Lee" class="w-9 h-9 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Sarah Lee</p>
                                    <p class="text-xs text-gray-400">2 weeks ago</p>
                                </div>
                            </div>
                            <div class="flex text-[#f5c518] text-xs">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">Excellent trade! The calculus book was in perfect condition. John was very professional and responsive. Would definitely trade with again!</p>
                    </div>

                    <!-- Review 2 -->
                    <div class="border-b border-gray-100 pb-5 last:border-b-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=7b0f10&color=fff" alt="Michael Brown" class="w-9 h-9 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Michael Brown</p>
                                    <p class="text-xs text-gray-400">1 month ago</p>
                                </div>
                            </div>
                            <div class="flex text-[#f5c518] text-xs">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">Good condition uniform set. Pickup was easy. Wish communication could have been faster, but overall a smooth transaction.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="text-base font-bold text-gray-900 mb-4">Recent Activity</h2>
            <div class="space-y-4">
                @foreach([
                    ['bg-[#7b0f10]', 'Posted new item', 'Programming Book Set', 'Today, 10:30 AM'],
                    ['bg-green-500', 'Trade completed', 'with Sarah Lee', '2 days ago'],
                    ['bg-[#f5c518]', 'Received donation', 'University Uniform', '5 days ago'],
                    ['bg-purple-500', 'Reached 20 trades', 'Achievement unlocked!', '1 week ago'],
                ] as $activity)
                <div class="flex gap-3">
                    <div class="w-2 h-2 {{ $activity[0] }} rounded-full mt-1.5 flex-shrink-0"></div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $activity[1] }}</p>
                        <p class="text-xs text-gray-500">{{ $activity[2] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity[3] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
