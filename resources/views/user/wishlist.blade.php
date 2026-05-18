@extends('layouts.master')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">My Wishlist</h1>
        <p class="text-gray-600">{{ $wishlistItems->total() }} items you're interested in</p>
    </div>

    @if($wishlistItems->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($wishlistItems as $wishlist)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden border border-gray-200">
            <div class="h-48 bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] flex items-center justify-center overflow-hidden">
                @if($wishlist->item->image_url)
                    <img src="{{ $wishlist->item->image_url }}" alt="{{ $wishlist->item->title }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-image text-white text-4xl opacity-30"></i>
                @endif
            </div>
            <div class="p-6">
                <div class="inline-block bg-[#f5c518]/20 text-[#7b0f10] text-xs font-bold px-3 py-1 rounded-full mb-2">
                    {{ $wishlist->item->category }}
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $wishlist->item->title }}</h3>
                <p class="text-gray-600 text-sm mb-2">By {{ $wishlist->item->user->name }}</p>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $wishlist->item->description }}</p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('items.show', $wishlist->item) }}" class="text-[#7b0f10] font-bold hover:underline">View Details</a>
                    <form action="{{ route('wishlist.remove', $wishlist->item) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition">
                            <i class="fas fa-heart text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $wishlistItems->links() }}
    </div>
    @else
    <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
        <i class="fas fa-heart text-5xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Your wishlist is empty</h3>
        <p class="text-gray-600 mb-6">Start adding items you're interested in!</p>
        <a href="{{ route('items.browse') }}" class="inline-block bg-[#7b0f10] text-white font-bold px-6 py-3 rounded-lg hover:bg-[#5a0a0b] transition">
            Browse Items
        </a>
    </div>
    @endif
</div>
@endsection
