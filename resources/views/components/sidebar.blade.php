<!-- Sidebar -->
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

    /* Scrollable nav area */
    .fb-sidebar-scroll {
        flex: 1;
        overflow-y: auto;
        padding: 10px 8px 8px;
    }
    .fb-sidebar-scroll::-webkit-scrollbar { width: 3px; }
    .fb-sidebar-scroll::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }

    /* Nav links */
    .fb-nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 7px 10px;
        border-radius: 8px;
        text-decoration: none;
        color: #374151;
        transition: background 0.15s;
        cursor: pointer;
        margin-bottom: 1px;
    }
    .fb-nav-link:hover { background: #f3f4f6; color: #1a1209; text-decoration: none; }
    .fb-nav-link.active { background: #fef2f2; color: #7b0f10; }
    .fb-nav-link.active .fb-icon { background: #7b0f10; color: #fff; }

    .fb-icon {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 0.75rem;
        color: #374151;
        transition: background 0.15s, color 0.15s;
    }
    .fb-nav-link:hover .fb-icon { background: #e5e7eb; color: #7b0f10; }

    .fb-label { font-size: 0.8rem; font-weight: 600; flex: 1; }

    .fb-badge {
        background: #ef4444; color: #fff;
        font-size: 0.62rem; font-weight: 800;
        padding: 1px 6px; border-radius: 999px; line-height: 1.4;
    }

    .fb-divider { height: 1px; background: #f3f4f6; margin: 6px 10px; }

    .fb-section-label {
        font-size: 0.65rem; font-weight: 800;
        color: #9ca3af; text-transform: uppercase;
        letter-spacing: 0.09em; padding: 4px 10px 6px;
    }

    /* ── BOTTOM USER CARD ── */
    .fb-user-card {
        border-top: 1px solid #e5e7eb;
        padding: 12px 10px 10px;
        background: #fff;
        flex-shrink: 0;
    }

    /* Avatar + name row */
    .fb-user-identity {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 10px;
        border-radius: 10px;
        background: #f9fafb;
        margin-bottom: 8px;
    }
    .fb-user-identity img {
        width: 34px; height: 34px; border-radius: 50%;
        border: 2px solid #7b0f10; flex-shrink: 0;
    }
    .fb-user-identity .fb-user-name {
        font-size: 0.75rem; font-weight: 700; color: #1a1209;
        margin: 0; line-height: 1.2;
        overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
    }
    .fb-user-identity .fb-user-id {
        font-size: 0.62rem; color: #9ca3af;
        margin: 1px 0 0;
        overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
    }

    /* Quick action buttons row */
    .fb-user-actions {
        display: flex; gap: 6px;
    }
    .fb-action-btn {
        flex: 1; display: flex; align-items: center; justify-content: center; gap: 5px;
        padding: 6px 4px;
        border-radius: 8px;
        font-size: 0.65rem; font-weight: 700;
        text-decoration: none; border: none; cursor: pointer;
        transition: all 0.15s;
    }
    .fb-action-btn:hover { text-decoration: none; }

    .fb-btn-profile {
        background: #f3f4f6; color: #374151;
    }
    .fb-btn-profile:hover { background: #e5e7eb; color: #1a1209; }

    .fb-btn-settings {
        background: #f3f4f6; color: #374151;
    }
    .fb-btn-settings:hover { background: #e5e7eb; color: #1a1209; }

    .fb-btn-logout {
        background: #fef2f2; color: #dc2626;
    }
    .fb-btn-logout:hover { background: #dc2626; color: #fff; }

    /* Mobile hidden */
    @media (max-width: 767px) {
        .fb-sidebar { display: none !important; }
        .fb-sidebar.mobile-open { display: flex !important; }
    }
</style>

<aside class="fb-sidebar" id="mobile-sidebar">

    <!-- ── SCROLLABLE NAV ── -->
    <div class="fb-sidebar-scroll">

        <!-- Main nav — NO user row at the top -->
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

        <a href="{{ route('items.my-items') }}" class="fb-nav-link {{ request()->routeIs('items.my-items') ? 'active' : '' }}">
            <span class="fb-icon"><i class="fas fa-box"></i></span>
            <span class="fb-label">My Items</span>
        </a>

        <a href="{{ route('items.donated') }}" class="fb-nav-link {{ request()->routeIs('items.donated') ? 'active' : '' }}">
            <span class="fb-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-hand-holding-heart"></i></span>
            <span class="fb-label">Donated Items</span>
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
            <span class="fb-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-leaf"></i></span>
            <span class="fb-label">Eco Leaderboard</span>
        </a>

        <a href="{{ route('reviews') }}" class="fb-nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}">
            <span class="fb-icon" style="background:#fef9c3;color:#ca8a04;"><i class="fas fa-star"></i></span>
            <span class="fb-label">My Reviews</span>
        </a>

        @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="fb-divider"></div>
            <p class="fb-section-label">Administration</p>
            <a href="{{ route('admin.dashboard') }}" class="fb-nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <span class="fb-icon" style="background:#fee2e2;color:#dc2626;"><i class="fas fa-shield-alt"></i></span>
                <span class="fb-label">Admin Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="fb-nav-link">
                <span class="fb-icon" style="background:#fee2e2;color:#dc2626;"><i class="fas fa-users"></i></span>
                <span class="fb-label">Manage Users</span>
            </a>
        @endif

        <div class="fb-divider"></div>
        <p style="font-size:0.6rem;color:#d1d5db;padding:2px 10px 6px;">UBarter 2.0 · University of Batangas</p>
    </div>

    <!-- ── BOTTOM USER CARD ── -->
    <div class="fb-user-card">

        <!-- Avatar + Name + Student ID -->
        <div class="fb-user-identity">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7b0f10&color=fff&bold=true"
                 alt="{{ auth()->user()->name }}">
            <div style="min-width:0;flex:1;">
                <p class="fb-user-name">{{ auth()->user()->name }}</p>
                <p class="fb-user-id">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Action buttons: Profile · Settings · Logout -->
        <div class="fb-user-actions">
            <a href="{{ route('profile.edit') }}" class="fb-action-btn fb-btn-profile" title="My Profile">
                <i class="fas fa-user" style="font-size:0.68rem;"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('settings') }}" class="fb-action-btn fb-btn-settings" title="Settings">
                <i class="fas fa-cog" style="font-size:0.68rem;"></i>
                <span>Settings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="flex:1;display:flex;">
                @csrf
                <button type="submit" class="fb-action-btn fb-btn-logout" style="width:100%;" title="Logout">
                    <i class="fas fa-sign-out-alt" style="font-size:0.68rem;"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

</aside>

<!-- Mobile overlay -->
<div id="sidebarOverlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:99;"
     onclick="closeMobileSidebar()"></div>

<script>
function closeMobileSidebar() {
    var s = document.getElementById('mobile-sidebar');
    var o = document.getElementById('sidebarOverlay');
    if (s) s.classList.remove('mobile-open');
    if (o) o.style.display = 'none';
}
</script>
