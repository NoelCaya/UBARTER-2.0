<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 w-full bg-white border-b-2 border-[#7b0f10] shadow-sm" style="height: 4rem; z-index: 1000;">
    <div class="px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex items-center space-x-2.5 hover:opacity-80 transition">
                    <img src="{{ asset('images/ub-logo.png') }}" alt="UB Logo" class="w-9 h-9 object-contain rounded-full border-2 border-[#7b0f10]" style="max-width:36px;max-height:36px;">
                    <div class="hidden sm:block leading-tight">
                        <span class="text-base font-bold text-[#7b0f10] block">UBarter</span>
                        <span class="text-xs text-gray-500 block">University of Batangas</span>
                    </div>
                </a>
            </div>

            <!-- Center - Search -->
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
            <div class="flex items-center space-x-1 sm:space-x-2" style="margin-right: 2rem;">
                @auth
                    <!-- User Menu — placed LEFT of notifications -->
                    <div class="relative" style="overflow:visible;">
                        <button id="userMenuBtn" class="flex items-center space-x-2 pl-1 pr-2 py-1 rounded-full hover:bg-gray-100 text-gray-700 hover:text-[#7b0f10] focus:outline-none transition" title="Account Menu">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7b0f10&color=fff"
                                 alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full border-2 border-[#f5c518]">
                            <span class="hidden sm:inline text-sm font-semibold max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400" id="userChevron" style="transition:transform 0.2s;"></i>
                        </button>

                        <!-- Dropdown — opens LEFT-aligned so it never goes off-screen -->
                        <div id="userDropdown"
                             class="hidden absolute bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
                             style="top: calc(100% + 10px); left: 0; width: 280px; z-index: 1100; transform: translateY(-8px); opacity: 0; transition: transform 0.22s ease, opacity 0.22s ease;">

                            <!-- User Info — maroon header -->
                            <div class="px-4 py-4" style="background:#7b0f10;">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=f5c518&color=7b0f10&bold=true&size=48"
                                         alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-full border-2 border-[#f5c518] flex-shrink-0">
                                    <div style="min-width:0;">
                                        <p class="font-bold text-white text-sm leading-tight" style="word-break:break-word;">{{ auth()->user()->name }}</p>
                                        <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.75); word-break:break-all;">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <nav class="px-2 py-2 space-y-0.5">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition group">
                                    <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#7b0f10]/10 flex items-center justify-center flex-shrink-0 transition">
                                        <i class="fas fa-user text-gray-400 group-hover:text-[#7b0f10] text-sm"></i>
                                    </span>
                                    <span class="font-semibold text-sm">My Profile</span>
                                </a>
                                <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition group">
                                    <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#7b0f10]/10 flex items-center justify-center flex-shrink-0 transition">
                                        <i class="fas fa-heart text-gray-400 group-hover:text-[#7b0f10] text-sm"></i>
                                    </span>
                                    <span class="font-semibold text-sm">Wishlist</span>
                                </a>
                                <a href="{{ route('reviews') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition group">
                                    <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#7b0f10]/10 flex items-center justify-center flex-shrink-0 transition">
                                        <i class="fas fa-star text-gray-400 group-hover:text-[#7b0f10] text-sm"></i>
                                    </span>
                                    <span class="font-semibold text-sm">Reviews</span>
                                </a>
                                <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-[#7b0f10]/5 hover:text-[#7b0f10] transition group">
                                    <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#7b0f10]/10 flex items-center justify-center flex-shrink-0 transition">
                                        <i class="fas fa-cog text-gray-400 group-hover:text-[#7b0f10] text-sm"></i>
                                    </span>
                                    <span class="font-semibold text-sm">Settings</span>
                                </a>
                            </nav>

                            <!-- Logout -->
                            <div class="px-2 pb-2 pt-1 border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition group">
                                        <span class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center flex-shrink-0 transition">
                                            <i class="fas fa-sign-out-alt text-red-500 text-sm"></i>
                                        </span>
                                        <span class="font-bold text-sm">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications — placed RIGHT of user menu -->
                    <div class="relative">
                        <button id="notificationsBtn" class="relative p-2 text-gray-500 hover:text-[#7b0f10] hover:bg-gray-100 rounded-full transition" title="Notifications">
                            <i class="far fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div id="notificationsDropdown" class="hidden absolute mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden" style="left:0; z-index:1100;">
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
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-[#7b0f10] font-bold hover:text-[#5a0a0b] transition">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition text-sm font-bold">Register</a>
                @endif

                @auth
                    {{-- Mobile menu button removed --}}
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var userDropdown  = document.getElementById('userDropdown');
    var userMenuBtn   = document.getElementById('userMenuBtn');
    var notifDropdown = document.getElementById('notificationsDropdown');
    var notifBtn      = document.getElementById('notificationsBtn');
    var chevron       = document.getElementById('userChevron');
    var userOpen      = false;

    if (!userDropdown || !userMenuBtn) return;

    function openUser() {
        userDropdown.classList.remove('hidden');
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                userDropdown.style.transform = 'translateY(0)';
                userDropdown.style.opacity   = '1';
            });
        });
        if (chevron) chevron.style.transform = 'rotate(180deg)';
        userOpen = true;
    }

    function closeUser() {
        userDropdown.style.transform = 'translateY(-8px)';
        userDropdown.style.opacity   = '0';
        setTimeout(function() { userDropdown.classList.add('hidden'); }, 200);
        if (chevron) chevron.style.transform = 'rotate(0deg)';
        userOpen = false;
    }

    function closeNotif() {
        if (notifDropdown) notifDropdown.classList.add('hidden');
    }

    userMenuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        closeNotif();
        userOpen ? closeUser() : openUser();
    });

    if (notifBtn) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            closeUser();
            notifDropdown.classList.toggle('hidden');
        });
    }

    var mobileBtn = document.getElementById('mobileMenuBtn');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            var sidebar = document.getElementById('mobile-sidebar');
            var overlay = document.getElementById('sidebarOverlay');
            if (sidebar) {
                var isOpen = sidebar.classList.contains('mobile-open');
                if (isOpen) {
                    sidebar.classList.remove('mobile-open');
                    if (overlay) overlay.style.display = 'none';
                } else {
                    sidebar.classList.add('mobile-open');
                    if (overlay) overlay.style.display = 'block';
                }
            }
        });
    }

    document.addEventListener('click', function() {
        if (userOpen) closeUser();
        closeNotif();
    });

    userDropdown.addEventListener('click', function(e) { e.stopPropagation(); });
    if (notifDropdown) notifDropdown.addEventListener('click', function(e) { e.stopPropagation(); });
});
</script>
