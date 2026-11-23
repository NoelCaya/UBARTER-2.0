@extends('layouts.master')
@section('title', 'User Reports - Admin')
@section('content')
<div style="max-width:1200px;margin:0 auto;padding:24px 16px;">
  <h1 style="font-size:1.3rem;font-weight:800;color:#1a1209;margin:0 0 3px;display:flex;align-items:center;gap:8px;">
    <i class="fas fa-flag" style="color:#dc2626;"></i> User Reports
  </h1>
  <p style="font-size:0.78rem;color:#9ca3af;margin:0 0 14px;">Review reports and follow up with users on open report tickets.</p>
  @include('admin.partials.nav')

  @if(session('success') || session('error'))
    <div style="background:{{ session('error') ? '#fef2f2' : '#dcfce7' }};color:{{ session('error') ? '#991b1b' : '#166534' }};padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:16px;">
      {{ session('error') ?? session('success') }}
    </div>
  @endif

  <div style="display:flex;gap:8px;margin-bottom:14px;">
    <a href="{{ route('admin.reports', ['tab' => 'reports']) }}"
       style="padding:8px 14px;border-radius:8px;text-decoration:none;font-size:.8rem;font-weight:700;background:{{ $tab === 'reports' ? '#7b0f10' : '#f3f4f6' }};color:{{ $tab === 'reports' ? '#fff' : '#4b5563' }};">
      Reports
    </a>
    <a href="{{ route('admin.reports', ['tab' => 'tickets']) }}"
       style="padding:8px 14px;border-radius:8px;text-decoration:none;font-size:.8rem;font-weight:700;background:{{ $tab === 'tickets' ? '#7b0f10' : '#f3f4f6' }};color:{{ $tab === 'tickets' ? '#fff' : '#4b5563' }};">
      Report Tickets
    </a>
  </div>

  <div style="background:#fff;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;min-width:880px;">
      <thead>
        <tr style="background:#f9fafb;border-bottom:1px solid #f3f4f6;">
          <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Reporter</th>
          <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Reported User</th>
          <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Reason / Details</th>
          <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Status</th>
          @if($tab === 'tickets')
            <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">User Response</th>
            <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Ticket Messages</th>
          @else
            <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Date</th>
            <th style="padding:12px 14px;text-align:left;font-size:.68rem;color:#9ca3af;text-transform:uppercase;">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
      @forelse($reports as $report)
        <tr style="border-bottom:1px solid #f3f4f6;vertical-align:top;">
          <td style="padding:12px 14px;font-size:.8rem;color:#374151;">{{ $report->reporter->name }}</td>
          <td style="padding:12px 14px;font-size:.8rem;color:#374151;">{{ $report->reportedUser->name }}</td>
          <td style="padding:12px 14px;max-width:260px;">
            <strong style="font-size:.76rem;color:#991b1b;">{{ $report->reason }}</strong>
            <div style="font-size:.75rem;color:#6b7280;margin-top:3px;">{{ $report->details ?: 'No additional details' }}</div>
          </td>
          <td style="padding:12px 14px;font-size:.74rem;">{{ $report->status }}</td>
          @if($tab === 'tickets')
            <td style="padding:12px 14px;max-width:280px;font-size:.76rem;color:#4b5563;white-space:pre-line;">{{ $report->reported_user_response ?: 'Awaiting response' }}</td>
            <td style="padding:12px 14px;">
              <div style="display:flex;flex-direction:column;gap:6px;align-items:flex-start;">
                <a href="{{ route('chat.show', $report->reporter_id) }}" style="font-size:.72rem;color:#7b0f10;font-weight:700;">Message reporter</a>
                <a href="{{ route('chat.show', $report->reported_user_id) }}" style="font-size:.72rem;color:#7b0f10;font-weight:700;">Message reported user</a>
                @if(in_array($report->status, ['Pending', 'Reviewed'], true))
                  <div style="display:flex;gap:6px;margin-top:3px;">
                    <form action="{{ route('admin.reports.resolve', $report) }}" method="POST">@csrf
                      <button type="submit" style="border:0;border-radius:6px;padding:5px 8px;background:#dcfce7;color:#166534;font-size:.68rem;font-weight:700;cursor:pointer;">Resolve</button>
                    </form>
                    <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">@csrf
                      <button type="submit" style="border:0;border-radius:6px;padding:5px 8px;background:#f3f4f6;color:#4b5563;font-size:.68rem;font-weight:700;cursor:pointer;">Dismiss</button>
                    </form>
                  </div>
                @endif
              </div>
            </td>
          @else
            <td style="padding:12px 14px;font-size:.72rem;color:#9ca3af;">{{ $report->created_at->format('M d, Y') }}</td>
            <td style="padding:12px 14px;">
              @if(in_array($report->status, ['Pending', 'Reviewed'], true))
                <a href="{{ route('admin.reports', ['tab' => 'tickets']) }}" style="font-size:.72rem;color:#7b0f10;font-weight:700;">Open ticket</a>
              @else
                <span style="font-size:.72rem;color:#9ca3af;">Closed</span>
              @endif
            </td>
          @endif
        </tr>
      @empty
        <tr><td colspan="{{ $tab === 'tickets' ? 6 : 6 }}" style="padding:38px;text-align:center;color:#9ca3af;">No {{ $tab === 'tickets' ? 'report tickets' : 'reports' }} to show.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  <div style="display:flex;justify-content:center;margin-top:18px;">{{ $reports->links() }}</div>
</div>
@endsection
