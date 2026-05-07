<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UBarter 2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50" style="overflow-x: hidden;">
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="flex min-h-screen bg-gray-50 pt-16">
        <!-- Sidebar -->
        @if(auth()->check())
            @include('components.sidebar')
        @endif

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto {{ auth()->check() ? 'md:ml-64' : '' }}">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>
</html>
