@extends('layouts.master')
@section('title', 'Donations Approval')
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
</style>

<div class="aw">
  <div style="margin-bottom:4px;">
    <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0 0 2px;">Admin Control Panel</h1>
  </div>

  @include('admin.partials.nav')

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  {{-- Stats strip --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px;">
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #f97316;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Pending Review</p>
      <p style="font-size:2rem;font-weight:900;color:#f97316;margin:0;line-height:1;">{{ $pendingDonation->count() }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #16a34a;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Approved</p>
      <p style="font-size:2rem;font-weight:900;color:#16a34a;margin:0;line-height:1;">{{ $approvedDonations }}</p>
    </div>
    <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.07);border-top:4px solid #ef4444;">
      <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.09em;color:#9ca3af;margin:0 0 4px;">Denied</p>
      <p style="font-size:2rem;font-weight:900;color:#ef4444;margin:0;line-height:1;">{{ $deniedDonations }}</p>
    </div>
  </div>

  {{-- 9.0 Donations table --}}
  <div class="sec">
    <div class="sec-hd">
      <span class="badge" style="background:#16a34a;">9.0</span>
      <h2>Approve / Deny Donations <span style="font-size:0.72rem;color:#9ca3af;font-weight:500;">(D4 Donations)</span></h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">{{ $pendingDonation->count() }} awaiting</span>
    </div>

    <div style="overflow-x:auto;">
      @if($pendingDonation->count() > 0)
        <table class="adm-table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Category</th>
              <th>Condition</th>
              <th>Donated By</th>
              <th>Submitted</th>
              <th style="text-align:center;">Decision</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pendingDonation as $item)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px;">
                    {{-- Fixed square thumbnail --}}
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
                  <div style="display:flex;align-items:center;gap:7px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=16a34a&color=fff&size=24&bold=true"
                         style="width:22px;height:22px;border-radius:50%;flex-shrink:0;">
                    <span style="font-size:0.72rem;color:#374151;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:100px;">{{ $item->user->name }}</span>
                  </div>
                </td>
                <td style="font-size:0.65rem;color:#9ca3af;">{{ $item->posted_at->diffForHumans() }}</td>
                <td style="text-align:center;">
                  <div style="display:flex;justify-content:center;gap:6px;">
                    <form action="{{ route('admin.items.approve', $item) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn-approve">
                        <i class="fas fa-check"></i> Approve
                      </button>
                    </form>
                    <form action="{{ route('admin.items.reject', $item) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn-reject">
                        <i class="fas fa-times"></i> Deny
                      </button>
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
        <div style="padding:48px;text-align:center;color:#9ca3af;">
          <i class="fas fa-check-circle" style="font-size:2.5rem;color:#16a34a;margin-bottom:12px;display:block;"></i>
          <p style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 4px;">All caught up!</p>
          <p style="font-size:0.8rem;margin:0;">No donations are pending review right now.</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
