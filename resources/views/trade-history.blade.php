@extends('layouts.master')

@section('title', 'Trade History - UBarter 2.0')

@section('content')
<style>
    :root {
        --ub-maroon: #7b0f10;
        --ub-maroon-dark: #5a0a0b;
        --ub-gold: #f5c518;
        --ub-gold-light: #fce8a6;
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
    
    .status-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .trade-item-card {
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .trade-item-card:hover {
        transform: translateY(-2px);
    }
</style>

<div class="p-6 md:p-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-history mr-3 text-[#7b0f10]"></i>Trade History
                </h1>
                <p class="text-gray-600 text-lg">Track all your barter exchanges and transactions</p>
            </div>
            <div class="flex gap-3">
                <form id="exportForm" method="POST" action="{{ route('trade-history.export') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-bold border-2 border-[#7b0f10] text-[#7b0f10] hover:bg-[#7b0f10] hover:text-white transition">
                        <i class="fas fa-download mr-2"></i> Export
                    </button>
                </form>
                <button class="px-6 py-2.5 rounded-lg text-sm font-bold bg-[#7b0f10] text-white hover:bg-[#5a0a0b] transition">
                    <i class="fas fa-plus mr-2"></i> New Trade
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="ub-card bg-white p-6 border-l-4 border-green-600">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Completed Trades</p>
            <p class="text-4xl font-bold text-green-600 mt-2">24</p>
            <p class="text-xs text-gray-600 mt-2">100% success rate</p>
        </div>
        
        <div class="ub-card bg-white p-6 border-l-4 border-[#f5c518]">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Items Given</p>
            <p class="text-4xl font-bold text-[#f5c518] mt-2">32</p>
            <p class="text-xs text-gray-600 mt-2">Total items shared</p>
        </div>
        
        <div class="ub-card bg-white p-6 border-l-4 border-blue-600">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Items Received</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">28</p>
            <p class="text-xs text-gray-600 mt-2">Total items obtained</p>
        </div>
        
        <div class="ub-card bg-white p-6 border-l-4 border-[#7b0f10]">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Waste Diverted</p>
            <p class="text-4xl font-bold text-[#7b0f10] mt-2">42.3 kg</p>
            <p class="text-xs text-gray-600 mt-2">Environmental impact</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="ub-card p-4 mb-6 bg-gray-50">
        <div class="flex flex-col md:flex-row gap-4 items-center">
            <input type="text" placeholder="Search trades..." 
                   class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#f5c518]">
            <select class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#f5c518]">
                <option>All Status</option>
                <option>Completed</option>
                <option>Pending</option>
                <option>Cancelled</option>
            </select>
            <select class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#f5c518]">
                <option>All Time</option>
                <option>This Month</option>
                <option>Last 3 Months</option>
                <option>This Year</option>
            </select>
        </div>
    </div>

    <!-- Trade History Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex gap-8">
            <button class="pb-4 px-2 border-b-4 border-[#7b0f10] text-[#7b0f10] font-bold">
                All Trades (24)
            </button>
            <button class="pb-4 px-2 border-b-4 border-transparent text-gray-600 font-bold hover:text-[#7b0f10]">
                Sent (12)
            </button>
            <button class="pb-4 px-2 border-b-4 border-transparent text-gray-600 font-bold hover:text-[#7b0f10]">
                Received (12)
            </button>
        </div>
    </div>

    <!-- Trade Records -->
    <div class="space-y-4">
        <!-- Completed Trade -->
        <div class="ub-card p-6 hover:shadow-lg transition">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <!-- Left Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-xl">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Arduino Uno Kit → Biology Textbook</h3>
                            <p class="text-sm text-gray-600">Traded with Maria Santos • ECE Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="status-badge status-completed">Completed</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-1 rounded-full font-bold">2.3 kg saved</span>
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold">Both Verified</span>
                    </div>
                </div>

                <!-- Right Info -->
                <div class="text-right">
                    <p class="text-sm text-gray-600">May 4, 2026</p>
                    <p class="text-xl font-bold text-[#7b0f10] mt-1">Equal Exchange</p>
                    <button class="mt-3 text-sm text-[#7b0f10] font-bold hover:underline">
                        View Details →
                    </button>
                </div>
            </div>
        </div>

        <!-- Pending Trade -->
        <div class="ub-card p-6 hover:shadow-lg transition border-l-4 border-[#f5c518]">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <!-- Left Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center text-xl">
                            ⏳
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Graphing Calculator → Chemistry Lab Manual</h3>
                            <p class="text-sm text-gray-600">Trading with James Reyes • ME Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="status-badge status-pending">Pending Confirmation</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-1 rounded-full font-bold">Est. 1.8 kg save</span>
                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-bold">Waiting for approval</span>
                    </div>
                </div>

                <!-- Right Info -->
                <div class="text-right">
                    <p class="text-sm text-gray-600">May 3, 2026</p>
                    <p class="text-xl font-bold text-[#7b0f10] mt-1">Pending Approval</p>
                    <button class="mt-3 text-sm text-[#7b0f10] font-bold hover:underline">
                        View Details →
                    </button>
                </div>
            </div>
        </div>

        <!-- Completed Trade -->
        <div class="ub-card p-6 hover:shadow-lg transition">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <!-- Left Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-xl">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Nursing Textbook Set → Drawing Materials</h3>
                            <p class="text-sm text-gray-600">Traded with Sofia Garcia • CAS Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="status-badge status-completed">Completed</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-1 rounded-full font-bold">3.2 kg saved</span>
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold">5 ⭐ Reviews</span>
                    </div>
                </div>

                <!-- Right Info -->
                <div class="text-right">
                    <p class="text-sm text-gray-600">May 1, 2026</p>
                    <p class="text-xl font-bold text-[#7b0f10] mt-1">Equal Exchange</p>
                    <button class="mt-3 text-sm text-[#7b0f10] font-bold hover:underline">
                        View Details →
                    </button>
                </div>
            </div>
        </div>

        <!-- Cancelled Trade -->
        <div class="ub-card p-6 hover:shadow-lg transition opacity-75">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <!-- Left Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center text-xl">
                            ✕
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 line-through">Laptop Bag → Phone Accessories</h3>
                            <p class="text-sm text-gray-600">Was trading with John Dela Cruz • ME Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="status-badge status-cancelled">Cancelled</span>
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full font-bold">Buyer withdrew</span>
                    </div>
                </div>

                <!-- Right Info -->
                <div class="text-right">
                    <p class="text-sm text-gray-600">April 28, 2026</p>
                    <p class="text-xl font-bold text-gray-500 mt-1">Cancelled</p>
                    <button class="mt-3 text-sm text-gray-500 font-bold hover:underline">
                        View Details →
                    </button>
                </div>
            </div>
        </div>

        <!-- More Completed Trades -->
        <div class="ub-card p-6 hover:shadow-lg transition">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <!-- Left Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-xl">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">USB Flash Drives (5x) → Programming Books</h3>
                            <p class="text-sm text-gray-600">Traded with Alex Chen • ECE Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="status-badge status-completed">Completed</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-1 rounded-full font-bold">1.5 kg saved</span>
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold">5 ⭐ Reviews</span>
                    </div>
                </div>

                <!-- Right Info -->
                <div class="text-right">
                    <p class="text-sm text-gray-600">April 25, 2026</p>
                    <p class="text-xl font-bold text-[#7b0f10] mt-1">Equal Exchange</p>
                    <button class="mt-3 text-sm text-[#7b0f10] font-bold hover:underline">
                        View Details →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Load More -->
    <div class="mt-8 text-center">
        <button class="px-8 py-3 border-2 border-[#7b0f10] text-[#7b0f10] font-bold rounded-lg hover:bg-[#7b0f10] hover:text-white transition">
            Load More Trades
        </button>
    </div>

    <!-- Trade Statistics -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Monthly Activity -->
        <div class="ub-card p-6">
            <h3 class="text-xl font-bold text-[#7b0f10] mb-4">
                <i class="fas fa-chart-bar mr-2"></i> Monthly Activity
            </h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-700">April 2026</span>
                        <span class="text-sm font-bold text-[#7b0f10]">8 trades</span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#7b0f10] to-[#f5c518] h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-700">May 2026</span>
                        <span class="text-sm font-bold text-[#7b0f10]">6 trades (so far)</span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#7b0f10] to-[#f5c518] h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-700">March 2026</span>
                        <span class="text-sm font-bold text-[#7b0f10]">5 trades</span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#7b0f10] to-[#f5c518] h-2 rounded-full" style="width: 62%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trade Partners -->
        <div class="ub-card p-6">
            <h3 class="text-xl font-bold text-[#7b0f10] mb-4">
                <i class="fas fa-users mr-2"></i> Frequent Trade Partners
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Alex+Chen&background=7b0f10&color=fff" alt="Alex Chen" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold text-gray-900">Alex Chen</p>
                            <p class="text-xs text-gray-600">4 trades</p>
                        </div>
                    </div>
                    <span class="text-[#f5c518] font-bold">5 ⭐</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Maria+Santos&background=7b0f10&color=fff" alt="Maria Santos" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold text-gray-900">Maria Santos</p>
                            <p class="text-xs text-gray-600">3 trades</p>
                        </div>
                    </div>
                    <span class="text-[#f5c518] font-bold">5 ⭐</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Sofia+Garcia&background=7b0f10&color=fff" alt="Sofia Garcia" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold text-gray-900">Sofia Garcia</p>
                            <p class="text-xs text-gray-600">2 trades</p>
                        </div>
                    </div>
                    <span class="text-[#f5c518] font-bold">5 ⭐</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
