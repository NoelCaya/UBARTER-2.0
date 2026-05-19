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

<div class="px-4 md:px-6 py-6 max-w-6xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('items.browse') }}" class="inline-flex items-center gap-2 text-sm text-[#7b0f10] hover:text-[#5a0a0b] font-semibold mb-5 transition">
        <i class="fas fa-arrow-left text-xs"></i>
        <span>Back to Browse</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Image Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-4">
                <!-- Main Image -->
                <div class="h-80 bg-gray-100 relative">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3 bg-[#7b0f10] text-white px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $item->item_type }}
                    </div>
                    <div class="absolute bottom-3 right-3 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                        <i class="fas fa-eye mr-1"></i>{{ $item->views }}
                    </div>
                </div>
            </div>

            <!-- Item Details -->
            <div class="bg-white rounded-xl shadow-sm p-5 mb-4">
                <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $item->title }}</h1>

                <!-- Status Badges -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $item->condition }}</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $item->status }}</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">{{ $item->category }}</span>
                </div>

                <!-- Description -->
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Description</h2>
                <p class="text-gray-600 leading-relaxed mb-5 text-sm">{{ $item->description }}</p>

                <!-- Item Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 py-4 border-t border-b border-gray-100">
                    <div class="text-center">
                        <p class="text-xl font-bold text-[#7b0f10]">{{ $item->views }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Views</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl font-bold text-[#7b0f10]">{{ $item->wishlist_count }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Wishlisted</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl font-bold text-[#7b0f10]">{{ $item->rating }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Rating</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-bold text-[#7b0f10]">{{ $item->posted_at->diffForHumans() }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Posted</p>
                    </div>
                </div>
            </div>

            <!-- Related Items -->
            @if($relatedItems->count() > 0)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Related Items in {{ $item->category }}</h2>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($relatedItems as $related)
                            <a href="{{ route('items.show', $related) }}" class="group">
                                <div class="bg-gray-100 rounded-lg overflow-hidden mb-2">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-32 object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm line-clamp-2 group-hover:text-[#7b0f10] transition">{{ $related->title }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $related->condition }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Seller Info & Action Sidebar -->
        <div class="lg:col-span-1">
            <!-- Seller Card -->
            <div class="bg-white rounded-xl shadow-sm p-5 mb-4 sticky top-24">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Seller Information</h3>

                <!-- Seller Avatar & Name -->
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&bold=true&size=60"
                         alt="{{ $item->user->name }}" class="w-14 h-14 rounded-full flex-shrink-0">
                    <div>
                        <p class="font-bold text-gray-900">{{ $item->user->name }}</p>
                        <div class="flex items-center gap-0.5 text-[#f5c518] text-xs mt-0.5">
                            @for($i = 0; $i < 5; $i++)<i class="fas fa-star"></i>@endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($item->seller_rating, 1) }} / 5.0</p>
                    </div>
                </div>

                <!-- Seller Stats -->
                <div class="space-y-2 py-3 border-t border-b border-gray-100 mb-4 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Response Time:</span>
                        <span class="font-semibold text-gray-900">&lt; 2 hours</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Positive Rating:</span>
                        <span class="font-semibold text-green-600">98%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Member Since:</span>
                        <span class="font-semibold text-gray-900">{{ $item->user->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <button class="w-full py-2.5 bg-[#7b0f10] hover:bg-[#5a0a0b] text-white rounded-lg font-bold mb-2.5 transition text-sm">
                    <i class="fas fa-envelope mr-2"></i> Contact Seller
                </button>
                <button class="w-full py-2.5 border-2 border-[#7b0f10] text-[#7b0f10] hover:bg-[#7b0f10] hover:text-white rounded-lg font-bold transition text-sm">
                    <i class="fas fa-heart mr-2"></i> Add to Wishlist
                </button>
            </div>

            <!-- Item Summary Card -->
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h4 class="font-bold text-gray-900 text-sm mb-3">Item Summary</h4>
                <ul class="space-y-2 text-xs">
                    <li class="flex justify-between">
                        <span class="text-gray-500">Type:</span>
                        <span class="font-semibold text-gray-900">{{ $item->item_type }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Category:</span>
                        <span class="font-semibold text-gray-900">{{ $item->category }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Condition:</span>
                        <span class="font-semibold text-gray-900">{{ $item->condition }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Status:</span>
                        <span class="font-semibold text-[#7b0f10]">{{ $item->status }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Posted:</span>
                        <span class="font-semibold text-gray-900">{{ $item->posted_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
