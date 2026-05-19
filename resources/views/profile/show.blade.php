@extends('layouts.master')

@section('title', 'My Profile')

@section('content')
<div style="max-width:900px; margin:0 auto; padding:24px 16px;">

    <!-- Profile Header Card -->
    <div style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,0.08); margin-bottom:20px;">
        <!-- Cover Banner -->
        <div style="height:120px; background:linear-gradient(135deg,#7b0f10 0%,#5a0a0b 60%,#9b1a1b 100%); position:relative;">
            <div style="position:absolute; bottom:-40px; left:24px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f5c518&color=7b0f10&bold=true&size=80"
                     alt="{{ auth()->user()->name }}"
                     style="width:80px;height:80px;border-radius:50%;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
            </div>
        </div>

        <!-- Info Row -->
        <div style="padding:52px 24px 20px; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <h1 style="font-size:1.4rem;font-weight:800;color:#1a1209;margin:0 0 4px;">{{ auth()->user()->name }}</h1>
                <p style="font-size:0.82rem;color:#6b7280;margin:0 0 8px;">{{ auth()->user()->email }}</p>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span style="background:#7b0f10;color:#fff;font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:0.05em;">UB MAIN</span>
                    <span style="background:#dcfce7;color:#16a34a;font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;display:flex;align-items:center;gap:4px;">
                        <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> UBmail Verified
                    </span>
                    <span style="background:#fef9c3;color:#92400e;font-size:0.68rem;font-weight:700;padding:3px 10px;border-radius:999px;">Trusted Trader</span>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
               style="background:#7b0f10;color:#fff;font-size:0.82rem;font-weight:700;padding:8px 18px;border-radius:10px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background 0.15s;"
               onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                <i class="fas fa-pen" style="font-size:0.75rem;"></i> Edit Profile
            </a>
        </div>

        <!-- Stats Strip -->
        <div style="display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid #f3f4f6;text-align:center;">
            @foreach([['23','Trades'],['12','Items Posted'],['8','Donations'],['4.9','Trust Score']] as $s)
            <div style="padding:14px 8px; border-right:1px solid #f3f4f6;">
                <p style="font-size:1.3rem;font-weight:800;color:#7b0f10;margin:0;">{{ $s[0] }}</p>
                <p style="font-size:0.7rem;color:#9ca3af;margin:2px 0 0;font-weight:600;">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

        <!-- Left Column -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- About -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-user" style="color:#7b0f10;font-size:0.85rem;"></i> About
                </h2>
                <p style="font-size:0.82rem;color:#4b5563;line-height:1.7;margin:0 0 12px;">
                    Third-year engineering student with a passion for sustainability and helping classmates. I love bartering for resources and helping the community through donations.
                </p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-envelope" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-map-marker-alt" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>University of Batangas, Batangas City</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-calendar" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>Member since January 2024</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.8rem;color:#6b7280;">
                        <i class="fas fa-reply" style="color:#7b0f10;width:14px;text-align:center;"></i>
                        <span>Responds in ~2 hours · 99% rate</span>
                    </div>
                </div>
            </div>

            <!-- Verification -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-shield-alt" style="color:#16a34a;font-size:0.85rem;"></i> Verification
                </h2>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.82rem;color:#16a34a;">
                        <i class="fas fa-check-circle"></i><span>Email Verified</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.82rem;color:#16a34a;">
                        <i class="fas fa-check-circle"></i><span>University ID Verified</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;font-size:0.82rem;color:#d1d5db;">
                        <i class="far fa-circle"></i><span style="color:#9ca3af;">Phone Not Verified</span>
                    </div>
                </div>
                <button style="margin-top:12px;font-size:0.75rem;color:#7b0f10;font-weight:700;background:none;border:none;cursor:pointer;padding:0;">
                    Verify Phone →
                </button>
            </div>

            <!-- Quick Actions -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 12px;">Quick Actions</h2>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('items.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;background:#7b0f10;color:#fff;border-radius:10px;text-decoration:none;font-size:0.82rem;font-weight:700;transition:background 0.15s;"
                       onmouseover="this.style.background='#5a0a0b'" onmouseout="this.style.background='#7b0f10'">
                        <i class="fas fa-plus" style="font-size:0.75rem;"></i> Post New Item
                    </a>
                    <a href="{{ route('items.browse') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;background:#f3f4f6;color:#374151;border-radius:10px;text-decoration:none;font-size:0.82rem;font-weight:700;transition:background 0.15s;"
                       onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="fas fa-box" style="font-size:0.75rem;"></i> My Listings
                    </a>
                    <a href="{{ route('wishlist') }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;background:#f3f4f6;color:#374151;border-radius:10px;text-decoration:none;font-size:0.82rem;font-weight:700;transition:background 0.15s;"
                       onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="fas fa-heart" style="font-size:0.75rem;"></i> Wishlist
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Reviews -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-star" style="color:#f5c518;font-size:0.85rem;"></i> Reviews
                    </h2>
                    <div style="display:flex;align-items:center;gap:4px;">
                        @for($i=0;$i<5;$i++)<i class="fas fa-star" style="color:#f5c518;font-size:0.75rem;"></i>@endfor
                        <span style="font-size:0.78rem;color:#6b7280;margin-left:4px;">4.8 (156)</span>
                    </div>
                </div>

                @foreach([
                    ['Sarah Lee','2 weeks ago',5,'Excellent trade! The calculus book was in perfect condition. Very professional and responsive.'],
                    ['Michael Brown','1 month ago',4,'Good condition uniform set. Pickup was easy. Overall a smooth transaction.'],
                ] as $r)
                <div style="padding:12px 0;border-bottom:1px solid #f3f4f6;last-child:border-bottom:none;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($r[0]) }}&background=7b0f10&color=fff&size=32"
                                 style="width:32px;height:32px;border-radius:50%;" alt="{{ $r[0] }}">
                            <div>
                                <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:0;">{{ $r[0] }}</p>
                                <p style="font-size:0.68rem;color:#9ca3af;margin:0;">{{ $r[1] }}</p>
                            </div>
                        </div>
                        <div style="display:flex;gap:2px;">
                            @for($j=0;$j<5;$j++)
                                <i class="{{ $j < $r[2] ? 'fas' : 'far' }} fa-star" style="color:#f5c518;font-size:0.65rem;"></i>
                            @endfor
                        </div>
                    </div>
                    <p style="font-size:0.78rem;color:#4b5563;margin:0;line-height:1.5;">{{ $r[3] }}</p>
                </div>
                @endforeach

                <a href="{{ route('reviews') }}" style="display:block;text-align:center;margin-top:12px;font-size:0.78rem;font-weight:700;color:#7b0f10;text-decoration:none;">
                    View all reviews →
                </a>
            </div>

            <!-- Recent Activity -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-clock" style="color:#7b0f10;font-size:0.85rem;"></i> Recent Activity
                </h2>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach([
                        ['#7b0f10','Posted new item','Programming Book Set','Today, 10:30 AM'],
                        ['#16a34a','Trade completed','with Sarah Lee','2 days ago'],
                        ['#f5c518','Received donation','University Uniform','5 days ago'],
                        ['#8b5cf6','Achievement unlocked','Reached 20 trades','1 week ago'],
                    ] as $a)
                    <div style="display:flex;gap:12px;align-items:flex-start;">
                        <div style="width:8px;height:8px;border-radius:50%;background:{{ $a[0] }};margin-top:5px;flex-shrink:0;"></div>
                        <div>
                            <p style="font-size:0.8rem;font-weight:700;color:#1a1209;margin:0;">{{ $a[1] }}</p>
                            <p style="font-size:0.72rem;color:#6b7280;margin:1px 0 0;">{{ $a[2] }}</p>
                            <p style="font-size:0.68rem;color:#d1d5db;margin:1px 0 0;">{{ $a[3] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Reputation -->
            <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                <h2 style="font-size:0.95rem;font-weight:800;color:#1a1209;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-award" style="color:#f5c518;font-size:0.85rem;"></i> Reputation
                </h2>
                <div style="text-align:center;margin-bottom:14px;">
                    <p style="font-size:2.5rem;font-weight:800;color:#7b0f10;margin:0;line-height:1;">94</p>
                    <p style="font-size:0.72rem;color:#9ca3af;margin:4px 0 0;font-weight:600;">EXCELLENT</p>
                </div>
                <div style="display:flex;flex-direction:column;gap:6px;">
                    @foreach([['Positive ratings','156','#16a34a'],['Neutral ratings','2','#f59e0b'],['Negative ratings','0','#ef4444']] as $rep)
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;">
                        <span style="color:#6b7280;">{{ $rep[0] }}</span>
                        <span style="font-weight:700;color:{{ $rep[2] }};">{{ $rep[1] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
