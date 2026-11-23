@extends('layouts.master')
@section('title', 'Donations Management')
@section('content')
<style>
*{box-sizing:border-box;}
.aw{max-width:1200px;margin:0 auto;padding:20px 16px;}
.sec{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;}
.sec-hd{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.sec-hd h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.badge{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;color:#fff;}
.adm-table{width:100%;border-collapse:collapse;}
.adm-table thead tr{background:#fafafa;border-bottom:1px solid #f3f4f6;}
.adm-table th{padding:10px 16px;text-align:left;font-size:0.65rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.06em;}
.adm-table tbody tr{border-bottom:1px solid #f9fafb;transition:background 0.12s;}
.adm-table tbody tr:hover{background:#fafafa;}
.adm-table td{padding:11px 16px;vertical-align:middle;}
.btn-approve{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 12px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#dcfce7;color:#166534;transition:all 0.15s;}
.btn-approve:hover{background:#16a34a;color:#fff;}
.btn-reject{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 12px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#fee2e2;color:#991b1b;transition:all 0.15s;}
.btn-reject:hover{background:#dc2626;color:#fff;}
.btn-view{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 10px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#f3f4f6;color:#374151;text-decoration:none;transition:all 0.15s;}
.btn-view:hover{background:#e5e7eb;color:#1a1209;text-decoration:none;}
.btn-export{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#16a34a;color:#fff;border-radius:9px;font-size:0.75rem;font-weight:700;text-decoration:none;transition:background 0.15s;}
.btn-export:hover{background:#15803d;color:#fff;text-decoration:none;}
.filter-tabs{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:0;}
.filter-tab{display:inline-flex;align-items:center;gap:5px;padding:6px 13px;border-radius:9px;font-size:0.72rem;font-weight:700;text-decoration:none;border:1.5px solid transparent;transition:all 0.15s;color:#6b7280;background:#f9fafb;border-color:#e5e7eb;}
.filter-tab:hover{background:#f3f4f6;color:#1a1209;text-decoration:none;}
.filter-tab.active{background:#1a1209;color:#fff;border-color:#1a1209;}
.status-pill{font-size:0.65rem;font-weight:700;padding:3px 9px;border-radius:999px;display:inline-block;}
.status-pending{background:#fff7ed;color:#c2410c;}
.status-active{background:#dcfce7;color:#166534;}
.status-archived{background:#fee2e2;color:#991b1b;}
.status-traded{background:#ede9fe;color:#6d28d9;}
</style>

<div class="aw">
  <div style="margin-bottom:4px;">
    <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0 0 2px;">Admin Control Panel</h1>
  </div>

  
  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- Stats strip --}}
  <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:16px;">
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #6b7280;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Total</p>
      <p style="font-size:2rem;font-weight:900;color:#374151;margin:0;line-height:1;">{{ $totalCount }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #f97316;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Pending</p>
      <p style="font-size:2rem;font-weight:900;color:#f97316;margin:0;line-height:1;">{{ $pendingCount }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #16a34a;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Approved</p>
      <p style="font-size:2rem;font-weight:900;color:#16a34a;margin:0;line-height:1;">{{ $approvedCount }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #ef4444;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Denied</p>
      <p style="font-size:2rem;font-weight:900;color:#ef4444;margin:0;line-height:1;">{{ $deniedCount }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #7c3aed;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Traded</p>
      <p style="font-size:2rem;font-weight:900;color:#7c3aed;margin:0;line-height:1;">{{ $tradedCount }}</p>
    </div>
  </div>

  {{-- Donations table --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge" style="background:#16a34a;">9.0</span>
      <h2>All Donations <span style="font-size:0.72rem;color:#9ca3af;font-weight:500;">(D4 Donations)</span></h2>

      {{-- Export button --}}
      <a href="{{ route('admin.donations.export', ['status' => $filterStatus]) }}" class="btn-export">
        <i class="fas fa-download"></i> Export CSV
      </a>
    </div>

    {{-- Filter tabs --}}
    <div style="padding:12px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
      <div class="filter-tabs">
        <a href="{{ route('admin.donations', ['status' => 'all']) }}"
           class="filter-tab {{ $filterStatus === 'all' ? 'active' : '' }}">
          All <span style="font-size:0.65rem;opacity:0.7;">({{ $totalCount }})</span>
        </a>
        <a href="{{ route('admin.donations', ['status' => 'pending']) }}"
           class="filter-tab {{ $filterStatus === 'pending' ? 'active' : '' }}">
          <span style="width:7px;height:7px;border-radius:50%;background:#f97316;display:inline-block;"></span>
          Pending <span style="font-size:0.65rem;opacity:0.7;">({{ $pendingCount }})</span>
        </a>
        <a href="{{ route('admin.donations', ['status' => 'active']) }}"
           class="filter-tab {{ $filterStatus === 'active' ? 'active' : '' }}">
          <span style="width:7px;height:7px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
          Approved <span style="font-size:0.65rem;opacity:0.7;">({{ $approvedCount }})</span>
        </a>
        <a href="{{ route('admin.donations', ['status' => 'archived']) }}"
           class="filter-tab {{ $filterStatus === 'archived' ? 'active' : '' }}">
          <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
          Denied <span style="font-size:0.65rem;opacity:0.7;">({{ $deniedCount }})</span>
        </a>
        <a href="{{ route('admin.donations', ['status' => 'traded']) }}"
           class="filter-tab {{ $filterStatus === 'traded' ? 'active' : '' }}">
          <span style="width:7px;height:7px;border-radius:50%;background:#7c3aed;display:inline-block;"></span>
          Traded <span style="font-size:0.65rem;opacity:0.7;">({{ $tradedCount }})</span>
        </a>
      </div>
      <span style="font-size:0.68rem;color:#9ca3af;">
        {{ $allDonations->total() }} {{ $allDonations->total() === 1 ? 'item' : 'items' }} found
      </span>
    </div>

    <div style="overflow-x:auto;">
      @if($allDonations->count() > 0)
        <table class="adm-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Item</th>
              <th>Category</th>
              <th>Condition</th>
              <th>Status</th>
              <th>Donated By</th>
              <th>Submitted</th>
              <th style="text-align:center;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($allDonations as $item)
              <tr>
                <td style="font-size:0.65rem;color:#9ca3af;white-space:nowrap;">#{{ $item->id }}</td>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <div style="position:relative;width:44px;padding-bottom:44px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f5f5;">
                      <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div style="min-width:0;">
                      <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:180px;">{{ $item->title }}</p>
                      <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:180px;">{{ Str::limit($item->description, 55) }}</p>
                    </div>
                  </div>
                </td>
                <td style="font-size:0.75rem;color:#4b5563;">{{ $item->category }}</td>
                <td>
                  <span style="font-size:0.68rem;font-weight:600;padding:3px 9px;border-radius:999px;background:#dcfce7;color:#166534;">{{ $item->condition }}</span>
                </td>
                <td>
                  @php
                    $statusClass = match($item->status) {
                        'Pending'  => 'status-pending',
                        'Active'   => 'status-active',
                        'Archived' => 'status-archived',
                        'Traded'   => 'status-traded',
                        default    => '',
                    };
                    $statusLabel = match($item->status) {
                        'Active'   => 'Approved',
                        'Archived' => 'Denied',
                        default    => $item->status,
                    };
                  @endphp
                  <span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
                <td>
                  <div style="display:flex;align-items:center;gap:7px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name ?? 'U') }}&background=16a34a&color=fff&size=24&bold=true"
                         style="width:22px;height:22px;border-radius:50%;flex-shrink:0;">
                    <div style="min-width:0;">
                      <p style="font-size:0.72rem;color:#374151;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:110px;">{{ $item->user->name ?? 'N/A' }}</p>
                      <p style="font-size:0.62rem;color:#9ca3af;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:110px;">{{ $item->user->email ?? '' }}</p>
                    </div>
                  </div>
                </td>
                <td style="font-size:0.65rem;color:#9ca3af;white-space:nowrap;">{{ $item->posted_at->diffForHumans() }}</td>
                <td style="text-align:center;">
                  <div style="display:flex;justify-content:center;gap:6px;flex-wrap:nowrap;">
                    @if($item->status === 'Pending')
                      <form action="{{ route('admin.items.approve', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-approve" title="Approve">
                          <i class="fas fa-check"></i> Approve
                        </button>
                      </form>
                      <form action="{{ route('admin.items.reject', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject" title="Deny">
                          <i class="fas fa-times"></i> Deny
                        </button>
                      </form>
                    @elseif($item->status === 'Active')
                      <form action="{{ route('admin.items.reject', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject" title="Revoke approval">
                          <i class="fas fa-ban"></i> Revoke
                        </button>
                      </form>
                    @elseif($item->status === 'Archived')
                      <form action="{{ route('admin.items.approve', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-approve" title="Re-approve">
                          <i class="fas fa-redo"></i> Re-approve
                        </button>
                      </form>
                    @else
                      <span style="font-size:0.65rem;color:#9ca3af;font-style:italic;">No actions</span>
                    @endif
                    <a href="{{ route('items.show', $item) }}" target="_blank" class="btn-view" title="View item">
                      <i class="fas fa-eye"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{-- Pagination --}}
        @if($allDonations->hasPages())
          <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;justify-content:center;">
            {{ $allDonations->links() }}
          </div>
        @endif

      @else
        <div style="padding:48px;text-align:center;color:#9ca3af;">
          <i class="fas fa-box-open" style="font-size:2.5rem;color:#d1d5db;margin-bottom:12px;display:block;"></i>
          <p style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 4px;">No donations found</p>
          <p style="font-size:0.8rem;margin:0;">
            @if($filterStatus !== 'all')
              There are no <strong>{{ $filterStatus }}</strong> donations.
              <a href="{{ route('admin.donations') }}" style="color:#16a34a;font-weight:600;">View all</a>
            @else
              No donations have been submitted yet.
            @endif
          </p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
