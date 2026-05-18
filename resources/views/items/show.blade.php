@extends('layouts.master')

@section('title', $item->title)

@section('content')
<style>
    :root {
        --ub-maroon: #7b0f10;
        --ub-maroon-dark: #5a0a0b;
        --ub-gold: #f5c518;
    }
</style>

<div class="w-full px-4 md:px-8 py-6 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <!-- Back Button -->
    <a href="{{ route('items.browse') }}" class="text-[#7b0f10] hover:text-[#5a0a0b] font-semibold mb-6 inline-flex items-center space-x-2">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Browse</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Image Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <!-- Main Image -->
                <div class="h-96 bg-gray-100 flex items-center justify-center relative">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                    
                    <!-- Badge -->
                    <div class="absolute top-4 right-4 bg-[#7b0f10] text-white px-4 py-2 rounded-full font-semibold">
                        {{ $item->item_type }}
                    </div>

                    <!-- Views Count -->
                    <div class="absolute bottom-4 right-4 bg-black/60 text-white px-4 py-2 rounded-full font-semibold backdrop-blur-sm">
                        <i class="fas fa-eye mr-2"></i>{{ $item->views }}
                    </div>
                </div>
            </div>

            <!-- Item Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $item->title }}</h1>
                
                <!-- Status Badges -->
                <div class="flex items-center flex-wrap gap-3 mb-6">
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ $item->condition }}</span>
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">{{ $item->status }}</span>
                    <span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">{{ $item->category }}</span>
                </div>

                <!-- Description -->
                <h2 class="text-lg font-bold text-gray-900 mb-3">Description</h2>
                <p class="text-gray-700 leading-relaxed mb-6 text-justify">
                    {{ $item->description }}
                </p>

                <!-- Item Info -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6 border-t border-b border-gray-200">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-[#7b0f10]">{{ $item->views }}</p>
                        <p class="text-sm text-gray-600">Views</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-[#7b0f10]">{{ $item->wishlist_count }}</p>
                        <p class="text-sm text-gray-600">Wishlisted</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-[#7b0f10]">{{ $item->rating }}</p>
                        <p class="text-sm text-gray-600">Rating</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-[#7b0f10]">{{ $item->posted_at->diffForHumans() }}</p>
                        <p class="text-sm text-gray-600">Posted</p>
                    </div>
                </div>
            </div>

            <!-- Related Items -->
            @if($relatedItems->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Items in {{ $item->category }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($relatedItems as $related)
                            <a href="{{ route('items.show', $related) }}" class="group">
                                <div class="bg-gray-100 rounded-lg overflow-hidden mb-3">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <h3 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-maroon">{{ $related->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $related->condition }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Seller Info & Action Sidebar -->
        <div class="lg:col-span-1">
            <!-- Seller Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Seller Information</h3>
                
                <!-- Seller Avatar & Name -->
                <div class="flex items-center gap-3 mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&bold=true&size=60" 
                         alt="{{ $item->user->name }}" class="w-16 h-16 rounded-full">
                    <div>
                        <p class="font-bold text-gray-900">{{ $item->user->name }}</p>
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600">{{ number_format($item->seller_rating, 1) }} / 5.0</p>
                    </div>
                </div>

                <!-- Seller Stats -->
                <div class="space-y-3 py-4 border-t border-b border-gray-200 mb-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Response Time:</span>
                        <span class="font-semibold text-gray-900">< 2 hours</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Positive Rating:</span>
                        <span class="font-semibold text-green-600">98%</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Member Since:</span>
                        <span class="font-semibold text-gray-900">{{ $item->user->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <button class="w-full py-3 bg-[#7b0f10] hover:bg-[#5a0a0b] text-white rounded-lg font-bold mb-3 transition">
                    <i class="fas fa-envelope mr-2"></i> Contact Seller
                </button>
                <button class="w-full py-3 border-2 border-[#7b0f10] text-[#7b0f10] hover:bg-[#7b0f10] hover:text-white rounded-lg font-bold transition">
                    <i class="fas fa-heart mr-2"></i> Add to Wishlist
                </button>
            </div>

            <!-- Item Summary Card -->
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                <h4 class="font-bold text-gray-900 mb-4">Item Summary</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between">
                        <span class="text-gray-600">Type:</span>
                        <span class="font-semibold text-gray-900">{{ $item->item_type }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Category:</span>
                        <span class="font-semibold text-gray-900">{{ $item->category }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Condition:</span>
                        <span class="font-semibold text-gray-900">{{ $item->condition }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-semibold text-[#7b0f10]">{{ $item->status }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Posted:</span>
                        <span class="font-semibold text-gray-900">{{ $item->posted_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
