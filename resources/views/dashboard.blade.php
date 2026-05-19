@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="px-4 md:px-6 py-6 max-w-7xl mx-auto">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Mabuhay, <span class="text-[#7b0f10]">{{ auth()->user()->name }}</span>! 🎓
            </h1>
            <div class="flex items-center mt-2 space-x-3">
                <span class="bg-[#7b0f10] text-white text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wide">UB MAIN</span>
                <span class="text-green-600 flex items-center text-xs font-semibold">
                    <i class="fas fa-check-circle mr-1.5"></i> UBmail Verified
                </span>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('items.browse') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-[#7b0f10] text-[#7b0f10] rounded-lg text-sm font-bold hover:bg-[#7b0f10] hover:text-white transition shadow-sm">
                <i class="fas fa-shopping-bag mr-2"></i> Browse
            </a>
            <a href="{{ route('trade-history') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-[#7b0f10] text-[#7b0f10] rounded-lg text-sm font-bold hover:bg-[#7b0f10] hover:text-white transition shadow-sm">
                <i class="fas fa-history mr-2"></i> Trades
            </a>
            <a href="{{ route('items.create') }}" class="inline-flex items-center px-4 py-2 bg-[#f5c518] text-[#7b0f10] rounded-lg text-sm font-bold shadow-sm hover:bg-[#e6b800] transition">
                <i class="fas fa-plus mr-2"></i> Post Item
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <!-- Eco Impact -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-80">Eco Impact</p>
                    <p class="text-3xl font-bold mt-2">14.5 kg</p>
                    <p class="text-xs mt-1.5 opacity-90">Waste diverted from landfills</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-white/20 flex justify-between text-xs opacity-75">
                <span><strong>+2.3 kg</strong> this week</span>
                <span>Rank: <strong>#12</strong></span>
            </div>
        </div>

        <!-- Trust Score -->
        <div class="bg-white rounded-xl p-5 border-l-4 border-[#f5c518] shadow-sm">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Trust Score</p>
            <p class="text-3xl font-bold text-[#7b0f10] mt-2">4.9<span class="text-lg text-gray-400">/5.0</span></p>
            <div class="flex items-center mt-2">
                <div class="flex text-[#f5c518] space-x-0.5">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="text-gray-500 text-xs ml-2">(24 reviews)</span>
            </div>
        </div>

        <!-- Active Proposals -->
        <div class="bg-white rounded-xl p-5 border-l-4 border-[#7b0f10] shadow-sm">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Active Proposals</p>
            <p class="text-3xl font-bold text-[#7b0f10] mt-2">3</p>
            <a href="{{ route('chat.index') }}" class="text-[#7b0f10] text-xs font-bold mt-2 inline-block hover:underline">
                View Chat Requests →
            </a>
        </div>
    </div>

    <!-- Smart Matches -->
    <div class="bg-gradient-to-r from-[#f5c518]/10 to-[#7b0f10]/5 border border-[#f5c518]/40 rounded-xl p-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-[#7b0f10] flex items-center">
                <i class="fas fa-wand-magic-sparkles mr-2 text-[#f5c518]"></i> Smart Matches for You
            </h2>
            <span class="text-xs font-bold bg-[#7b0f10] text-white px-2.5 py-1 rounded-full">BETA</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([
                ['Drawing Board (A3)', 'Matches your wishlist item!', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=300&h=150&fit=crop'],
                ['Laptop Stand', 'Great for your setup!', 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=300&h=150&fit=crop'],
                ['USB Hub (7-port)', 'Perfect match for your needs!', 'https://images.unsplash.com/photo-1625895197185-efcec01cffe0?w=300&h=150&fit=crop'],
            ] as $match)
            <div class="bg-white rounded-lg border border-[#f5c518]/50 p-4 hover:shadow-md transition">
                <div class="aspect-video bg-gray-100 rounded-lg mb-3 overflow-hidden">
                    <img src="{{ $match[2] }}" class="w-full h-full object-cover" alt="{{ $match[0] }}">
                </div>
                <p class="font-bold text-gray-900 text-sm mb-1">{{ $match[0] }}</p>
                <p class="text-xs text-gray-500 mb-3">{{ $match[1] }}</p>
                <button class="text-xs font-bold text-[#7b0f10] hover:text-[#f5c518] transition">Propose Barter →</button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Campus Marketplace -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Campus Marketplace</h2>
            <select class="text-sm border border-gray-200 bg-white text-gray-700 px-3 py-1.5 rounded-lg focus:ring-2 focus:ring-[#f5c518] focus:outline-none">
                <option>All Departments</option>
                <option>Engineering</option>
                <option>ICT</option>
                <option>Nursing</option>
                <option>Business</option>
            </select>
        </div>
        <div class="divide-y divide-gray-50">
            <div class="px-5 py-4 flex items-center gap-4 hover:bg-gray-50 transition cursor-pointer group">
                <img src="https://images.unsplash.com/photo-1553406830-ef2513450d76?w=80&h=80&fit=crop" class="w-16 h-16 rounded-lg object-cover shadow-sm flex-shrink-0" alt="Arduino Uno Starter Kit">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] text-xs px-2 py-0.5 rounded-full font-bold">ICT</span>
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-bold">Donation</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm truncate">Arduino Uno Starter Kit</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Posted by Noelito • 2 mins ago</p>
                </div>
                <button class="p-2 text-gray-300 hover:text-red-400 transition flex-shrink-0">
                    <i class="far fa-heart text-lg"></i>
                </button>
            </div>
            <div class="px-5 py-4 flex items-center gap-4 hover:bg-gray-50 transition cursor-pointer group">
                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=80&h=80&fit=crop" class="w-16 h-16 rounded-lg object-cover shadow-sm flex-shrink-0" alt="Nursing Textbook">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="bg-[#7b0f10]/10 text-[#7b0f10] text-xs px-2 py-0.5 rounded-full font-bold">Nursing</span>
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-bold">Trade</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm truncate">Nursing Textbook (2023)</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Posted by Maria Santos • 1 hour ago</p>
                </div>
                <button class="p-2 text-gray-300 hover:text-red-400 transition flex-shrink-0">
                    <i class="far fa-heart text-lg"></i>
                </button>
            </div>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 text-center">
            <a href="{{ route('items.browse') }}" class="text-sm font-bold text-[#7b0f10] hover:underline">View All Items →</a>
        </div>
    </div>

    <!-- Bottom Row: Quote + Eco Leaders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <!-- UBarter Quote -->
        <div class="bg-gradient-to-br from-[#7b0f10] to-[#5a0a0b] text-white rounded-xl p-5">
            <h3 class="font-bold text-lg mb-2 italic">"It's better if UBarter."</h3>
            <p class="text-sm leading-relaxed opacity-90 mb-4">
                Always meet in well-lit campus areas like the <strong>UB Lounge</strong> or <strong>Student Center</strong> for safety. Trust is built on transparency.
            </p>
            <div class="pt-4 border-t border-white/20 flex items-center space-x-2 text-xs">
                <i class="fas fa-shield-alt text-[#f5c518]"></i>
                <span>Safety verified by UB Admin</span>
            </div>
        </div>

        <!-- Eco Leaders -->
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-[#7b0f10] text-base flex items-center">
                    <i class="fas fa-leaf mr-2 text-green-600"></i> Eco Leaders
                </h3>
                <span class="text-[#f5c518] text-xs font-bold bg-[#7b0f10]/10 px-2.5 py-1 rounded-full">This Week</span>
            </div>
            <div class="space-y-2">
                @foreach([['🥇', 'Alex Chen', 'ECE', '28.5 kg', 'from-[#f5c518]/10'], ['🥈', 'Maria Santos', 'BSN', '24.0 kg', 'from-gray-50'], ['🥉', 'James Reyes', 'IT', '22.3 kg', 'from-gray-50']] as $leader)
                <div class="flex items-center justify-between px-3 py-2 bg-gradient-to-r {{ $leader[4] }} to-transparent rounded-lg">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">{{ $leader[0] }}</span>
                        <div>
                            <p class="font-bold text-sm text-gray-900">{{ $leader[1] }}</p>
                            <p class="text-xs text-gray-500">{{ $leader[2] }} • {{ $leader[3] }} saved</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('sustainability-leaderboard') }}" class="block w-full py-2 text-center text-sm font-bold text-[#7b0f10] border border-[#7b0f10] rounded-lg hover:bg-[#7b0f10] hover:text-white transition">
                    View Full Leaderboard
                </a>
            </div>
        </div>
    </div>

    <!-- Barter & Donation Browse -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 max-w-3xl">
        <!-- Barter Module -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-3 bg-gradient-to-r from-[#7b0f10] to-[#9b1a1b]">
                <h2 class="text-base font-bold text-white flex items-center">
                    <i class="fas fa-exchange-alt mr-2 text-[#f5c518]"></i> Barter Items
                </h2>
                <p class="text-white/70 text-xs mt-0.5">Items available for trading</p>
            </div>
            <div class="p-4 grid grid-cols-2 gap-3">
                @foreach([
                    ['Mechanical Keyboard RGB', 'Good condition', 'Alex Chen', '3h ago', 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&h=100&fit=crop'],
                    ['Wireless Mouse Logitech', 'Like new', 'Maria Santos', '5h ago', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200&h=100&fit=crop'],
                ] as $item)
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-[#f5c518] hover:shadow-md transition cursor-pointer">
                    <div class="relative">
                        <img src="{{ $item[4] }}" class="w-full object-cover" style="height:80px;" alt="{{ $item[0] }}">
                        <span class="absolute top-1.5 right-1.5 bg-[#7b0f10] text-white text-xs font-bold px-1.5 py-0.5 rounded" style="font-size:9px;">BARTER</span>
                    </div>
                    <div class="p-2">
                        <h3 class="font-bold text-xs text-gray-900 line-clamp-1">{{ $item[0] }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $item[1] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item[2] }} • {{ $item[3] }}</p>
                        <button class="w-full mt-2 text-white text-xs font-bold py-1.5 rounded transition" style="background-color:#7b0f10;font-size:10px;" onmouseover="this.style.backgroundColor='#5a0a0b'" onmouseout="this.style.backgroundColor='#7b0f10'">
                            Propose Trade
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Donation Module -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-3 bg-gradient-to-r from-green-600 to-green-700">
                <h2 class="text-base font-bold text-white flex items-center">
                    <i class="fas fa-gift mr-2"></i> Free Donations
                </h2>
                <p class="text-white/70 text-xs mt-0.5">Items available for free</p>
            </div>
            <div class="p-4 grid grid-cols-2 gap-3">
                @foreach([
                    ['Canvas Backpack', 'Excellent condition', 'Sarah Lee', '2h ago', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=200&h=100&fit=crop'],
                    ['LED Desk Lamp', 'Bright & adjustable', 'John Doe', '4h ago', 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=200&h=100&fit=crop'],
                ] as $item)
                <div class="border border-green-100 rounded-lg overflow-hidden hover:border-green-400 hover:shadow-md transition cursor-pointer">
                    <div class="relative">
                        <img src="{{ $item[4] }}" class="w-full object-cover" style="height:80px;" alt="{{ $item[0] }}">
                        <span class="absolute top-1.5 right-1.5 bg-green-600 text-white text-xs font-bold px-1.5 py-0.5 rounded" style="font-size:9px;">FREE</span>
                    </div>
                    <div class="p-2">
                        <h3 class="font-bold text-xs text-gray-900 line-clamp-1">{{ $item[0] }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $item[1] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item[2] }} • {{ $item[3] }}</p>
                        <button class="w-full mt-2 bg-green-600 text-white text-xs font-bold py-1.5 rounded hover:bg-green-700 transition" style="font-size:10px;">
                            Claim Item
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
