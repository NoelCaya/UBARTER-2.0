@extends('layouts.master')

@section('title', 'Trade History - UBarter 2.0')

@section('content')
<style>
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
    }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-pending   { background: #fef3c7; color: #92400e; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
</style>

<div class="px-4 md:px-6 py-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-history mr-2.5 text-[#7b0f10]"></i>Trade History
                </h1>
                <p class="text-gray-500 text-sm mt-1">Track all your barter exchanges and transactions</p>
            </div>
            <div class="flex gap-2">
                <form id="exportForm" method="POST" action="{{ route('trade-history.export') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold border-2 border-[#7b0f10] text-[#7b0f10] hover:bg-[#7b0f10] hover:text-white transition">
                        <i class="fas fa-download mr-2"></i> Export
                    </button>
                </form>
                <button class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-[#7b0f10] text-white hover:bg-[#5a0a0b] transition">
                    <i class="fas fa-plus mr-2"></i> New Trade
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Completed Trades</p>
            <p class="text-3xl font-bold text-green-600 mt-1.5">24</p>
            <p class="text-xs text-gray-400 mt-1">100% success rate</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-[#f5c518]">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Items Given</p>
            <p class="text-3xl font-bold text-[#f5c518] mt-1.5">32</p>
            <p class="text-xs text-gray-400 mt-1">Total items shared</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Items Received</p>
            <p class="text-3xl font-bold text-blue-500 mt-1.5">28</p>
            <p class="text-xs text-gray-400 mt-1">Total items obtained</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-[#7b0f10]">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Waste Diverted</p>
            <p class="text-3xl font-bold text-[#7b0f10] mt-1.5">42.3 kg</p>
            <p class="text-xs text-gray-400 mt-1">Environmental impact</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-5">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <input type="text" placeholder="Search trades..."
                   class="flex-1 px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm">
            <select class="px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 text-sm">
                <option>All Status</option>
                <option>Completed</option>
                <option>Pending</option>
                <option>Cancelled</option>
            </select>
            <select class="px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 text-sm">
                <option>All Time</option>
                <option>This Month</option>
                <option>Last 3 Months</option>
                <option>This Year</option>
            </select>
        </div>
    </div>

    <!-- Trade History Tabs -->
    <div class="mb-4 border-b border-gray-200">
        <div class="flex gap-6">
            <button class="pb-3 px-1 border-b-2 border-[#7b0f10] text-[#7b0f10] font-bold text-sm">All Trades (24)</button>
            <button class="pb-3 px-1 border-b-2 border-transparent text-gray-500 font-semibold text-sm hover:text-[#7b0f10] transition">Sent (12)</button>
            <button class="pb-3 px-1 border-b-2 border-transparent text-gray-500 font-semibold text-sm hover:text-[#7b0f10] transition">Received (12)</button>
        </div>
    </div>

    <!-- Trade Records -->
    <div class="space-y-3">
        <!-- Completed Trade -->
        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-base flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Arduino Uno Kit → Biology Textbook</h3>
                            <p class="text-xs text-gray-500">Traded with Maria Santos · ECE Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 text-xs">
                        <span class="status-badge status-completed">Completed</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-0.5 rounded-full font-bold">2.3 kg saved</span>
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">Both Verified</span>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-gray-400">May 4, 2026</p>
                    <p class="text-base font-bold text-[#7b0f10] mt-0.5">Equal Exchange</p>
                    <button class="mt-2 text-xs text-[#7b0f10] font-bold hover:underline">View Details →</button>
                </div>
            </div>
        </div>

        <!-- Pending Trade -->
        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition border-l-4 border-[#f5c518]">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-base flex-shrink-0">⏳</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Graphing Calculator → Chemistry Lab Manual</h3>
                            <p class="text-xs text-gray-500">Trading with James Reyes · ME Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 text-xs">
                        <span class="status-badge status-pending">Pending Confirmation</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-0.5 rounded-full font-bold">Est. 1.8 kg save</span>
                        <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-bold">Waiting for approval</span>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-gray-400">May 3, 2026</p>
                    <p class="text-base font-bold text-[#7b0f10] mt-0.5">Pending Approval</p>
                    <button class="mt-2 text-xs text-[#7b0f10] font-bold hover:underline">View Details →</button>
                </div>
            </div>
        </div>

        <!-- Completed Trade 2 -->
        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-base flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Nursing Textbook Set → Drawing Materials</h3>
                            <p class="text-xs text-gray-500">Traded with Sofia Garcia · CAS Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 text-xs">
                        <span class="status-badge status-completed">Completed</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-0.5 rounded-full font-bold">3.2 kg saved</span>
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">5 ⭐ Reviews</span>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-gray-400">May 1, 2026</p>
                    <p class="text-base font-bold text-[#7b0f10] mt-0.5">Equal Exchange</p>
                    <button class="mt-2 text-xs text-[#7b0f10] font-bold hover:underline">View Details →</button>
                </div>
            </div>
        </div>

        <!-- Cancelled Trade -->
        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition opacity-60">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-base flex-shrink-0">✕</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm line-through">Laptop Bag → Phone Accessories</h3>
                            <p class="text-xs text-gray-500">Was trading with John Dela Cruz · ME Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 text-xs">
                        <span class="status-badge status-cancelled">Cancelled</span>
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold">Buyer withdrew</span>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-gray-400">April 28, 2026</p>
                    <p class="text-base font-bold text-gray-400 mt-0.5">Cancelled</p>
                    <button class="mt-2 text-xs text-gray-400 font-bold hover:underline">View Details →</button>
                </div>
            </div>
        </div>

        <!-- Completed Trade 3 -->
        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-base flex-shrink-0">✓</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">USB Flash Drives (5x) → Programming Books</h3>
                            <p class="text-xs text-gray-500">Traded with Alex Chen · ECE Dept</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 text-xs">
                        <span class="status-badge status-completed">Completed</span>
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-0.5 rounded-full font-bold">1.5 kg saved</span>
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">5 ⭐ Reviews</span>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-gray-400">April 25, 2026</p>
                    <p class="text-base font-bold text-[#7b0f10] mt-0.5">Equal Exchange</p>
                    <button class="mt-2 text-xs text-[#7b0f10] font-bold hover:underline">View Details →</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Load More -->
    <div class="mt-6 text-center">
        <button class="px-6 py-2.5 border-2 border-[#7b0f10] text-[#7b0f10] font-bold rounded-lg hover:bg-[#7b0f10] hover:text-white transition text-sm">
            Load More Trades
        </button>
    </div>

    <!-- Trade Statistics -->
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Monthly Activity -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-base font-bold text-[#7b0f10] mb-4 flex items-center">
                <i class="fas fa-chart-bar mr-2"></i> Monthly Activity
            </h3>
            <div class="space-y-3">
                @foreach([['April 2026', '8 trades', '100%'], ['May 2026', '6 trades (so far)', '75%'], ['March 2026', '5 trades', '62%']] as $month)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-semibold text-gray-700">{{ $month[0] }}</span>
                        <span class="text-xs font-bold text-[#7b0f10]">{{ $month[1] }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-[#7b0f10] to-[#f5c518] h-1.5 rounded-full" style="width: {{ $month[2] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Trade Partners -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-base font-bold text-[#7b0f10] mb-4 flex items-center">
                <i class="fas fa-users mr-2"></i> Frequent Trade Partners
            </h3>
            <div class="space-y-2">
                @foreach([['Alex Chen', '4 trades'], ['Maria Santos', '3 trades'], ['Sofia Garcia', '2 trades']] as $partner)
                <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($partner[0]) }}&background=7b0f10&color=fff" alt="{{ $partner[0] }}" class="w-9 h-9 rounded-full">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $partner[0] }}</p>
                            <p class="text-xs text-gray-500">{{ $partner[1] }}</p>
                        </div>
                    </div>
                    <span class="text-[#f5c518] font-bold text-sm">5 ⭐</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
