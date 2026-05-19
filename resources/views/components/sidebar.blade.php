<!-- Sidebar — Facebook style -->
<style>
    .fb-sidebar {
        position: fixed;
        left: 0;
        top: 4rem;
        height: calc(100vh - 4rem);
        width: 240px;
        background: #fff;
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 100;
    }
    .fb-sidebar-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 8px 8px 16px;
    }
    .fb-sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .fb-sidebar-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    /* User row at top */
    .fb-user-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 10px;
        border-radius: 10px;
        text-decoration: none;
        color: #1a1209;
        margin-bottom: 4px;
        transition: background 0.15s;
    }
    .fb-user-row:hover { background: #f3f4f6; color: #1a1209; text-decoration: none; }
    .fb-user-row img { width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0; }
    .fb-user-row span { font-size: 0.9rem; font-weight: 700; }

    /* Nav links */
    .fb-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 10px;
        border-radius: 10px;
        text-decoration: none;
        color: #1a1209;
        transition: background 0.15s;
        cursor: pointer;
    }
    .fb-nav-link:hover { background: #f3f4f6; color: #1a1209; text-decoration: none; }
    .fb-nav-link.active { background: #fef2f2; color: #7b0f10; }
    .fb-nav-link.active .fb-icon { background: #7b0f10; color: #fff; }

    .fb-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1rem;
        color: #374151;
        transition: background 0.15s, color 0.15s;
    }
    .fb-nav-link:hover .fb-icon {
        background: #e5e7eb;
        color: #7b0f10;
    }

    .fb-label {
        font-size: 0.88rem;
        font-weight: 600;
        flex: 1;
    }

    .fb-badge {
        background: #ef4444;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 999px;
        line-height: 1.4;
    }

    .fb-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 8px 10px;
    }

    .fb-section-label {
        font-size: 0.72rem;
        font-weight: 800;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 4px 10px 6px;
    }

    /* Footer */
    .fb-sidebar-footer {
        padding: 10px 12px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
    }
    .fb-footer-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .fb-footer-user img { width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0; }
    .fb-footer-name { font-size: 0.78rem; font-weight: 700; color: #1a1209; }
    .fb-footer-email { font-size: 0.68rem; color: #9ca3af; }

    /* Mobile hidden */
    @media (max-width: 767px) {
        .fb-sidebar { display: none !important; }
        .fb-sidebar.mobile-open { display: flex !important; }
    }
</style>

<aside class="fb-sidebar" id="mobile-sidebar">
    <div class="fb-sidebar-scroll">

        <!-- User row -->
        <a href="{{ route('profile.edit') }}" class="fb-user-row">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f5c518&color=7b0f10&bold=true"
                 alt="{{ auth()->user()->name }}">
            <span>{{ auth()->user()->name }}</span>
        </a>

        <div class="fb-divider"></div>

        <!-- Main nav -->
        <a href="{{ route('dashboard') }}" class="fb-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-home"></i></span>
            <span class="fb-label">Dashboard</span>
        </a>

        <a href="{{ route('items.browse') }}" class="fb-nav-link {{ request()->routeIs('items.browse') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-shopping-bag"></i></span>
            <span class="fb-label">Browse Items</span>
        </a>

        <a href="{{ route('items.create') }}" class="fb-nav-link {{ request()->routeIs('items.create') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-plus-circle"></i></span>
            <span class="fb-label">Post Item</span>
        </a>

        <a href="{{ route('trade-history') }}" class="fb-nav-link {{ request()->routeIs('trade-history') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-exchange-alt"></i></span>
            <span class="fb-label">Trades & Requests</span>
        </a>

        <a href="{{ route('wishlist') }}" class="fb-nav-link {{ request()->routeIs('wishlist') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-heart"></i></span>
            <span class="fb-label">Wishlist</span>
        </a>

        <div class="fb-divider"></div>

        <a href="{{ route('chat.index') }}" class="fb-nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-comments"></i></span>
            <span class="fb-label">Messages</span>
            <span class="fb-badge">3</span>
        </a>

        <a href="{{ route('sustainability-leaderboard') }}" class="fb-nav-link {{ request()->routeIs('sustainability-leaderboard') ? 'active' : '' }}">
            <span class="fb-icon" style="background:#dcfce7; color:#16a34a;"><i class="fas fa-leaf"></i></span>
            <span class="fb-label">Eco Leaderboard</span>
        </a>

        <a href="{{ route('reviews') }}" class="fb-nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}">
            <span class="fb-icon" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-star"></i></span>
            <span class="fb-label">My Reviews</span>
        </a>

        <div class="fb-divider"></div>

        <a href="{{ route('profile.edit') }}" class="fb-nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-user-circle"></i></span>
            <span class="fb-label">My Profile</span>
        </a>

        <a href="{{ route('settings') }}" class="fb-nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-cog"></i></span>
            <span class="fb-label">Settings</span>
        </a>

        @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="fb-divider"></div>
            <p class="fb-section-label">Administration</p>
            <a href="#" class="fb-nav-link">
                <span class="fb-icon" style="background:#fee2e2; color:#dc2626;"><i class="fas fa-th-large"></i></span>
                <span class="fb-label">Admin Dashboard</span>
            </a>
            <a href="#" class="fb-nav-link">
                <span class="fb-icon" style="background:#fee2e2; color:#dc2626;"><i class="fas fa-check-circle"></i></span>
                <span class="fb-label">Approve Items</span>
            </a>
            <a href="#" class="fb-nav-link">
                <span class="fb-icon" style="background:#fee2e2; color:#dc2626;"><i class="fas fa-users"></i></span>
                <span class="fb-label">Manage Users</span>
            </a>
        @endif

        <!-- Footer note -->
        <div class="fb-divider"></div>
        <p style="font-size:0.65rem; color:#d1d5db; padding: 4px 10px;">UBarter 2.0 · University of Batangas</p>
    </div>

    <!-- Footer user strip -->
    <div class="fb-sidebar-footer">
        <div class="fb-footer-user">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7b0f10&color=fff&bold=true"
                 alt="{{ auth()->user()->name }}">
            <div style="min-width:0;">
                <p class="fb-footer-name truncate">{{ auth()->user()->name }}</p>
                <p class="fb-footer-email truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile overlay -->
<div id="sidebarOverlay"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:99;"
     onclick="closeMobileSidebar()"></div>

<script>
function closeMobileSidebar() {
    var s = document.getElementById('mobile-sidebar');
    var o = document.getElementById('sidebarOverlay');
    if (s) s.classList.remove('mobile-open');
    if (o) o.style.display = 'none';
}
</script>
