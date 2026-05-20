@extends('layouts.master')

@section('title', $item->title)

@section('content')
<div class="px-4 md:px-6 py-6 max-w-6xl mx-auto">

    <!-- Flash messages -->
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

    <!-- Back Button -->
    <a href="{{ route('items.browse') }}" class="inline-flex items-center gap-2 text-sm font-semibold mb-5 transition"
       style="color:#7b0f10;">
        <i class="fas fa-arrow-left text-xs"></i> Back to Browse
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Left: Image + Details -->
        <div class="lg:col-span-2 space-y-4">

            <!-- Image -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="relative" style="height:320px; background:#f5f5f5;">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                         class="w-full h-full object-cover">
                    <span class="absolute top-3 right-3 text-white text-xs font-bold px-3 py-1 rounded-full"
                          style="background:{{ $item->item_type === 'Barter' ? '#7b0f10' : '#16a34a' }};">
                        {{ $item->item_type }}
                    </span>
                    <span class="absolute bottom-3 right-3 text-white text-xs font-semibold px-3 py-1 rounded-full"
                          style="background:rgba(0,0,0,0.55);">
                        <i class="fas fa-eye mr-1"></i>{{ $item->views }}
                    </span>
                </div>
            </div>

            <!-- Details -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $item->title }}</h1>

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $item->condition }}</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $item->status }}</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">{{ $item->category }}</span>
                </div>

                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Description</p>
                <p class="text-gray-600 leading-relaxed text-sm mb-5">{{ $item->description }}</p>

                <div class="grid grid-cols-4 gap-3 py-4 border-t border-b border-gray-100 text-center">
                    <div>
                        <p class="text-xl font-bold" style="color:#7b0f10;">{{ $item->views }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Views</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold" style="color:#7b0f10;">{{ $item->wishlist_count }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Wishlisted</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold" style="color:#7b0f10;">{{ number_format($item->seller_rating, 1) }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Seller Rating</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold" style="color:#7b0f10;">{{ $item->posted_at->diffForHumans() }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Posted</p>
                    </div>
                </div>
            </div>

            <!-- Related Items -->
            @if($relatedItems->count() > 0)
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="text-base font-bold text-gray-900 mb-4">More in {{ $item->category }}</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($relatedItems as $related)
                    <a href="{{ route('items.show', $related) }}" class="group">
                        <div class="rounded-lg overflow-hidden mb-1.5" style="aspect-ratio:1/1;background:#f5f5f5;">
                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <p class="text-xs font-semibold text-gray-900 line-clamp-2 group-hover:text-[#7b0f10] transition">{{ $related->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $related->condition }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Seller + Actions -->
        <div class="lg:col-span-1 space-y-4">

            <!-- Seller Card -->
            <div class="bg-white rounded-xl shadow-sm p-5 sticky top-24">

                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Seller</p>

                <div class="flex items-center gap-3 mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=7b0f10&color=fff&bold=true&size=48"
                         alt="{{ $item->user->name }}" class="w-12 h-12 rounded-full flex-shrink-0">
                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ $item->user->name }}</p>
                        <div class="flex gap-0.5 mt-0.5">
                            @for($i=0;$i<5;$i++)
                                <i class="fas fa-star text-xs" style="color:#f5c518;"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($item->seller_rating,1) }} / 5.0</p>
                    </div>
                </div>

                <div class="space-y-1.5 text-xs py-3 border-t border-b border-gray-100 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Member since</span>
                        <span class="font-semibold text-gray-900">{{ $item->user->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Items posted</span>
                        <span class="font-semibold text-gray-900">{{ $item->user->items()->count() }}</span>
                    </div>
                </div>

                @if(auth()->id() !== $item->user_id)
                    {{-- Main action: Propose Barter or Claim Donation --}}
                    @if($item->item_type === 'Barter')
                        <button onclick="document.getElementById('barterModal').style.display='flex'"
                                class="w-full py-2.5 text-white font-bold rounded-lg text-sm mb-2.5 transition flex items-center justify-center gap-2"
                                style="background:#7b0f10;"
                                onmouseover="this.style.background='#5a0a0b'"
                                onmouseout="this.style.background='#7b0f10'">
                            <i class="fas fa-exchange-alt text-xs"></i> Propose Barter
                        </button>
                    @else
                        <button onclick="document.getElementById('claimModal').style.display='flex'"
                                class="w-full py-2.5 text-white font-bold rounded-lg text-sm mb-2.5 transition flex items-center justify-center gap-2"
                                style="background:#16a34a;"
                                onmouseover="this.style.background='#15803d'"
                                onmouseout="this.style.background='#16a34a'">
                            <i class="fas fa-gift text-xs"></i> Claim Donation
                        </button>
                    @endif

                    {{-- Contact Seller --}}
                    <a href="{{ route('chat.show', $item->user_id) }}"
                       class="w-full py-2.5 font-bold rounded-lg text-sm mb-2.5 transition flex items-center justify-center gap-2 border-2"
                       style="border-color:#7b0f10;color:#7b0f10;"
                       onmouseover="this.style.background='#7b0f10';this.style.color='white'"
                       onmouseout="this.style.background='';this.style.color='#7b0f10'">
                        <i class="fas fa-comments text-xs"></i> Message Seller
                    </a>

                    {{-- Wishlist --}}
                    @php
                        $inWishlist = auth()->check()
                            ? \App\Models\Wishlist::where('user_id', auth()->id())->where('item_id', $item->id)->exists()
                            : false;
                    @endphp

                    @if($inWishlist)
                        <form action="{{ route('wishlist.remove', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full py-2.5 font-bold rounded-lg text-sm transition flex items-center justify-center gap-2 border-2"
                                    style="border-color:#ef4444;color:#ef4444;"
                                    onmouseover="this.style.background='#ef4444';this.style.color='white'"
                                    onmouseout="this.style.background='';this.style.color='#ef4444'">
                                <i class="fas fa-heart text-xs"></i> Remove from Wishlist
                            </button>
                        </form>
                    @else
                        <form action="{{ route('wishlist.add', $item) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 font-bold rounded-lg text-sm transition flex items-center justify-center gap-2 border-2"
                                    style="border-color:#7b0f10;color:#7b0f10;"
                                    onmouseover="this.style.background='#7b0f10';this.style.color='white'"
                                    onmouseout="this.style.background='';this.style.color='#7b0f10'">
                                <i class="far fa-heart text-xs"></i> Add to Wishlist
                            </button>
                        </form>
                    @endif

                @else
                    {{-- Own item --}}
                    <div class="text-center py-3 text-sm text-gray-500 bg-gray-50 rounded-lg">
                        <i class="fas fa-info-circle mr-1"></i> This is your item
                    </div>
                @endif
            </div>

            <!-- Item Summary -->
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="font-bold text-gray-900 text-sm mb-3">Item Summary</p>
                <ul class="space-y-2 text-xs">
                    <li class="flex justify-between"><span class="text-gray-500">Type</span><span class="font-semibold text-gray-900">{{ $item->item_type }}</span></li>
                    <li class="flex justify-between"><span class="text-gray-500">Category</span><span class="font-semibold text-gray-900">{{ $item->category }}</span></li>
                    <li class="flex justify-between"><span class="text-gray-500">Condition</span><span class="font-semibold text-gray-900">{{ $item->condition }}</span></li>
                    <li class="flex justify-between"><span class="text-gray-500">Status</span><span class="font-semibold" style="color:#7b0f10;">{{ $item->status }}</span></li>
                    <li class="flex justify-between"><span class="text-gray-500">Posted</span><span class="font-semibold text-gray-900">{{ $item->posted_at->format('M d, Y') }}</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ===== PROPOSE BARTER MODAL ===== --}}
