@extends('layouts.master')

@section('title', 'Write a Review')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#7b0f10] to-[#5a0a0b] px-6 py-8">
            <h1 class="text-3xl font-bold text-white mb-2">Write a Review</h1>
            <p class="text-gray-100">Share your experience trading this item</p>
        </div>

        <div class="p-8">
            <!-- Item Info -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                <h3 class="font-bold text-lg text-gray-900 mb-2">Item: {{ $item->title }}</h3>
                <p class="text-gray-600 mb-2">Seller: <strong>{{ $item->user->name }}</strong></p>
                <p class="text-gray-600">Category: <strong>{{ $item->category }}</strong></p>
            </div>

            <!-- Review Form -->
            <form action="{{ route('reviews.store', $item) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3">Rating</label>
                    <div class="flex items-center space-x-2">
                        <div class="flex gap-2" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ $i == 5 ? 'checked' : '' }}>
                                <span class="text-4xl text-gray-300 peer-checked:text-[#f5c518] transition" data-value="{{ $i }}">★</span>
                            </label>
                            @endfor
                        </div>
                    </div>
                    @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div>
                    <label for="comment" class="block text-sm font-bold text-gray-900 mb-2">Your Review (Optional)</label>
                    <textarea name="comment" id="comment" rows="6" placeholder="Share your experience with this trader and item..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#f5c518] focus:border-transparent @error('comment') border-red-500 @enderror"></textarea>
                    <p class="text-gray-500 text-sm mt-1">Maximum 500 characters</p>
                    @error('comment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-[#7b0f10] text-white font-bold px-6 py-3 rounded-lg hover:bg-[#5a0a0b] transition">
                        Submit Review
                    </button>
                    <a href="{{ route('items.show', $item) }}" class="flex-1 bg-gray-300 text-gray-700 font-bold px-6 py-3 rounded-lg hover:bg-gray-400 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Review Guidelines -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="font-bold text-blue-900 mb-3">Review Guidelines</h3>
        <ul class="text-blue-800 text-sm space-y-2">
            <li>✓ Be honest and fair in your assessment</li>
            <li>✓ Focus on the item condition and seller communication</li>
            <li>✓ Avoid personal attacks or irrelevant comments</li>
            <li>✓ Your review helps maintain community trust</li>
        </ul>
    </div>
</div>

<script>
document.querySelectorAll('#ratingStars input').forEach(radio => {
    radio.addEventListener('change', function() {
        // Update star colors
        document.querySelectorAll('#ratingStars span').forEach((star, index) => {
            if (index + 1 <= this.value) {
                star.classList.add('text-[#f5c518]');
                star.classList.remove('text-gray-300');
            } else {
                star.classList.remove('text-[#f5c518]');
                star.classList.add('text-gray-300');
            }
        });
    });
});

// Initialize stars on page load
const checkedStar = document.querySelector('#ratingStars input:checked');
if (checkedStar) {
    const rating = parseInt(checkedStar.value);
    document.querySelectorAll('#ratingStars span').forEach((star, index) => {
        if (index + 1 <= rating) {
            star.classList.add('text-[#f5c518]');
            star.classList.remove('text-gray-300');
        }
    });
}
</script>
@endsection
