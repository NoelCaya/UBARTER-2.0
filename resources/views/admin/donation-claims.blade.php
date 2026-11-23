@extends('layouts.master')
@section('title', 'Donation Claim Requests')
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
.btn-approve{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 12px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#dcfce7;color:#166534;transition:all 0.15s;}
.btn-approve:hover{background:#16a34a;color:#fff;}
.btn-reject{display:inline-flex;align-items:center;gap:4px;border:none;border-radius:7px;padding:5px 12px;font-size:0.7rem;font-weight:700;cursor:pointer;background:#fee2e2;color:#991b1b;transition:all 0.15s;}
.btn-reject:hover{background:#dc2626;color:#fff;}
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
  @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
  @endif

  <div class="sec">
    <div class="sec-hd">
      <span class="badge-mod" style="background:#b45309;">Claims</span>
      <h2>Donation Claim Requests</h2>
      <span style="font-size:0.72rem;color:#9ca3af;margin-left:auto;">{{ $claims->total() }} total</span>
    </div>

    <div style="overflow-x:auto;">
      @if($claims->count() > 0)
        <table class="adm-table">
          <thead>
            <tr>
              <th>Donation Item</th>
              <th>Claimant</th>
              <th>Message</th>
              <th>Status</th>
              <th>Requested</th>
              <th style="text-align:center;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($claims as $claim)
              <tr>
                <td>
                  <p style="font-size:0.82rem;font-weight:700;color:#1a1209;margin:0;">{{ $claim->item->title }}</p>
                  <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;">
                    <i class="fas fa-user" style="font-size:0.6rem;"></i>
                    Donated by {{ $claim->item->user->name ?? '—' }}
                  </p>
                </td>
                <td>
                  <div style="display:flex;align-items:center;gap:7px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($claim->claimant->name ?? 'U') }}&background=7b0f10&color=fff&size=24&bold=true"
                         style="width:24px;height:24px;border-radius:50%;flex-shrink:0;">
                    <div style="min-width:0;">
                      <p style="font-size:0.78rem;font-weight:600;color:#374151;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">{{ $claim->claimant->name ?? '—' }}</p>
                      <p style="font-size:0.62rem;color:#9ca3af;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">{{ $claim->claimant->email ?? '' }}</p>
                    </div>
                  </div>
                </td>
                <td style="max-width:220px;">
                  <p style="font-size:0.78rem;color:#4b5563;margin:0;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                    {{ $claim->message ?: '—' }}
                  </p>
                </td>
                <td>
                  @php
                    $statusStyles = [
                      'Pending'  => 'background:#fff7ed;color:#c2410c;',
                      'Approved' => 'background:#dcfce7;color:#166534;',
                      'Rejected' => 'background:#fee2e2;color:#991b1b;',
                    ];
                  @endphp
                  <span style="font-size:0.68rem;font-weight:700;padding:3px 9px;border-radius:999px;display:inline-block;{{ $statusStyles[$claim->status] ?? '' }}">
                    {{ $claim->status }}
                  </span>
                </td>
                <td style="font-size:0.72rem;color:#9ca3af;white-space:nowrap;">
                  {{ $claim->created_at->format('M d, Y') }}
                </td>
                <td style="text-align:center;">
                  @if($claim->status === 'Pending')
                    <div style="display:flex;justify-content:center;gap:6px;">
                      <form action="{{ route('admin.donations.claims.approve', $claim) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-approve">
                          <i class="fas fa-check"></i> Approve
                        </button>
                      </form>
                      <form action="{{ route('admin.donations.claims.reject', $claim) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject">
                          <i class="fas fa-times"></i> Reject
                        </button>
                      </form>
                    </div>
                  @else
                    <span style="font-size:0.72rem;color:#d1d5db;font-style:italic;">No action needed</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if($claims->hasPages())
          <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;justify-content:center;">
            {{ $claims->links() }}
          </div>
        @endif
      @else
        <div style="padding:48px;text-align:center;color:#9ca3af;">
          <i class="fas fa-hand-paper" style="font-size:2.5rem;color:#d1d5db;margin-bottom:12px;display:block;"></i>
          <p style="font-size:0.9rem;font-weight:700;color:#374151;margin:0 0 4px;">No claim requests yet</p>
          <p style="font-size:0.8rem;margin:0;">Requests from students wanting to claim donation items will appear here.</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
