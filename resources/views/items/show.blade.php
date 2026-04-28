@extends('layouts.master')

@section('title', 'Item Details')

@section('content')
<div class="p-6 md:p-8">
    <!-- Back Button -->
    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium mb-6 inline-flex items-center space-x-2">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Browse</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Image Gallery -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <!-- Main Image -->
                <div class="h-96 bg-gray-100 flex items-center justify-center relative">
                    <img src="https://via.placeholder.com/600x400?text=Advanced+Calculus" alt="Product" class="w-full h-full object-cover">
                    
                    <!-- Badge -->
                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-full font-semibold">
                        Barter
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                <div class="flex space-x-2 p-4 overflow-x-auto">
                    @for($i = 1; $i <= 4; $i++)
                        <img src="https://via.placeholder.com/100x100?text=Image+{{ $i }}" alt="Thumbnail" class="w-20 h-20 rounded-lg object-cover cursor-pointer border-2 {{ $i == 1 ? 'border-blue-600' : 'border-gray-200' }} hover:border-blue-600">
                    @endfor
                </div>
            </div>

            <!-- Item Details Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Advanced Calculus Textbook - 3rd Edition</h1>
                
                <!-- Condition & Status -->
                <div class="flex items-center space-x-4 mb-6">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Brand New</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Available</span>
                </div>

                <!-- Description -->
                <h2 class="text-lg font-bold text-gray-900 mb-3">Description</h2>
                <p class="text-gray-700 leading-relaxed mb-6">
                    This is a comprehensive advanced calculus textbook perfect for engineering and mathematics students. The book is in pristine condition, never used, still has the original packaging. Contains detailed explanations, worked examples, and practice problems. Ideal for calculus II and III courses.
                </p>

                <!-- Item Details -->
                <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Category</p>
                        <p class="font-semibold text-gray-900">Books & Textbooks</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Condition</p>
                        <p class="font-semibold text-gray-900">Brand New</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Posted</p>
                        <p class="font-semibold text-gray-900">2 days ago</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Views</p>
                        <p class="font-semibold text-gray-900">156 views</p>
                    </div>
                </div>

                <!-- What's Being Sought (for barter items) -->
                <h2 class="text-lg font-bold text-gray-900 mb-3">What I'm Looking For</h2>
                <p class="text-gray-700 mb-4">Open to trading for the following items:</p>
                <div class="flex flex-wrap gap-2 mb-6 pb-6 border-b border-gray-200">
                    <span class="px-4 py-2 bg-gray-100 text-gray-900 rounded-full text-sm font-medium">
                        <i class="fas fa-search mr-2"></i>Programming Books
                    </span>
                    <span class="px-4 py-2 bg-gray-100 text-gray-900 rounded-full text-sm font-medium">
                        <i class="fas fa-search mr-2"></i>Physics Textbooks
                    </span>
                    <span class="px-4 py-2 bg-gray-100 text-gray-900 rounded-full text-sm font-medium">
                        <i class="fas fa-search mr-2"></i>Lab Equipment
                    </span>
                    <span class="px-4 py-2 bg-gray-100 text-gray-900 rounded-full text-sm font-medium">
                        <i class="fas fa-search mr-2"></i>Laptop Stand
                    </span>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Reviews & Comments</h2>
                
                <!-- Review Item -->
                <div class="flex space-x-4 pb-6 border-b border-gray-200 last:border-b-0">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Lee&background=0066cc&color=fff" alt="User" class="w-10 h-10 rounded-full flex-shrink-0">
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <p class="font-semibold text-gray-900">Sarah Lee</p>
                                <div class="flex items-center space-x-1 text-yellow-400 text-sm">
                                    <span>★★★★★</span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-600">1 week ago</span>
                        </div>
                        <p class="text-gray-700 text-sm">Great item! Well-packaged and arrived as described. The seller was very responsive and professional throughout the entire transaction.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Seller Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 mb-6 border border-blue-200">
                <div class="flex items-center space-x-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=0066cc&color=fff" alt="Seller" class="w-16 h-16 rounded-full border-4 border-white">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">John Doe</h3>
                        <p class="text-sm text-gray-600">Engineering Student</p>
                    </div>
                </div>

                <!-- Rating & Badges -->
                <div class="space-y-3 mb-6 pb-6 border-b border-blue-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-1">
                            <span class="text-yellow-400">★★★★★</span>
                            <span class="text-sm font-semibold text-gray-900">4.8</span>
                        </div>
                        <span class="text-xs text-gray-600">(156 reviews)</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <span class="text-sm text-gray-700">Trusted Trader</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-heart text-red-600"></i>
                        <span class="text-sm text-gray-700">23 Successful Trades</span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition mb-3 flex items-center justify-center space-x-2">
                    <i class="fas fa-comments"></i>
                    <span>Send Message</span>
                </button>
                <button class="w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold py-3 rounded-lg transition">
                    View Profile
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mb-6">
                <button class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center space-x-2">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Make Barter Offer</span>
                </button>
                <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg transition flex items-center justify-center space-x-2">
                    <i class="far fa-heart"></i>
                    <span>Add to Wishlist</span>
                </button>
                <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg transition flex items-center justify-center space-x-2">
                    <i class="fas fa-flag"></i>
                    <span>Report Item</span>
                </button>
            </div>

            <!-- Item Info Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4">Quick Info</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Item ID:</span>
                        <span class="font-semibold text-gray-900">#UB-2026-4582</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Location:</span>
                        <span class="font-semibold text-gray-900">Campus</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pickup/Delivery:</span>
                        <span class="font-semibold text-gray-900">Either</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Posted By:</span>
                        <span class="font-semibold text-gray-900">Individual</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
