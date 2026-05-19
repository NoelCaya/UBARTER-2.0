@extends('layouts.master')

@section('title', 'Browse & Barter - UBarter')

@section('content')
<style>
    :root {
        --ub-maroon: #7b0f10;
        --ub-maroon-dark: #5a0a0b;
        --ub-gold: #f5c518;
    }

    .item-card {
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        background: white;
    }

    .item-card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        transform: translateY(-4px);
    }

    .item-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .item-image:hover {
        opacity: 0.95;
    }

    .badge-barter {
        background: linear-gradient(135deg, var(--ub-maroon) 0%, #9b1a1b 100%);
        color: white;
    }

    .badge-donation {
        background: #10b981;
        color: white;
    }

    .wishlist-btn {
        transition: all 0.2s ease;
    }

    .wishlist-btn:hover {
        transform: scale(1.15);
    }

    .wishlist-btn.active {
        color: #ef4444;
    }
</style>

<div class="w-full px-4 md:px-6 py-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-gray-900">Browse & Barter</h1>
        <p class="text-gray-500 text-sm mt-1">Discover available items from your UB community.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-5 sticky top-24 max-h-[calc(100vh-120px)] overflow-y-auto">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-[#7b0f10] text-sm"></i> Filters
                </h2>

                <form action="{{ route('items.browse') }}" method="GET" class="space-y-6">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Search Items</label>
                        <input type="text" name="search" value="{{ $currentFilters['search'] }}" placeholder="Search by title..." 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#7b0f10] text-sm">
                    </div>

                    <!-- Item Type -->
                    <div class="pb-6 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3 text-sm">Item Type</h3>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="type" value="all" {{ $currentFilters['type'] === 'all' ? 'checked' : '' }} 
                                       class="w-4 h-4 text-[#7b0f10] rounded focus:ring-[#7b0f10]">
                                <span class="ml-3 text-sm text-gray-700">All Items</span>
                            </label>
                            @foreach($types as $type)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="type" value="{{ $type }}" {{ $currentFilters['type'] === $type ? 'checked' : '' }}
                                           class="w-4 h-4 text-[#7b0f10] rounded focus:ring-[#7b0f10]">
                                    <span class="ml-3 text-sm text-gray-700">{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="pb-6 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3 text-sm">Category</h3>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="category" value="all" {{ $currentFilters['category'] === 'all' ? 'checked' : '' }}
                                       class="w-4 h-4 text-[#7b0f10] rounded focus:ring-[#7b0f10]">
                                <span class="ml-3 text-sm text-gray-700">All Categories</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="category" value="{{ $category }}" {{ $currentFilters['category'] === $category ? 'checked' : '' }}
                                           class="w-4 h-4 text-[#7b0f10] rounded focus:ring-[#7b0f10]">
                                    <span class="ml-3 text-sm text-gray-700">{{ $category }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Condition -->
                    <div class="pb-6 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3 text-sm">Condition</h3>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="condition" value="all" {{ $currentFilters['condition'] === 'all' ? 'checked' : '' }}
                                       class="w-4 h-4 text-[#7b0f10] rounded focus:ring-[#7b0f10]">
                                <span class="ml-3 text-sm text-gray-700">All Conditions</span>
                            </label>
                            @foreach($conditions as $cond)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="condition" value="{{ $cond }}" {{ $currentFilters['condition'] === $cond ? 'checked' : '' }}
                                           class="w-4 h-4 text-[#7b0f10] rounded focus:ring-[#7b0f10]">
                                    <span class="ml-3 text-sm text-gray-700">{{ $cond }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-2">
                        <button type="submit" class="w-full py-2 bg-[#7b0f10] text-white rounded-lg font-semibold text-sm hover:bg-[#5a0a0b] transition">
                            <i class="fas fa-search mr-2"></i> Apply Filters
                        </button>
                        <a href="{{ route('items.browse') }}" class="block w-full py-2 text-center border border-gray-300 text-gray-700 rounded-lg font-semibold text-sm hover:bg-gray-50 transition">
                            <i class="fas fa-redo mr-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Items Grid -->
        <div class="lg:col-span-4">
            <!-- Header Bar -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-bold text-gray-900">{{ $items->count() }}</span> of 
                            <span class="font-bold text-gray-900">{{ $itemCount }}</span> items
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-700 font-medium">Sort by:</label>
                        <form action="{{ route('items.browse') }}" method="GET" class="flex">
                            <input type="hidden" name="search" value="{{ $currentFilters['search'] }}">
                            <input type="hidden" name="type" value="{{ $currentFilters['type'] }}">
                            <input type="hidden" name="category" value="{{ $currentFilters['category'] }}">
                            <input type="hidden" name="condition" value="{{ $currentFilters['condition'] }}">
                            <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7b0f10] text-sm">
                                <option value="newest" {{ $currentFilters['sort'] === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="most_viewed" {{ $currentFilters['sort'] === 'most_viewed' ? 'selected' : '' }}>Most Popular</option>
                                <option value="highest_rated" {{ $currentFilters['sort'] === 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="most_wishlisted" {{ $currentFilters['sort'] === 'most_wishlisted' ? 'selected' : '' }}>Most Wishlisted</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            @if($items->count() > 0)
                <!-- Items Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    @foreach($items as $item)
                        <div class="item-card">
                            <!-- Image Section -->
                            <div class="relative overflow-hidden bg-gray-100">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="item-image" loading="lazy">
                                
                                <!-- Type Badge -->
                                <div class="absolute top-3 right-3 badge-{{ strtolower($item->item_type) }} px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                    <i class="fas fa-{{ $item->item_type === 'Barter' ? 'exchange-alt' : 'gift' }} mr-1"></i>{{ $item->item_type }}
                                </div>

                                <!-- Wishlist Button -->
                                <button class="absolute top-3 left-3 w-10 h-10 bg-white rounded-full flex items-center justify-center wishlist-btn shadow-md hover:bg-red-50 transition">
                                    <i class="far fa-heart text-red-500 text-lg"></i>
                                </button>

                                <!-- Condition Badge -->
                                <div class="absolute bottom-3 left-3 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                    {{ $item->condition }}
                                </div>

                                <!-- Views Count -->
                                <div class="absolute bottom-3 right-3 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                    <i class="fas fa-eye mr-1"></i>{{ $item->views }}
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="flex flex-col flex-grow p-4">
                                <!-- Title -->
                                <h3 class="font-bold text-gray-900 text-sm line-clamp-2 mb-2 hover:text-maroon cursor-pointer">
                                    {{ $item->title }}
                                </h3>

                                <!-- Category & Location -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                <!-- Seller Info -->
                                <div class="flex items-center gap-2 mb-3 pb-3 border-b border-gray-200">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&bold=true" 
                                         alt="{{ $item->user->name }}" class="w-8 h-8 rounded-full">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-900 truncate">{{ $item->user->name }}</p>
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            <span class="text-xs text-gray-600">{{ number_format($item->seller_rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Preview -->
                                <p class="text-xs text-gray-600 mb-4 line-clamp-2">{{ $item->description }}</p>

                                <!-- Action Button -->
                                <a href="{{ route('items.show', $item) }}" class="mt-auto w-full py-2 bg-[#7b0f10] hover:bg-[#5a0a0b] text-white rounded-lg font-semibold text-sm transition text-center">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="flex justify-center my-8">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <div class="mb-4">
                        <i class="fas fa-inbox text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No items found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your filters or search terms to find what you're looking for.</p>
                    <a href="{{ route('items.browse') }}" class="inline-block px-6 py-2 bg-[#7b0f10] text-white rounded-lg font-semibold hover:bg-[#5a0a0b] transition">
                        <i class="fas fa-redo mr-2"></i> Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
