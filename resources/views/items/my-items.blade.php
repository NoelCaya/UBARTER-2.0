@extends('layouts.master')

@section('title', 'My Items')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:24px 16px;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
        <div>
            <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-box" style="color:#7b0f10;font-size:1.1rem;"></i> My Items
            </h1>
            <p style="font-size:0.78rem;color:#9ca3af;margin:3px 0 0;">Manage your posted items</p>
        </div>
        <a href="{{ route('items.create') }}"
           style="background:#7b0f10;color:#fff;border-radius:8px;padding:8px 16px;font-size:0.82rem;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:6px;"
           onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
            <i class="fas fa-plus" style="font-size:0.7rem;"></i> Post New Item
        </a>
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

    @if($items->count() > 0)
    <div style="display:flex;flex-direction:column;gap:10px;">
        @foreach($items as $item)
        <div style="background:#fff;border-radius:12px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07);display:flex;align-items:center;gap:14px;flex-wrap:wrap;">

            <!-- Image -->
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                 style="width:64px;height:64px;border-radius:10px;object-fit:cover;flex-shrink:0;background:#f5f5f5;">

            <!-- Info -->
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
                    <p style="font-size:0.9rem;font-weight:700;color:#1a1209;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:300px;">{{ $item->title }}</p>

                    {{-- Status badge --}}
                    @php
                        $statusColors = [
                            'Active'   => ['bg'=>'#dcfce7','color'=>'#166534'],
                            'Pending'  => ['bg'=>'#fef9c3','color'=>'#92400e'],
                            'Traded'   => ['bg'=>'#dbeafe','color'=>'#1d4ed8'],
                            'Archived' => ['bg'=>'#f3f4f6','color'=>'#6b7280'],
                        ];
                        $sc = $statusColors[$item->status] ?? ['bg'=>'#f3f4f6','color'=>'#6b7280'];
                    @endphp
                    <span style="font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:999px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">
                        {{ $item->status }}
                        @if($item->status === 'Pending')
                            · Awaiting admin approval
                        @endif
                    </span>

                    <span style="font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:999px;background:{{ $item->item_type === 'Barter' ? 'rgba(123,15,16,0.08)' : '#dcfce7' }};color:{{ $item->item_type === 'Barter' ? '#7b0f10' : '#166534' }};">
                        {{ $item->item_type }}
                    </span>
                </div>
                <p style="font-size:0.72rem;color:#9ca3af;margin:0;">
                    {{ $item->category }} · {{ $item->condition }} · Posted {{ $item->posted_at->diffForHumans() }}
                </p>
                <p style="font-size:0.72rem;color:#9ca3af;margin:2px 0 0;">
                    <i class="fas fa-eye" style="font-size:0.6rem;"></i> {{ $item->views }} views ·
                    <i class="fas fa-heart" style="font-size:0.6rem;color:#ef4444;"></i> {{ $item->wishlist_count }} wishlisted
                </p>
            </div>

            <!-- Actions -->
            <div style="display:flex;gap:6px;flex-shrink:0;flex-wrap:wrap;">
                {{-- View --}}
                @if($item->status === 'Active')
                <a href="{{ route('items.show', $item) }}"
                   style="background:#f3f4f6;color:#374151;border-radius:7px;padding:6px 12px;font-size:0.72rem;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:4px;"
                   onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                    <i class="fas fa-eye" style="font-size:0.65rem;"></i> View
                </a>
                @endif

                {{-- Edit (only if not Traded) --}}
                @if(!in_array($item->status, ['Traded']))
                <a href="{{ route('items.edit', $item) }}"
                   style="background:#dbeafe;color:#1d4ed8;border-radius:7px;padding:6px 12px;font-size:0.72rem;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:4px;"
                   onmouseover="this.style.background='#bfdbfe'" onmouseout="this.style.background='#dbeafe'">
                    <i class="fas fa-pen" style="font-size:0.65rem;"></i> Edit
                </a>
                @endif

                {{-- Cancel (only Active or Pending) --}}
                @if(in_array($item->status, ['Active', 'Pending']))
                <form action="{{ route('items.cancel', $item) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit"
                            style="background:#fef9c3;color:#92400e;border:none;border-radius:7px;padding:6px 12px;font-size:0.72rem;font-weight:600;cursor:pointer;"
                            onmouseover="this.style.background='#fde68a'" onmouseout="this.style.background='#fef9c3'"
                            onclick="return confirm('Cancel this listing? It will be removed from the marketplace.')">
                        <i class="fas fa-ban" style="font-size:0.65rem;"></i> Cancel
                    </button>
                </form>
                @endif

                {{-- Delete --}}
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="background:#fee2e2;color:#991b1b;border:none;border-radius:7px;padding:6px 12px;font-size:0.72rem;font-weight:600;cursor:pointer;"
                            onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'"
                            onclick="return confirm('Permanently delete \"{{ addslashes($item->title) }}\"? This cannot be undone.')">
                        <i class="fas fa-trash" style="font-size:0.65rem;"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @if($items->hasPages())
        <div style="margin-top:20px;display:flex;justify-content:center;">
            {{ $items->links() }}
        </div>
    @endif

    @else
    <div style="background:#fff;border-radius:14px;padding:48px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,0.06);">
        <i class="fas fa-box-open" style="font-size:2.5rem;color:#e5e7eb;margin-bottom:12px;display:block;"></i>
        <h3 style="font-size:1rem;font-weight:700;color:#1a1209;margin:0 0 6px;">No items posted yet</h3>
        <p style="font-size:0.82rem;color:#9ca3af;margin:0 0 16px;">Share something with the UB community!</p>
        <a href="{{ route('items.create') }}"
           style="background:#7b0f10;color:#fff;border-radius:8px;padding:9px 20px;font-size:0.82rem;font-weight:700;text-decoration:none;">
            Post Your First Item
        </a>
    </div>
    @endif

</div>
@endsection
