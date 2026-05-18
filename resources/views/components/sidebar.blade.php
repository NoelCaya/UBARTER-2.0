<!-- Sidebar -->
<aside id="mobile-sidebar" class="hidden md:flex md:fixed md:left-0 md:top-16 md:h-[calc(100vh-4rem)] md:w-64 text-white flex-col border-r border-[#5a0a0b] overflow-y-auto z-40" style="background: linear-gradient(to bottom, #7b0f10, #5a0a0b);">
    <div class="flex-1 overflow-y-auto px-4 py-6">
        <!-- Main Menu -->
        <nav class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#5a0a0b] border-l-4 border-[#f5c518]' : 'hover:bg-[#5a0a0b]' }} transition text-white">
                <i class="fas fa-home text-lg"></i>
                <span class="font-medium text-white">Dashboard</span>
            </a>

            <!-- Browse Items -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span class="font-medium text-white">Browse Items</span>
            </a>

            <!-- Post Item -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-plus-circle text-lg"></i>
                <span class="font-medium text-white">Post Item</span>
            </a>

            <!-- My Items -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-box text-lg"></i>
                <span class="font-medium text-white">My Items</span>
            </a>

            <!-- Trades & Requests -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-exchange-alt text-lg"></i>
                <span class="font-medium text-white">Trades & Requests</span>
            </a>

            <!-- Wishlist -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-heart text-lg"></i>
                <span class="font-medium text-white">Wishlist</span>
            </a>

            <div class="my-4 border-t border-[#5a0a0b]"></div>

            <!-- Chat -->
            <a href="{{ route('chat.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-comments text-lg"></i>
                <span class="font-medium text-white">Messages</span>
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
            </a>

            <!-- Reports -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-flag text-lg"></i>
                <span class="font-medium text-white">Reports</span>
            </a>

            <!-- Profile Section -->
            <div class="my-4 border-t border-[#5a0a0b]"></div>

            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-user-circle text-lg"></i>
                <span class="font-medium text-white">My Profile</span>
            </a>

            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                <i class="fas fa-cog text-lg"></i>
                <span class="font-medium text-white">Settings</span>
            </a>
        </nav>

        <!-- Admin Section (if user is admin) -->
        @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="mt-6 pt-6 border-t border-[#5a0a0b]">
                <p class="text-xs font-semibold uppercase text-[#f5c518] px-4 mb-3">Administration</p>
                <nav class="space-y-2">
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                        <i class="fas fa-th-large text-lg"></i>
                        <span class="font-medium text-white">Admin Dashboard</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span class="font-medium text-white">Approve Items</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                        <i class="fas fa-users text-lg"></i>
                        <span class="font-medium text-white">Manage Users</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#5a0a0b] transition text-white">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                        <span class="font-medium text-white">Disputes</span>
                    </a>
                </nav>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="px-4 py-4 border-t border-[#5a0a0b] bg-[#5a0a0b]">
        <p class="text-xs text-white text-center">
            <span class="text-white font-semibold">UBarter 2.0 v1.0</span><br>
            <span class="block text-[#f5c518] font-bold">University of Batangas</span>
        </p>
    </div>
</aside>
