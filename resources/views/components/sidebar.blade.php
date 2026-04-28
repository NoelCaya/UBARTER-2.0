<!-- Sidebar -->
<aside id="mobile-sidebar" class="hidden md:flex fixed left-0 top-16 h-screen w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white flex-col border-r border-blue-700">
    <div class="flex-1 overflow-y-auto px-4 py-6">
        <!-- Main Menu -->
        <nav class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-600' : 'hover:bg-blue-700' }} transition">
                <i class="fas fa-home text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Browse Items -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span class="font-medium">Browse Items</span>
            </a>

            <!-- Post Item -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus-circle text-lg"></i>
                <span class="font-medium">Post Item</span>
            </a>

            <!-- My Items -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-box text-lg"></i>
                <span class="font-medium">My Items</span>
            </a>

            <!-- Trades & Requests -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-exchange-alt text-lg"></i>
                <span class="font-medium">Trades & Requests</span>
            </a>

            <!-- Wishlist -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-heart text-lg"></i>
                <span class="font-medium">Wishlist</span>
            </a>

            <div class="my-4 border-t border-blue-700"></div>

            <!-- Chat -->
            <a href="{{ route('chat.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-comments text-lg"></i>
                <span class="font-medium">Messages</span>
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
            </a>

            <!-- Reports -->
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-flag text-lg"></i>
                <span class="font-medium">Reports</span>
            </a>

            <!-- Profile Section -->
            <div class="my-4 border-t border-blue-700"></div>

            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-user-circle text-lg"></i>
                <span class="font-medium">My Profile</span>
            </a>

            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-cog text-lg"></i>
                <span class="font-medium">Settings</span>
            </a>
        </nav>

        <!-- Admin Section (if user is admin) -->
        @if(auth()->user() && auth()->user()->role === 'admin')
            <div class="mt-6 pt-6 border-t border-blue-700">
                <p class="text-xs font-semibold uppercase text-blue-300 px-4 mb-3">Administration</p>
                <nav class="space-y-2">
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-th-large text-lg"></i>
                        <span class="font-medium">Admin Dashboard</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span class="font-medium">Approve Items</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-users text-lg"></i>
                        <span class="font-medium">Manage Users</span>
                    </a>
                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                        <span class="font-medium">Disputes</span>
                    </a>
                </nav>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="px-4 py-4 border-t border-blue-700">
        <p class="text-xs text-blue-300 text-center">
            UBarter 2.0 v1.0<br>
            <span class="block text-blue-400">University of Batangas</span>
        </p>
    </div>
</aside>
