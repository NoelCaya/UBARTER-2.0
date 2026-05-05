@extends('layouts.master')

@section('title', 'UBarter 2.0 Dashboard')

@section('content')
<style>
    :root {
        --ub-maroon: #7b0f10;
        --ub-maroon-dark: #5a0a0b;
        --ub-gold: #f5c518;
        --ub-gold-light: #fce8a6;
        --ub-cream: #f5f3ef;
    }
    
    .ub-gradient-maroon-gold {
        background: linear-gradient(135deg, var(--ub-maroon) 0%, #9b1a1b 100%);
    }
    
    .ub-btn-gold {
        background: var(--ub-gold);
        color: var(--ub-maroon);
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .ub-btn-gold:hover {
        background: #f5c518;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 197, 24, 0.3);
    }
    
    .ub-btn-maroon {
        background: var(--ub-maroon);
        color: white;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .ub-btn-maroon:hover {
        background: var(--ub-maroon-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(123, 15, 16, 0.3);
    }
    
    .ub-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .ub-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
</style>

<div class="p-6 md:p-12 bg-gradient-to-b from-gray-50 to-white min-h-screen" style="max-width: 1400px; margin: 0 auto;">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h1 class="text-6xl font-bold text-gray-900 tracking-tight mb-3">
                Mabuhay, <span class="text-[#7b0f10]">{{ auth()->user()->name }}</span>! 🎓
            </h1>
            <div class="flex items-center mt-4 space-x-4">
                <span class="bg-[#7b0f10] text-white text-xs px-4 py-1.5 rounded-full font-bold uppercase tracking-wide">UB MAIN</span>
                <span class="text-green-600 flex items-center text-sm font-semibold">
                    <i class="fas fa-check-circle mr-2"></i> UBmail Verified
                </span>
            </div>
        </div>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('trade-history') }}" class="bg-white border-2 border-[#7b0f10] text-[#7b0f10] px-8 py-3 rounded-lg text-sm font-bold hover:bg-[#7b0f10] hover:text-white transition shadow-sm">
                <i class="fas fa-history mr-2"></i> Trade History
            </a>
            <button class="ub-btn-gold px-8 py-3 rounded-lg text-sm font-bold shadow-md">
                <i class="fas fa-plus mr-2"></i> Post Item
            </button>
        </div>
    </div>

    <!-- Stats Grid - Full Width -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Eco Impact Card -->
        <div class="ub-card bg-gradient-to-br from-green-500 to-green-600 text-white p-8">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="opacity-80 text-xs font-bold uppercase tracking-widest">Eco Impact</p>
                    <p class="text-5xl font-bold mt-4">14.5 kg</p>
                    <p class="text-sm mt-3 opacity-90">Waste diverted from campus landfills</p>
                </div>
                <div class="bg-white/20 p-5 rounded-2xl backdrop-blur-sm flex-shrink-0">
                    <i class="fas fa-leaf text-4xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-white/20 flex justify-between text-xs opacity-75">
                <span><strong>+2.3 kg</strong> this week</span>
                <span>Rank: <strong>#12</strong></span>
            </div>
        </div>

        <!-- Trust Score Card -->
        <div class="ub-card bg-white p-8 border-l-4 border-[#f5c518]">
            <p class="text-gray-600 text-xs font-bold uppercase tracking-widest">Trust Score</p>
            <p class="text-5xl font-bold text-[#7b0f10] mt-4">4.9<span class="text-2xl text-gray-400">/5.0</span></p>
            <div class="flex items-center mt-4">
                <div class="flex text-[#f5c518] space-x-1">
                    <i class="fas fa-star text-2xl"></i>
                    <i class="fas fa-star text-2xl"></i>
                    <i class="fas fa-star text-2xl"></i>
                    <i class="fas fa-star text-2xl"></i>
                    <i class="fas fa-star text-2xl"></i>
                </div>
                <span class="text-gray-500 text-xs ml-4 font-semibold">(24 reviews)</span>
            </div>
        </div>

        <!-- Active Proposals Card -->
        <div class="ub-card bg-white p-8 border-l-4 border-[#7b0f10]">
            <p class="text-gray-600 text-xs font-bold uppercase tracking-widest">Active Proposals</p>
            <p class="text-5xl font-bold text-[#7b0f10] mt-4">3</p>
            <p class="text-[#7b0f10] text-xs font-bold mt-4 hover:underline cursor-pointer">
                View Chat Requests →
            </p>
        </div>
    </div>

    <!-- Smart Matches Section - Full Width -->
    <div class="ub-card bg-gradient-to-r from-[#f5c518]/10 to-[#7b0f10]/5 border-l-4 border-[#f5c518] p-8 mb-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-[#7b0f10] flex items-center">
                <i class="fas fa-wand-magic-sparkles mr-3 text-[#f5c518] text-4xl"></i> Smart Matches for You
            </h2>
            <span class="text-xs font-bold text-[#f5c518] bg-[#7b0f10] px-4 py-2 rounded-full text-white">BETA</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg border-2 border-[#f5c518] shadow-sm hover:shadow-lg transition">
                <div class="aspect-video bg-gray-200 rounded-lg mb-4 bg-cover" style="background-image: url('https://via.placeholder.com/300x150')"></div>
                <p class="text-lg font-bold text-gray-900 mb-2">Drawing Board (A3)</p>
                <p class="text-sm text-gray-600 mb-4">Matches your wishlist item!</p>
                <button class="text-sm font-bold text-[#7b0f10] hover:text-[#f5c518] transition">
                    Propose Barter →
                </button>
            </div>
        </div>
    </div>

    <!-- Campus Marketplace - Full Width -->
    <div class="ub-card overflow-hidden mb-12">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-3xl font-bold text-gray-900">Campus Marketplace</h2>
            <select class="text-sm border border-[#7b0f10] bg-white text-[#7b0f10] px-4 py-2 rounded-lg font-medium focus:ring-2 focus:ring-[#f5c518]">
                <option>All Departments</option>
                <option>Engineering</option>
                <option>ICT</option>
                <option>Nursing</option>
                <option>Business</option>
            </select>
        </div>
        <div class="divide-y divide-gray-100">
            <!-- Marketplace Item -->
            <div class="p-8 flex items-start gap-6 hover:bg-[#f5c518]/5 transition cursor-pointer group">
                <img src="https://via.placeholder.com/100" class="w-24 h-24 rounded-lg object-cover shadow-sm group-hover:shadow-md transition flex-shrink-0">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] text-xs px-3 py-1 rounded-full font-bold uppercase">ICT</span>
                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold uppercase">Donation</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Arduino Uno Starter Kit</h3>
                    <p class="text-sm text-gray-600">Posted by Noelito • 2 mins ago</p>
                </div>
                <button class="p-3 text-gray-400 hover:text-[#f5c518] transition">
                    <i class="far fa-heart text-2xl"></i>
                </button>
            </div>
            
            <!-- Another Item -->
            <div class="p-8 flex items-start gap-6 hover:bg-[#f5c518]/5 transition cursor-pointer group">
                <img src="https://via.placeholder.com/100" class="w-24 h-24 rounded-lg object-cover shadow-sm group-hover:shadow-md transition flex-shrink-0">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] text-xs px-3 py-1 rounded-full font-bold uppercase">Nursing</span>
                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold uppercase">Trade</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Nursing Textbook (2023)</h3>
                    <p class="text-sm text-gray-600">Posted by Maria Santos • 1 hour ago</p>
                </div>
                <button class="p-3 text-gray-400 hover:text-[#f5c518] transition">
                    <i class="far fa-heart text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6 text-center border-t border-gray-100 bg-gray-50">
            <a href="#" class="text-sm font-bold text-[#7b0f10] hover:text-[#f5c518] transition">
                View All Items →
            </a>
        </div>
    </div>

    <!-- Bottom Section: 2 Cards Side by Side -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- UBarter Quote -->
        <div class="ub-card bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] text-white p-8">
            <h3 class="font-bold text-2xl mb-4 italic">"It's better if UBarter."</h3>
            <p class="text-base leading-relaxed opacity-90 mb-6">
                Remember: Always meet in well-lit campus areas like the <strong>UB Lounge</strong> or <strong>Student Center</strong> for safety! Trust is built on transparency.
            </p>
            <div class="pt-6 border-t border-white/20 flex items-center space-x-2">
                <i class="fas fa-shield-alt text-[#f5c518] text-lg"></i>
                <span class="text-sm">Safety verified by UB Admin</span>
            </div>
        </div>

        <!-- Sustainability Leaderboard Preview -->
        <div class="ub-card p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-[#7b0f10] text-2xl flex items-center">
                    <i class="fas fa-leaf mr-3 text-green-600 text-3xl"></i> Eco Leaders
                </h3>
                <span class="text-[#f5c518] text-xs font-bold bg-[#7b0f10]/10 px-3 py-1 rounded-full">This Week</span>
            </div>
            <div class="space-y-4">
                <!-- Rank 1 -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-[#f5c518]/10 to-transparent rounded-lg">
                    <div class="flex items-center gap-4">
                        <span class="w-10 h-10 bg-[#f5c518] text-[#7b0f10] rounded-full flex items-center justify-center font-bold text-lg">🥇</span>
                        <div>
                            <p class="font-bold text-base text-gray-900">Alex Chen</p>
                            <p class="text-xs text-gray-600">ECE • 28.5 kg saved</p>
                        </div>
                    </div>
                    <span class="text-[#f5c518] font-bold text-base">+8.2 kg</span>
                </div>
                
                <!-- Rank 2 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">🥈</span>
                        <div>
                            <p class="font-bold text-base text-gray-900">Maria Santos</p>
                            <p class="text-xs text-gray-600">BSN • 24.0 kg saved</p>
                        </div>
                    </div>
                    <span class="text-gray-600 font-bold text-base">+5.1 kg</span>
                </div>
                
                <!-- Rank 3 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">🥉</span>
                        <div>
                            <p class="font-bold text-base text-gray-900">James Reyes</p>
                            <p class="text-xs text-gray-600">IT • 22.3 kg saved</p>
                        </div>
                    </div>
                    <span class="text-gray-600 font-bold text-base">+3.9 kg</span>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="{{ route('sustainability-leaderboard') }}" class="w-full py-3 text-center text-sm font-bold text-[#7b0f10] border border-[#7b0f10] rounded-lg hover:bg-[#7b0f10] hover:text-white transition">
                    View Full Leaderboard
                </a>
            </div>
        </div>
    </div>

    <!-- OLD GRID THAT WAS CRAMPED - COMMENTED OUT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 hidden">
        <!-- Left Column (Main Content) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Smart Matches Section -->
            <div class="ub-card bg-gradient-to-r from-[#f5c518]/10 to-[#7b0f10]/5 border-l-4 border-[#f5c518] p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-xl font-bold text-[#7b0f10] flex items-center">
                        <i class="fas fa-wand-magic-sparkles mr-3 text-[#f5c518]"></i> Smart Matches for You
                    </h2>
                    <span class="text-xs font-bold text-[#f5c518] bg-[#7b0f10] px-3 py-1 rounded-full text-white">BETA</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg border-2 border-[#f5c518] shadow-sm flex items-center space-x-4 hover:shadow-md transition">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0 bg-cover" style="background-image: url('https://via.placeholder.com/100')"></div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900">Drawing Board (A3)</p>
                            <p class="text-xs text-gray-600">Matches your wishlist item!</p>
                            <button class="mt-2 text-xs font-bold text-[#7b0f10] hover:text-[#f5c518] transition">
                                Propose Barter →
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campus Marketplace -->
            <div class="ub-card overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-2xl font-bold text-gray-900">Campus Marketplace</h2>
                    <select class="text-sm border border-[#7b0f10] bg-white text-[#7b0f10] px-3 py-2 rounded-lg font-medium focus:ring-2 focus:ring-[#f5c518]">
                        <option>All Departments</option>
                        <option>Engineering</option>
                        <option>ICT</option>
                        <option>Nursing</option>
                        <option>Business</option>
                    </select>
                </div>
                <div class="divide-y divide-gray-100">
                    <!-- Marketplace Item -->
                    <div class="p-6 flex items-center gap-4 hover:bg-[#f5c518]/5 transition cursor-pointer group">
                        <img src="https://via.placeholder.com/80" class="w-20 h-20 rounded-lg object-cover shadow-sm group-hover:shadow-md transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-[#7b0f10]/10 text-[#7b0f10] text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">ICT</span>
                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">Donation</span>
                            </div>
                            <h3 class="font-bold text-gray-900">Arduino Uno Starter Kit</h3>
                            <p class="text-xs text-gray-600 mt-1">Posted by Noelito • 2 mins ago</p>
                        </div>
                        <button class="p-2 text-gray-400 hover:text-[#f5c518] transition">
                            <i class="far fa-heart text-lg"></i>
                        </button>
                    </div>
                    
                    <!-- Another Item -->
                    <div class="p-6 flex items-center gap-4 hover:bg-[#f5c518]/5 transition cursor-pointer group">
                        <img src="https://via.placeholder.com/80" class="w-20 h-20 rounded-lg object-cover shadow-sm group-hover:shadow-md transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-[#7b0f10]/10 text-[#7b0f10] text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">Nursing</span>
                                <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">Trade</span>
                            </div>
                            <h3 class="font-bold text-gray-900">Nursing Textbook (2023)</h3>
                            <p class="text-xs text-gray-600 mt-1">Posted by Maria Santos • 1 hour ago</p>
                        </div>
                        <button class="p-2 text-gray-400 hover:text-[#f5c518] transition">
                            <i class="far fa-heart text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4 text-center border-t border-gray-100 bg-gray-50">
                    <a href="#" class="text-sm font-bold text-[#7b0f10] hover:text-[#f5c518] transition">
                        View All Items →
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- UBarter Quote -->
            <div class="ub-card bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] text-white p-6">
                <h3 class="font-bold text-lg mb-3 italic">"It's better if UBarter."</h3>
                <p class="text-sm leading-relaxed opacity-90">
                    Remember: Always meet in well-lit campus areas like the <strong>UB Lounge</strong> or <strong>Student Center</strong> for safety! Trust is built on transparency.
                </p>
                <div class="mt-4 pt-4 border-t border-white/20 flex space-x-2">
                    <i class="fas fa-shield-alt text-[#f5c518]"></i>
                    <span class="text-xs">Safety verified by UB Admin</span>
                </div>
            </div>

            <!-- Sustainability Leaderboard Preview -->
            <div class="ub-card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-[#7b0f10] text-lg flex items-center">
                        <i class="fas fa-leaf mr-2 text-green-600"></i> Eco Leaders
                    </h3>
                    <span class="text-[#f5c518] text-xs font-bold">This Week</span>
                </div>
                <div class="space-y-3">
                    <!-- Rank 1 -->
                    <div class="flex items-center justify-between p-3 bg-gradient-to-r from-[#f5c518]/10 to-transparent rounded-lg">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-[#f5c518] text-[#7b0f10] rounded-full flex items-center justify-center font-bold text-sm">🥇</span>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Alex Chen</p>
                                <p class="text-xs text-gray-600">ECE • 28.5 kg saved</p>
                            </div>
                        </div>
                        <span class="text-[#f5c518] font-bold text-sm">+8.2 kg</span>
                    </div>
                    
                    <!-- Rank 2 -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🥈</span>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Maria Santos</p>
                                <p class="text-xs text-gray-600">BSN • 24.0 kg saved</p>
                            </div>
                        </div>
                        <span class="text-gray-600 font-bold text-sm">+5.1 kg</span>
                    </div>
                    
                    <!-- Rank 3 -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🥉</span>
                            <div>
                                <p class="font-bold text-sm text-gray-900">James Reyes</p>
                                <p class="text-xs text-gray-600">IT • 22.3 kg saved</p>
                            </div>
                        </div>
                        <span class="text-gray-600 font-bold text-sm">+3.9 kg</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('sustainability-leaderboard') }}" class="w-full py-2 text-center text-sm font-bold text-[#7b0f10] border border-[#7b0f10] rounded-lg hover:bg-[#7b0f10] hover:text-white transition">
                        View Full Leaderboard
                    </a>
                </div>
