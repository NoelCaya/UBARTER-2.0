@extends('layouts.master')

@section('title', 'My Reviews')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">My Reviews & Ratings</h1>
    <p class="text-gray-600 mb-8">Reviews from other users about your trades</p>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-gray-600 text-sm font-medium mb-2">Overall Rating</p>
            <div class="flex items-center space-x-2">
                <span class="text-4xl font-bold text-[#7b0f10]">{{ number_format($averageRating, 1) }}</span>
                <div class="flex text-[#f5c518]">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < round($averageRating))
                            <i class="fas fa-star text-lg"></i>
                        @else
                            <i class="far fa-star text-lg"></i>
                        @endif
                    @endfor
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Based on {{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-gray-600 text-sm font-medium mb-2">Total Reviews</p>
            <p class="text-4xl font-bold text-[#7b0f10]">{{ $totalReviews }}</p>
            <p class="text-xs text-gray-500 mt-2">From different traders</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-gray-600 text-sm font-medium mb-2">Trust Score</p>
            <p class="text-4xl font-bold text-green-600">{{ round(($averageRating / 5) * 100) }}%</p>
            <p class="text-xs text-gray-500 mt-2">Reliability Rating</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <p class="text-gray-600 text-sm font-medium mb-2">Trader Status</p>
            <p class="text-2xl font-bold">
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
    <div class="space-y-4">
        @forelse($reviews as $review)
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer->name) }}&background=7b0f10&color=fff" 
                         alt="{{ $review->reviewer->name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-bold text-gray-900">{{ $review->reviewer->name }}</p>
                        <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex text-[#f5c518]">
                        @for($j = 0; $j < 5; $j++)
                            @if($j < $review->rating)
                                <i class="fas fa-star text-sm"></i>
                            @else
                                <i class="far fa-star text-sm"></i>
                            @endif
                        @endfor
                    </div>
                    @if(auth()->user()->id === $review->reviewer_id)
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold ml-2">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
            @if($review->comment)
                <p class="text-gray-700 mb-2">{{ $review->comment }}</p>
            @endif
            <p class="text-xs text-gray-500">Trading item: <strong>{{ $review->item->title }}</strong></p>
        </div>
        @empty
        <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
            <i class="fas fa-star text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No reviews yet</h3>
            <p class="text-gray-600">Start trading items to receive reviews from other users!</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->count() > 0)
    <div class="mt-8 flex justify-center">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
