@extends('layouts.master')

@section('title', 'Browse & Barter - UBarter')

@section('content')
<style>
    .product-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        transition: box-shadow 0.2s, transform 0.2s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.14);
        transform: translateY(-2px);
    }
    .product-card .img-wrap {
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        background: #f5f5f5;
        position: relative;
        flex-shrink: 0;
    }
    .product-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .product-card:hover .img-wrap img {
        transform: scale(1.04);
    }
    .product-card .card-body {
        padding: 8px 8px 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-card .card-title {
        font-size: 0.78rem;
        font-weight: 600;
        color: #222;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
    }
    .product-card .card-meta {
        font-size: 0.68rem;
        color: #999;
        margin-top: auto;
        padding-top: 4px;
    }
    .card-type-badge {
        position: absolute;
        top: 6px;
        left: 6px;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: white;
    }
    .card-condition-badge {
        position: absolute;
        bottom: 6px;
        right: 6px;
        font-size: 0.6rem;
        font-weight: 700;
        background: rgba(0,0,0,0.55);
        color: #fff;
        padding: 2px 5px;
        border-radius: 3px;
    }
    .card-wishlist-btn {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 26px;
        height: 26px;
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        font-size: 0.7rem;
        color: #ccc;
    }
    .card-wishlist-btn:hover { background: white; color: #ef4444; }
    .card-views {
        position: absolute;
        bottom: 6px;
        left: 6px;
        font-size: 0.6rem;
        background: rgba(0,0,0,0.45);
        color: #fff;
        padding: 2px 5px;
        border-radius: 3px;
    }
</style>

<div class="px-4 md:px-6 py-5 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-xl font-bold text-gray-900">Browse & Barter</h1>
        <p class="text-gray-500 text-xs mt-0.5">Discover items from your UB community</p>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-5">
        <!-- Filters Sidebar -->
        <div class="hidden lg:block w-44 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-4 sticky top-24 max-h-[calc(100vh-120px)] overflow-y-auto">
                <h2 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                    <i class="fas fa-filter text-[#7b0f10] text-xs"></i> Filters
                </h2>

                <form action="{{ route('items.browse') }}" method="GET" class="space-y-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ $currentFilters['search'] }}" placeholder="Search items..."
                               class="w-full px-3 py-1.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-xs">
                    </div>

                    <!-- Item Type -->
                    <div class="pb-3 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700 mb-2 text-xs uppercase tracking-wide">Type</h3>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="all" {{ $currentFilters['type'] === 'all' ? 'checked' : '' }}
                                       class="w-3.5 h-3.5 accent-[#7b0f10]">
                                <span class="text-xs text-gray-600">All Items</span>
                            </label>
                            @foreach($types as $type)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type" value="{{ $type }}" {{ $currentFilters['type'] === $type ? 'checked' : '' }}
                                           class="w-3.5 h-3.5 accent-[#7b0f10]">
                                    <span class="text-xs text-gray-600">{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="pb-3 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700 mb-2 text-xs uppercase tracking-wide">Category</h3>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="category" value="all" {{ $currentFilters['category'] === 'all' ? 'checked' : '' }}
                                       class="w-3.5 h-3.5 accent-[#7b0f10]">
                                <span class="text-xs text-gray-600">All</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="category" value="{{ $category }}" {{ $currentFilters['category'] === $category ? 'checked' : '' }}
                                           class="w-3.5 h-3.5 accent-[#7b0f10]">
                                    <span class="text-xs text-gray-600">{{ $category }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Condition -->
                    <div class="pb-3 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700 mb-2 text-xs uppercase tracking-wide">Condition</h3>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="condition" value="all" {{ $currentFilters['condition'] === 'all' ? 'checked' : '' }}
                                       class="w-3.5 h-3.5 accent-[#7b0f10]">
                                <span class="text-xs text-gray-600">All</span>
                            </label>
                            @foreach($conditions as $cond)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="condition" value="{{ $cond }}" {{ $currentFilters['condition'] === $cond ? 'checked' : '' }}
                                           class="w-3.5 h-3.5 accent-[#7b0f10]">
                                    <span class="text-xs text-gray-600">{{ $cond }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <button type="submit" class="w-full py-1.5 text-white rounded-lg font-bold text-xs transition" style="background:#7b0f10;">
                            <i class="fas fa-search mr-1"></i> Apply
                        </button>
                        <a href="{{ route('items.browse') }}" class="block w-full py-1.5 text-center border border-gray-200 text-gray-600 rounded-lg font-semibold text-xs hover:bg-gray-50 transition">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Items Area -->
        <div class="flex-1 min-w-0">
            <!-- Toolbar -->
            <div class="bg-white rounded-xl shadow-sm px-4 py-2.5 mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="text-xs text-gray-500">
                    Showing <span class="font-bold text-gray-900">{{ $items->count() }}</span> of
                    <span class="font-bold text-gray-900">{{ $itemCount }}</span> items
                </p>
                <div class="flex items-center gap-2">
                    <!-- Mobile filter toggle -->
                    <button class="lg:hidden flex items-center gap-1.5 px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-semibold text-gray-600 hover:border-[#7b0f10] hover:text-[#7b0f10] transition" onclick="document.getElementById('mobileFilters').classList.toggle('hidden')">
                        <i class="fas fa-filter text-xs"></i> Filters
                    </button>
                    <form action="{{ route('items.browse') }}" method="GET" class="flex items-center gap-2">
                        <input type="hidden" name="search" value="{{ $currentFilters['search'] }}">
                        <input type="hidden" name="type" value="{{ $currentFilters['type'] }}">
                        <input type="hidden" name="category" value="{{ $currentFilters['category'] }}">
                        <input type="hidden" name="condition" value="{{ $currentFilters['condition'] }}">
                        <label class="text-xs text-gray-500 font-medium">Sort:</label>
                        <select name="sort" onchange="this.form.submit()" class="px-2 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 text-xs">
                            <option value="newest" {{ $currentFilters['sort'] === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="most_viewed" {{ $currentFilters['sort'] === 'most_viewed' ? 'selected' : '' }}>Most Popular</option>
                            <option value="highest_rated" {{ $currentFilters['sort'] === 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="most_wishlisted" {{ $currentFilters['sort'] === 'most_wishlisted' ? 'selected' : '' }}>Most Wishlisted</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Mobile Filters (collapsible) -->
            <div id="mobileFilters" class="hidden lg:hidden bg-white rounded-xl shadow-sm p-4 mb-4">
                <form action="{{ route('items.browse') }}" method="GET" class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ $currentFilters['search'] }}" placeholder="Search..."
                               class="w-full px-3 py-1.5 rounded-lg border border-gray-200 text-xs focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Type</label>
                        <select name="type" class="w-full px-3 py-1.5 rounded-lg border border-gray-200 text-xs focus:outline-none">
                            <option value="all" {{ $currentFilters['type'] === 'all' ? 'selected' : '' }}>All Types</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ $currentFilters['type'] === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Category</label>
                        <select name="category" class="w-full px-3 py-1.5 rounded-lg border border-gray-200 text-xs focus:outline-none">
                            <option value="all" {{ $currentFilters['category'] === 'all' ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ $currentFilters['category'] === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Condition</label>
                        <select name="condition" class="w-full px-3 py-1.5 rounded-lg border border-gray-200 text-xs focus:outline-none">
                            <option value="all" {{ $currentFilters['condition'] === 'all' ? 'selected' : '' }}>All Conditions</option>
                            @foreach($conditions as $cond)
                                <option value="{{ $cond }}" {{ $currentFilters['condition'] === $cond ? 'selected' : '' }}>{{ $cond }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 flex gap-2">
                        <button type="submit" class="flex-1 py-1.5 text-white rounded-lg font-bold text-xs" style="background:#7b0f10;">Apply Filters</button>
                        <a href="{{ route('items.browse') }}" class="flex-1 py-1.5 text-center border border-gray-200 text-gray-600 rounded-lg font-semibold text-xs hover:bg-gray-50">Reset</a>
                    </div>
                </form>
            </div>

            @if($items->count() > 0)
                <!-- Shopee-style compact grid -->
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-6 gap-2 mb-6">
                    @foreach($items as $item)
                        <a href="{{ route('items.show', $item) }}" class="product-card">
                            <div class="img-wrap">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                                <!-- Type badge -->
                                <span class="card-type-badge" style="background: {{ $item->item_type === 'Barter' ? '#7b0f10' : '#10b981' }};">
                                    {{ $item->item_type }}
                                </span>
                                <!-- Wishlist -->
                                <form action="{{ route('wishlist.add', $item) }}" method="POST" style="position:absolute;top:6px;right:6px;">
                                    @csrf
                                    <button type="submit" class="card-wishlist-btn" onclick="event.stopPropagation();" title="Add to Wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </form>
                                <!-- Views -->
                                <span class="card-views"><i class="fas fa-eye mr-0.5"></i>{{ $item->views }}</span>
                                <!-- Condition -->
                                <span class="card-condition-badge">{{ $item->condition }}</span>
                            </div>
                            <div class="card-body">
                                <p class="card-title">{{ $item->title }}</p>
                                <div class="flex items-center gap-1 mt-1">
                                    <span class="text-xs font-bold px-1.5 py-0.5 rounded" style="background:rgba(123,15,16,0.08);color:#7b0f10;font-size:0.6rem;">{{ $item->category }}</span>
                                    <span class="flex items-center gap-0.5 text-yellow-400 ml-auto" style="font-size:0.6rem;">
                                        <i class="fas fa-star"></i>
                                        <span class="text-gray-500">{{ number_format($item->seller_rating, 1) }}</span>
                                    </span>
                                </div>
                                <p class="card-meta">{{ $item->user->name }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="flex justify-center my-6">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <i class="fas fa-inbox text-5xl text-gray-200 mb-4 block"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">No items found</h3>
                    <p class="text-gray-500 text-sm mb-5">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('items.browse') }}" class="inline-block px-5 py-2 text-white rounded-lg font-semibold text-sm transition" style="background:#7b0f10;">
                        <i class="fas fa-redo mr-2"></i> Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
