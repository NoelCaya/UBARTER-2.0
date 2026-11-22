@extends('layouts.master')
@section('title', 'Active Traders - UBarter')
@section('content')
<div style="max-width:1100px;margin:0 auto;padding:24px 16px;">

  {{-- Header --}}
  <div style="background:linear-gradient(135deg,#7b0f10,#5a0a0b);border-radius:18px;padding:24px 28px;color:#fff;margin-bottom:20px;">
    <h1 style="font-size:1.5rem;font-weight:900;margin:0 0 4px;">🏅 Active Traders</h1>
    <p style="font-size:0.82rem;opacity:0.8;margin:0;">Community reputation wall — see who your fellow UB students trust most</p>
  </div>

  {{-- Search --}}
  <form method="GET" action="{{ route('reputation.index') }}" style="margin-bottom:16px;">
    <div style="display:flex;gap:8px;max-width:400px;">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search traders…"
             style="flex:1;padding:9px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:0.85rem;outline:none;"
             onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'">
      <button type="submit" style="background:#7b0f10;color:#fff;border:none;border-radius:10px;padding:9px 18px;font-size:0.82rem;font-weight:700;cursor:pointer;">
        Search
      </button>
    </div>
  </form>

  {{-- Traders grid --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;">
    @forelse($traders as $trader)
      @php $avg = round($trader->avg_rating ?? 0, 1); @endphp
      <a href="{{ route('reputation.show', $trader) }}" style="text-decoration:none;color:inherit;">
        <div style="background:#fff;border-radius:16px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border:1px solid #f3f4f6;transition:box-shadow 0.18s,transform 0.18s;"
             onmouseover="this.style.boxShadow='0 6px 18px rgba(0,0,0,0.12)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.boxShadow='0 1px 4px rgba(0,0,0,0.07)';this.style.transform=''">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            <img src="{{ $trader->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trader->name).'&background=7b0f10&color=fff&bold=true&size=48' }}"
                 alt="{{ $trader->name }}"
                 style="width:48px;height:48px;border-radius:50%;border:2px solid #f3f4f6;flex-shrink:0;">
            <div style="min-width:0;">
              <p style="font-size:0.92rem;font-weight:800;color:#1a1209;margin:0 0 2px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $trader->name }}</p>
              <p style="font-size:0.68rem;color:#9ca3af;margin:0;">{{ $trader->email }}</p>
            </div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;text-align:center;">
            <div style="background:#fef9c3;border-radius:10px;padding:8px 4px;">
              <p style="font-size:1rem;font-weight:900;color:#92400e;margin:0;">{{ $avg > 0 ? $avg : '—' }}</p>
              <p style="font-size:0.58rem;color:#92400e;font-weight:700;margin:2px 0 0;text-transform:uppercase;">Rating</p>
            </div>
            <div style="background:#dcfce7;border-radius:10px;padding:8px 4px;">
              <p style="font-size:1rem;font-weight:900;color:#166534;margin:0;">{{ $trader->completed_trades_count }}</p>
              <p style="font-size:0.58rem;color:#166534;font-weight:700;margin:2px 0 0;text-transform:uppercase;">Trades</p>
            </div>
            <div style="background:#ede9fe;border-radius:10px;padding:8px 4px;">
              <p style="font-size:1rem;font-weight:900;color:#7c3aed;margin:0;">{{ $trader->review_count }}</p>
              <p style="font-size:0.58rem;color:#7c3aed;font-weight:700;margin:2px 0 0;text-transform:uppercase;">Reviews</p>
            </div>
          </div>
          @if($avg > 0)
            <div style="display:flex;gap:2px;margin-top:10px;justify-content:center;">
              @for($s=1;$s<=5;$s++)
                <i class="{{ $s <= round($avg) ? 'fas' : 'far' }} fa-star" style="color:#f5c518;font-size:0.75rem;"></i>
              @endfor
              <span style="font-size:0.68rem;color:#6b7280;margin-left:4px;">{{ $avg }}/5</span>
            </div>
          @endif
          <p style="font-size:0.68rem;color:#7b0f10;font-weight:700;text-align:center;margin:10px 0 0;">
            View Profile & Reviews →
          </p>
        </div>
      </a>
    @empty
      <div style="grid-column:1/-1;background:#fff;border-radius:14px;padding:48px;text-align:center;">
        <i class="fas fa-medal" style="font-size:2.5rem;color:#e5e7eb;margin-bottom:12px;display:block;"></i>
        <p style="font-size:1rem;font-weight:700;color:#1a1209;margin:0 0 6px;">No active traders yet</p>
        <p style="font-size:0.82rem;color:#9ca3af;margin:0;">Complete trades to appear here!</p>
      </div>
    @endforelse
  </div>

  @if($traders->hasPages())
    <div style="display:flex;justify-content:center;margin-top:20px;">{{ $traders->links() }}</div>
  @endif
</div>
@endsection
