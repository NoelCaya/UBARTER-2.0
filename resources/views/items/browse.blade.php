@extends('layouts.master')

@section('title', 'Browse & Barter - UBarter')

@section('content')
<style>
*{box-sizing:border-box;}

.item-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
  padding: 12px;
}
@media(max-width:1100px){ .item-grid{ grid-template-columns: repeat(3,1fr); } }
@media(max-width:700px){  .item-grid{ grid-template-columns: repeat(2,1fr); } }

.p-card {
  display: flex; flex-direction: column;
  background: #fff; border-radius: 10px; overflow: hidden;
  border: 1px solid #f0f0f0; box-shadow: 0 1px 3px rgba(0,0,0,0.07);
  text-decoration: none; color: inherit;
  transition: box-shadow 0.18s, transform 0.18s; cursor: pointer;
}
.p-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.13); transform: translateY(-2px); text-decoration: none; color: inherit; }

.p-card .img-box {
  position: relative; width: 100%; padding-bottom: 100%;
  overflow: hidden; background: #f5f5f5; flex-shrink: 0;
}
.p-card .img-box img {
  position: absolute; inset: 0; width: 100%; height: 100%;
  object-fit: cover; object-position: center; display: block;
  transition: transform 0.3s ease;
}
.p-card:hover .img-box img { transform: scale(1.06); }

