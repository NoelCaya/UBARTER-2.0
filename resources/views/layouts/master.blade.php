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

        /* Main content — always offset by sidebar on desktop */
        #main-content {
            padding-top: 4rem;
            min-height: 100vh;
            background: #f9fafb;
        }
        @media (min-width: 768px) {
            #main-content {
                margin-left: 240px;
            }
        }
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
    <main id="main-content">
        @yield('content')
    </main>
</body>
</html>
