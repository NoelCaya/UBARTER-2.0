@extends('layouts.master')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">My Wishlist</h1>
        <p class="text-gray-600">Items you're interested in</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden border border-gray-200">
            <div class="h-48 bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] flex items-center justify-center">
                <i class="fas fa-image text-white text-4xl opacity-30"></i>
            </div>
            <div class="p-6">
                <div class="inline-block bg-[#f5c518]/20 text-[#7b0f10] text-xs font-bold px-3 py-1 rounded-full mb-2">
                    Engineering
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">Item {{ $i }}</h3>
                <p class="text-gray-600 text-sm mb-4">Brief description of the item you're interested in.</p>
                <div class="flex justify-between items-center">
                    <span class="text-[#7b0f10] font-bold">View Details</span>
                    <button class="text-red-500 hover:text-red-700">
                        <i class="fas fa-heart text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