<div id="barterModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;padding:28px;max-width:480px;width:100%;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:1rem;font-weight:800;color:#1a1209;">Propose a Barter</h3>
            <button onclick="document.getElementById('barterModal').style.display='none'"
                    style="background:#f3f4f6;border:none;border-radius:8px;width:30px;height:30px;cursor:pointer;font-size:1rem;">✕</button>
        </div>

        <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:10px;padding:10px 14px;margin-bottom:16px;font-size:0.78rem;color:#92400e;">
            <i class="fas fa-exchange-alt mr-1"></i>
            You are proposing to barter for: <strong>{{ $item->title }}</strong>
        </div>

        <form action="{{ route('chat.show', $item->user_id) }}" method="GET">
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:0.75rem;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">
                    What will you offer in exchange?
                </label>
                <textarea name="barter_message" rows="3"
                          placeholder="Describe what you're offering to trade, e.g. 'I have a Calculus textbook in good condition...'"
                          style="width:100%;padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.85rem;outline:none;box-sizing:border-box;resize:none;"
                          onfocus="this.style.borderColor='#7b0f10'" onblur="this.style.borderColor='#e5e7eb'"></textarea>
            </div>
            <p style="font-size:0.72rem;color:#9ca3af;margin-bottom:14px;">
                <i class="fas fa-info-circle mr-1"></i>
                This will open a chat with the seller so you can negotiate the trade details.
            </p>
            <div style="display:flex;gap:10px;">
                <button type="button" onclick="document.getElementById('barterModal').style.display='none'"
                        style="flex:1;background:#f3f4f6;color:#374151;font-size:0.82rem;font-weight:700;padding:9px;border-radius:8px;border:none;cursor:pointer;">
                    Cancel
                </button>
                <button type="submit"
                        style="flex:2;background:#7b0f10;color:#fff;font-size:0.82rem;font-weight:700;padding:9px;border-radius:8px;border:none;cursor:pointer;"
                        onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                    <i class="fas fa-comments mr-1"></i> Start Chat with Seller
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== CLAIM DONATION MODAL ===== --}}
<div id="claimModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:16px;padding:28px;max-width:440px;width:100%;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:1rem;font-weight:800;color:#1a1209;">Claim this Donation</h3>
            <button onclick="document.getElementById('claimModal').style.display='none'"
                    style="background:#f3f4f6;border:none;border-radius:8px;width:30px;height:30px;cursor:pointer;font-size:1rem;">✕</button>
        </div>

        <div style="background:#dcfce7;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;margin-bottom:16px;font-size:0.78rem;color:#166534;">
            <i class="fas fa-gift mr-1"></i>
            You are claiming: <strong>{{ $item->title }}</strong>
        </div>

        <p style="font-size:0.82rem;color:#4b5563;margin-bottom:16px;line-height:1.6;">
            This item is being donated for free. Clicking "Contact Donor" will open a chat so you can arrange pickup.
        </p>

        <p style="font-size:0.72rem;color:#9ca3af;margin-bottom:16px;">
            <i class="fas fa-shield-alt mr-1" style="color:#7b0f10;"></i>
            Always meet in well-lit campus areas like the UB Lounge or Student Center.
        </p>

        <div style="display:flex;gap:10px;">
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
