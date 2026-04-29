@extends('layouts.master')

@section('title', 'UBarter 2.0 Dashboard')

@section('content')
<div class="p-6 md:p-8 bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                Mabuhay, {{ auth()->user()->name }}! 🎓
            </h1>
            <div class="flex items-center mt-2 space-x-2">
                <span class="bg-maroon-600 text-white text-xs px-2 py-1 rounded-full font-bold">UB MAIN</span>
                <span class="text-green-600 flex items-center text-sm font-medium">
                    <i class="fas fa-check-circle mr-1"></i> UBmail Verified
                </span>
            </div>
        </div>
        <div class="flex space-x-3">
            <button class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100 transition shadow-sm">
                <i class="fas fa-history mr-2"></i> Trade History
            </button>
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-md">
                <i class="fas fa-plus mr-2"></i> Post Item
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="opacity-80 text-sm font-medium uppercase tracking-wider">Eco Impact</p>
                    <p class="text-3xl font-bold mt-1">14.5 kg</p>
                    <p class="text-xs mt-2 italic">Waste diverted from campus landfills</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase">Trust Score</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">4.9/5.0</p>
                    <div class="flex items-center mt-2 text-yellow-400 space-x-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-gray-400 text-xs ml-2">(24 Peer Reviews)</span>
                    </div>
                </div>
                <div class="bg-yellow-50 p-3 rounded-xl text-yellow-600">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase">Active Proposals</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">3</p>
                    <p class="text-blue-600 text-xs font-bold mt-2 hover:underline cursor-pointer">
                        View Chat Requests →
                    </p>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600 relative">
                    <i class="fas fa-comments text-2xl"></i>
                    <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-blue-900 flex items-center">
                        <i class="fas fa-magic mr-2 text-blue-600"></i> Smart Matches for You
                    </h2>
                    <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">BETA</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-blue-200 shadow-sm flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0 bg-cover" style="background-image: url('https://via.placeholder.com/100')"></div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Drawing Board (A3)</p>
                            <p class="text-xs text-gray-500">Matches your wishlist item!</p>
                            <button class="mt-2 text-xs font-bold text-blue-600">Propose Barter</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Campus Marketplace</h2>
                    <select class="text-sm border-none bg-transparent font-medium text-blue-600 focus:ring-0">
                        <option>All Departments</option>
                        <option>Engineering</option>
                        <option>ICT</option>
                        <option>Nursing</option>
                    </select>
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="p-6 flex items-center gap-4 hover:bg-gray-50 transition cursor-pointer">
                        <img src="https://via.placeholder.com/80" class="w-20 h-20 rounded-xl object-cover shadow-sm">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-purple-100 text-purple-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">ICT</span>
                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">Donation</span>
                            </div>
                            <h3 class="font-bold text-gray-900">Arduino Uno Starter Kit</h3>
                            <p class="text-xs text-gray-500 mt-1">Posted by Noelito • 2 mins ago</p>
                        </div>
                        <button class="p-2 text-gray-400 hover:text-red-500"><i class="far fa-heart text-lg"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border-t-4 border-maroon-600">
                <h3 class="font-bold text-gray-900 mb-2 italic">"It's better if UBarter."</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Remember: Always meet in well-lit campus areas like the **UB Lounge** or **Student Center** for safety!
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4">Trending Requests</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Lab Gowns</span>
                        <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-1 rounded font-bold">42 Requests</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Calculators</span>
                        <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-1 rounded font-bold">28 Requests</span>
                    </div>
                </div>
                <button class="w-full mt-6 py-2 text-sm font-bold text-blue-600 border border-blue-100 rounded-xl hover:bg-blue-50 transition">
                    View Sustainability Leaderboard
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
