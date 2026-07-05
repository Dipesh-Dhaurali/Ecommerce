<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - e-mart</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl border-r border-gray-100 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-center h-20 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-pink-500">
                    <i class="fa-solid fa-basket-shopping text-indigo-600"></i> e-mart
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Catalog</p>
                </div>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-tags w-5"></i> Categories
                </a>
                
                <a href="{{ route('admin.brands.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.brands.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-star w-5"></i> Brands
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-box w-5"></i> Products
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sales</p>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-receipt w-5"></i> Orders
                </a>

                <a href="{{ route('admin.pos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pos.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-cash-register w-5"></i> Sales Counter
                </a>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-chart-bar w-5"></i> Reports
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reviews.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-star-half-stroke w-5"></i> Reviews
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                </div>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-indigo-50 to-pink-50 text-indigo-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-gear w-5"></i> Settings
                </a>

            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-red-500 rounded-xl hover:bg-red-50 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 w-full overflow-hidden">
            
            <!-- Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-md border-b border-gray-100 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-indigo-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors hidden sm:block">
                        View Store
                    </a>
                    <div class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4F46E5&color=fff" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 border border-green-100 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 border border-red-100 flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Overlay for mobile sidebar -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-40 bg-gray-800/50 backdrop-blur-sm md:hidden"></div>
    </div>

</body>
</html>
