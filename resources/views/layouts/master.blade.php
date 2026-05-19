<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UBarter 2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { color: #1a1209; margin: 0; padding: 0; overflow-x: hidden; }
        /* Smooth sidebar transitions on mobile */
        #mobile-sidebar { transition: transform 0.25s ease; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Sidebar -->
    @if(auth()->check())
        @include('components.sidebar')
    @endif

    <!-- Main Content -->
    <main class="min-h-screen bg-gray-50 {{ auth()->check() ? 'md:ml-60' : '' }}" style="padding-top: 4rem;">
        @yield('content')
    </main>
</body>
</html>
