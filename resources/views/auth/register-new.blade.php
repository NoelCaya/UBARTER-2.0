<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - UBarter 2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center space-x-3 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-3xl">UB</span>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Join UBarter 2.0</h1>
                <p class="text-gray-600">Create your account to start bartering and donating</p>
            </div>

            <!-- Registration Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <!-- Tabs -->
                <div class="flex space-x-1 mb-8 bg-gray-100 rounded-lg p-1">
                    <a href="{{ route('login') }}" class="flex-1 py-2 px-4 rounded-md text-gray-700 font-medium text-sm hover:bg-gray-200 transition text-center">
                        Login
                    </a>
                    <button type="button" class="flex-1 py-2 px-4 rounded-md bg-blue-600 text-white font-medium text-sm transition">
                        Create Account
                    </button>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               placeholder="John Doe"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required autofocus>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                            UB Email (@ub.edu.ph)
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="john.doe@ub.edu.ph"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">
                            Password
                        </label>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        <p class="text-xs text-gray-600 mt-1">At least 8 characters, with letters and numbers</p>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 mb-2">
                            Confirm Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" name="terms" required
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer mt-1">
                        <label for="terms" class="ml-2 text-sm text-gray-600 cursor-pointer">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center space-x-2 mt-6">
                        <span>Create Account</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-600 font-medium">Or sign up with</span>
                    </div>
                </div>

                <!-- Google Register Button -->
                <a href="{{ route('auth.google') }}" class="w-full border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Google Account</span>
                </a>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Sign in here</a>
                </p>
            </div>

            <!-- Info Box -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                <p class="text-xs text-gray-700">
                    <span class="font-semibold text-blue-900">ℹ️ UB Email Required:</span> Registration is only available to current and former University of Batangas students, alumni, faculty, and employees with a valid @ub.edu.ph email address.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
