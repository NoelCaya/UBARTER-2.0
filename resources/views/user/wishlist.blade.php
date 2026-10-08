@extends('layouts.master')

@section('title', 'My Wishlist')

@section('content')
<style>
*{box-sizing:border-box;}

/* ─── GRID ─── */
.wl-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
}
@media(max-width:1100px){ .wl-grid{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:700px){  .wl-grid{ grid-template-columns:repeat(2,1fr); } }

/* ─── CARD ─── */
.wl-card {
  display: flex; flex-direction: column;
  background: #fff; border-radius: 14px; overflow: hidden;
  border: 1px solid #f0f0f0;
  box-shadow: 0 1px 4px rgba(0,0,0,0.07);
  transition: box-shadow 0.2s, transform 0.2s;
}
.wl-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.12); transform:translateY(-2px); }

/* ─── IMAGE BOX — padding-bottom 100% = perfect square, no Tailwind JIT needed ─── */
.wl-card .img-box {
  position: relative;
  width: 100%;
  padding-bottom: 100%;
  overflow: hidden;
  background: #f5f5f5;
  flex-shrink: 0;
}
.wl-card .img-box img {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  object-fit: cover; object-position: center;
  display: block;
  transition: transform 0.3s ease;
}
.wl-card:hover .img-box img { transform: scale(1.05); }
.wl-card .img-box .b-cat {
  position: absolute; bottom: 6px; left: 6px; z-index: 1;
  font-size: 0.52rem; font-weight: 800; padding: 2px 7px; border-radius: 4px;
  text-transform: uppercase; letter-spacing: 0.04em;
  background: rgba(123,15,16,0.85); color: #fff;
}
.wl-card .img-box .b-type {
  position: absolute; top: 6px; left: 6px; z-index: 1;
  font-size: 0.52rem; font-weight: 800; padding: 2px 7px; border-radius: 4px;
  text-transform: uppercase; color: #fff;
}

