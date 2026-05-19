<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 w-full bg-white border-b-2 border-[#7b0f10] shadow-sm z-50" style="height: 4rem;">
    <div class="px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex items-center space-x-2.5 hover:opacity-80 transition">
                    <img src="{{ asset('images/ub-logo.png') }}" alt="UB Logo" class="w-7 h-7 object-contain rounded-full border-2 border-[#7b0f10]" style="max-width:28px;max-height:28px;">
                    <div class="hidden sm:block leading-tight">
                        <span class="text-base font-bold text-[#7b0f10] block">UBarter</span>
                        <span class="text-xs text-gray-500 block">University of Batangas</span>
                    </div>
                </a>
            </div>

            <!-- Center - Search (authenticated only, hidden on mobile) -->
            @if(auth()->check())
                <div class="hidden md:flex flex-1 mx-6 max-w-sm">
                    <form method="GET" action="{{ route('items.search') }}" class="relative w-full">
                        <input type="text" name="q" placeholder="Search items..."
                               class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#7b0f10]/30 focus:border-[#7b0f10] text-sm transition">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7b0f10] transition">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>
            @endif

            <!-- Right Section -->
            <div class="flex items-center space-x-1 sm:space-x-2">
                @auth
                    <!-- Notifications -->
                    <div class="relative">
                        <button id="notificationsBtn" class="relative p-2 text-gray-500 hover:text-[#7b0f10] hover:bg-gray-100 rounded-full transition" title="Notifications">
                            <i class="far fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl z-50 border border-gray-100 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-bold text-gray-900 text-sm">Notifications</h3>
                                <span class="text-xs bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded-full">3 new</span>
                            </div>
                            <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                                <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 rounded-full bg-[#7b0f10]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-exchange-alt text-[#7b0f10] text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">New trade request from Maria</p>
                                        <p class="text-xs text-gray-500 mt-0.5">5 minutes ago</p>
                                    </div>
                                </a>
                                <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 rounded-full bg-[#f5c518]/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-fire text-[#f5c518] text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">Your item is now trending!</p>
                                        <p class="text-xs text-gray-500 mt-0.5">1 hour ago</p>
                                    </div>
                                </a>
                                <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-comment text-blue-500 text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">New message from James</p>
                                        <p class="text-xs text-gray-500 mt-0.5">3 hours ago</p>
                                    </div>
                                </a>
                            </div>
                            <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50 text-center">
                                <a href="#" class="text-xs font-bold text-[#7b0f10] hover:underline">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center space-x-2 pl-1 pr-2 py-1 rounded-full hover:bg-gray-100 text-gray-700 hover:text-[#7b0f10] focus:outline-none transition" title="Account Menu">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7b0f10&color=fff"
                                 alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full border-2 border-[#f5c518]">
                            <span class="hidden sm:inline text-sm font-semibold max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl z-50 border border-gray-100 overflow-hidden py-1">
                            <div class="px-4 py-2.5 border-b border-gray-100 mb-1">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition">
                                <i class="fas fa-user w-4 mr-3 text-gray-400"></i> My Profile
                            </a>
                            <a href="{{ route('wishlist') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition">
                                <i class="fas fa-heart w-4 mr-3 text-gray-400"></i> Wishlist
                            </a>
                            <a href="{{ route('reviews') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition">
                                <i class="fas fa-star w-4 mr-3 text-gray-400"></i> Reviews
                            </a>
                            <a href="{{ route('settings') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition">
                                <i class="fas fa-cog w-4 mr-3 text-gray-400"></i> Settings
                            </a>
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt w-4 mr-3"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-[#7b0f10] font-bold hover:text-[#5a0a0b] transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition text-sm font-bold">
                        Register
                    </a>
                @endif

                <!-- Mobile Menu Button (authenticated only) -->
                @auth
                    <button id="mobileMenuBtn" class="md:hidden p-2 text-gray-500 hover:text-[#7b0f10] hover:bg-gray-100 rounded-full transition" title="Menu">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
(function() {
    function closeAll() {
        document.getElementById('userDropdown')?.classList.add('hidden');
        document.getElementById('notificationsDropdown')?.classList.add('hidden');
    }

    document.getElementById('userMenuBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const dd = document.getElementById('userDropdown');
        const isHidden = dd.classList.contains('hidden');
        closeAll();
        if (isHidden) dd.classList.remove('hidden');
    });

    document.getElementById('notificationsBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const dd = document.getElementById('notificationsDropdown');
        const isHidden = dd.classList.contains('hidden');
        closeAll();
        if (isHidden) dd.classList.remove('hidden');
    });

    document.getElementById('mobileMenuBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const sidebar = document.getElementById('mobile-sidebar');
        if (sidebar) {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('flex');
        }
    });

    document.addEventListener('click', function() {
        closeAll();
    });

    // Prevent dropdown clicks from closing
    document.getElementById('userDropdown')?.addEventListener('click', function(e) { e.stopPropagation(); });
    document.getElementById('notificationsDropdown')?.addEventListener('click', function(e) { e.stopPropagation(); });
})();
</script>
