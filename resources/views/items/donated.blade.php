@extends('layouts.master')

@section('title', 'Donated Items - UBarter')

@section('content')
<style>
*{box-sizing:border-box;}

/* ─── GRID ─── */
.item-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
  padding: 12px;
}
@media(max-width:1100px){ .item-grid{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:700px){  .item-grid{ grid-template-columns:repeat(2,1fr); } }

/* ─── CARD ─── */
.p-card {
  display: flex; flex-direction: column;
  background: #fff; border-radius: 10px; overflow: hidden;
  border: 1px solid #f0f0f0; box-shadow: 0 1px 3px rgba(0,0,0,0.07);
  text-decoration: none; color: inherit;
  transition: box-shadow 0.18s, transform 0.18s; cursor: pointer;
}
.p-card:hover { box-shadow:0 6px 18px rgba(0,0,0,0.13); transform:translateY(-2px); text-decoration:none; color:inherit; }

/* ─── IMAGE BOX — padding-bottom forces fixed 1:1 square ─── */
.p-card .img-box {
  position: relative;
  width: 100%;
  padding-bottom: 100%;
  overflow: hidden;
  background: #f5f5f5;
  flex-shrink: 0;
}
.p-card .img-box img {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  object-fit: cover; object-position: center;
  display: block;
  transition: transform 0.3s ease;
}
.p-card:hover .img-box img { transform: scale(1.06); }
.p-card .img-box .b-free {
  position: absolute; top:5px; left:5px; z-index:1;
  font-size:0.52rem; font-weight:800; padding:2px 6px; border-radius:4px;
  text-transform:uppercase; letter-spacing:0.04em; color:#fff; background:#16a34a; line-height:1.4;
}
.p-card .img-box .b-cond {
  position: absolute; bottom:5px; right:5px; z-index:1;
  font-size:0.52rem; font-weight:700; background:rgba(0,0,0,0.55); color:#fff; padding:1px 5px; border-radius:3px;
}
.p-card .img-box .b-views {
  position: absolute; bottom:5px; left:5px; z-index:1;
  font-size:0.52rem; background:rgba(0,0,0,0.45); color:#fff; padding:1px 5px; border-radius:3px;
}
.p-card .img-box .btn-wish {
  position:absolute; top:5px; right:5px; z-index:2;
  width:26px; height:26px; background:rgba(255,255,255,0.92); border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  border:none; cursor:pointer; font-size:0.68rem; color:#ccc; transition:all 0.15s;
}
.p-card .img-box .btn-wish:hover { background:#fff; color:#ef4444; transform:scale(1.1); }

/* card body */
.p-card .p-body { padding:8px 9px 10px; flex:1; display:flex; flex-direction:column; }
.p-card .p-title {
  font-size:0.72rem; font-weight:600; color:#1a1209; line-height:1.3;
  overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; margin:0 0 5px;
}
.p-card .p-meta-row { display:flex; align-items:center; justify-content:space-between; margin-top:3px; }
.p-card .p-cat { font-size:0.55rem; font-weight:700; background:rgba(22,163,74,0.08); color:#16a34a; padding:2px 6px; border-radius:3px; }
.p-card .p-rating { font-size:0.55rem; color:#f5c518; display:flex; align-items:center; gap:2px; }
.p-card .p-seller { font-size:0.58rem; color:#9ca3af; margin-top:3px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }

/* layout */
.browse-wrap { max-width:1200px; margin:0 auto; padding:20px 16px; }
.browse-layout { display:flex; gap:16px; align-items:flex-start; }
.filter-sidebar { width:190px; flex-shrink:0; position:sticky; top:74px; max-height:calc(100vh - 90px); overflow-y:auto; }
@media(max-width:900px){ .filter-sidebar{ display:none; } }
.filter-card { background:#fff; border-radius:14px; box-shadow:0 1px 3px rgba(0,0,0,0.07); padding:16px; }
.filter-section { padding-bottom:12px; border-bottom:1px solid #f3f4f6; margin-bottom:12px; }
.filter-section:last-child { border-bottom:none; padding-bottom:0; margin-bottom:0; }
.filter-label { font-size:0.6rem; font-weight:800; color:#9ca3af; text-transform:uppercase; letter-spacing:0.09em; display:block; margin-bottom:8px; }
.filter-input { width:100%; padding:7px 10px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:0.78rem; outline:none; transition:border-color 0.15s; background:#fafafa; }
.filter-input:focus { border-color:#16a34a; background:#fff; }
.filter-radio-row { display:flex; align-items:center; gap:7px; margin-bottom:6px; cursor:pointer; }
.filter-radio-row input { accent-color:#16a34a; width:13px; height:13px; cursor:pointer; }
.filter-radio-row span { font-size:0.72rem; color:#4b5563; }
.btn-apply { width:100%; padding:8px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:0.75rem; font-weight:700; cursor:pointer; transition:background 0.15s; margin-bottom:6px; }
.btn-apply:hover { background:#15803d; }
.btn-reset { display:block; width:100%; padding:7px; text-align:center; border:1.5px solid #e5e7eb; color:#6b7280; border-radius:8px; font-size:0.72rem; font-weight:600; text-decoration:none; transition:all 0.15s; background:#fff; }
.btn-reset:hover { border-color:#9ca3af; background:#f9fafb; color:#374151; text-decoration:none; }
.items-area { flex:1; min-width:0; }
.toolbar { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.06); padding:10px 14px; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; }
.toolbar-count { font-size:0.75rem; color:#6b7280; }
.toolbar-count strong { color:#1a1209; }
.toolbar-right { display:flex; align-items:center; gap:8px; }
.sort-select { padding:6px 28px 6px 10px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:0.75rem; outline:none; cursor:pointer; background:#fff; appearance:none; background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat:no-repeat; background-position:right 8px center; background-size:13px; }
.sort-select:focus { border-color:#16a34a; }
.btn-mobile-filter { display:none; align-items:center; gap:5px; padding:6px 12px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:0.75rem; font-weight:600; color:#6b7280; background:#fff; cursor:pointer; transition:all 0.15s; }
.btn-mobile-filter:hover { border-color:#16a34a; color:#16a34a; }
@media(max-width:900px){ .btn-mobile-filter{ display:flex; } }
.mobile-filters-panel { display:none; background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.07); padding:14px; margin-bottom:10px; }
.mobile-filters-panel.open { display:block; }
.empty-state { background:#fff; border-radius:14px; padding:60px 20px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.07); }
</style>

<div class="browse-wrap">

  {{-- HEADER --}}
  <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
    <div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;">
        <span style="background:#dcfce7;width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fas fa-hand-holding-heart" style="color:#16a34a;font-size:0.85rem;"></i>
        </span>
        <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0;">Donated Items</h1>
      </div>
      <p style="font-size:0.78rem;color:#9ca3af;margin:0 0 0 38px;">Items freely given to the UB community by fellow students</p>
    </div>
    @if(auth()->user()->role === 'admin')
      <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:#fee2e2;color:#dc2626;border-radius:8px;font-size:0.72rem;font-weight:700;border:1px solid #fecaca;">
        <i class="fas fa-shield-alt"></i> CES Admin View
      </span>
    @endif
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- Admin Stats --}}
  @if(auth()->user()->role === 'admin')
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px;">
      @foreach([['fa-box-open','#dcfce7','#16a34a','Total Available',$totalCount],['fa-tags','#dbeafe','#2563eb','Categories',$categories->count()],['fa-leaf','#fef9c3','#d97706','Eco Impact',$totalCount.' saved']] as $s)
        <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.06);padding:14px 16px;display:flex;align-items:center;gap:10px;">
          <div style="width:38px;height:38px;border-radius:10px;background:{{ $s[1] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas {{ $s[0] }}" style="color:{{ $s[2] }};font-size:0.9rem;"></i>
          </div>
          <div>
            <p style="font-size:0.62rem;color:#9ca3af;margin:0;">{{ $s[3] }}</p>
            <p style="font-size:1rem;font-weight:800;color:#1a1209;margin:2px 0 0;">{{ $s[4] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <div class="browse-layout">

    {{-- ══ FILTER SIDEBAR ══ --}}
    <div class="filter-sidebar">
      <div class="filter-card">
        <h2 style="font-size:0.82rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-sliders-h" style="color:#16a34a;font-size:0.75rem;"></i> Filters
        </h2>
        <form action="{{ route('items.donated') }}" method="GET">
          <div class="filter-section">
            <label class="filter-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search donated…" class="filter-input">
          </div>
          <div class="filter-section">
            <label class="filter-label">Category</label>
            <label class="filter-radio-row">
              <input type="radio" name="category" value="all" {{ request('category','all')==='all'?'checked':'' }}><span>All</span>
            </label>
            @foreach($categories as $cat)
              <label class="filter-radio-row">
                <input type="radio" name="category" value="{{ $cat }}" {{ request('category')===$cat?'checked':'' }}><span>{{ $cat }}</span>
              </label>
            @endforeach
          </div>
          <div class="filter-section">
            <label class="filter-label">Condition</label>
            <label class="filter-radio-row">
              <input type="radio" name="condition" value="all" {{ request('condition','all')==='all'?'checked':'' }}><span>All</span>
            </label>
            @foreach($conditions as $cond)
              <label class="filter-radio-row">
                <input type="radio" name="condition" value="{{ $cond }}" {{ request('condition')===$cond?'checked':'' }}><span>{{ $cond }}</span>
              </label>
            @endforeach
          </div>
          <button type="submit" class="btn-apply"><i class="fas fa-search" style="margin-right:4px;"></i> Apply</button>
          <a href="{{ route('items.donated') }}" class="btn-reset"><i class="fas fa-redo" style="margin-right:4px;"></i> Reset</a>
        </form>
      </div>
    </div>

    {{-- ══ ITEMS AREA ══ --}}
    <div class="items-area">

      {{-- Toolbar --}}
      <div class="toolbar">
        <p class="toolbar-count">
          <strong>{{ $items->count() }}</strong> of <strong>{{ $totalCount }}</strong> donated items
        </p>
        <div class="toolbar-right">
          <button class="btn-mobile-filter" onclick="document.getElementById('mobileFilters').classList.toggle('open')">
            <i class="fas fa-sliders-h"></i> Filters
          </button>
          <form action="{{ route('items.donated') }}" method="GET" style="display:flex;align-items:center;gap:6px;">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="category" value="{{ request('category','all') }}">
            <input type="hidden" name="condition" value="{{ request('condition','all') }}">
            <label style="font-size:0.72rem;color:#9ca3af;">Sort:</label>
            <select name="sort" onchange="this.form.submit()" class="sort-select">
              <option value="newest"         {{ request('sort','newest')==='newest'         ?'selected':'' }}>Newest</option>
              <option value="most_viewed"    {{ request('sort')==='most_viewed'              ?'selected':'' }}>Most Popular</option>
              <option value="most_wishlisted"{{ request('sort')==='most_wishlisted'          ?'selected':'' }}>Most Wishlisted</option>
            </select>
          </form>
        </div>
      </div>

      {{-- Mobile filters --}}
      <div id="mobileFilters" class="mobile-filters-panel">
        <form action="{{ route('items.donated') }}" method="GET">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div>
              <label class="filter-label" style="display:block;margin-bottom:4px;">Search</label>
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search…" class="filter-input">
            </div>
            <div>
              <label class="filter-label" style="display:block;margin-bottom:4px;">Category</label>
              <select name="category" class="filter-input" style="padding:7px 10px;">
                <option value="all">All</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="filter-label" style="display:block;margin-bottom:4px;">Condition</label>
              <select name="condition" class="filter-input" style="padding:7px 10px;">
                <option value="all">All</option>
                @foreach($conditions as $cond)
                  <option value="{{ $cond }}" {{ request('condition')===$cond?'selected':'' }}>{{ $cond }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="filter-label" style="display:block;margin-bottom:4px;">Sort</label>
              <select name="sort" class="filter-input" style="padding:7px 10px;">
                <option value="newest">Newest</option>
                <option value="most_viewed">Most Popular</option>
                <option value="most_wishlisted">Most Wishlisted</option>
              </select>
            </div>
          </div>
          <div style="display:flex;gap:8px;margin-top:10px;">
            <button type="submit" class="btn-apply" style="flex:1;margin:0;">Apply</button>
            <a href="{{ route('items.donated') }}" class="btn-reset" style="flex:1;">Reset</a>
          </div>
        </form>
      </div>

      {{-- ── ITEM GRID ── --}}
      @if($items->count() > 0)
        <div class="item-grid">
          @foreach($items as $item)
            <a href="{{ route('items.show', $item) }}" class="p-card">
              <div class="img-box">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                <span class="b-free"><i class="fas fa-hand-holding-heart" style="margin-right:2px;"></i>Free</span>
                <form action="{{ route('wishlist.add', $item) }}" method="POST" style="position:absolute;top:5px;right:5px;z-index:2;">
                  @csrf
                  <button type="submit" class="btn-wish" onclick="event.stopPropagation();">
                    <i class="far fa-heart"></i>
                  </button>
                </form>
                <span class="b-views"><i class="fas fa-eye" style="margin-right:2px;"></i>{{ $item->views }}</span>
                <span class="b-cond">{{ $item->condition }}</span>
              </div>
              <div class="p-body">
                <p class="p-title">{{ $item->title }}</p>
                <div class="p-meta-row">
                  <span class="p-cat">{{ $item->category }}</span>
                  <span class="p-rating"><i class="fas fa-star"></i><span style="color:#9ca3af;">{{ number_format($item->seller_rating,1) }}</span></span>
                </div>
                <p class="p-seller">{{ $item->user->name }}</p>
              </div>
            </a>
          @endforeach
        </div>

        @if($items->hasPages())
          <div style="display:flex;justify-content:center;margin-top:16px;">{{ $items->links() }}</div>
        @endif

      @else
        <div class="empty-state">
          <i class="fas fa-hand-holding-heart" style="font-size:3rem;color:#e5e7eb;margin-bottom:12px;display:block;"></i>
          <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 6px;">No donated items yet</h3>
          <p style="font-size:0.82rem;color:#9ca3af;margin:0 0 16px;">
            @if(request('search') || (request('category') && request('category') !== 'all'))
              No items match your filters. Try adjusting them.
            @else
              Be the first to donate an item to the UB community!
            @endif
          </p>
          <a href="{{ route('items.create') }}"
             style="display:inline-flex;align-items:center;gap:6px;padding:9px 20px;background:#16a34a;color:#fff;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;"
             onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
            <i class="fas fa-plus"></i> Donate an Item
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
