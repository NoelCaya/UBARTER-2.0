@extends('layouts.master')

@section('title', 'Search Items')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Search Results</h1>
        @if($query)
            <p class="text-gray-600">Results for "<span class="font-bold">{{ $query }}</span>" ({{ $items->total() }} items found)</p>
        @else
            <p class="text-gray-600">Browse all available items</p>
        @endif
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('items.search') }}" class="mb-8">
        <div class="flex gap-4">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search items..."
                   class="flex-1 px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f5c518]">
            <button type="submit" class="bg-[#7b0f10] text-white font-bold px-8 py-3 rounded-lg hover:bg-[#5a0a0b] transition">
                Search
            </button>
        </div>
    </form>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('items.search') }}" class="bg-white rounded-lg shadow border border-gray-200 p-4 mb-8">
        <input type="hidden" name="q" value="{{ $query }}">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $currentFilters['category'] == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                <select name="condition" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]" onchange="this.form.submit()">
                    <option value="all">Any Condition</option>
                    @foreach($conditions as $cond)
                    <option value="{{ $cond }}" {{ $currentFilters['condition'] == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]" onchange="this.form.submit()">
                    <option value="all">All Types</option>
                    @foreach($types as $t)
                    <option value="{{ $t }}" {{ $currentFilters['type'] == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]" onchange="this.form.submit()">
                    <option value="newest" {{ $currentFilters['sort'] == 'newest' ? 'selected' : '' }}>Most Recent</option>
                    <option value="most_viewed" {{ $currentFilters['sort'] == 'most_viewed' ? 'selected' : '' }}>Most Popular</option>
                    <option value="highest_rated" {{ $currentFilters['sort'] == 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="most_wishlisted" {{ $currentFilters['sort'] == 'most_wishlisted' ? 'selected' : '' }}>Most Wishlisted</option>
                </select>
            </div>
            <div class="flex items-end">
                <a href="{{ route('items.search') }}" class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg text-center hover:bg-gray-400 transition">
                    Clear Filters
                </a>
            </div>
        </div>
    </form>

    <!-- Items Grid -->
    @if($items->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($items as $item)
        <a href="{{ route('items.show', $item) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200 overflow-hidden">
            <div class="h-48 bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] flex items-center justify-center relative overflow-hidden">
                @if($item->image_url)
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-image text-white text-4xl opacity-30"></i>
                @endif
            </div>
            <div class="p-6">
                <div class="inline-block bg-[#f5c518]/20 text-[#7b0f10] text-xs font-bold px-3 py-1 rounded-full mb-3">
                    {{ $item->category }}
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ Str::limit($item->title, 50) }}</h3>
                <div class="flex items-center space-x-2 mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff" 
                         alt="{{ $item->user->name }}" class="w-6 h-6 rounded-full">
                    <p class="text-sm text-gray-600">{{ Str::limit($item->user->name, 20) }}</p>
                </div>
                <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ $item->description }}</p>
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-1 text-[#f5c518] text-xs">
                        @for($j = 0; $j < 5; $j++)
                            @if($j < round($item->rating ?? 0))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="text-gray-600 ml-1">({{ $item->views ?? 0 }} views)</span>
                    </div>
                    <span class="text-[#f5c518] font-bold text-sm">{{ $item->item_type }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $items->links() }}
    </div>
    @else
    <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
        <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No items found</h3>
        <p class="text-gray-600 mb-6">Try adjusting your search filters or browse all items.</p>
        <a href="{{ route('items.browse') }}" class="inline-block bg-[#7b0f10] text-white font-bold px-6 py-3 rounded-lg hover:bg-[#5a0a0b] transition">
            Browse All Items
        </a>
    </div>
    @endif
</div>
@endsection
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center gap-2">
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">← Previous</button>
        <button class="px-4 py-2 bg-[#7b0f10] text-white rounded-lg font-bold">1</button>
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">2</button>
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">3</button>
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">Next →</button>
    </div>
</div>
@endsection
