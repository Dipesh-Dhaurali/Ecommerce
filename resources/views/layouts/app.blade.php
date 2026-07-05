<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') - e-mart</title>

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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen" x-data="storefront()">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-pink-500">
                        <i class="fa-solid fa-basket-shopping text-indigo-600"></i> e-mart
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <div class="relative">
                            <input 
                                type="text" 
                                @input.debounce.300ms="search()" 
                                @focus="searchOpen = true"
                                @click.away="searchOpen = false"
                                x-model="searchQuery"
                                placeholder="Search products..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-full bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
                            >
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <div x-show="searchOpen && searchResults.length > 0" x-cloak x-transition class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden">
                            <div class="py-2">
                                <template x-for="product in searchResults" :key="product.id">
                                    <a :href="`/shop?q=${encodeURIComponent(product.name)}`" @click="searchOpen = false" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                        <img :src="product.image" class="w-10 h-10 rounded object-cover border border-gray-100">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate" x-text="product.name"></p>
                                            <p class="text-xs text-gray-500">Rs. <span x-text="product.price"></span></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Home</a>
                    <a href="{{ route('shop') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Shop</a>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <button @click="cartOpen = true" class="relative text-gray-500 hover:text-indigo-600 transition-colors p-2">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        <span x-show="cart.length > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-pink-500 rounded-full" x-text="cartTotalItems"></span>
                    </button>
                    
                    @auth
                        <div class="relative" x-data="{ userMenu: false }">
                            <button @click="userMenu = !userMenu" @click.away="userMenu = false" class="flex items-center gap-2 focus:outline-none">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4F46E5&color=fff" class="w-8 h-8 rounded-full border border-gray-200">
                                <span class="hidden sm:inline text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            </button>

                            <div x-show="userMenu" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">Admin Dashboard</a>
                                @endif
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">My Orders</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 hidden sm:block">Sign In</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition-colors hidden sm:block">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-12 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} e-mart. All rights reserved.</p>
        </div>
    </footer>

    <!-- Cart Slide-over panel -->
    <div x-show="cartOpen" class="fixed inset-0 z-50 overflow-hidden" x-cloak aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="cartOpen" x-transition.opacity @click="cartOpen = false" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div x-show="cartOpen" 
                     x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500" 
                     x-transition:enter-start="translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="translate-x-full" 
                     class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl">
                        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button @click="cartOpen = false" type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Close panel</span>
                                        <i class="fa-solid fa-xmark text-xl"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <div x-show="cart.length === 0" class="text-center text-gray-500 py-12">
                                        <i class="fa-solid fa-basket-shopping text-5xl mb-4 text-gray-300"></i>
                                        <p>Your cart is empty.</p>
                                        <button @click="cartOpen = false" class="mt-4 text-indigo-600 font-medium">Continue Shopping</button>
                                    </div>
                                    <ul x-show="cart.length > 0" role="list" class="-my-6 divide-y divide-gray-200">
                                        <template x-for="(item, index) in cart" :key="item.id">
                                            <li class="py-6 flex">
                                                <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-center object-cover">
                                                </div>

                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3 x-text="item.name"></h3>
                                                            <p class="ml-4">Rs. <span x-text="item.price * item.quantity"></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 flex items-end justify-between text-sm">
                                                        <div class="flex items-center gap-2">
                                                            <button @click="updateQuantity(index, -1)" class="w-6 h-6 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-50 text-gray-600"><i class="fa-solid fa-minus text-xs"></i></button>
                                                            <span class="text-gray-500 w-4 text-center" x-text="item.quantity"></span>
                                                            <button @click="updateQuantity(index, 1)" class="w-6 h-6 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-50 text-gray-600"><i class="fa-solid fa-plus text-xs"></i></button>
                                                        </div>

                                                        <div class="flex">
                                                            <button @click="removeFromCart(index)" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div x-show="cart.length > 0" class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p>Rs. <span x-text="cartTotal"></span></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            <div class="mt-6">
                                <a href="{{ route('checkout') }}" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">Checkout</a>
                            </div>
                            <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                                <p>
                                    or <button type="button" @click="cartOpen = false" class="text-indigo-600 font-medium hover:text-indigo-500">Continue Shopping<span aria-hidden="true"> &rarr;</span></button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('storefront', () => ({
                cartOpen: false,
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                searchOpen: false,
                searchQuery: '',
                searchResults: [],
                
                init() {
                    this.$watch('cart', val => localStorage.setItem('cart', JSON.stringify(val)))
                },

                async search() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }

                    try {
                        const response = await fetch(`{{ route('search.instant') }}?q=${encodeURIComponent(this.searchQuery)}`);
                        this.searchResults = await response.json();
                    } catch (error) {
                        console.error('Search error:', error);
                        this.searchResults = [];
                    }
                },

                addToCart(product) {
                    const index = this.cart.findIndex(item => item.id === product.id);
                    if (index > -1) {
                        this.cart[index].quantity++;
                    } else {
                        this.cart.push({ ...product, quantity: 1 });
                    }
                    this.cartOpen = true;
                },

                updateQuantity(index, change) {
                    const newQuantity = this.cart[index].quantity + change;
                    if (newQuantity <= 0) {
                        this.removeFromCart(index);
                    } else {
                        this.cart[index].quantity = newQuantity;
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                get cartTotalItems() {
                    return this.cart.reduce((total, item) => total + item.quantity, 0);
                },

                get cartTotal() {
                    return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
                }
            }));
        });
    </script>
</body>
</html>
