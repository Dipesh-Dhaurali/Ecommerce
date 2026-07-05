<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - e-mart</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-900 to-purple-900 text-gray-800 antialiased flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-10">
        <div class="text-center mb-8">
            <div class="mx-auto w-20 h-20 bg-gradient-to-r from-indigo-600 to-pink-500 rounded-2xl flex items-center justify-center mb-4">
                <i class="fa-solid fa-lock text-3xl text-white"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">Admin Panel</h2>
            <p class="mt-2 text-sm text-gray-500">Sign in to access the dashboard</p>
        </div>

        <form class="space-y-6" action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            
            @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                {{ $errors->first() }}
            </div>
            @endif
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700"> Remember me </label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-pink-500 hover:from-indigo-700 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Sign in to Admin
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fa-solid fa-arrow-left mr-1"></i>
                Back to Store
            </a>
        </div>
    </div>
</body>
</html>