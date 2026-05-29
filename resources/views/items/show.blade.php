@extends('layouts.master')

@section('title', $item->title)

@section('content')
<style>
    .show-layout {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .show-main { flex: 1; min-width: 0; }
    .show-sidebar {
        width: 280px;
        flex-shrink: 0;
        position: sticky;
        top: 80px;
    }
    @media (max-width: 768px) {
        .show-layout { flex-direction: column; }
        .show-sidebar { width: 100%; position: static; }
    }
    .action-btn-full {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.15s;
        text-decoration: none;
        margin-bottom: 8px;
        box-sizing: border-box;
    }
</style>

<div style="max-width:1000px;margin:0 auto;padding:20px 16px;">

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

    <a href="{{ route('items.browse') }}"
       style="color:#7b0f10;font-size:0.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:16px;">
        <i class="fas fa-arrow-left" style="font-size:0.7rem;"></i> Back to Browse
    </a>

    <div class="show-layout">

        <!-- LEFT: Image + Details -->
        <div class="show-main">

            <!-- Image -->
            <div style="background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:14px;">
                <div style="position:relative;height:300px;background:#f5f5f5;">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                         style="width:100%;height:100%;object-fit:cover;display:block;">
                    <span style="position:absolute;top:12px;right:12px;color:#fff;font-size:0.72rem;font-weight:800;padding:4px 12px;border-radius:999px;background:{{ $item->item_type === 'Barter' ? '#7b0f10' : '#16a34a' }};">
                        {{ $item->item_type }}
                    </span>
                    <span style="position:absolute;bottom:12px;right:12px;color:#fff;font-size:0.68rem;font-weight:600;padding:3px 10px;border-radius:999px;background:rgba(0,0,0,0.55);">
                        <i class="fas fa-eye" style="margin-right:3px;"></i>{{ $item->views }}
                    </span>
                </div>
            </div>

            <!-- Details -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:14px;">
                <h1 style="font-size:1.3rem;font-weight:800;color:#1a1209;margin:0 0 10px;">{{ $item->title }}</h1>

                <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;">
                    <span style="background:#dbeafe;color:#1d4ed8;font-size:0.7rem;font-weight:600;padding:3px 10px;border-radius:999px;">{{ $item->condition }}</span>
                    <span style="background:#dcfce7;color:#166534;font-size:0.7rem;font-weight:600;padding:3px 10px;border-radius:999px;">{{ $item->status }}</span>
                    <span style="background:#f3e8ff;color:#7c3aed;font-size:0.7rem;font-weight:600;padding:3px 10px;border-radius:999px;">{{ $item->category }}</span>
                </div>

                <p style="font-size:0.65rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 6px;">Description</p>
                <p style="font-size:0.85rem;color:#4b5563;line-height:1.7;margin:0 0 16px;">{{ $item->description }}</p>

                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;padding:14px 0;border-top:1px solid #f3f4f6;border-bottom:1px solid #f3f4f6;text-align:center;">
                    @foreach([[$item->views,'Views'],[$item->wishlist_count,'Wishlisted'],[number_format($item->seller_rating,1),'Rating'],[$item->posted_at->diffForHumans(),'Posted']] as $s)
                    <div>
                        <p style="font-size:1rem;font-weight:800;color:#7b0f10;margin:0;">{{ $s[0] }}</p>
                        <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;">{{ $s[1] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Related Items -->
            @if($relatedItems->count() > 0)
            <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
                <p style="font-size:0.85rem;font-weight:800;color:#1a1209;margin:0 0 12px;">More in {{ $item->category }}</p>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                    @foreach($relatedItems as $related)
                    <a href="{{ route('items.show', $related) }}" style="text-decoration:none;color:inherit;">
                        <div style="aspect-ratio:1/1;border-radius:8px;overflow:hidden;background:#f5f5f5;margin-bottom:5px;">
                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.25s;"
                                 onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <p style="font-size:0.72rem;font-weight:600;color:#1a1209;margin:0;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $related->title }}</p>
                        <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;">{{ $related->condition }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- RIGHT: Seller + Actions -->
        <div class="show-sidebar">

            <!-- Seller Card -->
            <div style="background:#fff;border-radius:14px;padding:18px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:12px;">
                <p style="font-size:0.62rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 12px;">Seller</p>

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&bold=true&size=48"
                         alt="{{ $item->user->name }}"
                         style="width:44px;height:44px;border-radius:50%;flex-shrink:0;">
                    <div>
                        <p style="font-size:0.85rem;font-weight:700;color:#1a1209;margin:0;">{{ $item->user->name }}</p>
                        <div style="display:flex;gap:2px;margin:2px 0;">
                            @for($i=0;$i<5;$i++)<i class="fas fa-star" style="color:#f5c518;font-size:0.6rem;"></i>@endfor
                        </div>
                        <p style="font-size:0.65rem;color:#9ca3af;margin:0;">{{ number_format($item->seller_rating,1) }} / 5.0</p>
                    </div>
                </div>

                <div style="font-size:0.72rem;padding:10px 0;border-top:1px solid #f3f4f6;border-bottom:1px solid #f3f4f6;margin-bottom:14px;display:flex;flex-direction:column;gap:6px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9ca3af;">Member since</span>
                        <span style="font-weight:600;color:#374151;">{{ $item->user->created_at->format('M Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9ca3af;">Items posted</span>
                        <span style="font-weight:600;color:#374151;">{{ $item->user->items()->count() }}</span>
                    </div>
                </div>

                @if(auth()->id() !== $item->user_id)

                    {{-- BARTER: Propose Trade --}}
                    @if($item->item_type === 'Barter')
                        <button onclick="document.getElementById('barterModal').style.display='flex'"
                                class="action-btn-full"
                                style="background:#7b0f10;color:#fff;"
                                onmouseover="this.style.background='#5a0a0b'"
                                onmouseout="this.style.background='#7b0f10'">
                            <i class="fas fa-exchange-alt" style="font-size:0.75rem;"></i> Propose Barter
                        </button>
                    @else
                        {{-- DONATION: Claim --}}
                        <button onclick="document.getElementById('claimModal').style.display='flex'"
                                class="action-btn-full"
                                style="background:#16a34a;color:#fff;"
                                onmouseover="this.style.background='#15803d'"
                                onmouseout="this.style.background='#16a34a'">
                            <i class="fas fa-gift" style="font-size:0.75rem;"></i> Claim Donation
                        </button>
                    @endif

                    {{-- Message Seller --}}
                    <a href="{{ route('chat.show', $item->user_id) }}"
                       class="action-btn-full"
                       style="border:2px solid #7b0f10;color:#7b0f10;background:transparent;"
                       onmouseover="this.style.background='#7b0f10';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='#7b0f10'">
                        <i class="fas fa-comments" style="font-size:0.75rem;"></i> Message Seller
                    </a>

                    {{-- Wishlist --}}
                    @php
                        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('item_id', $item->id)->exists();
                    @endphp
                    @if($inWishlist)
                        <form action="{{ route('wishlist.remove', $item) }}" method="POST" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn-full"
                                    style="border:2px solid #ef4444;color:#ef4444;background:transparent;"
                                    onmouseover="this.style.background='#ef4444';this.style.color='white'"
                                    onmouseout="this.style.background='transparent';this.style.color='#ef4444'">
                                <i class="fas fa-heart" style="font-size:0.75rem;"></i> Remove from Wishlist
                            </button>
                        </form>
                    @else
                        <form action="{{ route('wishlist.add', $item) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="action-btn-full"
                                    style="border:2px solid #7b0f10;color:#7b0f10;background:transparent;"
                                    onmouseover="this.style.background='#7b0f10';this.style.color='white'"
                                    onmouseout="this.style.background='transparent';this.style.color='#7b0f10'">
                                <i class="far fa-heart" style="font-size:0.75rem;"></i> Add to Wishlist
                            </button>
                        </form>
                    @endif

                @else
                    <div style="text-align:center;padding:12px;background:#f9fafb;border-radius:10px;font-size:0.78rem;color:#9ca3af;">
                        <i class="fas fa-info-circle" style="margin-right:4px;"></i> This is your item
                    </div>
                    <a href="{{ route('items.edit', $item) }}"
                       class="action-btn-full"
                       style="background:#dbeafe;color:#1d4ed8;margin-top:8px;"
                       onmouseover="this.style.background='#bfdbfe'" onmouseout="this.style.background='#dbeafe'">
                        <i class="fas fa-pen" style="font-size:0.75rem;"></i> Edit Item
                    </a>
                @endif
            </div>

            <!-- Item Summary -->
            <div style="background:#f9fafb;border-radius:14px;padding:16px;border:1px solid #e5e7eb;">
                <p style="font-size:0.78rem;font-weight:700;color:#1a1209;margin:0 0 10px;">Item Summary</p>
                <div style="display:flex;flex-direction:column;gap:7px;font-size:0.72rem;">
                    @foreach([['Type',$item->item_type],['Category',$item->category],['Condition',$item->condition],['Status',$item->status],['Posted',$item->posted_at->format('M d, Y')]] as $row)
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9ca3af;">{{ $row[0] }}</span>
                        <span style="font-weight:600;color:{{ $row[0]==='Status' ? '#7b0f10' : '#374151' }};">{{ $row[1] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PROPOSE BARTER MODAL --}}
<div id="barterModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;padding:24px;max-width:500px;width:100%;box-shadow:0 8px 32px rgba(0,0,0,0.2);max-height:90vh;overflow-y:auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-exchange-alt" style="color:#7b0f10;"></i> Propose a Barter
            </h3>
            <button onclick="document.getElementById('barterModal').style.display='none'"
                    style="background:#f3f4f6;border:none;border-radius:8px;width:28px;height:28px;cursor:pointer;font-size:0.9rem;">✕</button>
        </div>

        <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:0.78rem;color:#92400e;">
            <i class="fas fa-exchange-alt" style="margin-right:5px;"></i>
            You want: <strong>{{ $item->title }}</strong>
        </div>

        <form action="{{ route('trades.propose') }}" method="POST">
            @csrf
            <input type="hidden" name="receiver_item_id" value="{{ $item->id }}">

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#374151;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">
                    Your offer — select an item <span style="color:#ef4444;">*</span>
                </label>

                @if($myItems->count() > 0)
                <div style="display:flex;flex-direction:column;gap:7px;max-height:200px;overflow-y:auto;">
                    @foreach($myItems as $myItem)
                    <label style="display:flex;align-items:center;gap:10px;padding:10px;border:1.5px solid #e5e7eb;border-radius:10px;cursor:pointer;">
                        <input type="radio" name="initiator_item_id" value="{{ $myItem->id }}" required
                               style="accent-color:#7b0f10;flex-shrink:0;"
                               onchange="document.querySelectorAll('[data-offer]').forEach(l=>l.style.borderColor='#e5e7eb');this.closest('label').style.borderColor='#7b0f10';"
                               data-offer>
                        <img src="{{ $myItem->image_url }}" style="width:38px;height:38px;border-radius:6px;object-fit:cover;flex-shrink:0;" alt="{{ $myItem->title }}">
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $myItem->title }}</p>
                            <p style="font-size:0.65rem;color:#9ca3af;margin:1px 0 0;">{{ $myItem->condition }} · {{ $myItem->category }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:14px;text-align:center;">
                    <p style="font-size:0.78rem;color:#991b1b;font-weight:600;margin:0 0 8px;">You have no active barter items to offer.</p>
                    <a href="{{ route('items.create') }}" style="font-size:0.75rem;font-weight:700;color:#7b0f10;text-decoration:none;">
                        <i class="fas fa-plus" style="margin-right:3px;"></i> Post an item first
                    </a>
                </div>
                @endif
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">Message (optional)</label>
                <textarea name="message" rows="2" placeholder="e.g. 'Happy to meet at UB Lounge...'"
                          style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.82rem;outline:none;box-sizing:border-box;resize:none;"
                          onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'"></textarea>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="button" onclick="document.getElementById('barterModal').style.display='none'"
                        style="flex:1;background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:10px;border-radius:8px;border:none;cursor:pointer;">
                    Cancel
                </button>
                @if($myItems->count() > 0)
                <button type="submit"
                        style="flex:2;background:#7b0f10;color:#fff;font-size:0.82rem;font-weight:700;padding:10px;border-radius:8px;border:none;cursor:pointer;"
                        onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                    <i class="fas fa-exchange-alt" style="margin-right:5px;"></i> Send Trade Proposal
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- CLAIM DONATION MODAL --}}
<div id="claimModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;padding:24px;max-width:420px;width:100%;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;">Claim this Donation</h3>
            <button onclick="document.getElementById('claimModal').style.display='none'"
                    style="background:#f3f4f6;border:none;border-radius:8px;width:28px;height:28px;cursor:pointer;">✕</button>
        </div>
        <div style="background:#dcfce7;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:0.78rem;color:#166534;">
            <i class="fas fa-gift" style="margin-right:5px;"></i> Claiming: <strong>{{ $item->title }}</strong>
        </div>
        <p style="font-size:0.82rem;color:#4b5563;margin:0 0 12px;line-height:1.6;">This item is free. Contact the donor to arrange pickup.</p>
        <p style="font-size:0.7rem;color:#9ca3af;margin:0 0 14px;">
            <i class="fas fa-shield-alt" style="color:#7b0f10;margin-right:3px;"></i> Always meet in well-lit campus areas.
        </p>
        <div style="display:flex;gap:8px;">
            <button type="button" onclick="document.getElementById('claimModal').style.display='none'"
                    style="flex:1;background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:9px;border-radius:8px;border:none;cursor:pointer;">
                Cancel
            </button>
            <a href="{{ route('chat.show', $item->user_id) }}"
               style="flex:2;background:#16a34a;color:#fff;font-size:0.82rem;font-weight:700;padding:9px;border-radius:8px;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;"
               onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                <i class="fas fa-comments"></i> Contact Donor
            </a>
        </div>
    </div>
</div>

@endsection
