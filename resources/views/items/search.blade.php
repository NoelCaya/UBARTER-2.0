@extends('layouts.master')

@section('title', 'Search Items')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Search Results</h1>
        @if(request('q'))
        <p class="text-gray-600">Results for "<span class="font-bold">{{ request('q') }}</span>"</p>
        @else
        <p class="text-gray-600">Browse all available items</p>
        @endif
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('items.search') }}" class="mb-8">
        <div class="flex gap-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search items..."
                   class="flex-1 px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f5c518]">
            <button type="submit" class="bg-[#7b0f10] text-white font-bold px-8 py-3 rounded-lg hover:bg-[#5a0a0b] transition">
                Search
            </button>
        </div>
    </form>

    <!-- Filter Bar -->
    <div class="bg-white rounded-lg shadow border border-gray-200 p-4 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]">
                    <option>All Categories</option>
                    <option>Electronics</option>
                    <option>Books</option>
                    <option>Clothing</option>
                    <option>Furniture</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]">
                    <option>All Departments</option>
                    <option>Engineering</option>
                    <option>Business</option>
                    <option>Science</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]">
                    <option>Any Condition</option>
                    <option>Like New</option>
                    <option>Good</option>
                    <option>Fair</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518]">
                    <option>Most Recent</option>
                    <option>Most Popular</option>
                    <option>Trending</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Items Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($i = 1; $i <= 12; $i++)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200 overflow-hidden">
            <div class="h-48 bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] flex items-center justify-center relative">
                <i class="fas fa-image text-white text-4xl opacity-30"></i>
                @if($i % 3 == 0)
                <div class="absolute top-3 right-3 bg-[#f5c518] text-[#7b0f10] text-xs font-bold px-3 py-1 rounded-full">
                    Trending
                </div>
                @endif
            </div>
            <div class="p-6">
                <div class="inline-block bg-[#f5c518]/20 text-[#7b0f10] text-xs font-bold px-3 py-1 rounded-full mb-3">
                    Electronics
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">Item #{{ $i }}</h3>
                <div class="flex items-center space-x-2 mb-3">
                    <img src="https://ui-avatars.com/api/?name=User&background=7b0f10&color=fff" 
                         alt="User" class="w-6 h-6 rounded-full">
                    <p class="text-sm text-gray-600">Engineering Dept</p>
                </div>
                <p class="text-gray-700 text-sm mb-4">High-quality item in great condition. Perfect for students.</p>
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-1 text-[#f5c518]">
                        @for($j = 0; $j < 5; $j++)
                        <i class="fas fa-star text-xs"></i>
                        @endfor
                    </div>
                    <button class="bg-[#7b0f10] text-white font-bold px-4 py-2 rounded-lg hover:bg-[#5a0a0b] transition text-sm">
                        View
                    </button>
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
