@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Shopee-style product card */
    .product-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        transition: box-shadow 0.2s, transform 0.2s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.14);
        transform: translateY(-2px);
    }
    .product-card .img-wrap {
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        background: #f5f5f5;
        position: relative;
        flex-shrink: 0;
    }
    .product-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .product-card .card-body {
        padding: 8px 8px 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-card .card-title {
        font-size: 0.78rem;
        font-weight: 600;
        color: #222;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
    }
    .product-card .card-meta {
        font-size: 0.68rem;
        color: #999;
        margin-top: auto;
    }
    .product-card .card-badge {
        position: absolute;
        top: 6px;
        left: 6px;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .product-card .card-condition {
        position: absolute;
        bottom: 6px;
        right: 6px;
        font-size: 0.6rem;
        font-weight: 700;
        background: rgba(0,0,0,0.55);
        color: #fff;
        padding: 2px 5px;
        border-radius: 3px;
    }

    /* Action buttons */
    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 20px 16px;
        background: #fff;
        border: 1.5px solid #e5e7eb;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.85rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        flex: 1;
        min-width: 0;
        cursor: pointer;
    }
    .action-btn:hover {
        border-color: #7b0f10;
        color: #7b0f10;
        background: #fff8f8;
        box-shadow: 0 6px 20px rgba(123,15,16,0.15);
        transform: translateY(-3px);
        text-decoration: none;
    }
    .action-btn:active {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(123,15,16,0.12);
    }
    .action-btn .btn-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .action-btn:hover .btn-icon {
        background: #7b0f10 !important;
        color: #fff !important;
        transform: scale(1.08);
    }
    .action-btn .btn-label {
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }
</style>

<div class="px-4 md:px-6 py-5 max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-gray-900">
            Mabuhay, <span class="text-[#7b0f10]">{{ auth()->user()->name }}</span>! 🎓
        </h1>
        <div class="flex items-center mt-1.5 gap-2">
            <span class="bg-[#7b0f10] text-white text-xs px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wide">UB MAIN</span>
            <span class="text-green-600 flex items-center text-xs font-semibold">
                <i class="fas fa-check-circle mr-1"></i> UBmail Verified
            </span>
        </div>
    </div>

    <!-- Big Action Buttons -->
    <div class="flex gap-4 mb-6">
        <a href="{{ route('items.browse') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(123,15,16,0.08); color:#7b0f10;">
                <i class="fas fa-shopping-bag"></i>
            </span>
            <span class="btn-label">Browse</span>
        </a>
        <a href="{{ route('trade-history') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(245,197,24,0.12); color:#b8860b;">
                <i class="fas fa-history"></i>
            </span>
            <span class="btn-label">Trades</span>
        </a>
        <a href="{{ route('items.create') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(16,185,129,0.10); color:#059669;">
                <i class="fas fa-plus"></i>
            </span>
            <span class="btn-label">Post Item</span>
        </a>
        <a href="{{ route('chat.index') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(59,130,246,0.10); color:#2563eb;">
                <i class="fas fa-comments"></i>
            </span>
            <span class="btn-label">Messages</span>
        </a>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-80">Eco Impact</p>
                    <p class="text-2xl font-bold mt-1">14.5 kg</p>
                    <p class="text-xs mt-1 opacity-80">Rank: <strong>#12</strong></p>
                </div>
                <div class="bg-white/20 p-2.5 rounded-xl"><i class="fas fa-leaf text-xl"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 border-l-4 border-[#f5c518] shadow-sm">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Trust Score</p>
            <p class="text-2xl font-bold text-[#7b0f10] mt-1">4.9<span class="text-sm text-gray-400">/5</span></p>
            <div class="flex text-[#f5c518] text-xs mt-1 gap-0.5">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 border-l-4 border-[#7b0f10] shadow-sm">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Proposals</p>
            <p class="text-2xl font-bold text-[#7b0f10] mt-1">3</p>
            <a href="{{ route('chat.index') }}" class="text-[#7b0f10] text-xs font-bold mt-1 inline-block hover:underline">View →</a>
        </div>
    </div>

    <!-- Campus Marketplace — Shopee-style grid -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-store text-[#7b0f10] text-sm"></i> Campus Marketplace
            </h2>
            <div class="flex items-center gap-2">
                <select class="text-xs border border-gray-200 bg-white text-gray-600 px-2 py-1 rounded-lg focus:outline-none">
                    <option>All</option><option>Engineering</option><option>ICT</option><option>Nursing</option><option>Business</option>
                </select>
                <a href="{{ route('items.browse') }}" class="text-xs font-bold text-[#7b0f10] hover:underline whitespace-nowrap">See all →</a>
            </div>
        </div>

        <div class="p-3 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2">
            @php
            $marketItems = [
                ['Arduino Uno Starter Kit',    'Donation', 'ICT',      'New',          'Noelito',      '2m',  'https://images.unsplash.com/photo-1553406830-ef2513450d76?w=200&h=200&fit=crop', '#10b981'],
                ['Nursing Textbook 2023',       'Trade',    'Nursing',  'Good',         'Maria S.',     '1h',  'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=200&h=200&fit=crop', '#3b82f6'],
                ['Mechanical Keyboard RGB',     'Trade',    'ICT',      'Good',         'Alex C.',      '3h',  'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&h=200&fit=crop', '#3b82f6'],
                ['Wireless Mouse Logitech',     'Trade',    'ICT',      'Like New',     'Maria S.',     '5h',  'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200&h=200&fit=crop', '#3b82f6'],
                ['Canvas Backpack',             'Donation', 'General',  'Excellent',    'Sarah L.',     '2h',  'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=200&h=200&fit=crop', '#10b981'],
                ['LED Desk Lamp',               'Donation', 'General',  'Good',         'John D.',      '4h',  'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=200&h=200&fit=crop', '#10b981'],
                ['Drawing Board A3',            'Trade',    'CAS',      'New',          'Sofia G.',     '6h',  'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&h=200&fit=crop', '#3b82f6'],
                ['Laptop Stand Adjustable',     'Trade',    'ICT',      'Like New',     'James R.',     '8h',  'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=200&h=200&fit=crop', '#3b82f6'],
                ['Calculus Textbook 3rd Ed.',   'Trade',    'Eng.',     'Used',         'John D.',      '1d',  'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=200&h=200&fit=crop', '#3b82f6'],
                ['USB Hub 7-port',              'Trade',    'ICT',      'New',          'Alex C.',      '1d',  'https://images.unsplash.com/photo-1625895197185-efcec01cffe0?w=200&h=200&fit=crop', '#3b82f6'],
                ['Lab Coat Size M',             'Donation', 'Nursing',  'Good',         'Maria S.',     '2d',  'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=200&h=200&fit=crop', '#10b981'],
                ['Engineering Drawing Set',     'Trade',    'Eng.',     'Good',         'James R.',     '2d',  'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=200&h=200&fit=crop', '#3b82f6'],
            ];
            @endphp

            @foreach($marketItems as $p)
            <div class="product-card">
                <div class="img-wrap">
                    <img src="{{ $p[6] }}" alt="{{ $p[0] }}" loading="lazy">
                    <span class="card-badge" style="background:{{ $p[7] }}; color:white;">{{ $p[1] }}</span>
                    <span class="card-condition">{{ $p[3] }}</span>
                </div>
                <div class="card-body">
                    <p class="card-title">{{ $p[0] }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        <span class="text-xs font-bold px-1.5 py-0.5 rounded" style="background:rgba(123,15,16,0.08);color:#7b0f10;font-size:0.6rem;">{{ $p[2] }}</span>
                    </div>
                    <p class="card-meta mt-1">{{ $p[4] }} · {{ $p[5] }} ago</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50 text-center">
            <a href="{{ route('items.browse') }}" class="text-sm font-bold text-[#7b0f10] hover:underline">View All Items →</a>
        </div>
    </div>

    <!-- Bottom Row: Quote + Eco Leaders + Smart Matches -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-5">

        <!-- Smart Matches -->
        <div class="lg:col-span-2 bg-gradient-to-r from-[#f5c518]/10 to-[#7b0f10]/5 border border-[#f5c518]/40 rounded-xl p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-bold text-[#7b0f10] flex items-center">
                    <i class="fas fa-wand-magic-sparkles mr-1.5 text-[#f5c518]"></i> Smart Matches
                </h2>
                <span class="text-xs font-bold bg-[#7b0f10] text-white px-2 py-0.5 rounded-full">BETA</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @foreach([
                    ['Drawing Board (A3)', 'Wishlist match', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&h=200&fit=crop'],
                    ['Laptop Stand',       'Great for setup', 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=200&h=200&fit=crop'],
                    ['USB Hub (7-port)',   'Perfect match',   'https://images.unsplash.com/photo-1625895197185-efcec01cffe0?w=200&h=200&fit=crop'],
                ] as $m)
                <div class="bg-white rounded-lg overflow-hidden border border-[#f5c518]/40 hover:shadow-md transition cursor-pointer">
                    <div style="aspect-ratio:1/1; overflow:hidden; background:#f5f5f5;">
                        <img src="{{ $m[2] }}" class="w-full h-full object-cover" alt="{{ $m[0] }}">
                    </div>
                    <div class="p-2">
                        <p class="font-bold text-gray-900 text-xs line-clamp-1">{{ $m[0] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $m[1] }}</p>
                        <button class="text-xs font-bold mt-1.5" style="color:#7b0f10;">Propose →</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Eco Leaders -->
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-[#7b0f10] text-sm flex items-center">
                    <i class="fas fa-leaf mr-1.5 text-green-600"></i> Eco Leaders
                </h3>
                <span class="text-xs font-bold bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-0.5 rounded-full">This Week</span>
            </div>
            <div class="space-y-1.5">
                @foreach([['🥇','Alex Chen','ECE','28.5 kg','from-[#f5c518]/10'],['🥈','Maria Santos','BSN','24.0 kg','from-gray-50'],['🥉','James Reyes','IT','22.3 kg','from-gray-50']] as $l)
                <div class="flex items-center gap-2 px-2 py-1.5 bg-gradient-to-r {{ $l[4] }} to-transparent rounded-lg">
                    <span class="text-base">{{ $l[0] }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-xs text-gray-900 truncate">{{ $l[1] }}</p>
                        <p class="text-xs text-gray-400">{{ $l[2] }} · {{ $l[3] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-3 pt-2 border-t border-gray-100">
                <a href="{{ route('sustainability-leaderboard') }}" class="block w-full py-1.5 text-center text-xs font-bold text-[#7b0f10] border border-[#7b0f10] rounded-lg hover:bg-[#7b0f10] hover:text-white transition">
                    Full Leaderboard
                </a>
            </div>
        </div>
    </div>

    <!-- Safety Banner -->
    <div class="bg-gradient-to-r from-[#7b0f10] to-[#5a0a0b] text-white rounded-xl p-4 flex items-center gap-4">
        <div class="bg-white/20 p-3 rounded-xl flex-shrink-0">
            <i class="fas fa-shield-alt text-[#f5c518] text-xl"></i>
        </div>
        <div>
            <p class="font-bold text-sm italic">"It's better if UBarter."</p>
            <p class="text-xs opacity-80 mt-0.5">Always meet in well-lit campus areas like the <strong>UB Lounge</strong> or <strong>Student Center</strong>. Safety verified by UB Admin.</p>
        </div>
    </div>

</div>
@endsection
