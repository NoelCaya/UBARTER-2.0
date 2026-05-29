@extends('layouts.master')

@section('title', 'Trade History')

@section('content')
<div style="max-width:960px;margin:0 auto;padding:24px 16px;">

    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <div>
            <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-exchange-alt" style="color:#7b0f10;"></i> Trades & Requests
            </h1>
            <p style="font-size:0.78rem;color:#9ca3af;margin:3px 0 0;">Manage your barter proposals</p>
        </div>
        <div style="display:flex;gap:8px;">
            <form method="POST" action="{{ route('trade-history.export') }}">
                @csrf
                <button type="submit" style="background:#fff;border:1.5px solid #7b0f10;color:#7b0f10;border-radius:8px;padding:7px 14px;font-size:0.78rem;font-weight:700;cursor:pointer;"
                        onmouseover="this.style.background='#7b0f10';this.style.color='white'" onmouseout="this.style.background='#fff';this.style.color='#7b0f10'">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </form>
            <a href="{{ route('items.browse') }}" style="background:#7b0f10;color:#fff;border-radius:8px;padding:7px 14px;font-size:0.78rem;font-weight:700;text-decoration:none;"
               onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                <i class="fas fa-search mr-1"></i> Find Items to Trade
            </a>
        </div>
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

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px;">
        <div style="background:#fff;border-radius:12px;padding:14px;border-left:4px solid #16a34a;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
            <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;margin:0;">Completed</p>
            <p style="font-size:1.5rem;font-weight:800;color:#16a34a;margin:3px 0 0;">{{ $stats['completed'] }}</p>
        </div>
        <div style="background:#fff;border-radius:12px;padding:14px;border-left:4px solid #f59e0b;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
            <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;margin:0;">Pending</p>
            <p style="font-size:1.5rem;font-weight:800;color:#f59e0b;margin:3px 0 0;">{{ $stats['pending'] }}</p>
        </div>
        <div style="background:#fff;border-radius:12px;padding:14px;border-left:4px solid #7b0f10;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
            <p style="font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9ca3af;margin:0;">Total</p>
            <p style="font-size:1.5rem;font-weight:800;color:#7b0f10;margin:3px 0 0;">{{ $stats['total'] }}</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div style="display:flex;gap:4px;margin-bottom:16px;background:#f3f4f6;padding:4px;border-radius:10px;width:fit-content;">
        @foreach(['all'=>'All','Pending'=>'Pending','Accepted'=>'Accepted','Completed'=>'Completed','Rejected'=>'Rejected','Cancelled'=>'Cancelled'] as $val=>$label)
        <a href="{{ route('trade-history', ['status'=>$val]) }}"
           style="padding:5px 12px;border-radius:7px;font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.15s;
                  {{ $status===$val ? 'background:#7b0f10;color:#fff;' : 'color:#6b7280;' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <!-- Trade Cards -->
    @if($trades->count() > 0)
    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($trades as $trade)
        @php $isInitiator = $trade->initiator_id === auth()->id(); @endphp

        <div style="background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,0.08);overflow:hidden;
                    {{ $trade->status==='Pending' && !$isInitiator ? 'border:2px solid #f59e0b;' : 'border:1px solid #f3f4f6;' }}">

            {{-- Incoming proposal banner --}}
            @if($trade->status === 'Pending' && !$isInitiator)
            <div style="background:#fef9c3;padding:8px 16px;display:flex;align-items:center;gap:8px;border-bottom:1px solid #fde68a;">
                <i class="fas fa-bell" style="color:#f59e0b;font-size:0.85rem;"></i>
                <p style="font-size:0.78rem;font-weight:700;color:#92400e;margin:0;">
                    <strong>{{ $trade->initiator->name }}</strong> wants to trade with you — action required!
                </p>
            </div>
            @endif

            <div style="padding:16px;">
                {{-- Trade Exchange Visual --}}
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;flex-wrap:wrap;">

                    {{-- Initiator's item --}}
                    <div style="flex:1;min-width:140px;background:#f9fafb;border-radius:10px;padding:10px;display:flex;align-items:center;gap:10px;border:1px solid #f3f4f6;">
                        <img src="{{ $trade->initiatorItem->image_url ?? 'https://via.placeholder.com/48' }}"
                             style="width:48px;height:48px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#e5e7eb;"
                             alt="{{ $trade->initiatorItem->title ?? 'Item' }}">
                        <div style="min-width:0;">
                            <p style="font-size:0.65rem;color:#9ca3af;margin:0;font-weight:600;">
                                {{ $isInitiator ? 'YOUR OFFER' : $trade->initiator->name . "'s OFFER" }}
                            </p>
                            <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:2px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">
                                {{ $trade->initiatorItem->title ?? 'Deleted item' }}
                            </p>
                            <p style="font-size:0.65rem;color:#9ca3af;margin:1px 0 0;">{{ $trade->initiatorItem->condition ?? '' }}</p>
                        </div>
                    </div>

                    {{-- Exchange arrow --}}
                    <div style="flex-shrink:0;text-align:center;">
                        <div style="background:#7b0f10;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="fas fa-exchange-alt" style="font-size:0.75rem;"></i>
                        </div>
                        <p style="font-size:0.6rem;color:#9ca3af;margin:3px 0 0;font-weight:600;">BARTER</p>
                    </div>

                    {{-- Receiver's item --}}
                    <div style="flex:1;min-width:140px;background:#f9fafb;border-radius:10px;padding:10px;display:flex;align-items:center;gap:10px;border:1px solid #f3f4f6;">
                        <img src="{{ $trade->receiverItem->image_url ?? 'https://via.placeholder.com/48' }}"
                             style="width:48px;height:48px;border-radius:8px;object-fit:cover;flex-shrink:0;background:#e5e7eb;"
                             alt="{{ $trade->receiverItem->title ?? 'Item' }}">
                        <div style="min-width:0;">
                            <p style="font-size:0.65rem;color:#9ca3af;margin:0;font-weight:600;">
                                {{ !$isInitiator ? 'YOUR ITEM' : $trade->receiver->name . "'s ITEM" }}
                            </p>
                            <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:2px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">
                                {{ $trade->receiverItem->title ?? 'Deleted item' }}
                            </p>
                            <p style="font-size:0.65rem;color:#9ca3af;margin:1px 0 0;">{{ $trade->receiverItem->condition ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Meta row --}}
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        {{-- Status --}}
                        @php
                            $statusStyle = [
                                'Pending'   => 'background:#fef9c3;color:#92400e;',
                                'Accepted'  => 'background:#dbeafe;color:#1d4ed8;',
                                'Completed' => 'background:#dcfce7;color:#166534;',
                                'Rejected'  => 'background:#fee2e2;color:#991b1b;',
                                'Cancelled' => 'background:#f3f4f6;color:#6b7280;',
                            ][$trade->status] ?? 'background:#f3f4f6;color:#6b7280;';
                        @endphp
                        <span style="font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;{{ $statusStyle }}">
                            {{ $trade->status }}
                        </span>

                        {{-- Direction --}}
                        <span style="font-size:0.68rem;color:#9ca3af;">
                            @if($isInitiator)
                                <i class="fas fa-arrow-right" style="color:#7b0f10;font-size:0.6rem;"></i> You proposed to {{ $trade->receiver->name }}
                            @else
                                <i class="fas fa-arrow-left" style="color:#16a34a;font-size:0.6rem;"></i> Proposal from {{ $trade->initiator->name }}
                            @endif
                        </span>

                        {{-- Message --}}
                        @if($trade->message)
                        <span style="font-size:0.65rem;color:#6b7280;background:#f9fafb;padding:2px 8px;border-radius:999px;border:1px solid #e5e7eb;">
                            "{{ Str::limit($trade->message, 50) }}"
                        </span>
                        @endif

                        <span style="font-size:0.65rem;color:#d1d5db;">{{ $trade->created_at->format('M d, Y') }}</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">

                        {{-- RECEIVER: Accept or Reject pending trade --}}
                        @if($trade->status === 'Pending' && !$isInitiator)
                            <form action="{{ route('trades.accept', $trade) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="background:#16a34a;color:#fff;border:none;border-radius:8px;padding:7px 16px;font-size:0.78rem;font-weight:700;cursor:pointer;"
                                        onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                                    <i class="fas fa-check mr-1"></i> Accept Trade
                                </button>
                            </form>
                            <form action="{{ route('trades.reject', $trade) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="background:#fee2e2;color:#991b1b;border:none;border-radius:8px;padding:7px 16px;font-size:0.78rem;font-weight:700;cursor:pointer;"
                                        onmouseover="this.style.background='#dc2626';this.style.color='white'" onmouseout="this.style.background='#fee2e2';this.style.color='#991b1b'">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                            </form>
                        @endif

                        {{-- BOTH: Mark complete when accepted --}}
                        @if($trade->status === 'Accepted')
                            <div style="background:#dbeafe;border-radius:8px;padding:6px 12px;font-size:0.72rem;color:#1d4ed8;font-weight:600;display:flex;align-items:center;gap:5px;">
                                <i class="fas fa-handshake"></i> Trade accepted — arrange the exchange!
                            </div>
                            <form action="{{ route('trades.complete', $trade) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="background:#7b0f10;color:#fff;border:none;border-radius:8px;padding:7px 16px;font-size:0.78rem;font-weight:700;cursor:pointer;"
                                        onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                                    <i class="fas fa-handshake mr-1"></i> Mark as Completed
                                </button>
                            </form>
                        @endif

                        {{-- INITIATOR: Cancel pending trade --}}
                        @if($trade->status === 'Pending' && $isInitiator)
                            <form action="{{ route('trades.cancel', $trade) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="background:#f3f4f6;color:#6b7280;border:none;border-radius:8px;padding:7px 14px;font-size:0.72rem;font-weight:600;cursor:pointer;"
                                        onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'"
                                        onclick="return confirm('Cancel this trade proposal?')">
                                    Cancel Proposal
                                </button>
                            </form>
                        @endif

                        {{-- Chat with partner --}}
                        @php $partnerId = $isInitiator ? $trade->receiver_id : $trade->initiator_id; @endphp
                        <a href="{{ route('chat.show', $partnerId) }}"
                           style="background:#f3f4f6;color:#374151;border-radius:8px;padding:7px 12px;font-size:0.72rem;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:4px;"
                           onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                            <i class="fas fa-comments" style="font-size:0.65rem;"></i> Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($trades->hasPages())
        <div style="margin-top:20px;display:flex;justify-content:center;">
            {{ $trades->appends(request()->query())->links() }}
        </div>
    @endif

    @else
    <div style="background:#fff;border-radius:14px;padding:48px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
        <i class="fas fa-exchange-alt" style="font-size:2.5rem;color:#e5e7eb;margin-bottom:12px;display:block;"></i>
        <h3 style="font-size:1rem;font-weight:700;color:#1a1209;margin:0 0 6px;">No trades yet</h3>
        <p style="font-size:0.82rem;color:#9ca3af;margin:0 0 16px;">Browse items and click "Propose Barter" to start trading!</p>
        <a href="{{ route('items.browse') }}"
           style="background:#7b0f10;color:#fff;border-radius:8px;padding:9px 20px;font-size:0.82rem;font-weight:700;text-decoration:none;">
            Browse Items
        </a>
    </div>
    @endif

</div>

{{-- How it works guide (shown when no trades) --}}
@if($trades->count() === 0)
<div style="max-width:960px;margin:0 auto 24px;padding:0 16px;">
    <div style="background:linear-gradient(135deg,rgba(123,15,16,0.04),rgba(245,197,24,0.06));border:1px solid rgba(123,15,16,0.1);border-radius:14px;padding:20px 24px;">
        <h3 style="font-size:0.9rem;font-weight:800;color:#7b0f10;margin:0 0 14px;display:flex;align-items:center;gap:6px;">
            <i class="fas fa-info-circle"></i> How Bartering Works
        </h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;">
            @foreach([
                ['1','fas fa-search','Browse Items','Find a Barter item you want from the marketplace'],
                ['2','fas fa-exchange-alt','Propose Trade','Select one of your items to offer in exchange'],
                ['3','fas fa-check','Receiver Accepts','The other user reviews and accepts or rejects your offer'],
                ['4','fas fa-handshake','Exchange & Complete','Meet up, exchange items, then mark the trade as complete'],
            ] as $step)
            <div style="display:flex;gap:10px;align-items:flex-start;">
                <div style="width:24px;height:24px;border-radius:50%;background:#7b0f10;color:#fff;font-size:0.7rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">{{ $step[0] }}</div>
                <div>
                    <p style="font-size:0.78rem;font-weight:700;color:#1a1209;margin:0;"><i class="fas {{ $step[1] }}" style="color:#7b0f10;margin-right:4px;font-size:0.7rem;"></i>{{ $step[2] }}</p>
                    <p style="font-size:0.68rem;color:#9ca3af;margin:2px 0 0;line-height:1.4;">{{ $step[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
