@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<style>
    .product-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        transition: box-shadow 0.18s, transform 0.18s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
    }
    .product-card:hover {
        box-shadow: 0 4px 14px rgba(0,0,0,0.13);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
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
        transition: transform 0.25s ease;
    }
    .product-card:hover .img-wrap img { transform: scale(1.05); }
    .product-card .card-body {
        padding: 6px 7px 8px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-card .card-title {
        font-size: 0.72rem;
        font-weight: 600;
        color: #222;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 3px;
    }
    .card-badge {
        position: absolute;
        top: 5px;
        left: 5px;
        font-size: 0.55rem;
        font-weight: 800;
        padding: 2px 5px;
        border-radius: 3px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: white;
    }
    .card-condition {
        position: absolute;
        bottom: 5px;
        right: 5px;
        font-size: 0.55rem;
        font-weight: 700;
        background: rgba(0,0,0,0.55);
        color: #fff;
        padding: 1px 4px;
        border-radius: 3px;
    }
    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px 10px;
        background: #fff;
        border: 1.5px solid #e5e7eb;
        border-radius: 14px;
        font-weight: 700;
        color: #374151;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        flex: 1;
        min-width: 0;
        cursor: pointer;
    }
    .action-btn:hover {
        border-color: #7b0f10;
        color: #7b0f10;
        background: #fff8f8;
        box-shadow: 0 4px 14px rgba(123,15,16,0.12);
        transform: translateY(-2px);
        text-decoration: none;
    }
    .action-btn .btn-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: all 0.18s ease;
    }
    .action-btn:hover .btn-icon {
        background: #7b0f10 !important;
        color: #fff !important;
    }
    .action-btn .btn-label { font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
</style>

<div class="px-4 md:px-6 py-5 max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-gray-900">
            Mabuhay, <span style="color:#7b0f10;">{{ auth()->user()->name }}</span>! 🎓
        </h1>
        <div class="flex items-center mt-1.5 gap-2">
            <span style="background:#7b0f10;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.05em;">UB MAIN</span>
            <span style="color:#16a34a;font-size:0.72rem;font-weight:600;display:flex;align-items:center;gap:4px;">
                <i class="fas fa-check-circle"></i> UBmail Verified
            </span>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex gap-3 mb-5">
        <a href="{{ route('items.browse') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(123,15,16,0.08);color:#7b0f10;"><i class="fas fa-shopping-bag"></i></span>
            <span class="btn-label">Browse</span>
        </a>
        <a href="{{ route('trade-history') }}" class="action-btn" style="position:relative;">
            <span class="btn-icon" style="background:rgba(245,197,24,0.12);color:#b8860b;"><i class="fas fa-exchange-alt"></i></span>
            <span class="btn-label">Trades</span>
            @if($pendingTrades > 0)
                <span style="position:absolute;top:8px;right:8px;background:#ef4444;color:#fff;font-size:0.6rem;font-weight:800;padding:1px 5px;border-radius:999px;">{{ $pendingTrades }}</span>
            @endif
        </a>
        <a href="{{ route('items.create') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(16,185,129,0.10);color:#059669;"><i class="fas fa-plus"></i></span>
            <span class="btn-label">Post Item</span>
        </a>
        <a href="{{ route('chat.index') }}" class="action-btn">
            <span class="btn-icon" style="background:rgba(59,130,246,0.10);color:#2563eb;"><i class="fas fa-comments"></i></span>
            <span class="btn-label">Messages</span>
        </a>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border-radius:14px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;opacity:0.8;">Eco Impact</p>
                    <p style="font-size:1.6rem;font-weight:800;margin-top:4px;">14.5 kg</p>
                    <p style="font-size:0.65rem;opacity:0.8;margin-top:2px;">Rank: <strong>#12</strong></p>
                </div>
                <div style="background:rgba(255,255,255,0.2);padding:10px;border-radius:10px;">
                    <i class="fas fa-leaf" style="font-size:1.1rem;"></i>
                </div>
            </div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px;border-left:4px solid #f5c518;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;">Trust Score</p>
            <p style="font-size:1.6rem;font-weight:800;color:#7b0f10;margin-top:4px;">4.9<span style="font-size:0.9rem;color:#9ca3af;">/5</span></p>
            <div style="display:flex;gap:2px;margin-top:4px;">
                @for($i=0;$i<5;$i++)<i class="fas fa-star" style="color:#f5c518;font-size:0.65rem;"></i>@endfor
            </div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px;border-left:4px solid #7b0f10;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <p style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;">Pending Trades</p>
            <p style="font-size:1.6rem;font-weight:800;color:#7b0f10;margin-top:4px;">{{ $pendingTrades }}</p>
            <a href="{{ route('trade-history') }}" style="font-size:0.65rem;font-weight:700;color:#7b0f10;text-decoration:none;margin-top:4px;display:inline-block;">View →</a>
        </div>
    </div>

    <!-- Campus Marketplace — real DB items, Shopee-style -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:20px;">
        <div style="padding:12px 16px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
            <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-store" style="color:#7b0f10;font-size:0.85rem;"></i> Campus Marketplace
            </h2>
            <a href="{{ route('items.browse') }}" style="font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;">See all →</a>
        </div>

        @if($recentItems->count() > 0)
        <div style="padding:10px;display:grid;grid-template-columns:repeat(6,1fr);gap:8px;">
            @foreach($recentItems as $item)
            <a href="{{ route('items.show', $item) }}" class="product-card">
                <div class="img-wrap">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                    <span class="card-badge" style="background:{{ $item->item_type === 'Barter' ? '#7b0f10' : '#16a34a' }};">{{ $item->item_type }}</span>
                    <span class="card-condition">{{ $item->condition }}</span>
                </div>
                <div class="card-body">
                    <p class="card-title">{{ $item->title }}</p>
                    <div style="display:flex;align-items:center;gap:4px;margin-top:3px;">
                        <span style="background:rgba(123,15,16,0.08);color:#7b0f10;font-size:0.55rem;font-weight:700;padding:1px 5px;border-radius:3px;">{{ $item->category }}</span>
                        <span style="font-size:0.55rem;color:#f5c518;margin-left:auto;"><i class="fas fa-star"></i> <span style="color:#9ca3af;">{{ number_format($item->seller_rating,1) }}</span></span>
                    </div>
                    <p style="font-size:0.6rem;color:#9ca3af;margin-top:3px;">{{ $item->user->name }}</p>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div style="padding:32px;text-align:center;color:#9ca3af;">
            <i class="fas fa-box-open" style="font-size:2rem;margin-bottom:8px;display:block;"></i>
            <p style="font-size:0.82rem;">No items yet. <a href="{{ route('items.create') }}" style="color:#7b0f10;font-weight:700;">Post the first one!</a></p>
        </div>
        @endif

        <div style="padding:10px 16px;border-top:1px solid #f3f4f6;background:#fafafa;text-align:center;">
            <a href="{{ route('items.browse') }}" style="font-size:0.78rem;font-weight:700;color:#7b0f10;text-decoration:none;">View All Items →</a>
        </div>
    </div>

    <!-- Bottom: Eco Leaders + Safety -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
        <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <h3 style="font-size:0.85rem;font-weight:800;color:#7b0f10;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-leaf" style="color:#16a34a;"></i> Eco Leaders
                </h3>
                <span style="font-size:0.6rem;font-weight:700;background:rgba(123,15,16,0.08);color:#7b0f10;padding:2px 8px;border-radius:999px;">This Week</span>
            </div>
            @foreach([['🥇','Alex Chen','ECE','28.5 kg'],['🥈','Maria Santos','BSN','24.0 kg'],['🥉','James Reyes','IT','22.3 kg']] as $l)
            <div style="display:flex;align-items:center;gap:8px;padding:6px 8px;border-radius:8px;background:{{ $loop->first ? 'rgba(245,197,24,0.08)' : '#fafafa' }};margin-bottom:4px;">
                <span style="font-size:1rem;">{{ $l[0] }}</span>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:0.72rem;font-weight:700;color:#1a1209;margin:0;">{{ $l[1] }}</p>
                    <p style="font-size:0.62rem;color:#9ca3af;margin:0;">{{ $l[2] }} · {{ $l[3] }}</p>
                </div>
            </div>
            @endforeach
            <div style="margin-top:10px;padding-top:10px;border-top:1px solid #f3f4f6;">
                <a href="{{ route('sustainability-leaderboard') }}" style="display:block;text-align:center;font-size:0.72rem;font-weight:700;color:#7b0f10;border:1px solid #7b0f10;border-radius:8px;padding:6px;text-decoration:none;">Full Leaderboard</a>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#7b0f10,#5a0a0b);color:#fff;border-radius:14px;padding:16px;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <p style="font-size:0.85rem;font-weight:800;font-style:italic;margin-bottom:8px;">"It's better if UBarter."</p>
                <p style="font-size:0.72rem;opacity:0.85;line-height:1.6;">Always meet in well-lit campus areas like the <strong>UB Lounge</strong> or <strong>Student Center</strong> for safety.</p>
            </div>
            <div style="margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;gap:6px;font-size:0.65rem;opacity:0.8;">
                <i class="fas fa-shield-alt" style="color:#f5c518;"></i> Safety verified by UB Admin
            </div>
        </div>
    </div>

</div>
@endsection
