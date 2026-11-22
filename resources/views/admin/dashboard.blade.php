@extends('layouts.master')
@section('title', 'Admin Overview')
@section('content')
<style>
*{box-sizing:border-box;}
.aw{max-width:1200px;margin:0 auto;padding:20px 16px;}
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
@media(max-width:900px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
.stat-card{background:#fff;border-radius:14px;padding:18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid transparent;display:flex;flex-direction:column;gap:4px;}
.stat-label{font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;}
.stat-value{font-size:2rem;font-weight:900;line-height:1;}
.stat-sub{font-size:0.65rem;font-weight:600;}
.sec{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;}
.sec-hd{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;}
.sec-hd h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.badge{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;color:#fff;}
.ag{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding:16px;}
@media(max-width:700px){.ag{grid-template-columns:1fr;}}
.ac{background:#f9fafb;border-radius:12px;padding:16px;border:1px solid #f3f4f6;}
.ac h4{font-size:0.78rem;font-weight:700;color:#374151;margin:0 0 12px;}
.br{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
.bl{font-size:0.65rem;color:#6b7280;min-width:80px;}
.bb{flex:1;height:8px;background:#e5e7eb;border-radius:999px;overflow:hidden;}
.bf{height:100%;border-radius:999px;}
.bv{font-size:0.65rem;font-weight:700;color:#374151;min-width:30px;text-align:right;}
</style>

<div class="aw">
  {{-- Header --}}
  <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:4px;">
    <div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
        <span style="background:#7b0f10;color:#fff;font-size:0.6rem;font-weight:800;padding:3px 10px;border-radius:999px;text-transform:uppercase;">CES ADMIN</span>
        <span style="font-size:0.72rem;color:#9ca3af;">Community Extension Services · University of Batangas</span>
      </div>
      <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0;">Admin Control Panel</h1>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" style="padding:9px 16px;background:#fee2e2;color:#991b1b;border:none;border-radius:10px;font-size:0.75rem;font-weight:700;cursor:pointer;transition:all 0.15s;"
              onmouseover="this.style.background='#dc2626';this.style.color='#fff'" onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'">
        <i class="fas fa-sign-out-alt" style="margin-right:4px;"></i> Logout
      </button>
    </form>
  </div>

  {{-- Admin sub-nav --}}
  @include('admin.partials.nav')

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- 8.4 Stats --}}
  <div class="stat-grid">
    <div class="stat-card" style="border-top-color:#f97316;">
      <span class="stat-label">Pending Donations</span>
      <span class="stat-value" style="color:#f97316;">{{ $totalPending }}</span>
      <span class="stat-sub" style="color:#f97316;"><i class="fas fa-clock" style="margin-right:3px;"></i>Needs review</span>
    </div>
    <div class="stat-card" style="border-top-color:#16a34a;">
      <span class="stat-label">Active Items (D2)</span>
      <span class="stat-value" style="color:#16a34a;">{{ $activeItems }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Live on platform</span>
    </div>
    <div class="stat-card" style="border-top-color:#8b5cf6;">
      <span class="stat-label">Total Users (D1)</span>
      <span class="stat-value" style="color:#8b5cf6;">{{ $totalUsers }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Registered accounts</span>
    </div>
    <div class="stat-card" style="border-top-color:#10b981;">
      <span class="stat-label">Pending (D4)</span>
      <span class="stat-value" style="color:#10b981;">{{ $pendingDonation }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Donations awaiting</span>
    </div>
  </div>

  {{-- Analytics --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge" style="background:#0ea5e9;">8.4</span>
      <h2>Dashboard Metrics — Analytics Report</h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">D1 / D2 / D3 / D4</span>
    </div>
    <div class="ag">
      <div class="ac">
        <h4><i class="fas fa-boxes" style="color:#7b0f10;margin-right:5px;"></i> Items (D2)</h4>
        @php $totalApproval = max(1, $totalPending + $activeItems); @endphp
        <div class="br"><span class="bl">Active</span><div class="bb"><div class="bf" style="width:{{ min(100,($activeItems/$totalApproval)*100) }}%;background:#16a34a;"></div></div><span class="bv">{{ $activeItems }}</span></div>
        <div class="br"><span class="bl">Pending</span><div class="bb"><div class="bf" style="width:{{ min(100,($totalPending/$totalApproval)*100) }}%;background:#f97316;"></div></div><span class="bv">{{ $totalPending }}</span></div>
      </div>
      <div class="ac">
        <h4><i class="fas fa-users" style="color:#8b5cf6;margin-right:5px;"></i> User Activity (D1)</h4>
        <div class="br"><span class="bl">Total</span><div class="bb"><div class="bf" style="width:100%;background:#8b5cf6;"></div></div><span class="bv">{{ $totalUsers }}</span></div>
        <div class="br"><span class="bl">Active</span><div class="bb"><div class="bf" style="width:85%;background:#10b981;"></div></div><span class="bv">~{{ round($totalUsers*0.85) }}</span></div>
        <div class="br"><span class="bl">Restricted</span><div class="bb"><div class="bf" style="width:5%;background:#ef4444;"></div></div><span class="bv">~{{ round($totalUsers*0.05) }}</span></div>
      </div>
      <div class="ac">
        <h4><i class="fas fa-exchange-alt" style="color:#0ea5e9;margin-right:5px;"></i> Barters (D3)</h4>
        <div class="br"><span class="bl">Pending</span><div class="bb"><div class="bf" style="width:{{ $totalPending>0?min(100,($pendingBarter/$totalPending)*100):0 }}%;background:#0ea5e9;"></div></div><span class="bv">{{ $pendingBarter }}</span></div>
      </div>
      <div class="ac">
        <h4><i class="fas fa-hand-holding-heart" style="color:#16a34a;margin-right:5px;"></i> Donations (D4)</h4>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:4px;">
          <div style="background:#fff;border-radius:10px;padding:12px;text-align:center;border:1px solid #f0f0f0;">
            <p style="font-size:1.6rem;font-weight:900;color:#f97316;margin:0;line-height:1;">{{ $pendingDonation }}</p>
            <p style="font-size:0.62rem;color:#9ca3af;margin:4px 0 0;">Pending</p>
          </div>
          <div style="background:#fff;border-radius:10px;padding:12px;text-align:center;border:1px solid #f0f0f0;">
            <p style="font-size:1.6rem;font-weight:900;color:#16a34a;margin:0;line-height:1;">{{ $activeItems }}</p>
            <p style="font-size:0.62rem;color:#9ca3af;margin:4px 0 0;">Approved</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Recent Activity --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge" style="background:#374151;">Activity</span>
      <h2>Recent Pending Submissions</h2>
    </div>
    @forelse($recentActivity as $item)
      <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f9fafb;">
        <img src="{{ $item->image_url }}" style="width:38px;height:38px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">
        <div style="flex:1;min-width:0;">
          <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $item->title }}</p>
          <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;">by {{ $item->user->name }} · {{ $item->posted_at->diffForHumans() }}</p>
        </div>
        <span style="font-size:0.65rem;font-weight:700;padding:3px 9px;border-radius:999px;color:#fff;background:{{ $item->item_type==='Barter'?'#7b0f10':'#16a34a' }};">{{ $item->item_type }}</span>
        <a href="{{ route('admin.donations') }}" style="font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;">Review →</a>
      </div>
    @empty
      <div style="padding:32px;text-align:center;color:#9ca3af;font-size:0.85rem;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:1.5rem;display:block;margin-bottom:8px;"></i>
        No pending submissions.
      </div>
    @endforelse
  </div>

</div>
@endsection
