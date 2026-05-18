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

    .item-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .badge-barter {
        background: var(--ub-maroon);
        color: white;
    }

    .badge-donation {
        background: #10b981;
        color: white;
    }

    .condition-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }

    .wishlist-btn {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.2s;
    }

    .wishlist-btn:hover {
        background: #fef3c7;
        transform: scale(1.1);
    }

    .wishlist-btn.active {
        color: #dc2626;
    }

    .item-content {
        padding: 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .item-title {
        font-weight: 600;
        font-size: 13px;
        line-height: 1.4;
        color: #1a1a1a;
        margin: 0 0 6px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .item-category {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }

    .item-seller {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
        font-size: 12px;
    }

    .seller-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
    }

    .seller-info {
        flex: 1;
    }

    .seller-name {
        font-weight: 500;
        color: #1a1a1a;
        font-size: 12px;
    }

    .seller-rating {
        font-size: 11px;
        color: #666;
    }

    .star {
        color: #fbbf24;
        font-size: 11px;
    }

    .item-footer {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .view-btn {
        flex: 1;
        padding: 10px;
        background: var(--ub-maroon);
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .view-btn:hover {
        background: var(--ub-maroon-dark);
    }

    .inquiry-btn {
        flex: 1;
        padding: 10px;
        background: var(--ub-gold);
        color: var(--ub-maroon);
        border: none;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .inquiry-btn:hover {
        background: #f5c518;
        box-shadow: 0 2px 8px rgba(245, 197, 24, 0.3);
    }

    /* Filters Sidebar */
    .filters-section {
        position: sticky;
        top: 100px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .filter-group {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
    }

    .filter-group:last-child {
        border-bottom: none;
    }

    .filter-title {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 12px;
        color: #1a1a1a;
    }

    .filter-option {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        cursor: pointer;
    }

    .filter-option input[type="checkbox"],
    .filter-option input[type="radio"] {
        margin-right: 8px;
        cursor: pointer;
        accent-color: var(--ub-maroon);
    }

    .filter-option label {
        flex: 1;
        font-size: 13px;
        cursor: pointer;
        margin: 0;
    }

    .filter-count {
        font-size: 12px;
        color: #999;
    }

    .reset-btn {
        width: 100%;
        padding: 10px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .reset-btn:hover {
        background: #f9f9f9;
    }

    /* Search bar */
    .search-box {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .search-box input {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
    }

    .search-box input:focus {
        border-color: var(--ub-maroon);
    }

    .search-box button {
        padding: 10px 16px;
        background: var(--ub-maroon);
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .search-box button:hover {
        background: var(--ub-maroon-dark);
    }

    /* Sorting */
    .sort-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
    }

    .item-count {
        font-size: 13px;
        color: #666;
    }

    .sort-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
        background: white;
    }

    .view-toggle {
        display: flex;
        gap: 4px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 2px;
    }

    .view-toggle button {
        padding: 6px 10px;
        border: none;
        background: white;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .view-toggle button.active {
        background: var(--ub-maroon);
        color: white;
    }

    /* Pagination */
    .pagination-section {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
        padding-top: 20px;
    }

    .pagination-section a,
    .pagination-section button {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: white;
        color: #666;
        cursor: pointer;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
    }

    .pagination-section a:hover,
    .pagination-section button:hover {
        border-color: var(--ub-maroon);
        color: var(--ub-maroon);
    }

    .pagination-section .active {
        background: var(--ub-maroon);
        color: white;
        border-color: var(--ub-maroon);
    }

    /* Empty state */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 20px;
        color: #ccc;
    }

    .empty-state-text {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    /* Scrollbar */
    .filters-section::-webkit-scrollbar {
        width: 6px;
    }

    .filters-section::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .filters-section::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .filters-section::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<div class="bg-white min-h-screen">
    <!-- Header -->
    <div class="sticky top-0 z-40 bg-white border-b border-gray-200">
        <div class="px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900">🛍️ Browse & Barter</h1>
            <p class="text-sm text-gray-600 mt-1">Discover items from your UBarter community</p>
        </div>
    </div>

    <div class="flex">
        <!-- Filters Sidebar -->
        <div class="w-64 border-r border-gray-200 p-6 filters-section">
            <!-- Search Box -->
            <div class="search-box mb-6">
                <form method="GET" action="{{ route('items.browse') }}" class="flex gap-2 w-full">
                    <input type="text" name="search" placeholder="Search items..." value="{{ $currentFilters['search'] }}" class="flex-1">
                    <button type="submit">Search</button>
                </form>
            </div>

            <!-- Item Type Filter -->
            <div class="filter-group">
                <div class="filter-title">Type</div>
                <form method="GET" action="{{ route('items.browse') }}" class="inline">
                    <div class="filter-option">
                        <input type="radio" id="type_all" name="type" value="all"
                            {{ $currentFilters['type'] == 'all' ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <label for="type_all">All Types</label>
                    </div>
                    @foreach($types as $type)
                        <div class="filter-option">
                            <input type="radio" id="type_{{ $loop->index }}" name="type" value="{{ $type }}"
                                {{ $currentFilters['type'] == $type ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <label for="type_{{ $loop->index }}">{{ $type }}</label>
                        </div>
                    @endforeach
                </form>
            </div>

            <!-- Category Filter -->
            <div class="filter-group">
                <div class="filter-title">Category</div>
                <form method="GET" action="{{ route('items.browse') }}" class="inline">
                    <div class="filter-option">
                        <input type="radio" id="category_all" name="category" value="all"
                            {{ $currentFilters['category'] == 'all' ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <label for="category_all">All Categories</label>
                    </div>
                    @foreach($categories as $category)
                        <div class="filter-option">
                            <input type="radio" id="category_{{ $loop->index }}" name="category" value="{{ $category }}"
                                {{ $currentFilters['category'] == $category ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <label for="category_{{ $loop->index }}">{{ $category }}</label>
                        </div>
                    @endforeach
                </form>
            </div>

            <!-- Condition Filter -->
            <div class="filter-group">
                <div class="filter-title">Condition</div>
                <form method="GET" action="{{ route('items.browse') }}" class="inline">
                    <div class="filter-option">
                        <input type="radio" id="condition_all" name="condition" value="all"
                            {{ $currentFilters['condition'] == 'all' ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <label for="condition_all">All Conditions</label>
                    </div>
                    @foreach($conditions as $condition)
                        <div class="filter-option">
                            <input type="radio" id="condition_{{ $loop->index }}" name="condition" value="{{ $condition }}"
                                {{ $currentFilters['condition'] == $condition ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <label for="condition_{{ $loop->index }}">{{ $condition }}</label>
                        </div>
                    @endforeach
                </form>
            </div>

            <!-- Reset Button -->
            <a href="{{ route('items.browse') }}" class="reset-btn block text-center">Reset Filters</a>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Sort & View Options -->
            <div class="sort-section">
                <div class="item-count">Showing <strong>{{ $itemCount }}</strong> items</div>
                <form method="GET" action="{{ route('items.browse') }}" class="inline">
                    <select name="sort" onchange="this.form.submit()" class="sort-select">
                        <option value="newest" {{ $currentFilters['sort'] == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="most_viewed" {{ $currentFilters['sort'] == 'most_viewed' ? 'selected' : '' }}>Most Viewed</option>
                        <option value="highest_rated" {{ $currentFilters['sort'] == 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="most_wishlisted" {{ $currentFilters['sort'] == 'most_wishlisted' ? 'selected' : '' }}>Most Wishlisted</option>
                    </select>
                </form>
            </div>

            <!-- Items Grid -->
            @if($items->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($items as $item)
                        <div class="item-card">
                            <!-- Image Container -->
                            <div class="relative group overflow-hidden bg-gray-100" style="height: 280px;">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="item-image w-full h-full">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                                        <i class="fas fa-image text-gray-500 text-4xl"></i>
                                    </div>
                                @endif

                                <!-- Type Badge -->
                                <span class="item-badge {{ $item->item_type == 'Barter' ? 'badge-barter' : 'badge-donation' }}">
                                    {{ $item->item_type }}
                                </span>

                                <!-- Condition -->
                                <div class="condition-badge">{{ $item->condition }}</div>

                                <!-- Wishlist Button -->
                                <button class="wishlist-btn" onclick="toggleWishlist(this, {{ $item->id }})">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>

                            <!-- Content -->
                            <div class="item-content">
                                <!-- Title -->
                                <h3 class="item-title">{{ $item->title }}</h3>

                                <!-- Category -->
                                <p class="item-category">{{ $item->category }}</p>

                                <!-- Seller Info -->
                                <div class="item-seller">
                                    @if($item->user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $item->user->profile_photo_path) }}" alt="{{ $item->user->name }}" class="seller-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff" alt="{{ $item->user->name }}" class="seller-avatar">
                                    @endif
                                    <div class="seller-info flex-1">
                                        <div class="seller-name">{{ $item->user->name }}</div>
                                        <div class="seller-rating">
                                            <span class="star">★</span> {{ number_format($item->seller_rating, 1) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="item-footer">
                                    <a href="{{ route('items.show', $item) }}" class="view-btn">
                                        View
                                    </a>
                                    <button class="inquiry-btn" onclick="sendInquiry({{ $item->id }})">
                                        Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="pagination-section">
                        @if($items->onFirstPage())
                            <span class="opacity-50 cursor-not-allowed">← Previous</span>
                        @else
                            <a href="{{ $items->previousPageUrl() }}">← Previous</a>
                        @endif

                        @foreach($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                            @if($page == $items->currentPage())
                                <button class="active">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($items->hasMorePages())
                            <a href="{{ $items->nextPageUrl() }}">Next →</a>
                        @else
                            <span class="opacity-50 cursor-not-allowed">Next →</span>
                        @endif
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <div class="empty-state-text">No items found matching your criteria</div>
                    <a href="{{ route('items.browse') }}" class="view-btn inline-block">Clear Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleWishlist(button, itemId) {
        event.preventDefault();
        button.classList.toggle('active');
        // Add your wishlist functionality here
    }

    function sendInquiry(itemId) {
        // Navigate to chat or message page
        // window.location.href = `/chat?item=${itemId}`;
    }
</script>
@endsection
