@extends('layouts.master')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Wishlist</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $wishlistItems->total() }} items you're interested in</p>
        </div>
    </div>

    @if($wishlistItems->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($wishlistItems as $wishlist)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100">
            <div class="h-44 bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] overflow-hidden">
                @if($wishlist->item->image_url)
                    <img src="{{ $wishlist->item->image_url }}" alt="{{ $wishlist->item->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl opacity-20"></i>
                    </div>
                @endif
            </div>
            <div class="p-4">
                <span class="inline-block bg-[#f5c518]/20 text-[#7b0f10] text-xs font-bold px-2.5 py-1 rounded-full mb-2">
                    {{ $wishlist->item->category }}
                </span>
                <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">{{ $wishlist->item->title }}</h3>
                <p class="text-gray-500 text-xs mb-1">By {{ $wishlist->item->user->name }}</p>
                <p class="text-gray-500 text-xs mb-3 line-clamp-2">{{ $wishlist->item->description }}</p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <a href="{{ route('items.show', $wishlist->item) }}" class="text-sm text-[#7b0f10] font-bold hover:underline">View Details</a>
                    <form action="{{ route('wishlist.remove', $wishlist->item) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Remove from wishlist">
                            <i class="fas fa-heart text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        {{ $wishlistItems->links() }}
    </div>
    @else
    <div class="text-center py-16 bg-white rounded-xl border border-gray-100 shadow-sm">
        <i class="fas fa-heart text-5xl text-gray-200 mb-4 block"></i>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Your wishlist is empty</h3>
        <p class="text-gray-500 text-sm mb-5">Start adding items you're interested in!</p>
        <a href="{{ route('items.browse') }}" class="inline-block bg-[#7b0f10] text-white font-bold px-5 py-2.5 rounded-lg hover:bg-[#5a0a0b] transition text-sm">
            Browse Items
        </a>
    </div>
    @endif
</div>
@endsection
