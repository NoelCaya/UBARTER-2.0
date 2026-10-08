@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
{{-- ╔══════════════════════════════════════════════════════════╗
     ║  UBARTER 2.0 — USER DASHBOARD                           ║
     ╚══════════════════════════════════════════════════════════╝ --}}
<style>
/* ─── RESET & BASE ─── */
*{box-sizing:border-box;}

/* ─── PRODUCT CARD (strict Shopee-style) ─── */
.mkt-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
  padding: 12px;
}
@media(max-width:900px){.mkt-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:600px){.mkt-grid{grid-template-columns:repeat(2,1fr);}}

.mkt-card {
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid #f0f0f0;
  box-shadow: 0 1px 3px rgba(0,0,0,0.07);
  text-decoration: none;
  color: inherit;
  transition: box-shadow 0.18s, transform 0.18s;
}
.mkt-card:hover {
  box-shadow: 0 6px 18px rgba(0,0,0,0.13);
  transform: translateY(-2px);
  text-decoration: none;
  color: inherit;
}

/* THE KEY FIX — force image container to a fixed, small square */
.mkt-card .img-box {
  position: relative;
  width: 100%;
  padding-bottom: 100%;   /* 1:1 ratio hack — always a square */
  overflow: hidden;
  background: #f5f5f5;
  flex-shrink: 0;
}
.mkt-card .img-box img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
  transition: transform 0.3s ease;
}
.mkt-card:hover .img-box img { transform: scale(1.06); }

.mkt-card .img-box .badge-type {
  position: absolute;
  top: 5px; left: 5px;
  font-size: 0.52rem;
  font-weight: 800;
  padding: 2px 6px;
  border-radius: 4px;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: #fff;
  line-height: 1.4;
}
.mkt-card .img-box .badge-cond {
  position: absolute;
  bottom: 5px; right: 5px;
  font-size: 0.52rem;
  font-weight: 700;
  background: rgba(0,0,0,0.55);
  color: #fff;
  padding: 1px 5px;
  border-radius: 3px;
}

.mkt-card .card-info {
  padding: 8px 9px 10px;
  flex: 1;
  display: flex;
  flex-direction: column;
}
.mkt-card .card-info .card-title {
  font-size: 0.72rem;
  font-weight: 600;
  color: #1a1209;
  line-height: 1.3;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  margin: 0 0 5px;
}
.mkt-card .card-info .card-cat {
  font-size: 0.55rem;
  font-weight: 700;
  background: rgba(123,15,16,0.07);
  color: #7b0f10;
  padding: 2px 6px;
  border-radius: 3px;
  display: inline-block;
}
.mkt-card .card-info .card-meta {
  font-size: 0.58rem;
  color: #9ca3af;
  margin-top: 4px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.mkt-card .card-info .card-rating {
  font-size: 0.58rem;
  color: #f5c518;
  display: flex;
  align-items: center;
  gap: 2px;
}
.card-bottom-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 4px;
}

