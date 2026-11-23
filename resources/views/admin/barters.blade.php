@extends('layouts.master')
@section('title', 'Barter Monitoring')
@section('content')
<div style="max-width:1200px;margin:0 auto;padding:20px 16px;">
    <h1 style="font-size:1.35rem;font-weight:900;color:#1a1209;margin:0 0 4px;">Barter Monitoring</h1>
    <p style="font-size:0.8rem;color:#9ca3af;margin:0 0 14px;">Read-only oversight of active listings and completed barters. Admins are not participants in these exchanges.</p>
    @include('admin.partials.nav')

    <section style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.07);overflow:hidden;margin-bottom:18px;">
        <h2 style="padding:14px 18px;margin:0;border-bottom:1px solid #f3f4f6;font-size:.95rem;">Available Barter Items</h2>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:700px;">
                <thead style="background:#f9fafb;"><tr>
                    <th style="padding:10px;text-align:left;">Item</th>
                    <th style="padding:10px;text-align:left;">Owner</th>
                    <th style="padding:10px;text-align:left;">Category</th>
                    <th style="padding:10px;text-align:left;">Condition</th>
                    <th style="padding:10px;text-align:left;">Posted</th>
                </tr></thead>
                <tbody>
                @forelse($availableBarters as $item)
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:10px;">
                            <div style="display:flex;align-items:center;gap:9px;">
                                <img src="{{ $item->image_url }}" alt="" style="width:44px;height:44px;object-fit:cover;border-radius:7px;">
                                <div><strong>{{ $item->title }}</strong><div style="font-size:.72rem;color:#6b7280;">{{ \Illuminate\Support\Str::limit($item->description, 90) }}</div></div>
                            </div>
                        </td>
                        <td style="padding:10px;">{{ $item->user->name }}</td>
                        <td style="padding:10px;">{{ $item->category }}</td>
                        <td style="padding:10px;">{{ $item->condition }}</td>
                        <td style="padding:10px;">{{ $item->posted_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="padding:28px;text-align:center;color:#9ca3af;">No active barter listings.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:12px;">{{ $availableBarters->links() }}</div>
    </section>

    <section style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.07);overflow:hidden;">
        <h2 style="padding:14px 18px;margin:0;border-bottom:1px solid #f3f4f6;font-size:.95rem;">Completed Barters</h2>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:780px;">
                <thead style="background:#f9fafb;"><tr>
                    <th style="padding:10px;text-align:left;">Exchange</th>
                    <th style="padding:10px;text-align:left;">Participants</th>
                    <th style="padding:10px;text-align:left;">Completed</th>
                    <th style="padding:10px;text-align:left;">Trade note</th>
                </tr></thead>
                <tbody>
                @forelse($completedBarters as $trade)
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:10px;">
                            {{ $trade->initiatorItem->title ?? 'Item removed' }}
                            <span style="color:#9ca3af;">↔</span>
                            {{ $trade->receiverItem->title ?? 'Item removed' }}
                        </td>
                        <td style="padding:10px;">{{ $trade->initiator->name ?? 'User removed' }} ↔ {{ $trade->receiver->name ?? 'User removed' }}</td>
                        <td style="padding:10px;">{{ optional($trade->completed_at)->format('M d, Y') ?? '—' }}</td>
                        <td style="padding:10px;max-width:240px;color:#6b7280;">{{ $trade->message ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="padding:28px;text-align:center;color:#9ca3af;">No completed barters to monitor.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:12px;">{{ $completedBarters->links() }}</div>
    </section>
</div>
@endsection
