@extends('layouts.master')

@section('title', $item->title)

@section('content')
<style>
*{box-sizing:border-box;}

/* ─── PAGE LAYOUT ─── */
.show-wrap { max-width:1100px; margin:0 auto; padding:18px 16px; }
.show-layout { display:grid; grid-template-columns:1fr 300px; gap:18px; align-items:start; }
@media(max-width:900px){ .show-layout{ grid-template-columns:1fr; } }
.show-sidebar { position:sticky; top:78px; }
@media(max-width:900px){ .show-sidebar{ position:static; } }

/* ─── MAIN IMAGE — padding-bottom forces fixed aspect ratio ─── */
.main-img-box {
  position: relative;
  width: 100%;
  padding-bottom: 66%;    /* 3:2 ratio — good for product photos */
  overflow: hidden;
  background: #f5f5f5;
  border-radius: 14px;
}
.main-img-box img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
}
.main-img-badge {
  position: absolute;
  top: 12px; right: 12px;
  font-size: 0.72rem; font-weight: 800;
  padding: 5px 14px; border-radius: 999px;
  color: #fff; z-index: 1;
}
.main-img-views {
  position: absolute;
  bottom: 12px; right: 12px;
  font-size: 0.7rem; font-weight: 600;
  padding: 4px 12px; border-radius: 999px;
  background: rgba(0,0,0,0.55); color: #fff; z-index: 1;
}

/* ─── RELATED ITEMS GRID — also force square images ─── */
.related-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
.related-card { text-decoration:none; color:inherit; }
.related-card:hover { text-decoration:none; }
.related-img-box {
  position: relative;
  width: 100%;
  padding-bottom: 100%;   /* 1:1 square */
  overflow: hidden;
  background: #f5f5f5;
  border-radius: 8px;
  margin-bottom: 5px;
}
.related-img-box img {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  object-fit: cover; object-position: center;
  display: block;
  transition: transform 0.25s ease;
}
.related-card:hover .related-img-box img { transform: scale(1.05); }

