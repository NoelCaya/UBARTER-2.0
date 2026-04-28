@extends('layouts.master')

@section('title', 'Browse Items')

@section('content')
<div class="p-6 md:p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Browse Items</h1>
        <p class="text-gray-600 mt-2">Discover available items from our UB community.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24 max-h-[calc(100vh-100px)] overflow-y-auto">
                <div class="flex justify-between items-center mb-6 lg:block">
                    <h2 class="text-xl font-bold text-gray-900">Filters</h2>
                    <button class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Search in Filters -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Search</label>
                    <input type="text" placeholder="Search items..."
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Item Type -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-3 text-sm">Item Type</h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Barter Items</span>
                            <span class="ml-auto text-xs text-gray-500">(245)</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Donations</span>
                            <span class="ml-auto text-xs text-gray-500">(189)</span>
                        </label>
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-3 text-sm">Category</h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Books & Textbooks</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Uniforms & Apparel</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Lab Supplies</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Electronics</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Furniture</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Art & Craft Supplies</span>
                        </label>
                    </div>
                </div>

                <!-- Condition -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-3 text-sm">Condition</h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="condition" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">All Conditions</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="condition" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Brand New</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="condition" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Slightly Used</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="condition" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Used</span>
                        </label>
                    </div>
                </div>

                <!-- Seller Rating -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3 text-sm">Seller Rating</h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">★★★★★ 5 Stars</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">★★★★ 4+ Stars</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">★★★ 3+ Stars</span>
                        </label>
                    </div>
                </div>

                <!-- Reset Filters -->
                <button class="w-full py-2 text-blue-600 hover:text-blue-700 font-medium text-sm border border-blue-600 rounded-lg transition">
                    Reset Filters
                </button>
            </div>
        </div>

        <!-- Items Grid -->
        <div class="lg:col-span-3">
            <!-- View Options Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <p class="text-sm text-gray-600">Showing <span class="font-bold text-gray-900">434</span> items</p>
                    <div class="flex items-center space-x-2 border border-gray-300 rounded-lg p-1 bg-white">
                        <button class="px-3 py-2 text-blue-600 border-r border-gray-300">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="px-3 py-2 text-gray-400">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option>Sort by: Newest</option>
                    <option>Most Popular</option>
                    <option>Most Requested</option>
                    <option>Rating: High to Low</option>
                </select>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Item Card Template (repeat as needed) -->
                @for($i = 1; $i <= 9; $i++)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200 hover:shadow-lg transition group">
                        <!-- Image -->
                        <div class="relative h-64 bg-gray-100 overflow-hidden">
                            <img src="https://via.placeholder.com/400x300?text=Item+{{ $i }}" alt="Item" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            
                            <!-- Type Badge -->
                            @if($i % 2 == 0)
                                <div class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Barter
                                </div>
                            @else
                                <div class="absolute top-3 right-3 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Donation
                                </div>
                            @endif

                            <!-- Save Button -->
                            <button class="absolute top-3 left-3 w-9 h-9 bg-white rounded-full flex items-center justify-center hover:bg-red-50 transition shadow-sm">
                                <i class="far fa-heart text-red-500 text-lg"></i>
                            </button>

                            <!-- Condition -->
                            <div class="absolute bottom-3 left-3 bg-black/50 text-white px-2 py-1 rounded text-xs font-medium backdrop-blur-sm">
                                @if($i % 3 == 0) New @elseif($i % 3 == 1) Slightly Used @else Used @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <!-- Title -->
                            <h3 class="font-bold text-gray-900 text-sm line-clamp-2 mb-2">
                                {{ ['Advanced Calculus Textbook', 'Engineering Uniform Set', 'Laptop Stand Aluminum', 'Programming Guide Book', 'Lab Coat Size M', 'Organic Chemistry Notes', 'Physics Lab Equipment', 'Mathematics Handbook', 'Design Software License'][$i-1] }}
                            </h3>

                            <!-- Category -->
                            <p class="text-xs text-gray-600 mb-3">
                                {{ ['Books', 'Uniforms', 'Electronics', 'Books', 'Apparel', 'Books', 'Lab Supplies', 'Books', 'Software'][$i-1] }}
                            </p>

                            <!-- Seller Info -->
                            <div class="flex items-center space-x-2 mb-4 pb-4 border-b border-gray-200">
                                <img src="https://ui-avatars.com/api/?name=User+{{ $i }}&background=0066cc&color=fff" alt="User" class="w-7 h-7 rounded-full">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-900">User {{ $i }}</p>
                                    <div class="flex items-center space-x-1">
                                        <span class="text-yellow-400 text-xs">★</span>
                                        <span class="text-xs text-gray-600">{{ 4.5 + ($i * 0.1) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                                View Item
                            </button>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">← Previous</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">3</button>
                    <span class="text-gray-600">...</span>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Next →</button>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
