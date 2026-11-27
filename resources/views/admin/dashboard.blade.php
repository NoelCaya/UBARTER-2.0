@extends('layouts.master')
@section('title', 'Admin Overview')
@section('content')
<style>
*{box-sizing:border-box;}
.aw{max-width:1200px;margin:0 auto;padding:20px 16px;}
/* ── Stat cards ── */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
@media(max-width:900px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:480px){.stat-grid{grid-template-columns:1fr;}}
.stat-card{background:#fff;border-radius:14px;padding:18px 20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid transparent;position:relative;overflow:hidden;}
.stat-card::after{content:'';position:absolute;bottom:-18px;right:-18px;width:70px;height:70px;border-radius:50%;opacity:0.06;}
.stat-label{font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#9ca3af;margin:0 0 6px;}
.stat-value{font-size:2.2rem;font-weight:900;line-height:1;margin:0 0 4px;}
.stat-sub{font-size:0.65rem;font-weight:600;display:flex;align-items:center;gap:4px;}
/* ── Sections ── */
.sec{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;}
.sec-hd{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.sec-hd h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.badge-tag{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;color:#fff;}
/* ── Analytics grid ── */
.ag{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding:16px;}
@media(max-width:700px){.ag{grid-template-columns:1fr;}}
.ac{background:#f9fafb;border-radius:12px;padding:16px 18px;border:1px solid #f3f4f6;}
.ac-title{font-size:0.78rem;font-weight:800;color:#374151;margin:0 0 14px;display:flex;align-items:center;gap:6px;}
/* ── Bar rows ── */
.br{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
.br:last-child{margin-bottom:0;}
.bl{font-size:0.68rem;color:#6b7280;min-width:88px;}
.bb{flex:1;height:9px;background:#e5e7eb;border-radius:999px;overflow:hidden;}
.bf{height:100%;border-radius:999px;transition:width 0.6s ease;}
.bv{font-size:0.68rem;font-weight:700;color:#374151;min-width:28px;text-align:right;}
/* ── Metric tiles ── */
.tile-row{display:grid;gap:8px;}
.tile{background:#fff;border-radius:10px;padding:12px 14px;border:1px solid #f0f0f0;display:flex;align-items:center;gap:10px;}
.tile-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;}
.tile-val{font-size:1.4rem;font-weight:900;line-height:1;}
.tile-lbl{font-size:0.62rem;color:#9ca3af;font-weight:600;margin-top:1px;}
</style>

<div class="aw">

  {{-- Header --}}
  <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
    <div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
        <span style="background:#7b0f10;color:#fff;font-size:0.6rem;font-weight:800;padding:3px 10px;border-radius:999px;text-transform:uppercase;">UBARTER Admin</span>
        <span style="font-size:0.72rem;color:#9ca3af;">University of Batangas</span>
      </div>
      <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0;">Admin Control Panel</h1>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" style="padding:9px 16px;background:#fee2e2;color:#991b1b;border:none;border-radius:10px;font-size:0.75rem;font-weight:700;cursor:pointer;"
              onmouseover="this.style.background='#dc2626';this.style.color='#fff'" onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'">
        <i class="fas fa-sign-out-alt" style="margin-right:4px;"></i> Logout
      </button>
    </form>
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- ── TOP STAT CARDS ── --}}
  <div class="stat-grid">
    <div class="stat-card" style="border-top-color:#8b5cf6;">
      <p class="stat-label">Total Users</p>
      <p class="stat-value" style="color:#8b5cf6;">{{ $totalUsers }}</p>
      <p class="stat-sub" style="color:#16a34a;"><i class="fas fa-circle" style="font-size:0.45rem;"></i> {{ $activeUsers }} active &nbsp;<span style="color:#ef4444;">{{ $suspendedUsers }} restricted</span></p>
    </div>
    <div class="stat-card" style="border-top-color:#0ea5e9;">
      <p class="stat-label">Barter Trades</p>
      <p class="stat-value" style="color:#0ea5e9;">{{ $totalTrades }}</p>
      <p class="stat-sub" style="color:#16a34a;"><i class="fas fa-check-circle"></i> {{ $completedTrades }} completed &nbsp;<span style="color:#f59e0b;">{{ $pendingTrades }} pending</span></p>
    </div>
    <div class="stat-card" style="border-top-color:#16a34a;">
      <p class="stat-label">Active Listings</p>
      <p class="stat-value" style="color:#16a34a;">{{ $activeItems }}</p>
      <p class="stat-sub" style="color:#9ca3af;"><i class="fas fa-exchange-alt"></i> {{ $activeBarters }} barters &nbsp;<i class="fas fa-hand-holding-heart"></i> {{ $activeDonations }} donations</p>
    </div>
    <div class="stat-card" style="border-top-color:#f97316;">
      <p class="stat-label">Pending Donations</p>
      <p class="stat-value" style="color:#f97316;">{{ $pendingDonation }}</p>
      <p class="stat-sub" style="color:#f97316;"><i class="fas fa-clock"></i> Awaiting review</p>
    </div>
  </div>

  {{-- ── ANALYTICS REPORT ── --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge-tag" style="background:#0ea5e9;">8.4</span>
      <h2>Analytics Report</h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">Live data · {{ now()->format('M d, Y g:i A') }}</span>
    </div>
    <div class="ag">

      {{-- Users (D1) --}}
      <div class="ac">
        <p class="ac-title"><i class="fas fa-users" style="color:#8b5cf6;"></i> Users (D1)</p>
        @php $uMax = max(1, $totalUsers); @endphp
        <div class="br">
          <span class="bl">Total</span>
          <div class="bb"><div class="bf" style="width:100%;background:#8b5cf6;"></div></div>
          <span class="bv">{{ $totalUsers }}</span>
        </div>
        <div class="br">
          <span class="bl">Active</span>
          <div class="bb"><div class="bf" style="width:{{ $uMax ? round(($activeUsers/$uMax)*100) : 0 }}%;background:#16a34a;"></div></div>
          <span class="bv">{{ $activeUsers }}</span>
        </div>
        <div class="br">
          <span class="bl">Restricted</span>
          <div class="bb"><div class="bf" style="width:{{ $uMax ? round(($suspendedUsers/$uMax)*100) : 0 }}%;background:#ef4444;"></div></div>
          <span class="bv">{{ $suspendedUsers }}</span>
        </div>
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid #e5e7eb;display:grid;grid-template-columns:1fr 1fr;gap:8px;">
          <div style="text-align:center;background:#fff;border-radius:8px;padding:8px;border:1px solid #f0f0f0;">
            <p style="font-size:1.3rem;font-weight:900;color:#8b5cf6;margin:0;">{{ $totalUsers > 0 ? round(($activeUsers/$totalUsers)*100) : 0 }}%</p>
            <p style="font-size:0.6rem;color:#9ca3af;margin:2px 0 0;">Active Rate</p>
          </div>
          <div style="text-align:center;background:#fff;border-radius:8px;padding:8px;border:1px solid #f0f0f0;">
            <p style="font-size:1.3rem;font-weight:900;color:#ef4444;margin:0;">{{ $suspendedUsers }}</p>
            <p style="font-size:0.6rem;color:#9ca3af;margin:2px 0 0;">Restricted</p>
          </div>
        </div>
      </div>

      {{-- Items (D2) --}}
      <div class="ac">
        <p class="ac-title"><i class="fas fa-boxes" style="color:#7b0f10;"></i> Item Listings (D2)</p>
        @php $iMax = max(1, $totalItems); @endphp
        <div class="br">
          <span class="bl">Total</span>
          <div class="bb"><div class="bf" style="width:100%;background:#374151;"></div></div>
          <span class="bv">{{ $totalItems }}</span>
        </div>
        <div class="br">
          <span class="bl">Active</span>
          <div class="bb"><div class="bf" style="width:{{ round(($activeItems/$iMax)*100) }}%;background:#16a34a;"></div></div>
          <span class="bv">{{ $activeItems }}</span>
        </div>
        <div class="br">
          <span class="bl">Barters</span>
          <div class="bb"><div class="bf" style="width:{{ round(($activeBarters/$iMax)*100) }}%;background:#7b0f10;"></div></div>
          <span class="bv">{{ $activeBarters }}</span>
        </div>
        <div class="br">
          <span class="bl">Donations</span>
          <div class="bb"><div class="bf" style="width:{{ round(($activeDonations/$iMax)*100) }}%;background:#16a34a;"></div></div>
          <span class="bv">{{ $activeDonations }}</span>
        </div>
        <div class="br">
          <span class="bl">Pending</span>
          <div class="bb"><div class="bf" style="width:{{ round(($pendingDonation/$iMax)*100) }}%;background:#f97316;"></div></div>
          <span class="bv">{{ $pendingDonation }}</span>
        </div>
      </div>

      {{-- Barters (D3) --}}
      <div class="ac">
        <p class="ac-title"><i class="fas fa-exchange-alt" style="color:#0ea5e9;"></i> Barter Trades (D3)</p>
        @php $tMax = max(1, $totalTrades); @endphp
        <div class="br">
          <span class="bl">Total</span>
          <div class="bb"><div class="bf" style="width:100%;background:#374151;"></div></div>
          <span class="bv">{{ $totalTrades }}</span>
        </div>
        <div class="br">
          <span class="bl">Completed</span>
          <div class="bb"><div class="bf" style="width:{{ round(($completedTrades/$tMax)*100) }}%;background:#16a34a;"></div></div>
          <span class="bv">{{ $completedTrades }}</span>
        </div>
        <div class="br">
          <span class="bl">Pending</span>
          <div class="bb"><div class="bf" style="width:{{ round(($pendingTrades/$tMax)*100) }}%;background:#f59e0b;"></div></div>
          <span class="bv">{{ $pendingTrades }}</span>
        </div>
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid #e5e7eb;text-align:center;background:#fff;border-radius:8px;padding:10px;border:1px solid #f0f0f0;">
          <p style="font-size:1.5rem;font-weight:900;color:#0ea5e9;margin:0;">{{ $totalTrades > 0 ? round(($completedTrades/$totalTrades)*100) : 0 }}%</p>
          <p style="font-size:0.62rem;color:#9ca3af;margin:3px 0 0;">Completion Rate</p>
        </div>
      </div>

      {{-- Donations (D4) --}}
      <div class="ac">
        <p class="ac-title"><i class="fas fa-hand-holding-heart" style="color:#16a34a;"></i> Donations (D4)</p>
        <div class="tile-row" style="grid-template-columns:1fr 1fr;">
          <div class="tile">
            <div class="tile-icon" style="background:#fff7ed;color:#f97316;"><i class="fas fa-clock"></i></div>
            <div>
              <p class="tile-val" style="color:#f97316;">{{ $pendingDonation }}</p>
              <p class="tile-lbl">Pending Review</p>
            </div>
          </div>
          <div class="tile">
            <div class="tile-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-check-circle"></i></div>
            <div>
              <p class="tile-val" style="color:#16a34a;">{{ $activeDonations }}</p>
              <p class="tile-lbl">Approved</p>
            </div>
          </div>
          <div class="tile">
            <div class="tile-icon" style="background:#fef9c3;color:#b45309;"><i class="fas fa-hand-paper"></i></div>
            <div>
              <p class="tile-val" style="color:#b45309;">{{ $pendingClaims }}</p>
              <p class="tile-lbl">Claim Requests</p>
            </div>
          </div>
          <div class="tile">
            <div class="tile-icon" style="background:#ede9fe;color:#7c3aed;"><i class="fas fa-gift"></i></div>
            <div>
              <p class="tile-val" style="color:#7c3aed;">{{ $approvedClaims }}</p>
              <p class="tile-lbl">Claims Approved</p>
            </div>
          </div>
        </div>
      </div>

    </div>

    {{-- Reports summary strip --}}
    <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;align-items:center;gap:16px;flex-wrap:wrap;background:#fafafa;">
      <span style="font-size:0.68rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.06em;">Reports</span>
      <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;">
        <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
        <span style="color:#6b7280;">Open:</span>
        <strong style="color:#1a1209;">{{ $openReports }}</strong>
      </div>
      <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;">
        <span style="width:8px;height:8px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
        <span style="color:#6b7280;">Resolved:</span>
        <strong style="color:#1a1209;">{{ $resolvedReports }}</strong>
      </div>
      <a href="{{ route('admin.reports') }}" style="font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;margin-left:auto;">View Reports →</a>
    </div>
  </div>

  {{-- ══ NEW CHART ANALYTICS ══ --}}
  {{-- Line graphs and bar charts for items, categories --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge-tag" style="background:#7b0f10;">Charts</span>
      <h2>Visual Analytics</h2>
    </div>
    <div style="padding:20px;">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
        @media(max-width:900px){grid-template-columns:1fr;}
        
        {{-- Line Chart: Most Bartered Items --}}
        <div style="background:#fff;border:1px solid #f3f4f6;border-radius:12px;padding:18px;">
          <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-chart-line" style="color:#0ea5e9;"></i> Most Bartered Items
          </h3>
          <canvas id="barteredItemsChart" style="max-height:220px;"></canvas>
        </div>

        {{-- Line Chart: Most Donated Items --}}
        <div style="background:#fff;border:1px solid #f3f4f6;border-radius:12px;padding:18px;">
          <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-chart-line" style="color:#16a34a;"></i> Most Donated Items
          </h3>
          <canvas id="donatedItemsChart" style="max-height:220px;"></canvas>
        </div>
      </div>

      {{-- Line Chart: Most Wishlisted Items --}}
      <div style="background:#fff;border:1px solid #f3f4f6;border-radius:12px;padding:18px;margin-bottom:20px;">
        <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
          <i class="fas fa-chart-line" style="color:#ef4444;"></i> Most Wishlisted Items
        </h3>
        <canvas id="wishlistedItemsChart" style="max-height:240px;"></canvas>
      </div>

      {{-- Bar Charts: Category Analysis --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
        @media(max-width:900px){grid-template-columns:1fr;}
        
        {{-- Bar Chart: Barter Items by Category --}}
        <div style="background:#fff;border:1px solid #f3f4f6;border-radius:12px;padding:18px;">
          <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-chart-bar" style="color:#7b0f10;"></i> Barter Items by Category
          </h3>
          <canvas id="barterCategoriesChart" style="max-height:280px;"></canvas>
        </div>

        {{-- Bar Chart: Donated Items by Category --}}
        <div style="background:#fff;border:1px solid #f3f4f6;border-radius:12px;padding:18px;">
          <h3 style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-chart-bar" style="color:#16a34a;"></i> Donated Items by Category
          </h3>
          <canvas id="donationCategoriesChart" style="max-height:280px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- ── RECENT PENDING DONATIONS ── --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge-tag" style="background:#374151;">Activity</span>
      <h2>Pending Donation Submissions</h2>
      <a href="{{ route('admin.donations') }}" style="font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;margin-left:auto;">View All →</a>
    </div>
    @forelse($recentActivity as $item)
      <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f9fafb;">
        <div style="position:relative;width:40px;padding-bottom:40px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f5f5;">
          <img src="{{ $item->image_url }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" alt="">
        </div>
        <div style="flex:1;min-width:0;">
          <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $item->title }}</p>
          <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;">by {{ $item->user->name }} · {{ $item->posted_at->diffForHumans() }}</p>
        </div>
        <span style="font-size:0.65rem;font-weight:700;padding:3px 9px;border-radius:999px;background:#fff7ed;color:#c2410c;">Pending</span>
        <div style="display:flex;gap:6px;">
          <form action="{{ route('admin.items.approve', $item) }}" method="POST">
            @csrf
            <button type="submit" style="border:none;border-radius:6px;padding:5px 10px;background:#dcfce7;color:#166534;font-size:0.68rem;font-weight:700;cursor:pointer;">
              <i class="fas fa-check"></i>
            </button>
          </form>
          <form action="{{ route('admin.items.reject', $item) }}" method="POST">
            @csrf
            <button type="submit" style="border:none;border-radius:6px;padding:5px 10px;background:#fee2e2;color:#991b1b;font-size:0.68rem;font-weight:700;cursor:pointer;">
              <i class="fas fa-times"></i>
            </button>
          </form>
        </div>
      </div>
    @empty
      <div style="padding:32px;text-align:center;color:#9ca3af;font-size:0.85rem;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:1.5rem;display:block;margin-bottom:8px;"></i>
        No pending donations.
      </div>
    @endforelse
  </div>

</div>

{{-- Chart.js for visualizations --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Most Bartered Items (Line Chart)
new Chart(document.getElementById('barteredItemsChart'), {
  type: 'line',
  data: {
    labels: {!! json_encode($mostBartered->pluck('title')->map(fn($t) => strlen($t) > 20 ? substr($t, 0, 20).'...' : $t)) !!},
    datasets: [{
      label: 'Views',
      data: {!! json_encode($mostBartered->pluck('views')) !!},
      borderColor: '#0ea5e9',
      backgroundColor: 'rgba(14, 165, 233, 0.1)',
      tension: 0.4,
      fill: true
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});

// Most Donated Items (Line Chart)
new Chart(document.getElementById('donatedItemsChart'), {
  type: 'line',
  data: {
    labels: {!! json_encode($mostDonated->pluck('title')->map(fn($t) => strlen($t) > 20 ? substr($t, 0, 20).'...' : $t)) !!},
    datasets: [{
      label: 'Views',
      data: {!! json_encode($mostDonated->pluck('views')) !!},
      borderColor: '#16a34a',
      backgroundColor: 'rgba(22, 163, 74, 0.1)',
      tension: 0.4,
      fill: true
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});

// Most Wishlisted Items (Line Chart)
new Chart(document.getElementById('wishlistedItemsChart'), {
  type: 'line',
  data: {
    labels: {!! json_encode($mostWishlisted->pluck('title')->map(fn($t) => strlen($t) > 25 ? substr($t, 0, 25).'...' : $t)) !!},
    datasets: [{
      label: 'Wishlist Count',
      data: {!! json_encode($mostWishlisted->pluck('wishlist_count')) !!},
      borderColor: '#ef4444',
      backgroundColor: 'rgba(239, 68, 68, 0.1)',
      tension: 0.4,
      fill: true
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});

// Barter Items by Category (Bar Chart)
new Chart(document.getElementById('barterCategoriesChart'), {
  type: 'bar',
  data: {
    labels: {!! json_encode($barterByCategory->pluck('category')) !!},
    datasets: [{
      label: 'Barter Items',
      data: {!! json_encode($barterByCategory->pluck('count')) !!},
      backgroundColor: '#7b0f10'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: { beginAtZero: true, ticks: { stepSize: 1 } }
    }
  }
});

// Donated Items by Category (Bar Chart)
new Chart(document.getElementById('donationCategoriesChart'), {
  type: 'bar',
  data: {
    labels: {!! json_encode($donationByCategory->pluck('category')) !!},
    datasets: [{
      label: 'Donations',
      data: {!! json_encode($donationByCategory->pluck('count')) !!},
      backgroundColor: '#16a34a'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: { beginAtZero: true, ticks: { stepSize: 1 } }
    }
  }
});
</script>
@endsection
