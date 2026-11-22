@extends('layouts.master')
@section('title', 'User Reports - Admin')
@section('content')
<div style="max-width:1100px;margin:0 auto;padding:24px 16px;">

  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div>
      <h1 style="font-size:1.3rem;font-weight:800;color:#1a1209;margin:0 0 3px;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-flag" style="color:#dc2626;"></i> User Reports
      </h1>
      <p style="font-size:0.78rem;color:#9ca3af;margin:0;">Review and action reports submitted by users</p>
    </div>
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  <div style="background:#fff;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:#f9fafb;border-bottom:1px solid #f3f4f6;">
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Reporter</th>
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Reported User</th>
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Reason</th>
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Details</th>
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Status</th>
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Date</th>
          <th style="padding:12px 16px;text-align:left;font-size:0.68rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reports as $report)
          <tr style="border-bottom:1px solid #f9fafb;">
            <td style="padding:12px 16px;font-size:0.82rem;color:#374151;">{{ $report->reporter->name }}</td>
            <td style="padding:12px 16px;">
              <span style="font-size:0.82rem;font-weight:700;color:#1a1209;">{{ $report->reportedUser->name }}</span>
            </td>
            <td style="padding:12px 16px;">
              <span style="font-size:0.72rem;font-weight:700;padding:3px 8px;border-radius:6px;background:#fee2e2;color:#991b1b;">
                {{ $report->reason }}
              </span>
            </td>
            <td style="padding:12px 16px;font-size:0.78rem;color:#6b7280;max-width:200px;">
              {{ $report->details ? \Str::limit($report->details, 60) : '—' }}
            </td>
            <td style="padding:12px 16px;">
              @php
                $sc = ['Pending'=>'background:#fef9c3;color:#92400e;','Reviewed'=>'background:#dbeafe;color:#1d4ed8;','Resolved'=>'background:#dcfce7;color:#166534;','Dismissed'=>'background:#f3f4f6;color:#6b7280;'];
              @endphp
              <span style="font-size:0.68rem;font-weight:700;padding:3px 8px;border-radius:999px;{{ $sc[$report->status] ?? '' }}">{{ $report->status }}</span>
            </td>
            <td style="padding:12px 16px;font-size:0.72rem;color:#9ca3af;">{{ $report->created_at->format('M d, Y') }}</td>
            <td style="padding:12px 16px;">
              @if($report->status === 'Pending')
                <div style="display:flex;gap:6px;">
                  <form action="{{ route('admin.reports.resolve', $report) }}" method="POST">
                    @csrf
                    <button type="submit" style="background:#dcfce7;color:#166534;border:none;border-radius:6px;padding:5px 10px;font-size:0.7rem;font-weight:700;cursor:pointer;">
                      Resolve
                    </button>
                  </form>
                  <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">
                    @csrf
                    <button type="submit" style="background:#f3f4f6;color:#6b7280;border:none;border-radius:6px;padding:5px 10px;font-size:0.7rem;font-weight:700;cursor:pointer;">
                      Dismiss
                    </button>
                  </form>
                </div>
              @else
                <span style="font-size:0.72rem;color:#d1d5db;">No action needed</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="padding:40px;text-align:center;color:#9ca3af;font-size:0.85rem;">
              No reports submitted yet.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($reports->hasPages())
    <div style="display:flex;justify-content:center;margin-top:20px;">{{ $reports->links() }}</div>
  @endif

</div>
@endsection
