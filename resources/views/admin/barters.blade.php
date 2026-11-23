@extends('layouts.master')
@section('title', 'Barter Monitor')
@section('content')
<style>
*{box-sizing:border-box;}
.aw{max-width:1200px;margin:0 auto;padding:20px 16px;}
.sec{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;margin-bottom:16px;}
.sec-hd{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.sec-hd h2{font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;flex:1;}
.badge-mod{font-size:0.62rem;font-weight:800;padding:3px 9px;border-radius:5px;text-transform:uppercase;color:#fff;}
.adm-table{width:100%;border-collapse:collapse;}
.adm-table thead tr{background:#fafafa;border-bottom:1px solid #f3f4f6;}
.adm-table th{padding:10px 16px;text-align:left;font-size:0.65rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.06em;}
.adm-table tbody tr{border-bottom:1px solid #f9fafb;transition:background 0.12s;}
.adm-table tbody tr:hover{background:#fafafa;}
.adm-table td{padding:11px 16px;vertical-align:middle;font-size:0.82rem;color:#374151;}
</style>

<div class="aw">
  <div style="margin-bottom:4px;">
    <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0 0 2px;">Admin Control Panel</h1>
  </div>

  
  <p style="font-size:0.78rem;color:#9ca3af;margin:0 0 16px;">
    Review pending barter listings, monitor active listings, and view completed exchanges.
  </p>

  {{-- ── Pending Barter Submissions ── --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge-mod" style="background:#f59e0b;">Review</span>
      <h2>Pending Barter Submissions</h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">{{ $pendingBarters->total() }} pending</span>
    </div>
    <div style="overflow-x:auto;">
      @if($pendingBarters->count() > 0)
        <table class="adm-table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Owner</th>
              <th>Category</th>
              <th>Condition</th>
              <th>Submitted</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pendingBarters as $item)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <div style="position:relative;width:44px;padding-bottom:44px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f5f5;">
                      <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div style="min-width:0;">
                      <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;max-width:220px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $item->title }}</p>
                      <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;max-width:220px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ Str::limit($item->description, 60) }}</p>
                    </div>
                  </div>
                </td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->condition }}</td>
                <td style="font-size:0.72rem;color:#9ca3af;white-space:nowrap;">{{ $item->posted_at->format('M d, Y') }}</td>
                <td>
                  <div style="display:flex;align-items:center;gap:6px;">
                    <form action="{{ route('admin.items.approve', $item) }}" method="POST">
                      @csrf
                      <button type="submit" style="border:0;border-radius:7px;padding:6px 10px;background:#dcfce7;color:#166534;font-size:0.72rem;font-weight:700;cursor:pointer;">
                        <i class="fas fa-check"></i> Approve
                      </button>
                    </form>
                    <form action="{{ route('admin.items.reject', $item) }}" method="POST">
                      @csrf
                      <button type="submit" style="border:0;border-radius:7px;padding:6px 10px;background:#fee2e2;color:#991b1b;font-size:0.72rem;font-weight:700;cursor:pointer;">
                        <i class="fas fa-times"></i> Reject
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if($pendingBarters->hasPages())
          <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;justify-content:center;">
            {{ $pendingBarters->links() }}
          </div>
        @endif
      @else
        <div style="padding:36px;text-align:center;color:#9ca3af;">
          <p style="font-size:0.85rem;font-weight:700;color:#374151;margin:0 0 4px;">No pending barter submissions</p>
          <p style="font-size:0.78rem;margin:0;">New barter listings awaiting review will appear here.</p>
        </div>
      @endif
    </div>
  </div>

  {{-- ── Available Barter Items ── --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge-mod" style="background:#7c3aed;">Monitor</span>
      <h2>Available Barter Items</h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">{{ $availableBarters->total() }} active listing{{ $availableBarters->total() !== 1 ? 's' : '' }}</span>
    </div>
    <div style="overflow-x:auto;">
      @if($availableBarters->count() > 0)
        <table class="adm-table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Owner</th>
              <th>Category</th>
              <th>Condition</th>
              <th>Posted</th>
              <th>Views</th>
            </tr>
          </thead>
          <tbody>
            @foreach($availableBarters as $item)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    <div style="position:relative;width:44px;padding-bottom:44px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f5f5;">
                      <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                           style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div style="min-width:0;">
                      <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:220px;">{{ $item->title }}</p>
                      <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:220px;">{{ Str::limit($item->description, 60) }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="display:flex;align-items:center;gap:7px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&size=24&bold=true"
                         style="width:24px;height:24px;border-radius:50%;flex-shrink:0;">
                    <div style="min-width:0;">
                      <p style="font-size:0.78rem;font-weight:600;color:#374151;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:110px;">{{ $item->user->name }}</p>
                      <p style="font-size:0.62rem;color:#9ca3af;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:110px;">{{ $item->user->email }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <span style="font-size:0.72rem;font-weight:600;padding:3px 9px;border-radius:999px;background:#ede9fe;color:#6d28d9;">{{ $item->category }}</span>
                </td>
                <td>
                  <span style="font-size:0.72rem;font-weight:600;padding:3px 9px;border-radius:999px;background:#dbeafe;color:#1d4ed8;">{{ $item->condition }}</span>
                </td>
                <td style="font-size:0.72rem;color:#9ca3af;white-space:nowrap;">{{ $item->posted_at->format('M d, Y') }}</td>
                <td>
                  <span style="font-size:0.78rem;font-weight:700;color:#7b0f10;">{{ number_format($item->views) }}</span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if($availableBarters->hasPages())
          <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;justify-content:center;">
            {{ $availableBarters->links() }}
          </div>
        @endif
      @else
        <div style="padding:48px;text-align:center;color:#9ca3af;">
          <i class="fas fa-exchange-alt" style="font-size:2.5rem;color:#d1d5db;margin-bottom:12px;display:block;"></i>
          <p style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 4px;">No active barter listings</p>
          <p style="font-size:0.8rem;margin:0;">Items will appear here once approved by admin.</p>
        </div>
      @endif
    </div>
  </div>

  {{-- ── Completed Barters ── --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge-mod" style="background:#16a34a;">History</span>
      <h2>Completed Barters</h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">{{ $completedBarters->total() }} completed</span>
    </div>
    <div style="overflow-x:auto;">
      @if($completedBarters->count() > 0)
        <table class="adm-table">
          <thead>
            <tr>
              <th>Initiator</th>
              <th>Offered Item</th>
              <th>Receiver</th>
              <th>Received Item</th>
              <th>Completed</th>
            </tr>
          </thead>
          <tbody>
            @foreach($completedBarters as $trade)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:7px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($trade->initiator->name ?? 'U') }}&background=7b0f10&color=fff&size=24&bold=true"
                         style="width:24px;height:24px;border-radius:50%;flex-shrink:0;">
                    <span style="font-size:0.78rem;font-weight:600;color:#374151;">{{ $trade->initiator->name ?? '—' }}</span>
                  </div>
                </td>
                <td>
                  <p style="font-size:0.78rem;font-weight:600;color:#1a1209;margin:0;max-width:160px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                    {{ $trade->initiatorItem->title ?? '—' }}
                  </p>
                </td>
                <td>
                  <div style="display:flex;align-items:center;gap:7px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($trade->receiver->name ?? 'U') }}&background=1d4ed8&color=fff&size=24&bold=true"
                         style="width:24px;height:24px;border-radius:50%;flex-shrink:0;">
                    <span style="font-size:0.78rem;font-weight:600;color:#374151;">{{ $trade->receiver->name ?? '—' }}</span>
                  </div>
                </td>
                <td>
                  <p style="font-size:0.78rem;font-weight:600;color:#1a1209;margin:0;max-width:160px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                    {{ $trade->receiverItem->title ?? '—' }}
                  </p>
                </td>
                <td style="font-size:0.72rem;color:#9ca3af;white-space:nowrap;">
                  {{ $trade->completed_at ? \Carbon\Carbon::parse($trade->completed_at)->format('M d, Y') : '—' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if($completedBarters->hasPages())
          <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;justify-content:center;">
            {{ $completedBarters->links() }}
          </div>
        @endif
      @else
        <div style="padding:48px;text-align:center;color:#9ca3af;">
          <i class="fas fa-check-circle" style="font-size:2.5rem;color:#d1d5db;margin-bottom:12px;display:block;"></i>
          <p style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 4px;">No completed barters yet</p>
          <p style="font-size:0.8rem;margin:0;">Completed trades will appear here.</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
