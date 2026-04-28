@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 md:p-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-gray-600 mt-2">Here's what's happening in the UBarter community today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Items Posted -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Items Posted</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">12</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-600 text-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">
                <span class="text-green-600 font-medium">+2</span> this month
            </p>
        </div>

        <!-- Successful Trades -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Successful Trades</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">8</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">
                <span class="text-green-600 font-medium">100%</span> positive feedback
            </p>
        </div>

        <!-- Current Rating -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Your Rating</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">4.8</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-lg"></i>
                </div>
            </div>
            <div class="flex items-center mt-4 space-x-1">
                <span class="text-yellow-400">★★★★★</span>
                <span class="text-xs text-gray-500">(156 reviews)</span>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending Requests</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">3</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-inbox text-purple-600 text-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">
                <span class="text-orange-600 font-medium">2 urgent</span>
            </p>
        </div>
    </div>

    <!-- Search Bar (Mobile) -->
    <div class="mb-8 md:hidden">
        <div class="relative">
            <input type="text" placeholder="Search items..." 
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="absolute right-3 top-3 text-gray-400">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Featured Items -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Featured Available Items</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Item Card 1 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition group cursor-pointer">
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            <img src="https://via.placeholder.com/300x200?text=Calculus+Textbook" alt="Item" class="w-full h-full object-cover group-hover:scale-105 transition">
                            <div class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">Barter</div>
                            <button class="absolute top-3 left-3 w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-red-50">
                                <i class="far fa-heart text-red-500"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 text-sm line-clamp-2">Advanced Calculus Textbook - Brand New</h3>
                            <p class="text-xs text-gray-600 mt-1">Engineering Department</p>
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex items-center space-x-1">
                                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=0066cc&color=fff" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-600">John Doe</span>
                                </div>
                                <button class="text-blue-600 hover:text-blue-700 text-xs font-medium">View →</button>
                            </div>
                        </div>
                    </div>

                    <!-- Item Card 2 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition group cursor-pointer">
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            <img src="https://via.placeholder.com/300x200?text=Laptop+Stand" alt="Item" class="w-full h-full object-cover group-hover:scale-105 transition">
                            <div class="absolute top-3 right-3 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">Donation</div>
                            <button class="absolute top-3 left-3 w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-red-50">
                                <i class="far fa-heart text-gray-400"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 text-sm line-clamp-2">Aluminum Laptop Stand - Slightly Used</h3>
                            <p class="text-xs text-gray-600 mt-1">Computer Science</p>
                            <div class="flex justify-between items-center mt-3">
                                <div class="flex items-center space-x-1">
                                    <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=0066cc&color=fff" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-600">Jane Smith</span>
                                </div>
                                <button class="text-blue-600 hover:text-blue-700 text-xs font-medium">View →</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently Posted Items -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Recently Posted</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All →</a>
                </div>

                <div class="space-y-3">
                    <!-- List Item 1 -->
                    <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
                        <img src="https://via.placeholder.com/80x80?text=Book" alt="Item" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-900">Programming in Python (3rd Edition)</h3>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded font-medium ml-2 flex-shrink-0">Barter</span>
                            </div>
                            <div class="flex items-center space-x-3 text-xs text-gray-600 mb-2">
                                <span class="flex items-center"><i class="fas fa-user-circle mr-1"></i> Maria Santos</span>
                                <span class="flex items-center"><i class="fas fa-clock mr-1"></i> 2 hours ago</span>
                                <span class="flex items-center"><i class="fas fa-tag mr-1"></i> Books, Textbooks</span>
                            </div>
                            <p class="text-sm text-gray-600 truncate">Great condition, perfect for CS majors and programming enthusiasts...</p>
                        </div>
                        <button class="text-gray-400 hover:text-red-500 text-lg flex-shrink-0">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <!-- List Item 2 -->
                    <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-blue-50 transition">
                        <img src="https://via.placeholder.com/80x80?text=Uniform" alt="Item" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-900">UB Engineering Uniform - Size M</h3>
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded font-medium ml-2 flex-shrink-0">Donation</span>
                            </div>
                            <div class="flex items-center space-x-3 text-xs text-gray-600 mb-2">
                                <span class="flex items-center"><i class="fas fa-user-circle mr-1"></i> Raymond Cruz</span>
                                <span class="flex items-center"><i class="fas fa-clock mr-1"></i> 5 hours ago</span>
                                <span class="flex items-center"><i class="fas fa-tag mr-1"></i> Uniforms, Apparel</span>
                            </div>
                            <p class="text-sm text-gray-600 truncate">Complete set, worn for 1 semester, perfect condition. Donating to help students...</p>
                        </div>
                        <button class="text-red-500 text-lg flex-shrink-0">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Post New Item</span>
                    </button>
                    <button class="w-full bg-gray-100 text-gray-900 py-3 rounded-lg font-medium hover:bg-gray-200 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Browse All Items</span>
                    </button>
                    <button class="w-full bg-gray-100 text-gray-900 py-3 rounded-lg font-medium hover:bg-gray-200 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-heart"></i>
                        <span>View Wishlist</span>
                    </button>
                </div>
            </div>

            <!-- Mostly Needed Items -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Mostly Needed Items</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border border-orange-200">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Calculus Books</p>
                            <p class="text-xs text-gray-600">25 requests</p>
                        </div>
                        <span class="text-orange-600 font-bold">25</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg border border-blue-200">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Lab Coats</p>
                            <p class="text-xs text-gray-600">18 requests</p>
                        </div>
                        <span class="text-blue-600 font-bold">18</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Programming Guides</p>
                            <p class="text-xs text-gray-600">14 requests</p>
                        </div>
                        <span class="text-purple-600 font-bold">14</span>
                    </div>
                </div>
            </div>

            <!-- Top Donors This Month -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Top Donors This Month</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Alex+Johnson&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm">Alex Johnson</p>
                            <p class="text-xs text-gray-600">9 items donated</p>
                        </div>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Williams&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm">Sarah Williams</p>
                            <p class="text-xs text-gray-600">7 items donated</p>
                        </div>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm">Michael Brown</p>
                            <p class="text-xs text-gray-600">6 items donated</p>
                        </div>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
