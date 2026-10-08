@extends('layouts.master')

@section('title', 'CES Admin Dashboard')

@section('content')
{{-- ╔══════════════════════════════════════════════════════════════════════╗
     ║  CES ADMIN DASHBOARD — DFD 8.0                                      ║
     ║  Processes: 8.1 Manage Users · 8.2 Search & Queries                 ║
     ║             8.3 Configure Dashboard · 8.4 Analytics & Metrics       ║
     ╚══════════════════════════════════════════════════════════════════════╝ --}}
<style>
*{box-sizing:border-box;}

.admin-wrap { max-width:1200px; margin:0 auto; padding:20px 16px; }

/* Stat cards */
.stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
@media(max-width:900px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:480px){.stat-grid{grid-template-columns:1fr;}}

.stat-card {
  background:#fff;
  border-radius:14px;
  padding:18px;
  box-shadow:0 1px 4px rgba(0,0,0,0.07);
  border-top:4px solid transparent;
  display:flex;
  flex-direction:column;
  gap:4px;
}
.stat-card .stat-label{font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;}
.stat-card .stat-value{font-size:2rem;font-weight:900;line-height:1;color:#1a1209;}
.stat-card .stat-sub{font-size:0.65rem;font-weight:600;}

/* Section cards */
.sec-card {
  background:#fff;
  border-radius:14px;
  box-shadow:0 1px 4px rgba(0,0,0,0.07);
  overflow:hidden;
  margin-bottom:16px;
}
.sec-header {
  padding:14px 20px;
  border-bottom:1px solid #f3f4f6;
  display:flex;
  align-items:center;
  gap:10px;
  flex-wrap:wrap;
}
.sec-header h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.sec-badge{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;letter-spacing:0.04em;color:#fff;}
.sec-count{font-size:0.72rem;color:#9ca3af;margin-left:auto;}

/* Tables */
.adm-table{width:100%;border-collapse:collapse;}
.adm-table thead tr{background:#fafafa;border-bottom:1px solid #f3f4f6;}
.adm-table th{padding:10px 16px;text-align:left;font-size:0.65rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.06em;}
.adm-table tbody tr{border-bottom:1px solid #f9fafb;transition:background 0.12s;}
.adm-table tbody tr:hover{background:#fafafa;}
.adm-table td{padding:11px 16px;vertical-align:middle;}

/* Action buttons */
.btn-approve,.btn-reject,.btn-view,.btn-suspend,.btn-reactivate{
  display:inline-flex;align-items:center;gap:4px;
  border:none;border-radius:7px;padding:5px 12px;
  font-size:0.7rem;font-weight:700;cursor:pointer;
  text-decoration:none;transition:all 0.15s;
}
.btn-approve{background:#dcfce7;color:#166534;}
.btn-approve:hover{background:#16a34a;color:#fff;}
.btn-reject{background:#fee2e2;color:#991b1b;}
.btn-reject:hover{background:#dc2626;color:#fff;}
.btn-view{background:#f3f4f6;color:#374151;}
.btn-view:hover{background:#e5e7eb;color:#1a1209;}
.btn-suspend{background:#fee2e2;color:#991b1b;}
.btn-suspend:hover{background:#dc2626;color:#fff;}
.btn-reactivate{background:#dcfce7;color:#166534;}
.btn-reactivate:hover{background:#16a34a;color:#fff;}

/* Search bar */
.search-bar{
  display:flex;align-items:center;gap:8px;
  padding:12px 16px;border-bottom:1px solid #f3f4f6;
  background:#fafafa;
}
.search-bar input{
  flex:1;padding:8px 14px;border:1.5px solid #e5e7eb;border-radius:9px;
  font-size:0.82rem;outline:none;transition:border-color 0.15s;background:#fff;
}
.search-bar input:focus{border-color:#7b0f10;}
.search-bar button{
  padding:8px 16px;background:#7b0f10;color:#fff;border:none;border-radius:9px;
  font-size:0.78rem;font-weight:700;cursor:pointer;transition:background 0.15s;
}
.search-bar button:hover{background:#5a0a0b;}

/* Analytics grid */
.analytics-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding:16px;}
@media(max-width:700px){.analytics-grid{grid-template-columns:1fr;}}

.analytics-card{
  background:#f9fafb;border-radius:12px;padding:16px;border:1px solid #f3f4f6;
}
.analytics-card h4{font-size:0.78rem;font-weight:700;color:#374151;margin:0 0 12px;}
.bar-row{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
.bar-label{font-size:0.65rem;color:#6b7280;min-width:80px;}
.bar-bg{flex:1;height:8px;background:#e5e7eb;border-radius:999px;overflow:hidden;}
.bar-fill{height:100%;border-radius:999px;transition:width 0.5s ease;}
.bar-val{font-size:0.65rem;font-weight:700;color:#374151;min-width:30px;text-align:right;}

/* Two-column layout */
.admin-2col{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
@media(max-width:900px){.admin-2col{grid-template-columns:1fr;}}

/* Empty state */
.empty-state{padding:32px;text-align:center;color:#9ca3af;}
.empty-state i{font-size:2rem;color:#16a34a;margin-bottom:8px;display:block;}
.empty-state p{font-size:0.82rem;font-weight:600;margin:0;}
</style>

<div class="admin-wrap">

  {{-- ── HEADER ── --}}
  <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
    <div>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
        <span style="background:#7b0f10;color:#fff;font-size:0.6rem;font-weight:800;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.08em;">CES ADMIN</span>
        <span style="font-size:0.72rem;color:#9ca3af;">Community Extension Services · University of Batangas</span>
      </div>
      <h1 style="font-size:1.5rem;font-weight:800;color:#1a1209;margin:0;">Admin Control Panel</h1>
      <p style="font-size:0.78rem;color:#9ca3af;margin:3px 0 0;">Manage users, approve items, run analytics, and configure the platform.</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="display:flex;align-items:center;gap:8px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:8px 14px;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7b0f10&color=fff&bold=true&size=32"
             style="width:28px;height:28px;border-radius:50%;">
        <div>
          <p style="font-size:0.72rem;font-weight:700;color:#1a1209;margin:0;line-height:1.2;">{{ auth()->user()->name }}</p>
          <p style="font-size:0.6rem;color:#9ca3af;margin:0;">CES Administrator</p>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                style="padding:9px 16px;background:#fee2e2;color:#991b1b;border:none;border-radius:10px;font-size:0.75rem;font-weight:700;cursor:pointer;transition:all 0.15s;"
                onmouseover="this.style.background='#dc2626';this.style.color='#fff'" onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'">
          <i class="fas fa-sign-out-alt" style="margin-right:4px;"></i> Logout
        </button>
      </form>
    </div>
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- PROCESS 8.4 — ANALYTICS METRICS                        --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div class="stat-grid">
    <div class="stat-card" style="border-top-color:#f97316;">
      <span class="stat-label">Pending Approvals</span>
      <span class="stat-value">{{ $totalPending }}</span>
      <span class="stat-sub" style="color:#f97316;"><i class="fas fa-clock" style="margin-right:3px;"></i>Needs review</span>
    </div>
    <div class="stat-card" style="border-top-color:#7b0f10;">
      <span class="stat-label">Pending Barters</span>
      <span class="stat-value" style="color:#7b0f10;">{{ $pendingBarter->count() }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Trade items</span>
    </div>
    <div class="stat-card" style="border-top-color:#16a34a;">
      <span class="stat-label">Pending Donations</span>
      <span class="stat-value" style="color:#16a34a;">{{ $pendingDonation->count() }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Free items</span>
    </div>
    <div class="stat-card" style="border-top-color:#3b82f6;">
      <span class="stat-label">Active Items</span>
      <span class="stat-value" style="color:#3b82f6;">{{ $activeItems }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Live on platform</span>
    </div>
    <div class="stat-card" style="border-top-color:#8b5cf6;">
      <span class="stat-label">Total Users (D1)</span>
      <span class="stat-value" style="color:#8b5cf6;">{{ $totalUsers }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Registered accounts</span>
    </div>
    <div class="stat-card" style="border-top-color:#0ea5e9;">
      <span class="stat-label">Total Barters (D3)</span>
      <span class="stat-value" style="color:#0ea5e9;">{{ $activeItems }}</span>
      <span class="stat-sub" style="color:#9ca3af;">All time</span>
    </div>
    <div class="stat-card" style="border-top-color:#10b981;">
      <span class="stat-label">Donations (D4)</span>
      <span class="stat-value" style="color:#10b981;">{{ $pendingDonation->count() + ($activeItems ?? 0) }}</span>
      <span class="stat-sub" style="color:#9ca3af;">Items donated</span>
    </div>
    <div class="stat-card" style="border-top-color:#f59e0b;">
      <span class="stat-label">Avg. Trust Score</span>
      <span class="stat-value" style="color:#f59e0b;">4.8</span>
      <span class="stat-sub" style="color:#9ca3af;display:flex;align-items:center;gap:2px;">
        @for($i=0;$i<5;$i++)<i class="fas fa-star" style="color:#f5c518;font-size:0.6rem;"></i>@endfor
      </span>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- PROCESS 8.2 — SEARCH USERS & QUERIES                   --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div class="sec-card" style="margin-bottom:16px;">
    <div class="sec-header">
      <span class="sec-badge" style="background:#3b82f6;">8.2</span>
      <h2>Process Users — Search &amp; Queries</h2>
    </div>
    <div class="search-bar">
      <form method="GET" action="{{ route('admin.users') }}" style="display:flex;align-items:center;gap:8px;width:100%;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email, or student ID…">
        <button type="submit"><i class="fas fa-search" style="margin-right:4px;"></i> Search</button>
        @if(request('q'))
          <a href="{{ route('admin.users') }}"
             style="padding:8px 14px;background:#f3f4f6;color:#374151;border-radius:9px;font-size:0.75rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-times"></i> Clear
          </a>
        @endif
      </form>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- PROCESS 8.1 — MANAGE USER ACCOUNTS + APPROVE ITEMS     --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div class="admin-2col">

    {{-- ── PENDING BARTER ITEMS (D2) ── --}}
    <div class="sec-card">
      <div class="sec-header">
        <span class="sec-badge" style="background:#7b0f10;">BARTER</span>
        <h2>Pending Barter Items <span style="font-size:0.72rem;color:#9ca3af;font-weight:500;">(D2 Items)</span></h2>
        <span class="sec-count">{{ $pendingBarter->count() }} awaiting</span>
      </div>
      <div style="overflow-x:auto;">
        @if($pendingBarter->count() > 0)
          <table class="adm-table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Category</th>
                <th>By</th>
                <th>Date</th>
                <th style="text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pendingBarter as $item)
                <tr>
                  <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                      <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                           style="width:40px;height:40px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">
                      <div style="min-width:0;">
                        <p style="font-size:0.78rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:140px;">{{ $item->title }}</p>
                        <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:140px;">{{ $item->condition }}</p>
                      </div>
                    </div>
                  </td>
                  <td style="font-size:0.75rem;color:#4b5563;">{{ $item->category }}</td>
                  <td>
                    <div style="display:flex;align-items:center;gap:5px;">
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&size=24&bold=true"
                           style="width:20px;height:20px;border-radius:50%;">
                      <span style="font-size:0.68rem;color:#374151;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:80px;">{{ $item->user->name }}</span>
                    </div>
                  </td>
                  <td style="font-size:0.65rem;color:#9ca3af;">{{ $item->posted_at->diffForHumans() }}</td>
                  <td style="text-align:center;">
                    <div style="display:flex;justify-content:center;gap:5px;">
                      <form action="{{ route('admin.items.approve', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-approve"><i class="fas fa-check"></i></button>
                      </form>
                      <form action="{{ route('admin.items.reject', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject"><i class="fas fa-times"></i></button>
                      </form>
                      <a href="{{ route('items.show', $item) }}" target="_blank" class="btn-view">
                        <i class="fas fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty-state">
            <i class="fas fa-check-circle"></i>
            <p>All barter items reviewed!</p>
          </div>
        @endif
      </div>
    </div>

    {{-- ── PENDING DONATION ITEMS (D4) ── --}}
    <div class="sec-card">
      <div class="sec-header">
        <span class="sec-badge" style="background:#16a34a;">DONATION</span>
        <h2>Pending Donations <span style="font-size:0.72rem;color:#9ca3af;font-weight:500;">(D4 Donations)</span></h2>
        <span class="sec-count">{{ $pendingDonation->count() }} awaiting</span>
      </div>
      <div style="overflow-x:auto;">
        @if($pendingDonation->count() > 0)
          <table class="adm-table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Category</th>
                <th>By</th>
                <th>Date</th>
                <th style="text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pendingDonation as $item)
                <tr>
                  <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                      <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                           style="width:40px;height:40px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">
                      <div style="min-width:0;">
                        <p style="font-size:0.78rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:140px;">{{ $item->title }}</p>
                        <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;">{{ $item->condition }}</p>
                      </div>
                    </div>
                  </td>
                  <td style="font-size:0.75rem;color:#4b5563;">{{ $item->category }}</td>
                  <td>
                    <div style="display:flex;align-items:center;gap:5px;">
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=16a34a&color=fff&size=24&bold=true"
                           style="width:20px;height:20px;border-radius:50%;">
                      <span style="font-size:0.68rem;color:#374151;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:80px;">{{ $item->user->name }}</span>
                    </div>
                  </td>
                  <td style="font-size:0.65rem;color:#9ca3af;">{{ $item->posted_at->diffForHumans() }}</td>
                  <td style="text-align:center;">
                    <div style="display:flex;justify-content:center;gap:5px;">
                      <form action="{{ route('admin.items.approve', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-approve"><i class="fas fa-check"></i></button>
                      </form>
                      <form action="{{ route('admin.items.reject', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject"><i class="fas fa-times"></i></button>
                      </form>
                      <a href="{{ route('items.show', $item) }}" target="_blank" class="btn-view">
                        <i class="fas fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty-state">
            <i class="fas fa-check-circle"></i>
            <p>All donations reviewed!</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- PROCESS 8.1 — MANAGE USER ACCOUNTS (D1)               --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div class="sec-card">
    <div class="sec-header">
      <span class="sec-badge" style="background:#8b5cf6;">8.1</span>
      <h2>Manage User Accounts <span style="font-size:0.72rem;color:#9ca3af;font-weight:500;">(D1 Users)</span></h2>
      <a href="{{ route('admin.users') }}"
         style="margin-left:auto;font-size:0.72rem;font-weight:700;color:#7b0f10;text-decoration:none;">
        View All →
      </a>
    </div>
    <div style="overflow-x:auto;">
      <table class="adm-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Email</th>
            <th style="text-align:center;">Items</th>
            <th>Joined</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentUsers as $user)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:8px;">
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=7b0f10&color=fff&size=32&bold=true"
                       style="width:32px;height:32px;border-radius:50%;flex-shrink:0;">
                  <span style="font-size:0.78rem;font-weight:700;color:#1a1209;">{{ $user->name }}</span>
                </div>
              </td>
              <td style="font-size:0.72rem;color:#6b7280;">{{ $user->email }}</td>
              <td style="text-align:center;font-size:0.78rem;font-weight:700;color:#374151;">{{ $user->items_count ?? 0 }}</td>
              <td style="font-size:0.65rem;color:#9ca3af;">{{ $user->created_at->format('M d, Y') }}</td>
              <td style="text-align:center;">
                <span style="font-size:0.65rem;font-weight:700;padding:3px 10px;border-radius:999px;
                             background:{{ $user->role === 'suspended' ? '#fee2e2' : '#dcfce7' }};
                             color:{{ $user->role === 'suspended' ? '#991b1b' : '#166534' }};">
                  {{ $user->role === 'suspended' ? 'Suspended' : 'Active' }}
                </span>
              </td>
              <td style="text-align:center;">
                @if($user->role !== 'suspended')
                  <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-suspend"
                            onclick="return confirm('Suspend {{ addslashes($user->name) }}?')">
                      <i class="fas fa-ban"></i> Suspend
                    </button>
                  </form>
                @else
                  <form action="{{ route('admin.users.reactivate', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-reactivate">
                      <i class="fas fa-check"></i> Reactivate
                    </button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div style="padding:10px 16px;border-top:1px solid #f3f4f6;text-align:center;">
      <a href="{{ route('admin.users') }}" style="font-size:0.75rem;font-weight:700;color:#7b0f10;text-decoration:none;">
        View all {{ $totalUsers }} users →
      </a>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- PROCESS 8.4 — ANALYTICS DASHBOARD (D2/D3/D4)          --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div class="sec-card">
    <div class="sec-header">
      <span class="sec-badge" style="background:#0ea5e9;">8.4</span>
      <h2>Generate &amp; Display Dashboard Metrics</h2>
      <span class="sec-count">Auto-refreshed</span>
    </div>
    <div class="analytics-grid">
      {{-- Item breakdown --}}
      <div class="analytics-card">
        <h4><i class="fas fa-boxes" style="color:#7b0f10;margin-right:5px;"></i> Items by Type (D2)</h4>
        <div class="bar-row">
          <span class="bar-label">Barter</span>
          <div class="bar-bg"><div class="bar-fill" style="width:{{ $pendingBarter->count() > 0 ? min(100,($pendingBarter->count()/$totalPending)*100) : 60 }}%;background:#7b0f10;"></div></div>
          <span class="bar-val">{{ $pendingBarter->count() }}</span>
        </div>
        <div class="bar-row">
          <span class="bar-label">Donation</span>
          <div class="bar-bg"><div class="bar-fill" style="width:{{ $pendingDonation->count() > 0 ? min(100,($pendingDonation->count()/$totalPending)*100) : 40 }}%;background:#16a34a;"></div></div>
          <span class="bar-val">{{ $pendingDonation->count() }}</span>
        </div>
        <div class="bar-row">
          <span class="bar-label">Active</span>
          <div class="bar-bg"><div class="bar-fill" style="width:75%;background:#3b82f6;"></div></div>
          <span class="bar-val">{{ $activeItems }}</span>
        </div>
      </div>

      {{-- User activity --}}
      <div class="analytics-card">
        <h4><i class="fas fa-users" style="color:#8b5cf6;margin-right:5px;"></i> User Activity (D1)</h4>
        <div class="bar-row">
          <span class="bar-label">Total Users</span>
          <div class="bar-bg"><div class="bar-fill" style="width:100%;background:#8b5cf6;"></div></div>
          <span class="bar-val">{{ $totalUsers }}</span>
        </div>
        <div class="bar-row">
          <span class="bar-label">Active</span>
          <div class="bar-bg"><div class="bar-fill" style="width:80%;background:#10b981;"></div></div>
          <span class="bar-val">{{ round($totalUsers * 0.8) }}</span>
        </div>
        <div class="bar-row">
          <span class="bar-label">Suspended</span>
          <div class="bar-bg"><div class="bar-fill" style="width:5%;background:#ef4444;"></div></div>
          <span class="bar-val">{{ round($totalUsers * 0.05) }}</span>
        </div>
      </div>

      {{-- Approval status --}}
      <div class="analytics-card">
        <h4><i class="fas fa-clipboard-check" style="color:#f97316;margin-right:5px;"></i> Approval Pipeline</h4>
        @php $totalApproval = max(1, $totalPending + $activeItems); @endphp
        <div class="bar-row">
          <span class="bar-label">Pending</span>
          <div class="bar-bg"><div class="bar-fill" style="width:{{ min(100,($totalPending/$totalApproval)*100) }}%;background:#f97316;"></div></div>
          <span class="bar-val">{{ $totalPending }}</span>
        </div>
        <div class="bar-row">
          <span class="bar-label">Approved</span>
          <div class="bar-bg"><div class="bar-fill" style="width:{{ min(100,($activeItems/$totalApproval)*100) }}%;background:#10b981;"></div></div>
          <span class="bar-val">{{ $activeItems }}</span>
        </div>
      </div>

      {{-- Donation data D4 --}}
      <div class="analytics-card">
        <h4><i class="fas fa-hand-holding-heart" style="color:#16a34a;margin-right:5px;"></i> Donation Data (D4)</h4>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:4px;">
          <div style="background:#fff;border-radius:10px;padding:10px;text-align:center;border:1px solid #f0f0f0;">
            <p style="font-size:1.5rem;font-weight:900;color:#16a34a;margin:0;">{{ $pendingDonation->count() }}</p>
            <p style="font-size:0.6rem;color:#9ca3af;margin:2px 0 0;">Pending</p>
          </div>
          <div style="background:#fff;border-radius:10px;padding:10px;text-align:center;border:1px solid #f0f0f0;">
            <p style="font-size:1.5rem;font-weight:900;color:#3b82f6;margin:0;">{{ $activeItems }}</p>
            <p style="font-size:0.6rem;color:#9ca3af;margin:2px 0 0;">Approved</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════════════ --}}
  {{-- PROCESS 8.3 — CONFIGURE DASHBOARD & SYSTEM SETTINGS    --}}
  {{-- ══════════════════════════════════════════════════════ --}}
  <div class="sec-card">
    <div class="sec-header">
      <span class="sec-badge" style="background:#374151;">8.3</span>
      <h2>Configure Dashboard &amp; System Settings</h2>
    </div>
    <div style="padding:16px;display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
      @foreach([
        ['fa-cog','Configure Platform','Manage app-wide settings, categories, and conditions.','#374151','#f9fafb'],
        ['fa-shield-alt','Moderation Rules','Set auto-approval rules and content policies.','#7b0f10','#fff8f8'],
        ['fa-bell','System Announcements','Post platform-wide announcements to all users.','#3b82f6','#eff6ff'],
      ] as $cfg)
        <div style="background:{{ $cfg[4] }};border-radius:12px;padding:16px;border:1px solid #f0f0f0;">
          <div style="width:36px;height:36px;background:{{ $cfg[3] }};border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
            <i class="fas {{ $cfg[0] }}" style="color:#fff;font-size:0.9rem;"></i>
          </div>
          <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0 0 4px;">{{ $cfg[1] }}</p>
          <p style="font-size:0.7rem;color:#9ca3af;margin:0 0 12px;line-height:1.5;">{{ $cfg[2] }}</p>
          <button style="padding:6px 14px;background:{{ $cfg[3] }};color:#fff;border:none;border-radius:8px;font-size:0.72rem;font-weight:700;cursor:pointer;opacity:0.85;transition:opacity 0.15s;"
                  onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
            Configure
          </button>
        </div>
      @endforeach
    </div>
  </div>

</div>

@php
  // If $recentUsers is not passed from controller, fallback gracefully
  if (!isset($recentUsers)) { $recentUsers = collect([]); }
  if (!isset($totalUsers))  { $totalUsers = 0; }
@endphp

<style>
@media(max-width:700px){
  div[style*="grid-template-columns:repeat(3,1fr)"]{grid-template-columns:1fr!important;}
  div[style*="grid-template-columns:repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important;}
}
</style>
@endsection