.b-type {
  position: absolute; top: 5px; left: 5px;
  font-size: 0.52rem; font-weight: 800; padding: 2px 6px;
  border-radius: 4px; text-transform: uppercase; color: #fff; z-index: 1;
}
.b-cond {
  position: absolute; bottom: 5px; right: 5px;
  font-size: 0.52rem; font-weight: 700;
  background: rgba(0,0,0,0.55); color: #fff; padding: 1px 5px;
  border-radius: 3px; z-index: 1;
}
.b-views {
  position: absolute; bottom: 5px; left: 5px;
  font-size: 0.52rem; background: rgba(0,0,0,0.45);
  color: #fff; padding: 1px 5px; border-radius: 3px; z-index: 1;
}
.btn-wish {
  position: absolute; top: 5px; right: 5px;
  width: 28px; height: 28px; background: rgba(255,255,255,0.92);
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
  border: none; cursor: pointer; font-size: 0.75rem; color: #ccc;
  transition: all 0.15s; z-index: 2;
}
.btn-wish.wishlisted { color: #ef4444; background:#fff; }
.btn-wish:hover { background:#fff; color:#ef4444; transform:scale(1.1); }

.p-card .p-body { padding: 8px 9px 10px; flex: 1; display: flex; flex-direction: column; }
.p-title { font-size: 0.72rem; font-weight: 600; color: #1a1209; line-height: 1.3; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin: 0 0 4px; }
.p-meta-row { display: flex; align-items: center; justify-content: space-between; margin-top: 2px; }
.p-cat { font-size: 0.55rem; font-weight: 700; background: rgba(123,15,16,0.07); color: #7b0f10; padding: 2px 6px; border-radius: 3px; }
.p-rating { font-size: 0.55rem; color: #f5c518; display: flex; align-items: center; gap: 2px; }
.p-seller { font-size: 0.58rem; color: #9ca3af; margin-top: 3px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.p-timestamp { font-size: 0.55rem; color: #d1d5db; margin-top: 2px; }
.p-wishcount { font-size: 0.55rem; color: #ef4444; display:flex; align-items:center; gap:2px; }

/* Browse layout */
.browse-wrap { max-width: 1200px; margin: 0 auto; padding: 20px 16px; }
.browse-layout { display: flex; gap: 16px; align-items: flex-start; }

/* Filter sidebar */
.filter-sidebar { width: 190px; flex-shrink: 0; position: sticky; top: 74px; max-height: calc(100vh - 90px); overflow-y: auto; }
@media(max-width:900px){ .filter-sidebar{ display:none; } }

.filter-card { background: #fff; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.07); padding: 16px; }
.filter-section { padding-bottom: 12px; border-bottom: 1px solid #f3f4f6; margin-bottom: 12px; }
.filter-section:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
.filter-label { font-size: 0.6rem; font-weight: 800; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.09em; display: block; margin-bottom: 8px; }
.filter-input { width: 100%; padding: 7px 10px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.78rem; outline: none; transition: border-color 0.15s; background: #fafafa; }
.filter-input:focus { border-color: #7b0f10; background: #fff; }
.filter-radio-row { display: flex; align-items: center; gap: 7px; margin-bottom: 6px; cursor: pointer; }
.filter-radio-row input { accent-color: #7b0f10; width: 13px; height: 13px; cursor: pointer; }
.filter-radio-row span { font-size: 0.72rem; color: #4b5563; }
.btn-reset { display: block; width: 100%; padding: 7px; text-align: center; border: 1.5px solid #e5e7eb; color: #6b7280; border-radius: 8px; font-size: 0.72rem; font-weight: 600; text-decoration: none; transition: all 0.15s; background: #fff; }
.btn-reset:hover { border-color: #9ca3af; background: #f9fafb; color: #374151; text-decoration: none; }

.items-area { flex: 1; min-width: 0; }
.toolbar { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 10px 14px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
.toolbar-count { font-size: 0.75rem; color: #6b7280; }
.toolbar-count strong { color: #1a1209; }
.sort-select { padding: 6px 28px 6px 10px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.75rem; outline: none; cursor: pointer; background: #fff; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 8px center; background-size: 13px; }
.sort-select:focus { border-color: #7b0f10; }

.btn-mobile-filter { display: none; align-items: center; gap: 5px; padding: 6px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.75rem; font-weight: 600; color: #6b7280; background: #fff; cursor: pointer; transition: all 0.15s; }
.btn-mobile-filter:hover { border-color: #7b0f10; color: #7b0f10; }
@media(max-width:900px){ .btn-mobile-filter{ display:flex; } }

.mobile-filters-panel { display: none; background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.07); padding: 14px; margin-bottom: 10px; }
.mobile-filters-panel.open { display: block; }
.mobile-filters-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

.empty-state { background: #fff; border-radius: 14px; padding: 60px 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.07); }
</style>

<div class="browse-wrap">
  <div style="margin-bottom:16px;">
    <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0 0 2px;">Browse &amp; Barter</h1>
    <p style="font-size:0.78rem;color:#9ca3af;margin:0;">Discover items from your UB community</p>
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  <div class="browse-layout">

    {{-- ══ DESKTOP FILTER SIDEBAR — auto-submit on change (#5) ══ --}}
    <div class="filter-sidebar">
      <div class="filter-card">
        <h2 style="font-size:0.82rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-sliders-h" style="color:#7b0f10;font-size:0.75rem;"></i> Filters
        </h2>
        <form id="filterForm" action="{{ route('items.browse') }}" method="GET">

          <div class="filter-section">
            <label class="filter-label">Search</label>
            <input type="text" name="search" value="{{ $currentFilters['search'] }}"
                   placeholder="Search items…" class="filter-input"
                   oninput="debounceFilter()">
          </div>

          <div class="filter-section">
            <label class="filter-label">Category</label>
            <label class="filter-radio-row">
              <input type="radio" name="category" value="all"
                     {{ $currentFilters['category']==='all'?'checked':'' }}
                     onchange="submitFilter()">
              <span>All Categories</span>
            </label>
            @foreach($categories as $cat)
              <label class="filter-radio-row">
                <input type="radio" name="category" value="{{ $cat }}"
                       {{ $currentFilters['category']===$cat?'checked':'' }}
                       onchange="submitFilter()">
                <span>{{ $cat }}</span>
              </label>
            @endforeach
          </div>

          <div class="filter-section">
            <label class="filter-label">Condition</label>
            <label class="filter-radio-row">
              <input type="radio" name="condition" value="all"
                     {{ $currentFilters['condition']==='all'?'checked':'' }}
                     onchange="submitFilter()">
              <span>All</span>
            </label>
            @foreach($conditions as $cond)
              <label class="filter-radio-row">
                <input type="radio" name="condition" value="{{ $cond }}"
                       {{ $currentFilters['condition']===$cond?'checked':'' }}
                       onchange="submitFilter()">
                <span>{{ $cond }}</span>
              </label>
            @endforeach
          </div>

          <input type="hidden" name="sort" value="{{ $currentFilters['sort'] }}">
          <a href="{{ route('items.browse') }}" class="btn-reset"><i class="fas fa-redo" style="margin-right:4px;"></i> Reset</a>
        </form>
      </div>
    </div>

    {{-- ══ ITEMS AREA ══ --}}
    <div class="items-area">

      {{-- Toolbar --}}
      <div class="toolbar">
        <p class="toolbar-count">
          <strong>{{ $items->total() }}</strong> items found
        </p>
        <div style="display:flex;align-items:center;gap:8px;">
          <button class="btn-mobile-filter" onclick="document.getElementById('mobileFilters').classList.toggle('open')">
            <i class="fas fa-sliders-h"></i> Filters
          </button>
          <form action="{{ route('items.browse') }}" method="GET" style="display:flex;align-items:center;gap:6px;">
            <input type="hidden" name="search"    value="{{ $currentFilters['search'] }}">
            <input type="hidden" name="category"  value="{{ $currentFilters['category'] }}">
            <input type="hidden" name="condition" value="{{ $currentFilters['condition'] }}">
            <label style="font-size:0.72rem;color:#9ca3af;">Sort:</label>
            <select name="sort" onchange="this.form.submit()" class="sort-select">
              <option value="newest"         {{ $currentFilters['sort']==='newest'         ?'selected':'' }}>Newest</option>
              <option value="most_viewed"    {{ $currentFilters['sort']==='most_viewed'    ?'selected':'' }}>Most Popular</option>
              <option value="highest_rated"  {{ $currentFilters['sort']==='highest_rated'  ?'selected':'' }}>Highest Rated</option>
              <option value="most_wishlisted"{{ $currentFilters['sort']==='most_wishlisted'?'selected':'' }}>Most Wishlisted</option>
            </select>
          </form>
        </div>
      </div>

      {{-- Mobile filters panel --}}
      <div id="mobileFilters" class="mobile-filters-panel">
        <form action="{{ route('items.browse') }}" method="GET">
          <div class="mobile-filters-grid">
            <div>
              <label class="filter-label" style="display:block;margin-bottom:4px;">Search</label>
              <input type="text" name="search" value="{{ $currentFilters['search'] }}" placeholder="Search…" class="filter-input">
            </div>
            <div>
              <label class="filter-label" style="display:block;margin-bottom:4px;">Condition</label>
              <select name="condition" class="filter-input" style="padding:7px 10px;" onchange="this.form.submit()">
                <option value="all" {{ $currentFilters['condition']==='all'?'selected':'' }}>All</option>
                @foreach($conditions as $cond)
                  <option value="{{ $cond }}" {{ $currentFilters['condition']===$cond?'selected':'' }}>{{ $cond }}</option>
                @endforeach
              </select>
            </div>
            <div style="grid-column:span 2;">
              <label class="filter-label" style="display:block;margin-bottom:4px;">Category</label>
              <select name="category" class="filter-input" style="padding:7px 10px;" onchange="this.form.submit()">
                <option value="all" {{ $currentFilters['category']==='all'?'selected':'' }}>All Categories</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat }}" {{ $currentFilters['category']===$cat?'selected':'' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <input type="hidden" name="sort" value="{{ $currentFilters['sort'] }}">
          <div style="display:flex;gap:8px;margin-top:10px;">
            <a href="{{ route('items.browse') }}" class="btn-reset" style="flex:1;">Reset</a>
          </div>
        </form>
      </div>

      {{-- ── ITEM GRID ── --}}
      @if($items->count() > 0)
        <div class="item-grid">
          @foreach($items as $item)
            @php
              $isWishlisted = auth()->check()
                ? \App\Models\Wishlist::where('user_id', auth()->id())->where('item_id', $item->id)->exists()
                : false;
            @endphp
            <div class="p-card" onclick="window.location='{{ route('items.show', $item) }}'">
              <div class="img-box">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                <span class="b-type" style="background:#7b0f10;">Barter</span>
                {{-- Wishlist toggle button (#6) --}}
                <button class="btn-wish {{ $isWishlisted ? 'wishlisted' : '' }}"
                        onclick="event.stopPropagation(); toggleWishlist(this, {{ $item->id }})"
                        data-item-id="{{ $item->id }}"
                        title="{{ $isWishlisted ? 'Remove from wishlist' : 'Save to wishlist' }}">
                  <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
                </button>
                <span class="b-views"><i class="fas fa-eye" style="margin-right:2px;"></i>{{ $item->views }}</span>
                <span class="b-cond">{{ $item->condition }}</span>
              </div>
              <div class="p-body">
                <p class="p-title">{{ $item->title }}</p>
                <div class="p-meta-row">
                  <span class="p-cat">{{ $item->category }}</span>
                  <span class="p-wishcount" id="wc-{{ $item->id }}">
                    <i class="fas fa-heart"></i> {{ $item->wishlist_count }}
                  </span>
                </div>
                <p class="p-seller">{{ $item->user->name }}</p>
                {{-- Timestamp (#9) --}}
                <p class="p-timestamp">
                  <i class="far fa-clock" style="margin-right:2px;"></i>
                  {{ $item->posted_at ? $item->posted_at->diffForHumans() : $item->created_at->diffForHumans() }}
                </p>
              </div>
            </div>
          @endforeach
        </div>

        @if($items->hasPages())
          <div style="display:flex;justify-content:center;margin-top:16px;">
            {{ $items->appends(request()->query())->links() }}
          </div>
        @endif

      @else
        <div class="empty-state">
          <i class="fas fa-inbox" style="font-size:3rem;color:#e5e7eb;margin-bottom:12px;display:block;"></i>
          <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 6px;">No items found</h3>
          <p style="font-size:0.82rem;color:#9ca3af;margin:0 0 16px;">Try adjusting your filters.</p>
          <a href="{{ route('items.browse') }}"
             style="display:inline-flex;align-items:center;gap:6px;padding:9px 20px;background:#7b0f10;color:#fff;border-radius:10px;font-size:0.82rem;font-weight:700;text-decoration:none;">
            <i class="fas fa-redo"></i> Clear Filters
          </a>
        </div>
      @endif
    </div>
  </div>
</div>

<script>
// Auto-submit filter form with debounce for search (#5)
let filterTimer = null;
function debounceFilter() {
  clearTimeout(filterTimer);
  filterTimer = setTimeout(submitFilter, 500);
}
function submitFilter() {
  document.getElementById('filterForm')?.submit();
}

// Wishlist toggle via AJAX (#6)
function toggleWishlist(btn, itemId) {
  fetch(`/wishlist/toggle/${itemId}`, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
  })
  .then(r => r.json())
  .then(data => {
    const icon = btn.querySelector('i');
    if (data.in_wishlist) {
      icon.className = 'fas fa-heart';
      btn.classList.add('wishlisted');
      btn.title = 'Remove from wishlist';
    } else {
      icon.className = 'far fa-heart';
      btn.classList.remove('wishlisted');
      btn.title = 'Save to wishlist';
    }
    // Update counter (#7)
    const counter = document.getElementById(`wc-${itemId}`);
    if (counter) counter.innerHTML = `<i class="fas fa-heart"></i> ${data.wishlist_count}`;
  })
  .catch(err => console.error(err));
}
</script>
@endsection
