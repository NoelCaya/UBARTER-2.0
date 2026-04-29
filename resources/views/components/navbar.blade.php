<!-- Navbar -->
<nav class="fixed top-0 w-full bg-white border-b border-gray-200 shadow-sm z-40">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">UB</span>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-gray-900">UBarter</h1>
                        <p class="text-xs text-gray-500">University of Batangas</p>
                    </div>
                </a>
            </div>

            <!-- Center - Search (hidden on mobile) -->
            @if(auth()->check())
                <div class="hidden md:flex flex-1 mx-8 max-w-md">
                    <div class="relative w-full">
                        <input type="text" placeholder="Search items, users..." 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <button class="absolute right-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Notifications -->
                    <button class="relative text-gray-600 hover:text-blue-600 transition">
                        <i class="far fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Chat -->
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="far fa-comments text-xl"></i>
                    </a>

                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none" onclick="toggleUserMenu()">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0066cc&color=fff" 
                                 alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full">
                            <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 first:rounded-t-lg">
                                <i class="fas fa-user mr-2"></i> My Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-heart mr-2"></i> Wishlist
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-star mr-2"></i> Reviews
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 last:rounded-b-lg cursor-pointer font-medium">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 font-medium hover:text-blue-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Register
                    </a>
                @endif

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.relative');
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuBtn && userDropdown && event.target !== userMenuBtn && !userMenuBtn.contains(event.target)) {
        userDropdown.classList.add('hidden');
    }
});
</script>
