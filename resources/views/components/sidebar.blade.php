<!-- Sidebar -->
<aside id="mobile-sidebar"
       class="hidden md:flex md:fixed md:left-0 md:top-16 md:h-[calc(100vh-4rem)] md:w-60 flex-col z-40 overflow-hidden"
       style="background: linear-gradient(180deg, #7b0f10 0%, #5a0a0b 100%);">

    <div class="flex-1 overflow-y-auto px-3 py-4">
        <!-- Main Navigation -->
        <nav class="space-y-0.5">
            @php
                function sidebarLink($route) {
                    return request()->routeIs($route) ? 'bg-black/20 border-l-4 border-[#f5c518] pl-3' : 'border-l-4 border-transparent pl-3 hover:bg-black/15';
                }
            @endphp

            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('dashboard') }} transition text-white group">
                <i class="fas fa-home text-base w-5 text-center {{ request()->routeIs('dashboard') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <a href="{{ route('items.browse') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('items.browse') }} transition text-white group">
                <i class="fas fa-shopping-bag text-base w-5 text-center {{ request()->routeIs('items.browse') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Browse Items</span>
            </a>

            <a href="{{ route('items.create') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('items.create') }} transition text-white group">
                <i class="fas fa-plus-circle text-base w-5 text-center {{ request()->routeIs('items.create') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Post Item</span>
            </a>

            <a href="{{ route('trade-history') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('trade-history') }} transition text-white group">
                <i class="fas fa-exchange-alt text-base w-5 text-center {{ request()->routeIs('trade-history') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Trades & Requests</span>
            </a>

            <a href="{{ route('wishlist') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('wishlist') }} transition text-white group">
                <i class="fas fa-heart text-base w-5 text-center {{ request()->routeIs('wishlist') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Wishlist</span>
            </a>

            <div class="my-3 border-t border-white/10"></div>

            <a href="{{ route('chat.index') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('chat.*') }} transition text-white group">
                <i class="fas fa-comments text-base w-5 text-center {{ request()->routeIs('chat.*') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium flex-1">Messages</span>
                <span class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">3</span>
            </a>

            <a href="{{ route('sustainability-leaderboard') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('sustainability-leaderboard') }} transition text-white group">
                <i class="fas fa-leaf text-base w-5 text-center {{ request()->routeIs('sustainability-leaderboard') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Eco Leaderboard</span>
            </a>

            <a href="{{ route('reviews') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('reviews') }} transition text-white group">
                <i class="fas fa-star text-base w-5 text-center {{ request()->routeIs('reviews') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">My Reviews</span>
            </a>

            <div class="my-3 border-t border-white/10"></div>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('profile.edit') }} transition text-white group">
                <i class="fas fa-user-circle text-base w-5 text-center {{ request()->routeIs('profile.edit') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">My Profile</span>
            </a>

            <a href="{{ route('settings') }}"
               class="flex items-center space-x-3 pr-3 py-2.5 rounded-lg {{ sidebarLink('settings') }} transition text-white group">
                <i class="fas fa-cog text-base w-5 text-center {{ request()->routeIs('settings') ? 'text-[#f5c518]' : 'text-white/70 group-hover:text-white' }}"></i>
                <span class="text-sm font-medium">Settings</span>
            </a>
        </nav>

        <!-- Admin Section -->
        @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="mt-4 pt-4 border-t border-white/10">
                <p class="text-xs font-bold uppercase text-[#f5c518] px-3 mb-2 tracking-wider">Administration</p>
                <nav class="space-y-0.5">
                    <a href="#" class="flex items-center space-x-3 pl-3 pr-3 py-2.5 rounded-lg border-l-4 border-transparent hover:bg-black/15 transition text-white group">
                        <i class="fas fa-th-large text-base w-5 text-center text-white/70 group-hover:text-white"></i>
                        <span class="text-sm font-medium">Admin Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 pl-3 pr-3 py-2.5 rounded-lg border-l-4 border-transparent hover:bg-black/15 transition text-white group">
                        <i class="fas fa-check-circle text-base w-5 text-center text-white/70 group-hover:text-white"></i>
                        <span class="text-sm font-medium">Approve Items</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 pl-3 pr-3 py-2.5 rounded-lg border-l-4 border-transparent hover:bg-black/15 transition text-white group">
                        <i class="fas fa-users text-base w-5 text-center text-white/70 group-hover:text-white"></i>
                        <span class="text-sm font-medium">Manage Users</span>
                    </a>
                </nav>
            </div>
        @endif
    </div>

    <!-- Sidebar Footer -->
    <div class="px-4 py-3 border-t border-white/10 bg-black/20">
        <div class="flex items-center space-x-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f5c518&color=7b0f10&bold=true"
                 alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full flex-shrink-0">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-[#f5c518] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-30 md:hidden" onclick="document.getElementById('mobile-sidebar').classList.add('hidden'); document.getElementById('mobile-sidebar').classList.remove('flex'); this.classList.add('hidden');"></div>

<script>
// Extend mobile menu button to also show overlay
document.addEventListener('DOMContentLoaded', function() {
    const mobileBtn = document.getElementById('mobileMenuBtn');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', function() {
            const overlay = document.getElementById('sidebarOverlay');
            const sidebar = document.getElementById('mobile-sidebar');
            if (sidebar && !sidebar.classList.contains('flex') || sidebar.classList.contains('hidden')) {
                overlay?.classList.remove('hidden');
            } else {
                overlay?.classList.add('hidden');
            }
        });
    }
});
</script>
