@extends('layouts.master')

@section('title', 'My Reviews')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-1">My Reviews & Ratings</h1>
    <p class="text-gray-500 text-sm mb-6">Reviews from other users about your trades</p>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-medium mb-1.5">Overall Rating</p>
            <div class="flex items-center gap-1.5">
                <span class="text-2xl font-bold text-[#7b0f10]">{{ number_format($averageRating, 1) }}</span>
                <div class="flex text-[#f5c518] text-xs">
                    @for($i = 0; $i < 5; $i++)
                        <i class="{{ $i < round($averageRating) ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-1">{{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-medium mb-1.5">Total Reviews</p>
            <p class="text-2xl font-bold text-[#7b0f10]">{{ $totalReviews }}</p>
            <p class="text-xs text-gray-400 mt-1">From different traders</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-medium mb-1.5">Trust Score</p>
            <p class="text-2xl font-bold text-green-600">{{ round(($averageRating / 5) * 100) }}%</p>
            <p class="text-xs text-gray-400 mt-1">Reliability rating</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-xs font-medium mb-1.5">Trader Status</p>
            <p class="text-base font-bold mt-1">
                @if($averageRating >= 4.5)
                    <span class="text-green-600">⭐ Excellent</span>
                @elseif($averageRating >= 3.5)
                    <span class="text-blue-600">⭐ Good</span>
                @elseif($averageRating >= 2.5)
                    <span class="text-yellow-600">⭐ Fair</span>
                @else
                    <span class="text-red-600">⭐ Poor</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-3">
        @forelse($reviews as $review)
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-3">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer->name) }}&background=7b0f10&color=fff"
                         alt="{{ $review->reviewer->name }}" class="w-9 h-9 rounded-full flex-shrink-0">
                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ $review->reviewer->name }}</p>
                        <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex text-[#f5c518] text-xs">
                        @for($j = 0; $j < 5; $j++)
                            <i class="{{ $j < $review->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </div>
                    @if(auth()->user()->id === $review->reviewer_id)
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-bold ml-1 transition">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
            @if($review->comment)
                <p class="text-gray-700 text-sm mb-2">{{ $review->comment }}</p>
            @endif
            <p class="text-xs text-gray-400">Item: <strong class="text-gray-600">{{ $review->item->title }}</strong></p>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-xl border border-gray-100 shadow-sm">
            <i class="fas fa-star text-5xl text-gray-200 mb-4 block"></i>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No reviews yet</h3>
            <p class="text-gray-500 text-sm">Start trading items to receive reviews from other users!</p>
        </div>
        @endforelse
    </div>

    @if($reviews->count() > 0)
    <div class="mt-6 flex justify-center">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
