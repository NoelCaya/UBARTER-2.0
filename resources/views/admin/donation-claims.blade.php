@extends('layouts.master')
@section('title', 'Donation Claim Requests')
@section('content')
<div style="max-width:1200px;margin:0 auto;padding:20px 16px;">
    <h1 style="font-size:1.35rem;font-weight:900;color:#1a1209;margin:0 0 4px;">Donation Claim Requests</h1>
    <p style="font-size:0.8rem;color:#9ca3af;margin:0 0 14px;">Review requests from users who want to claim an available donation.</p>
    @include('admin.partials.nav')

    @if(session('success') || session('error'))
        <div style="padding:10px 14px;border-radius:9px;margin-bottom:14px;background:{{ session('error') ? '#fef2f2' : '#dcfce7' }};color:{{ session('error') ? '#991b1b' : '#166534' }};">
            {{ session('error') ?? session('success') }}
        </div>
    @endif

    <div style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.07);overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;min-width:800px;">
            <thead style="background:#f9fafb;">
                <tr>
                    <th style="padding:12px;text-align:left;">Donation</th>
                    <th style="padding:12px;text-align:left;">Claimant</th>
                    <th style="padding:12px;text-align:left;">Request message</th>
                    <th style="padding:12px;text-align:left;">Status</th>
                    <th style="padding:12px;text-align:left;">Requested</th>
                    <th style="padding:12px;text-align:left;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($claims as $claim)
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:12px;">
                            <strong>{{ $claim->item->title }}</strong>
                            <div style="font-size:.72rem;color:#9ca3af;">Donated by {{ $claim->item->user->name }}</div>
                        </td>
                        <td style="padding:12px;">
                            {{ $claim->claimant->name }}
                            <div style="font-size:.72rem;color:#9ca3af;">{{ $claim->claimant->email }}</div>
                        </td>
                        <td style="padding:12px;font-size:.8rem;color:#4b5563;max-width:260px;">{{ $claim->message ?: '—' }}</td>
                        <td style="padding:12px;">{{ $claim->status }}</td>
                        <td style="padding:12px;font-size:.75rem;color:#6b7280;">{{ $claim->created_at->format('M d, Y') }}</td>
                        <td style="padding:12px;">
                            @if($claim->status === 'Pending')
                                <div style="display:flex;gap:6px;">
                                    <form action="{{ route('admin.donations.claims.approve', $claim) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="border:0;border-radius:6px;padding:6px 9px;background:#dcfce7;color:#166534;font-weight:700;cursor:pointer;">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.donations.claims.reject', $claim) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="border:0;border-radius:6px;padding:6px 9px;background:#fee2e2;color:#991b1b;font-weight:700;cursor:pointer;">Reject</button>
                                    </form>
                                </div>
                            @else
                                <span style="color:#9ca3af;font-size:.76rem;">No action needed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="padding:36px;text-align:center;color:#9ca3af;">No claim requests yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="display:flex;justify-content:center;margin-top:16px;">{{ $claims->links() }}</div>
</div>
@endsection
