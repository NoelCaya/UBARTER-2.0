@extends('layouts.master')
@section('title', $user->name . ' - Trader Profile')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:24px 16px;">

  {{-- Back --}}
  <a href="{{ route('reputation.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.82rem;font-weight:700;color:#7b0f10;text-decoration:none;margin-bottom:16px;">
    <i class="fas fa-arrow-left"></i> Back to Traders
  </a>

  {{-- Profile card --}}
  <div style="background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,0.08);margin-bottom:20px;">
    <div style="height:90px;background:linear-gradient(135deg,#7b0f10,#5a0a0b);"></div>
    <div style="padding:0 24px 20px;position:relative;">
      <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f5c518&color=7b0f10&bold=true&size=80' }}"
           alt="{{ $user->name }}"
           style="width:72px;height:72px;border-radius:50%;border:4px solid #fff;position:absolute;top:-36px;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
      <div style="padding-top:44px;">
        <h1 style="font-size:1.3rem;font-weight:900;color:#1a1209;margin:0 0 3px;">{{ $user->name }}</h1>
        <p style="font-size:0.78rem;color:#9ca3af;margin:0 0 12px;">{{ $user->email }}</p>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;text-align:center;">
          @foreach([
            [number_format($avgRating,1),'#f5c518','Avg Rating'],
            [$totalReviews,'#7b0f10','Reviews'],
            [$completedTrades,'#16a34a','Trades Done'],
            [$user->created_at->format('M Y'),'#6b7280','Member Since'],
          ] as $s)
            <div style="background:#f9fafb;border-radius:12px;padding:12px 8px;">
              <p style="font-size:1.1rem;font-weight:900;color:{{ $s[1] }};margin:0;">{{ $s[0] }}</p>
              <p style="font-size:0.6rem;color:#9ca3af;font-weight:700;text-transform:uppercase;margin:3px 0 0;">{{ $s[2] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- Rating breakdown --}}
  @if($totalReviews > 0)
    <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin-bottom:16px;">
      <h3 style="font-size:0.9rem;font-weight:800;color:#1a1209;margin:0 0 14px;">Rating Breakdown</h3>
      @foreach([5,4,3,2,1] as $star)
        @php $pct = $totalReviews > 0 ? round(($starCounts[$star]/$totalReviews)*100) : 0; @endphp
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
          <span style="font-size:0.72rem;font-weight:700;color:#374151;min-width:28px;text-align:right;">
            {{ $star }}<i class="fas fa-star" style="color:#f5c518;font-size:0.6rem;margin-left:2px;"></i>
          </span>
          <div style="flex:1;height:9px;background:#f3f4f6;border-radius:999px;overflow:hidden;">
            <div style="width:{{ $pct }}%;height:100%;background:linear-gradient(90deg,#f5c518,#f59e0b);border-radius:999px;"></div>
          </div>
          <span style="font-size:0.68rem;color:#9ca3af;min-width:24px;">{{ $starCounts[$star] }}</span>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Reviews list --}}
  <h2 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0 0 12px;">Reviews ({{ $totalReviews }})</h2>
  @forelse($reviews as $review)
    <div style="background:#fff;border-radius:14px;padding:18px 20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border:1px solid #f3f4f6;margin-bottom:12px;">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:10px;">
        <div style="display:flex;align-items:center;gap:10px;">
          <img src="{{ $review->reviewer->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($review->reviewer->name).'&background=7b0f10&color=fff&bold=true&size=40' }}"
               alt="{{ $review->reviewer->name }}"
               style="width:38px;height:38px;border-radius:50%;border:2px solid #f3f4f6;flex-shrink:0;">
          <div>
            <p style="font-size:0.88rem;font-weight:700;color:#1a1209;margin:0;">{{ $review->reviewer->name }}</p>
            <p style="font-size:0.68rem;color:#9ca3af;margin:1px 0 0;">{{ $review->created_at->diffForHumans() }}</p>
          </div>
        </div>
        <div style="display:flex;gap:2px;">
          @for($s=0;$s<5;$s++)
            <i class="{{ $s < $review->rating ? 'fas' : 'far' }} fa-star" style="color:#f5c518;font-size:0.78rem;"></i>
          @endfor
        </div>
      </div>
      @if($review->comment)
        <p style="font-size:0.85rem;color:#4b5563;line-height:1.6;margin:0 0 8px;">"{{ $review->comment }}"</p>
      @endif
      @if($review->item)
        <span style="font-size:0.7rem;color:#9ca3af;background:#f9fafb;padding:3px 8px;border-radius:6px;">
          <i class="fas fa-box" style="margin-right:3px;"></i>{{ $review->item->title ?? 'Deleted item' }}
        </span>
      @endif
    </div>
  @empty
    <div style="background:#fff;border-radius:14px;padding:40px;text-align:center;">
      <i class="fas fa-star" style="font-size:2.5rem;color:#f3f4f6;margin-bottom:12px;display:block;"></i>
      <p style="font-size:0.9rem;color:#9ca3af;margin:0;">No reviews yet for this trader.</p>
    </div>
  @endforelse

  @if($reviews->hasPages())
    <div style="display:flex;justify-content:center;margin-top:20px;">{{ $reviews->links() }}</div>
  @endif
</div>
@endsection