/* card body */
.wl-card .wl-body { padding: 12px; flex: 1; display: flex; flex-direction: column; }
.wl-card .wl-title {
  font-size: 0.82rem; font-weight: 700; color: #1a1209; line-height: 1.3;
  overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  margin: 0 0 4px;
}
.wl-card .wl-seller { font-size: 0.68rem; color: #9ca3af; margin: 0 0 8px; }
.wl-card .wl-desc {
  font-size: 0.72rem; color: #6b7280; line-height: 1.45;
  overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  margin: 0 0 12px; flex: 1;
}
.wl-card .wl-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding-top: 10px; border-top: 1px solid #f3f4f6;
}
.btn-view {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 0.75rem; font-weight: 700; color: #fff;
  background: #7b0f10; padding: 6px 12px; border-radius: 8px;
  text-decoration: none; transition: background 0.15s;
}
.btn-view:hover { background: #5a0a0b; text-decoration: none; color: #fff; }
.btn-remove {
  width: 30px; height: 30px;
  background: #fef2f2; border: none; border-radius: 8px;
  color: #ef4444; cursor: pointer; display: flex;
  align-items: center; justify-content: center;
  font-size: 0.85rem; transition: all 0.15s;
}
.btn-remove:hover { background: #ef4444; color: #fff; transform: scale(1.05); }
</style>

<div style="max-width:1200px;margin:0 auto;padding:20px 16px;">

  {{-- HEADER --}}
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
    <div>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:3px;">
        <span style="width:36px;height:36px;border-radius:10px;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fas fa-heart" style="color:#ef4444;"></i>
        </span>
        <h1 style="font-size:1.5rem;font-weight:900;color:#1a1209;margin:0;">My Wishlist</h1>
      </div>
      <p style="font-size:0.78rem;color:#9ca3af;margin:0 0 0 46px;">{{ $wishlistItems->total() }} items you're interested in</p>
    </div>
    <a href="{{ route('items.browse') }}"
       style="display:inline-flex;align-items:center;gap:7px;padding:10px 18px;background:#7b0f10;color:#fff;border-radius:12px;font-weight:700;font-size:0.85rem;text-decoration:none;transition:background 0.15s;"
       onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
      <i class="fas fa-search"></i> Browse Items
    </a>
  </div>

  @if($wishlistItems->count() > 0)
    <div class="wl-grid">
      @foreach($wishlistItems as $wishlist)
        <div class="wl-card">
          {{-- IMAGE — fixed square via padding-bottom hack --}}
          <div class="img-box">
            @if($wishlist->item->image_url)
              <img src="{{ $wishlist->item->image_url }}" alt="{{ $wishlist->item->title }}">
            @else
              <div style="position:absolute;inset:0;background:linear-gradient(135deg,#7b0f10,#5a0a0b);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-image" style="color:rgba(255,255,255,0.25);font-size:2rem;"></i>
              </div>
            @endif
            <span class="b-type" style="background:{{ $wishlist->item->item_type==='Barter'?'#7b0f10':'#16a34a' }};">{{ $wishlist->item->item_type }}</span>
            <span class="b-cat">{{ $wishlist->item->category }}</span>
          </div>

          {{-- BODY --}}
          <div class="wl-body">
            <h3 class="wl-title">{{ $wishlist->item->title }}</h3>
            <p class="wl-seller">by {{ $wishlist->item->user->name }}</p>
            <p class="wl-desc">{{ $wishlist->item->description }}</p>

            <div class="wl-footer">
              <a href="{{ route('items.show', $wishlist->item) }}" class="btn-view">
                View <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i>
              </a>
              <form action="{{ route('wishlist.remove', $wishlist->item) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-remove" title="Remove from wishlist">
                  <i class="fas fa-heart"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @if($wishlistItems->hasPages())
      <div style="display:flex;justify-content:center;margin-top:20px;">
        {{ $wishlistItems->links() }}
      </div>
    @endif

  @else
    {{-- EMPTY STATE --}}
    <div style="background:#fff;border-radius:20px;padding:64px 24px;text-align:center;border:1px solid #f3f4f6;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
      <i class="fas fa-heart" style="font-size:3.5rem;color:#f3f4f6;margin-bottom:16px;display:block;"></i>
      <h3 style="font-size:1.2rem;font-weight:800;color:#1a1209;margin:0 0 8px;">Your wishlist is empty</h3>
      <p style="font-size:0.88rem;color:#9ca3af;margin:0 0 24px;max-width:380px;display:inline-block;line-height:1.6;">
        Start adding items you're interested in! Browse the marketplace and tap the heart icon.
      </p>
      <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:32px;">
        <a href="{{ route('items.browse') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:11px 22px;background:#7b0f10;color:#fff;border-radius:12px;font-weight:700;font-size:0.85rem;text-decoration:none;transition:background 0.15s;"
           onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
          <i class="fas fa-search"></i> Browse Items
        </a>
        <a href="{{ route('items.donated') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:11px 22px;border:2px solid #16a34a;color:#16a34a;border-radius:12px;font-weight:700;font-size:0.85rem;text-decoration:none;transition:all 0.15s;"
           onmouseover="this.style.background='#16a34a';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='#16a34a'">
          <i class="fas fa-hand-holding-heart"></i> Donations
        </a>
      </div>
      <div style="padding-top:24px;border-top:1px solid #f3f4f6;display:flex;flex-wrap:wrap;justify-content:center;gap:24px;max-width:500px;margin:0 auto;">
        <div style="display:flex;align-items:flex-start;gap:10px;text-align:left;max-width:200px;">
          <i class="fas fa-heart" style="color:#ef4444;margin-top:2px;flex-shrink:0;"></i>
          <div>
            <p style="font-size:0.78rem;font-weight:700;color:#374151;margin:0 0 2px;">Save for Later</p>
            <p style="font-size:0.68rem;color:#9ca3af;margin:0;">Heart items to track and get notified</p>
          </div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:10px;text-align:left;max-width:200px;">
          <i class="fas fa-bell" style="color:#3b82f6;margin-top:2px;flex-shrink:0;"></i>
          <div>
            <p style="font-size:0.78rem;font-weight:700;color:#374151;margin:0 0 2px;">Get Notified</p>
            <p style="font-size:0.68rem;color:#9ca3af;margin:0;">We'll alert you when similar items post</p>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
