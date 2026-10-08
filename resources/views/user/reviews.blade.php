@extends('layouts.master')

@section('title', 'My Reviews')

@section('content')
<style>
*{box-sizing:border-box;}

.rv-wrap { max-width:900px; margin:0 auto; padding:20px 16px 40px; }

/* ─── HEADER HERO ─── */
.rv-hero {
  background: linear-gradient(135deg,#7b0f10 0%,#5a0a0b 100%);
  border-radius:18px; padding:24px 28px; color:#fff;
  position:relative; overflow:hidden; margin-bottom:20px;
}
.rv-hero::before {
  content:'';
  position:absolute; inset:0;
  background:radial-gradient(circle at 80% 50%, rgba(245,197,24,0.12) 0%, transparent 60%);
}
.rv-hero-content { position:relative; z-index:1; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; }
.big-rating { font-size:3.5rem; font-weight:900; line-height:1; margin:0 0 4px; }

/* ─── STAT CARDS ─── */
.stat-row { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
@media(max-width:800px){ .stat-row{ grid-template-columns:repeat(2,1fr); } }
.stat-card { background:#fff; border-radius:14px; padding:16px 18px; box-shadow:0 1px 4px rgba(0,0,0,0.07); border-top:4px solid transparent; }

/* ─── RATING BREAKDOWN ─── */
.breakdown-card { background:#fff; border-radius:14px; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.07); margin-bottom:20px; }
.rating-bar-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
.rating-bar-label { font-size:0.72rem; font-weight:700; color:#374151; min-width:28px; text-align:right; display:flex; align-items:center; gap:3px; }
.rating-bar-track { flex:1; height:9px; background:#f3f4f6; border-radius:999px; overflow:hidden; }
.rating-bar-fill  { height:100%; border-radius:999px; background:linear-gradient(90deg,#f5c518,#f59e0b); transition:width 0.8s ease; }
.rating-bar-count { font-size:0.68rem; color:#9ca3af; min-width:24px; }

/* ─── REVIEW CARDS ─── */
.review-card {
  background:#fff; border-radius:14px; padding:18px 20px;
  box-shadow:0 1px 4px rgba(0,0,0,0.07); border:1px solid #f3f4f6;
  margin-bottom:12px; transition:box-shadow 0.18s;
}
.review-card:hover { box-shadow:0 4px 14px rgba(0,0,0,0.1); }

.reviewer-row { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:12px; }
.reviewer-info { display:flex; align-items:center; gap:10px; }
.reviewer-avatar { width:40px; height:40px; border-radius:50%; border:2px solid #f3f4f6; flex-shrink:0; }
.reviewer-name { font-size:0.88rem; font-weight:700; color:#1a1209; margin:0 0 2px; }
.reviewer-time { font-size:0.7rem; color:#9ca3af; margin:0; }

.star-row { display:flex; align-items:center; gap:2px; }
.star { font-size:0.8rem; }
.star.filled { color:#f5c518; }
.star.empty  { color:#e5e7eb; }

.review-comment { font-size:0.85rem; color:#4b5563; line-height:1.65; margin:0 0 10px; }
.review-item-pill {
  display:inline-flex; align-items:center; gap:6px;
  background:#f9fafb; border:1px solid #f3f4f6; border-radius:8px;
  padding:5px 10px; font-size:0.7rem; color:#6b7280;
  text-decoration:none; transition:all 0.15s;
}
.review-item-pill:hover { background:#fff8f8; border-color:#fecaca; color:#7b0f10; text-decoration:none; }
.review-item-pill strong { color:#374151; font-weight:600; }

.rating-badge {
  display:inline-flex; align-items:center; gap:4px;
  padding:4px 10px; border-radius:999px; font-size:0.72rem; font-weight:700;
}

/* ─── EMPTY STATE ─── */
.empty-state { background:#fff; border-radius:16px; padding:60px 24px; text-align:center; box-shadow:0 1px 4px rgba(0,0,0,0.07); }
</style>

<div class="rv-wrap">

  {{-- ── HERO ── --}}
  <div class="rv-hero">
    <div class="rv-hero-content">
      <div>
        <p style="font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:0.12em;opacity:0.7;margin:0 0 6px;">
          <i class="fas fa-star" style="margin-right:4px;"></i> Trust & Reputation
        </p>
        <h1 style="font-size:1.5rem;font-weight:900;margin:0 0 4px;">My Reviews &amp; Ratings</h1>
        <p style="font-size:0.8rem;opacity:0.75;margin:0;">Reviews from other UB students about your trades</p>
      </div>
      <div style="text-align:right;">
        <p class="big-rating">{{ number_format($averageRating,1) }}</p>
        <div class="star-row" style="justify-content:flex-end;margin-bottom:4px;">
          @for($i=0;$i<5;$i++)
            <i class="{{ $i < round($averageRating) ? 'fas' : 'far' }} fa-star star {{ $i < round($averageRating) ? 'filled' : 'empty' }}"></i>
          @endfor
        </div>
        <p style="font-size:0.72rem;opacity:0.7;margin:0;">{{ $totalReviews }} review{{ $totalReviews!==1?'s':'' }}</p>
      </div>
    </div>
  </div>

  {{-- ── STAT CARDS ── --}}
  <div class="stat-row">
    <div class="stat-card" style="border-top-color:#7b0f10;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Overall Rating</p>
      <div style="display:flex;align-items:baseline;gap:6px;margin-bottom:4px;">
        <p style="font-size:1.8rem;font-weight:900;color:#7b0f10;margin:0;line-height:1;">{{ number_format($averageRating,1) }}</p>
        <p style="font-size:0.78rem;color:#9ca3af;margin:0;">/5</p>
      </div>
      <div class="star-row">
        @for($i=0;$i<5;$i++)
          <i class="{{ $i < round($averageRating) ? 'fas' : 'far' }} fa-star" style="color:#f5c518;font-size:0.65rem;"></i>
        @endfor
      </div>
    </div>

    <div class="stat-card" style="border-top-color:#f5c518;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Total Reviews</p>
      <p style="font-size:1.8rem;font-weight:900;color:#7b0f10;margin:0 0 4px;line-height:1;">{{ $totalReviews }}</p>
      <p style="font-size:0.68rem;color:#9ca3af;margin:0;">From different traders</p>
    </div>

    <div class="stat-card" style="border-top-color:#22c55e;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Trust Score</p>
      <p style="font-size:1.8rem;font-weight:900;color:#16a34a;margin:0 0 4px;line-height:1;">{{ round(($averageRating/5)*100) }}%</p>
      <p style="font-size:0.68rem;color:#9ca3af;margin:0;">Reliability rating</p>
    </div>

    <div class="stat-card" style="border-top-color:#3b82f6;">
      <p style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 6px;">Trader Status</p>
      <p style="font-size:1rem;font-weight:800;margin:6px 0 2px;line-height:1.1;">
        @if($averageRating >= 4.5)
          <span style="color:#16a34a;">⭐ Excellent</span>
        @elseif($averageRating >= 3.5)
          <span style="color:#2563eb;">⭐ Good</span>
        @elseif($averageRating >= 2.5)
          <span style="color:#d97706;">⭐ Fair</span>
        @else
          <span style="color:#dc2626;">⭐ Poor</span>
        @endif
      </p>
      <p style="font-size:0.68rem;color:#9ca3af;margin:0;">Based on all reviews</p>
    </div>
  </div>

  {{-- ── RATING BREAKDOWN ── --}}
  @if($totalReviews > 0)
    <div class="breakdown-card">
      <h3 style="font-size:0.88rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:7px;">
        <i class="fas fa-chart-bar" style="color:#7b0f10;font-size:0.82rem;"></i> Rating Breakdown
      </h3>
      @php
        $starCounts = [5=>0,4=>0,3=>0,2=>0,1=>0];
        foreach($reviews as $r){ if(isset($starCounts[$r->rating])) $starCounts[$r->rating]++; }
      @endphp
      @foreach([5,4,3,2,1] as $star)
        @php $pct = $totalReviews > 0 ? round(($starCounts[$star]/$totalReviews)*100) : 0; @endphp
        <div class="rating-bar-row">
          <span class="rating-bar-label">{{ $star }}<i class="fas fa-star" style="color:#f5c518;font-size:0.6rem;"></i></span>
          <div class="rating-bar-track">
            <div class="rating-bar-fill" style="width:{{ $pct }}%;"></div>
          </div>
          <span class="rating-bar-count">{{ $starCounts[$star] }}</span>
        </div>
      @endforeach
    </div>
  @endif

  {{-- ── REVIEWS LIST ── --}}
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
    <h2 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;">All Reviews ({{ $totalReviews }})</h2>
  </div>

  @forelse($reviews as $review)
    <div class="review-card">
      <div class="reviewer-row">
        {{-- Reviewer info --}}
        <div class="reviewer-info">
          <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer->name) }}&background=7b0f10&color=fff&bold=true&size=40"
               alt="{{ $review->reviewer->name }}" class="reviewer-avatar">
          <div>
            <p class="reviewer-name">{{ $review->reviewer->name }}</p>
            <p class="reviewer-time">{{ $review->created_at->diffForHumans() }}</p>
          </div>
        </div>

        {{-- Rating + delete --}}
        <div style="display:flex;align-items:center;gap:10px;">
          <div>
            <span class="rating-badge" style="background:{{ $review->rating>=4?'#dcfce7':($review->rating>=3?'#fef9c3':'#fee2e2') }};color:{{ $review->rating>=4?'#166534':($review->rating>=3?'#92400e':'#991b1b') }};">
              @for($j=0;$j<$review->rating;$j++)<i class="fas fa-star"></i>@endfor
              {{ $review->rating }}/5
            </span>
          </div>
          @if(auth()->user()->id === $review->reviewer_id)
            <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit"
                      style="background:#fef2f2;border:none;color:#ef4444;font-size:0.7rem;font-weight:700;padding:5px 10px;border-radius:7px;cursor:pointer;transition:all 0.15s;"
                      onmouseover="this.style.background='#ef4444';this.style.color='#fff'" onmouseout="this.style.background='#fef2f2';this.style.color='#ef4444'"
                      onclick="return confirm('Delete this review?')">
                <i class="fas fa-trash-alt" style="margin-right:3px;"></i> Delete
              </button>
            </form>
          @endif
        </div>
      </div>

      @if($review->comment)
        <p class="review-comment">"{{ $review->comment }}"</p>
      @else
        <p style="font-size:0.8rem;color:#d1d5db;font-style:italic;margin:0 0 10px;">No written comment provided.</p>
      @endif

      <a href="{{ route('items.show', $review->item) }}" class="review-item-pill">
        <i class="fas fa-box" style="color:#9ca3af;font-size:0.68rem;"></i>
        Item: <strong>{{ Str::limit($review->item->title, 40) }}</strong>
        <i class="fas fa-arrow-right" style="font-size:0.6rem;color:#9ca3af;"></i>
      </a>
    </div>
  @empty
    <div class="empty-state">
      <i class="fas fa-star" style="font-size:3rem;color:#f3f4f6;margin-bottom:14px;display:block;"></i>
      <h3 style="font-size:1.1rem;font-weight:800;color:#1a1209;margin:0 0 6px;">No reviews yet</h3>
      <p style="font-size:0.85rem;color:#9ca3af;margin:0 0 20px;max-width:360px;display:inline-block;line-height:1.6;">
        Complete trades and other users can leave you reviews to build your reputation!
      </p>
      <a href="{{ route('items.browse') }}"
         style="display:inline-flex;align-items:center;gap:7px;padding:10px 20px;background:#7b0f10;color:#fff;border-radius:12px;font-weight:700;font-size:0.85rem;text-decoration:none;transition:background 0.15s;"
         onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
        <i class="fas fa-shopping-bag"></i> Start Browsing Items
      </a>
    </div>
  @endforelse

  @if($reviews->hasPages())
    <div style="display:flex;justify-content:center;margin-top:20px;">
      {{ $reviews->links() }}
    </div>
  @endif

</div>
@endsection
