<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UBarter 2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50" style="overflow-x: hidden; color: #1a1209; margin: 0; padding: 0;">
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            color: #1a1209;
            margin: 0;
            padding: 0;
        }
    </style>
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Sidebar -->
    @if(auth()->check())
        @include('components.sidebar')
    @endif

    <!-- Main Content -->
    <main class="overflow-y-auto min-h-screen bg-gray-50 {{ auth()->check() ? 'md:ml-64' : '' }}" style="margin-top: 4rem;">
        @yield('content')
    </main>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>
</html>