/* ─── QUICK ACTION LINKS ─── */
.ql {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 7px;
  padding: 14px 8px;
  background: #fff;
  border: 1.5px solid #e5e7eb;
  border-radius: 14px;
  font-weight: 700;
  color: #374151;
  text-decoration: none;
  transition: all 0.18s;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  flex: 1;
  min-width: 0;
  cursor: pointer;
  position: relative;
}
.ql:hover {
  border-color: #7b0f10;
  color: #7b0f10;
  background: #fff8f8;
  box-shadow: 0 4px 14px rgba(123,15,16,0.10);
  transform: translateY(-2px);
  text-decoration: none;
}
.ql-icon {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  transition: all 0.18s;
}
.ql:hover .ql-icon { background: #7b0f10 !important; color: #fff !important; }
.ql-label { font-size: 0.73rem; font-weight: 700; white-space: nowrap; }
.ql-badge {
  position: absolute;
  top: 7px; right: 7px;
  background: #ef4444;
  color: #fff;
  font-size: 0.58rem;
  font-weight: 800;
  padding: 1px 5px;
  border-radius: 999px;
  line-height: 1.4;
}
</style>

<div style="max-width:1200px;margin:0 auto;padding:20px 16px;">

  {{-- ── HERO HEADER ── --}}
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
    <div>
      <p style="font-size:0.65rem;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:0.1em;margin:0 0 2px;">
        Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}
      </p>
      <h1 style="font-size:1.5rem;font-weight:800;color:#1a1209;margin:0;">
        Mabuhay, <span style="color:#7b0f10;">{{ auth()->user()->name }}</span>! 🎓
      </h1>
      <div style="display:flex;align-items:center;gap:8px;margin-top:6px;">
        <span style="background:#7b0f10;color:#fff;font-size:0.58rem;font-weight:800;padding:2px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.06em;">
          <i class="fas fa-university" style="font-size:0.52rem;"></i> UB Main
        </span>
        <span style="color:#16a34a;font-size:0.72rem;font-weight:600;display:flex;align-items:center;gap:3px;">
          <i class="fas fa-check-circle" style="font-size:0.72rem;"></i> UBmail Verified
        </span>
      </div>
    </div>
    <a href="{{ route('items.create') }}"
       style="display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:#7b0f10;color:#fff;border-radius:12px;font-weight:700;font-size:0.85rem;text-decoration:none;transition:background 0.15s;box-shadow:0 2px 8px rgba(123,15,16,0.2);"
       onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
      <i class="fas fa-plus"></i> Post Item
    </a>
  </div>

  {{-- ── FLASH ── --}}
  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- ── QUICK ACTIONS ── --}}
  <div style="display:flex;gap:10px;margin-bottom:20px;">
    <a href="{{ route('items.browse') }}" class="ql">
      <span class="ql-icon" style="background:rgba(123,15,16,0.08);color:#7b0f10;"><i class="fas fa-shopping-bag"></i></span>
      <span class="ql-label">Browse</span>
    </a>
    <a href="{{ route('trade-history') }}" class="ql">
      <span class="ql-icon" style="background:rgba(245,197,24,0.12);color:#b8860b;"><i class="fas fa-exchange-alt"></i></span>
      <span class="ql-label">Trades</span>
      @if($pendingTrades > 0)
        <span class="ql-badge">{{ $pendingTrades }}</span>
      @endif
    </a>
    <a href="{{ route('items.donated') }}" class="ql">
      <span class="ql-icon" style="background:rgba(22,163,74,0.10);color:#16a34a;"><i class="fas fa-hand-holding-heart"></i></span>
      <span class="ql-label">Donate</span>
    </a>
    <a href="{{ route('chat.index') }}" class="ql">
      <span class="ql-icon" style="background:rgba(59,130,246,0.10);color:#2563eb;"><i class="fas fa-comments"></i></span>
      <span class="ql-label">Messages</span>
    </a>
    <a href="{{ route('wishlist') }}" class="ql">
      <span class="ql-icon" style="background:rgba(239,68,68,0.08);color:#ef4444;"><i class="fas fa-heart"></i></span>
      <span class="ql-label">Wishlist</span>
    </a>
  </div>

  {{-- ── STATS ROW ── --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    <div style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border-radius:16px;padding:18px 20px;box-shadow:0 2px 8px rgba(22,163,74,0.2);">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;">
        <div>
          <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;opacity:0.8;margin:0 0 6px;">Eco Impact</p>
          <p style="font-size:2rem;font-weight:900;margin:0;line-height:1;">14.5<span style="font-size:1rem;font-weight:700;opacity:0.8;margin-left:3px;">kg</span></p>
          <p style="font-size:0.6rem;opacity:0.75;margin:5px 0 0;">CO₂ saved · Rank <strong>#12</strong></p>
        </div>
        <div style="background:rgba(255,255,255,0.2);width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fas fa-leaf" style="font-size:1.1rem;"></i>
        </div>
      </div>
    </div>
    <div style="background:#fff;border-radius:16px;padding:18px 20px;border-left:4px solid #f5c518;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#9ca3af;margin:0 0 6px;">Trust Score</p>
      <p style="font-size:2rem;font-weight:900;color:#7b0f10;margin:0;line-height:1;">4.9<span style="font-size:1rem;font-weight:500;color:#9ca3af;">/5</span></p>
      <div style="display:flex;gap:3px;margin-top:5px;">
        @for($i=0;$i<5;$i++)<i class="fas fa-star" style="color:#f5c518;font-size:0.7rem;"></i>@endfor
      </div>
    </div>
    <div style="background:#fff;border-radius:16px;padding:18px 20px;border-left:4px solid #7b0f10;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#9ca3af;margin:0 0 6px;">Pending Trades</p>
      <p style="font-size:2rem;font-weight:900;color:#7b0f10;margin:0;line-height:1;">{{ $pendingTrades }}</p>
      <a href="{{ route('trade-history') }}" style="font-size:0.65rem;font-weight:700;color:#7b0f10;text-decoration:none;margin-top:5px;display:inline-block;">View all →</a>
    </div>
  </div>

  {{-- ── 8/4 MAIN GRID ── --}}
  <div style="display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;">

    {{-- LEFT: CAMPUS MARKETPLACE --}}
    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;">
      <div style="padding:14px 16px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-store" style="color:#7b0f10;font-size:0.82rem;"></i> Campus Marketplace
        </h2>
        <a href="{{ route('items.browse') }}" style="font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;">See all →</a>
      </div>

      @if($recentItems->count() > 0)
        <div class="mkt-grid">
          @foreach($recentItems as $item)
            <a href="{{ route('items.show', $item) }}" class="mkt-card">
              <div class="img-box">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                <span class="badge-type" style="background:{{ $item->item_type === 'Barter' ? '#7b0f10' : '#16a34a' }};">{{ $item->item_type }}</span>
                <span class="badge-cond">{{ $item->condition }}</span>
              </div>
              <div class="card-info">
                <p class="card-title">{{ $item->title }}</p>
                <div class="card-bottom-row">
                  <span class="card-cat">{{ $item->category }}</span>
                  <span class="card-rating"><i class="fas fa-star"></i> <span style="color:#9ca3af;">{{ number_format($item->seller_rating,1) }}</span></span>
                </div>
                <p class="card-meta">{{ $item->user->name }}</p>
              </div>
            </a>
          @endforeach
        </div>
      @else
        <div style="padding:40px;text-align:center;color:#9ca3af;">
          <i class="fas fa-box-open" style="font-size:2.5rem;margin-bottom:10px;display:block;"></i>
          <p style="font-size:0.85rem;">No items yet. <a href="{{ route('items.create') }}" style="color:#7b0f10;font-weight:700;text-decoration:none;">Post the first one!</a></p>
        </div>
      @endif

      <div style="padding:10px 16px;border-top:1px solid #f3f4f6;background:#fafafa;text-align:center;">
        <a href="{{ route('items.browse') }}" style="font-size:0.78rem;font-weight:700;color:#7b0f10;text-decoration:none;">View All Items →</a>
      </div>
    </div>

    {{-- RIGHT: SIDEBAR WIDGETS --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

      {{-- Active Trades --}}
      <div style="background:#fff;border-radius:16px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border:1px solid #f3f4f6;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
          <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:5px;">
            <i class="fas fa-exchange-alt" style="color:#7b0f10;font-size:0.75rem;"></i> Active Trades
          </h3>
          <span style="font-size:0.58rem;font-weight:700;padding:2px 8px;border-radius:999px;background:#fee2e2;color:#dc2626;">{{ $pendingTrades }} pending</span>
        </div>
        @if($pendingTrades > 0)
          <div style="background:#f9fafb;border-radius:10px;padding:10px 12px;display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <div style="width:36px;height:36px;background:#7b0f10;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="fas fa-handshake" style="color:#fff;font-size:0.85rem;"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <p style="font-size:0.78rem;font-weight:700;color:#1a1209;margin:0;">{{ $pendingTrades }} pending trade{{ $pendingTrades !== 1 ? 's' : '' }}</p>
              <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;">Awaiting your response</p>
            </div>
          </div>
        @else
          <div style="text-align:center;padding:16px 0;color:#d1d5db;">
            <i class="fas fa-handshake" style="font-size:1.8rem;margin-bottom:6px;display:block;"></i>
            <p style="font-size:0.72rem;color:#9ca3af;margin:0;">No active trades</p>
          </div>
        @endif
        <a href="{{ route('trade-history') }}"
           style="display:block;text-align:center;padding:7px;border:1.5px solid rgba(123,15,16,0.3);border-radius:10px;font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;transition:all 0.15s;"
           onmouseover="this.style.background='#7b0f10';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#7b0f10'">
          View All Trades
        </a>
      </div>

      {{-- Eco Leaders --}}
      <div style="background:#fff;border-radius:16px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border:1px solid #f3f4f6;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
          <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:5px;">
            <i class="fas fa-leaf" style="color:#16a34a;font-size:0.75rem;"></i> Eco Leaders
          </h3>
          <span style="font-size:0.58rem;font-weight:700;padding:2px 8px;border-radius:999px;background:rgba(123,15,16,0.07);color:#7b0f10;">This Week</span>
        </div>
        @foreach([['🥇','Alex Chen','ECE','28.5 kg'],['🥈','Maria Santos','BSN','24.0 kg'],['🥉','James Reyes','IT','22.3 kg']] as $l)
          <div style="display:flex;align-items:center;gap:8px;padding:7px 8px;border-radius:10px;margin-bottom:5px;background:{{ $loop->first ? 'rgba(245,197,24,0.08)' : '#fafafa' }};">
            <span style="font-size:0.95rem;">{{ $l[0] }}</span>
            <div style="flex:1;min-width:0;">
              <p style="font-size:0.72rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $l[1] }}</p>
              <p style="font-size:0.6rem;color:#9ca3af;margin:1px 0 0;">{{ $l[2] }}</p>
            </div>
            <span style="font-size:0.68rem;font-weight:700;color:#16a34a;flex-shrink:0;">{{ $l[3] }}</span>
          </div>
        @endforeach
        <div style="margin-top:10px;padding-top:10px;border-top:1px solid #f3f4f6;">
          <a href="{{ route('sustainability-leaderboard') }}"
             style="display:block;text-align:center;padding:7px;border:1.5px solid #d1fae5;border-radius:10px;font-size:0.72rem;font-weight:700;color:#16a34a;text-decoration:none;transition:all 0.15s;"
             onmouseover="this.style.background='#16a34a';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#16a34a'">
            Full Leaderboard
          </a>
        </div>
      </div>

      {{-- Safety Banner --}}
      <div style="background:linear-gradient(135deg,#7b0f10,#3d0607);border-radius:16px;padding:16px;color:#fff;">
        <p style="font-size:0.85rem;font-weight:800;font-style:italic;margin:0 0 8px;">"It's better if UBarter."</p>
        <p style="font-size:0.72rem;opacity:0.82;line-height:1.6;margin:0 0 12px;">Always meet in well-lit campus areas like the <strong>UB Lounge</strong> or <strong>Student Center</strong>.</p>
        <div style="padding-top:10px;border-top:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;gap:6px;font-size:0.62rem;opacity:0.7;">
          <i class="fas fa-shield-alt" style="color:#f5c518;"></i> Safety verified by UB Admin
        </div>
      </div>

    </div>
  </div>

</div>

{{-- Responsive sidebar fix --}}
<style>
@media(max-width:900px){
  div[style*="grid-template-columns:1fr 300px"]{
    grid-template-columns:1fr !important;
  }
}
</style>
@endsection