/* ─── ACTION BUTTONS ─── */
.action-btn {
  display: flex; align-items: center; justify-content: center; gap: 7px;
  width: 100%; padding: 11px 16px; border-radius: 12px;
  font-size: 0.84rem; font-weight: 700; cursor: pointer; border: none;
  transition: all 0.15s; text-decoration: none; margin-bottom: 8px;
}
.action-btn:last-child { margin-bottom: 0; }
.btn-primary { background:#7b0f10; color:#fff; }
.btn-primary:hover { background:#5a0a0b; color:#fff; text-decoration:none; transform:translateY(-1px); box-shadow:0 4px 12px rgba(123,15,16,0.25); }
.btn-outline { border:2px solid #7b0f10; color:#7b0f10; background:transparent; }
.btn-outline:hover { background:#7b0f10; color:#fff; text-decoration:none; }
.btn-success { background:#16a34a; color:#fff; }
.btn-success:hover { background:#15803d; color:#fff; text-decoration:none; }
.btn-danger-outline { border:2px solid #ef4444; color:#ef4444; background:transparent; }
.btn-danger-outline:hover { background:#ef4444; color:#fff; text-decoration:none; }
.btn-edit { background:#dbeafe; color:#1d4ed8; }
.btn-edit:hover { background:#bfdbfe; color:#1d4ed8; text-decoration:none; }

/* ─── MODAL ─── */
.modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,0.6); z-index: 9999;
  align-items: center; justify-content: center;
  padding: 20px;
  backdrop-filter: blur(3px);
}
.modal-box {
  background: #fff; border-radius: 18px; padding: 26px;
  max-width: 500px; width: 100%; max-height: 90vh; overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0,0,0,0.25);
}
.modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.modal-close { background:#f3f4f6; border:none; border-radius:8px; width:30px; height:30px; cursor:pointer; font-size:0.95rem; display:flex; align-items:center; justify-content:center; transition:background 0.15s; }
.modal-close:hover { background:#e5e7eb; }
.offer-label {
  display: flex; align-items: center; gap: 10px;
  padding: 10px; border: 2px solid #e5e7eb; border-radius: 10px;
  cursor: pointer; transition: border-color 0.15s; margin-bottom: 8px;
}
.offer-label:hover, .offer-label.selected { border-color: #7b0f10; }
.offer-label img { width:44px; height:44px; border-radius:7px; object-fit:cover; flex-shrink:0; }
</style>

<div class="show-wrap">

  {{-- Flash messages --}}
  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
  @endif

  {{-- Back link --}}
  <a href="{{ route('items.browse') }}"
     style="display:inline-flex;align-items:center;gap:5px;font-size:0.82rem;font-weight:600;color:#7b0f10;text-decoration:none;margin-bottom:14px;">
    <i class="fas fa-arrow-left" style="font-size:0.7rem;"></i> Back to Browse
  </a>

  <div class="show-layout">

    {{-- ═══ LEFT: Image + Details ═══ --}}
    <div>

      {{-- Main image — FIXED SIZE via padding-bottom --}}
      <div style="margin-bottom:14px;box-shadow:0 1px 4px rgba(0,0,0,0.08);border-radius:14px;overflow:hidden;">
        <div class="main-img-box">
          <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
          <span class="main-img-badge" style="background:{{ $item->item_type==='Barter'?'#7b0f10':'#16a34a' }};">{{ $item->item_type }}</span>
          <span class="main-img-views"><i class="fas fa-eye" style="margin-right:3px;"></i>{{ $item->views }}</span>
        </div>
      </div>

      {{-- Details card --}}
      <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:14px;">
        <h1 style="font-size:1.4rem;font-weight:900;color:#1a1209;margin:0 0 12px;line-height:1.2;">{{ $item->title }}</h1>

        {{-- Status badges --}}
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px;">
          <span style="background:#dbeafe;color:#1d4ed8;font-size:0.7rem;font-weight:600;padding:3px 12px;border-radius:999px;">{{ $item->condition }}</span>
          <span style="background:#dcfce7;color:#166534;font-size:0.7rem;font-weight:600;padding:3px 12px;border-radius:999px;">{{ $item->status }}</span>
          <span style="background:#f3e8ff;color:#7c3aed;font-size:0.7rem;font-weight:600;padding:3px 12px;border-radius:999px;">{{ $item->category }}</span>
        </div>

        {{-- Description --}}
        <p style="font-size:0.62rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.09em;margin:0 0 6px;">Description</p>
        <p style="font-size:0.88rem;color:#4b5563;line-height:1.75;margin:0 0 18px;">{{ $item->description }}</p>

        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;padding:14px 0;border-top:1px solid #f3f4f6;border-bottom:1px solid #f3f4f6;text-align:center;">
          @foreach([[$item->views,'Views'],[$item->wishlist_count,'Wishlisted'],[number_format($item->seller_rating,1),'Rating'],[$item->posted_at->diffForHumans(),'Posted']] as $s)
            <div>
              <p style="font-size:1.1rem;font-weight:900;color:#7b0f10;margin:0;">{{ $s[0] }}</p>
              <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;">{{ $s[1] }}</p>
            </div>
          @endforeach
        </div>
      </div>

      {{-- Related Items --}}
      @if($relatedItems->count() > 0)
        <div style="background:#fff;border-radius:14px;padding:16px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
          <p style="font-size:0.88rem;font-weight:800;color:#1a1209;margin:0 0 12px;">More in {{ $item->category }}</p>
          <div class="related-grid">
            @foreach($relatedItems as $related)
              <a href="{{ route('items.show', $related) }}" class="related-card">
                {{-- FIXED IMAGE using padding-bottom hack --}}
                <div class="related-img-box">
                  <img src="{{ $related->image_url }}" alt="{{ $related->title }}">
                </div>
                <p style="font-size:0.72rem;font-weight:600;color:#1a1209;margin:0;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $related->title }}</p>
                <p style="font-size:0.62rem;color:#9ca3af;margin:2px 0 0;">{{ $related->condition }}</p>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    {{-- ═══ RIGHT: Sidebar ═══ --}}
    <div class="show-sidebar">

      {{-- Seller Card --}}
      <div style="background:#fff;border-radius:14px;padding:18px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:12px;">
        <p style="font-size:0.6rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.09em;margin:0 0 12px;">Seller</p>

        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
          <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&bold=true&size=48"
               style="width:46px;height:46px;border-radius:50%;flex-shrink:0;" alt="{{ $item->user->name }}">
          <div style="min-width:0;">
            <p style="font-size:0.88rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $item->user->name }}</p>
            <div style="display:flex;gap:2px;margin:3px 0;">
              @for($i=0;$i<5;$i++)<i class="fas fa-star" style="color:#f5c518;font-size:0.62rem;"></i>@endfor
            </div>
            <p style="font-size:0.65rem;color:#9ca3af;margin:0;">{{ number_format($item->seller_rating,1) }} / 5.0</p>
          </div>
        </div>

        {{-- Seller stats --}}
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

        {{-- Action Buttons --}}
        @if(auth()->id() !== $item->user_id)
          @if($item->item_type === 'Barter')
            <button onclick="openBarterModal()" class="action-btn btn-primary">
              <i class="fas fa-exchange-alt" style="font-size:0.75rem;"></i> Propose Barter
            </button>
          @else
            <button onclick="openClaimModal()" class="action-btn btn-success">
              <i class="fas fa-gift" style="font-size:0.75rem;"></i> Claim Donation
            </button>
          @endif

          <a href="{{ route('chat.show', $item->user_id) }}" class="action-btn btn-outline">
            <i class="fas fa-comments" style="font-size:0.75rem;"></i> Message Seller
          </a>

          @php $inWishlist = \App\Models\Wishlist::where('user_id',auth()->id())->where('item_id',$item->id)->exists(); @endphp
          @if($inWishlist)
            <form action="{{ route('wishlist.remove', $item) }}" method="POST" style="margin:0;">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn btn-danger-outline">
                <i class="fas fa-heart" style="font-size:0.75rem;"></i> Remove from Wishlist
              </button>
            </form>
          @else
            <form action="{{ route('wishlist.add', $item) }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" class="action-btn btn-outline">
                <i class="far fa-heart" style="font-size:0.75rem;"></i> Add to Wishlist
              </button>
            </form>
          @endif
        @else
          <div style="text-align:center;padding:10px;background:#f9fafb;border-radius:10px;font-size:0.78rem;color:#9ca3af;margin-bottom:8px;">
            <i class="fas fa-info-circle" style="margin-right:4px;"></i> This is your item
          </div>
          <a href="{{ route('items.edit', $item) }}" class="action-btn btn-edit">
            <i class="fas fa-pen" style="font-size:0.75rem;"></i> Edit Item
          </a>
        @endif
      </div>

      {{-- Item Summary --}}
      <div style="background:#f9fafb;border-radius:14px;padding:16px;border:1px solid #e5e7eb;">
        <p style="font-size:0.78rem;font-weight:800;color:#1a1209;margin:0 0 10px;">Item Summary</p>
        <div style="display:flex;flex-direction:column;gap:7px;font-size:0.72rem;">
          @foreach([['Type',$item->item_type],['Category',$item->category],['Condition',$item->condition],['Status',$item->status],['Posted',$item->posted_at->format('M d, Y')]] as $row)
            <div style="display:flex;justify-content:space-between;">
              <span style="color:#9ca3af;">{{ $row[0] }}</span>
              <span style="font-weight:600;color:{{ $row[0]==='Status'?'#7b0f10':'#374151' }};">{{ $row[1] }}</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ══════ BARTER MODAL ══════ --}}
<div id="barterModal" class="modal-overlay" onclick="if(event.target===this)closeBarterModal()">
  <div class="modal-box">
    <div class="modal-header">
      <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-exchange-alt" style="color:#7b0f10;"></i> Propose a Barter
      </h3>
      <button class="modal-close" onclick="closeBarterModal()">✕</button>
    </div>

    <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:0.78rem;color:#92400e;">
      <i class="fas fa-exchange-alt" style="margin-right:5px;"></i>
      You want: <strong>{{ $item->title }}</strong>
    </div>

    <form action="{{ route('trades.propose') }}" method="POST">
      @csrf
      <input type="hidden" name="receiver_item_id" value="{{ $item->id }}">

      <label style="display:block;font-size:0.72rem;font-weight:700;color:#374151;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">
        Your offer <span style="color:#ef4444;">*</span>
      </label>

      @if($myItems->count() > 0)
        <div style="max-height:220px;overflow-y:auto;margin-bottom:14px;">
          @foreach($myItems as $myItem)
            <label class="offer-label" onclick="selectOffer(this)">
              <input type="radio" name="initiator_item_id" value="{{ $myItem->id }}" required class="sr-only" style="position:absolute;opacity:0;">
              <img src="{{ $myItem->image_url }}" alt="{{ $myItem->title }}">
              <div style="flex:1;min-width:0;">
                <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $myItem->title }}</p>
                <p style="font-size:0.65rem;color:#9ca3af;margin:2px 0 0;">{{ $myItem->condition }} · {{ $myItem->category }}</p>
              </div>
            </label>
          @endforeach
        </div>
      @else
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:14px;text-align:center;margin-bottom:14px;">
          <p style="font-size:0.78rem;color:#991b1b;font-weight:600;margin:0 0 8px;">No active items to offer.</p>
          <a href="{{ route('items.create') }}" style="font-size:0.75rem;font-weight:700;color:#7b0f10;text-decoration:none;">
            <i class="fas fa-plus" style="margin-right:3px;"></i> Post an item first
          </a>
        </div>
      @endif

      <label style="display:block;font-size:0.72rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">Message (optional)</label>
      <textarea name="message" rows="2" placeholder="e.g. 'Happy to meet at UB Lounge...'"
                style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.82rem;outline:none;resize:none;margin-bottom:14px;transition:border-color 0.15s;"
                onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'"></textarea>

      <div style="display:flex;gap:8px;">
        <button type="button" onclick="closeBarterModal()"
                style="flex:1;background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:10px;border-radius:8px;border:none;cursor:pointer;">
          Cancel
        </button>
        @if($myItems->count() > 0)
          <button type="submit"
                  style="flex:2;background:#7b0f10;color:#fff;font-size:0.82rem;font-weight:700;padding:10px;border-radius:8px;border:none;cursor:pointer;transition:background 0.15s;"
                  onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
            <i class="fas fa-exchange-alt" style="margin-right:4px;"></i> Send Trade Proposal
          </button>
        @endif
      </div>
    </form>
  </div>
</div>

{{-- ══════ CLAIM MODAL ══════ --}}
<div id="claimModal" class="modal-overlay" onclick="if(event.target===this)closeClaimModal()">
  <div class="modal-box" style="max-width:420px;">
    <div class="modal-header">
      <h3 style="font-size:1rem;font-weight:800;color:#1a1209;margin:0;">Claim this Donation</h3>
      <button class="modal-close" onclick="closeClaimModal()">✕</button>
    </div>
    <div style="background:#dcfce7;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;margin-bottom:14px;font-size:0.78rem;color:#166534;">
      <i class="fas fa-gift" style="margin-right:5px;"></i> Claiming: <strong>{{ $item->title }}</strong>
    </div>
    <p style="font-size:0.82rem;color:#4b5563;margin:0 0 10px;line-height:1.6;">This item is free. Contact the donor to arrange pickup.</p>
    <p style="font-size:0.7rem;color:#9ca3af;margin:0 0 16px;display:flex;align-items:center;gap:5px;">
      <i class="fas fa-shield-alt" style="color:#7b0f10;"></i> Always meet in well-lit campus areas.
    </p>
    <div style="display:flex;gap:8px;">
      <button type="button" onclick="closeClaimModal()"
              style="flex:1;background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:9px;border-radius:8px;border:none;cursor:pointer;">
        Cancel
      </button>
      <a href="{{ route('chat.show', $item->user_id) }}"
         style="flex:2;background:#16a34a;color:#fff;font-size:0.82rem;font-weight:700;padding:9px;border-radius:8px;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;transition:background 0.15s;"
         onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
        <i class="fas fa-comments"></i> Contact Donor
      </a>
    </div>
  </div>
</div>

<script>
function openBarterModal()  { document.getElementById('barterModal').style.display  = 'flex'; }
function closeBarterModal() { document.getElementById('barterModal').style.display  = 'none'; }
function openClaimModal()   { document.getElementById('claimModal').style.display   = 'flex'; }
function closeClaimModal()  { document.getElementById('claimModal').style.display   = 'none'; }

function selectOffer(label) {
  document.querySelectorAll('.offer-label').forEach(el => el.classList.remove('selected'));
  label.classList.add('selected');
  label.querySelector('input[type="radio"]').checked = true;
}
</script>
@endsection
