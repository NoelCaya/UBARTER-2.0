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

            <!-- Center — Search bar (authenticated only) -->
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
            <div class="flex items-center space-x-2">
                @auth
                    <!-- Notifications bell only — no avatar/name/dropdown -->
                    <div class="relative">
                        <button id="notificationsBtn"
                                class="relative p-2 text-gray-500 hover:text-[#7b0f10] hover:bg-gray-100 rounded-full transition"
                                title="Notifications">
                            <i class="far fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <div id="notificationsDropdown"
                             class="hidden absolute right-0 top-full mt-2 z-50 w-80 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
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
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm text-[#7b0f10] font-bold hover:text-[#5a0a0b] transition">Login</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition text-sm font-bold">Register</a>
                @endauth
            </div>

        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var notifDropdown = document.getElementById('notificationsDropdown');
    var notifBtn      = document.getElementById('notificationsBtn');

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function () {
            notifDropdown.classList.add('hidden');
        });
        notifDropdown.addEventListener('click', function (e) { e.stopPropagation(); });
    }
});
</script>
