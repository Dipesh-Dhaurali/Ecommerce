@extends('layouts.app')

@section('title', 'Welcome to e-mart')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-indigo-50/40 via-white to-emerald-50/20 overflow-hidden border-b border-gray-100">
    <!-- Decorative background elements -->
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-200/20 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-emerald-200/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 relative z-10">
        <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-center">
            <!-- Left Content Column -->
            <div class="sm:text-center lg:text-left lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 border border-indigo-100/60 rounded-full text-indigo-700 text-xs font-semibold tracking-wide">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    ⚡ Fast Delivery & Premium Brands
                </div>
                
                <h1 class="text-4xl tracking-tight font-black text-gray-900 sm:text-5xl md:text-6xl leading-none">
                    Your favorite <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-600 bg-clip-text text-transparent">brands & essentials</span> delivered today
                </h1>
                
                <p class="text-base text-gray-600 sm:text-lg sm:max-w-xl sm:mx-auto md:text-xl lg:mx-0 leading-relaxed">
                    Explore a handpicked collection of premium smartphones, electronics, high-speed accessories, and gourmet snacks. All from the comfort of your home.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 sm:justify-center lg:justify-start">
                    <a href="{{ route('shop') }}" class="flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5 text-base md:text-lg">
                        Shop Collection <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                    </a>
                    <a href="{{ route('shop') }}?brand=1" class="flex items-center justify-center px-8 py-4 bg-white border-2 border-gray-100 hover:border-gray-200 text-gray-700 font-semibold rounded-2xl hover:bg-gray-50 transition-all text-base md:text-lg">
                        Explore Brands
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-6 border-t border-gray-100 flex flex-wrap gap-x-8 gap-y-4 sm:justify-center lg:justify-start text-xs text-gray-500 font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-truck text-emerald-500 text-sm"></i> Free Same-Day Shipping
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-indigo-500 text-sm"></i> 100% Genuine Products
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-arrows-rotate text-purple-500 text-sm"></i> Easy Returns & Refunds
                    </div>
                </div>
            </div>
            
            <!-- Right Image Column -->
            <div class="mt-12 lg:mt-0 lg:col-span-6 relative">
                <div class="relative mx-auto w-full max-w-lg lg:max-w-none flex justify-center items-center">
                    <!-- Glassmorphism backdrop block -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-100/30 to-emerald-100/30 rounded-3xl transform rotate-3 scale-95 blur-sm pointer-events-none"></div>
                    <div class="absolute inset-0 bg-white/40 backdrop-blur-md border border-white/60 rounded-3xl shadow-2xl pointer-events-none"></div>
                    
                    <img src="{{ asset('images/hero_banner.png') }}" alt="e-mart premium digital market" class="relative z-10 w-full h-auto rounded-3xl object-cover transform hover:scale-[1.02] transition-transform duration-500 p-4">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="sm:flex sm:items-baseline sm:justify-between mb-8">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Shop by Category</h2>
        <a href="{{ route('shop') }}" class="hidden sm:block text-sm font-semibold text-green-600 hover:text-green-500">Browse all categories &rarr;</a>
    </div>

    <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-4 lg:gap-x-8">
        @foreach($categories as $category)
        <a href="{{ route('shop', ['category' => $category->id]) }}" class="group relative">
            <div class="w-full h-48 rounded-2xl bg-gray-100 overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-3 sm:h-auto flex items-center justify-center text-4xl text-gray-300 transition-opacity">
                @if($category->image)
                    <img src="{{ $category->image }}" class="w-full h-full object-center object-cover">
                @else
                    <i class="fa-solid fa-tags"></i>
                @endif
            </div>
            <h3 class="mt-4 text-base font-semibold text-gray-900 text-center">
                {{ $category->name }}
            </h3>
        </a>
        @endforeach
    </div>
</div>

<!-- Featured Products -->
<div class="bg-gray-50 border-t border-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Trending Products</h2>
            <a href="{{ route('shop') }}" class="hidden text-sm font-medium text-green-600 hover:text-green-500 md:block">Shop the collection <span aria-hidden="true">&rarr;</span></a>
        </div>

        <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($featuredProducts as $product)
            <a href="{{ route('product.show', $product) }}" class="group relative bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-lg transition-shadow flex flex-col">
                <div class="w-full h-48 bg-gray-50 rounded-xl overflow-hidden mb-4 flex items-center justify-center relative border border-gray-100">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-contain p-2 group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 line-clamp-2">
                            {{ $product->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="mt-4 flex items-center justify-between z-20 relative">
                        <p class="text-lg font-bold text-green-600">Rs. {{ number_format($product->price, 2) }}</p>
                        @if($product->stock > 0)
                        <button @click.stop.prevent="addToCart({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image]) }})" class="p-2.5 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white rounded-xl transition-colors" title="Add to Cart">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                        @else
                        <span class="text-xs text-red-500 font-medium">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
<div class="fixed bottom-4 right-4 z-50 bg-green-50 border-l-4 border-green-400 p-4 rounded shadow-lg max-w-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fa-solid fa-check-circle text-green-400"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">
                {{ session('success') }}
            </p>
        </div>
    </div>
</div>
@endif

@endsection
