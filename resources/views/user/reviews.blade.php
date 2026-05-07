@extends('layouts.master')

@section('title', 'My Reviews')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">My Reviews & Ratings</h1>
    <p class="text-gray-600 mb-8">Reviews from other users about your trades</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Stats -->
        <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <p class="text-gray-600 text-sm font-medium mb-2">Overall Rating</p>
                <div class="flex items-center space-x-2">
                    <span class="text-4xl font-bold text-[#7b0f10]">4.8</span>
                    <div class="flex text-[#f5c518]">
                        @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star text-lg"></i>
                        @endfor
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Based on 24 reviews</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <p class="text-gray-600 text-sm font-medium mb-2">Total Reviews</p>
                <p class="text-4xl font-bold text-[#7b0f10]">24</p>
                <p class="text-xs text-gray-500 mt-2">Positive: 23</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <p class="text-gray-600 text-sm font-medium mb-2">Trust Score</p>
                <p class="text-4xl font-bold text-green-600">92%</p>
                <p class="text-xs text-gray-500 mt-2">Excellent</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <p class="text-gray-600 text-sm font-medium mb-2">Recommend Rate</p>
                <p class="text-4xl font-bold text-blue-600">100%</p>
                <p class="text-xs text-gray-500 mt-2">Would trade again</p>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="lg:col-span-3">
            <div class="space-y-4">
                @for($i = 1; $i <= 5; $i++)
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=User {{ $i }}&background=7b0f10&color=fff" 
                                 alt="User" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-bold text-gray-900">User {{ $i }}</p>
                                <p class="text-xs text-gray-500">Engineering Department</p>
                            </div>
                        </div>
                        <div class="flex text-[#f5c518]">
                            @for($j = 0; $j < 5; $j++)
                            <i class="fas fa-star text-sm"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 mb-2">Great trader! Item was exactly as described. Very responsive and professional. Would recommend for any future trades.</p>
                    <p class="text-xs text-gray-500">Traded on {{ date('M d, Y', strtotime("-$i days")) }}</p>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
