@extends('layouts.app')

@section('title', 'Welcome to e-mart')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Fresh groceries</span>
                        <span class="block text-green-600 xl:inline">delivered to you</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Shop our huge selection of groceries, electronics, and daily essentials from the comfort of your home.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('shop') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-green-600 hover:bg-green-700 md:py-4 md:text-lg transition-colors">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-green-50">
        <!-- Abstract shape or placeholder image -->
        <div class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full flex items-center justify-center text-green-200">
            <i class="fa-solid fa-basket-shopping text-9xl"></i>
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
                <div class="w-full min-h-48 bg-gray-200 aspect-w-1 aspect-h-1 rounded-xl overflow-hidden mb-4">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
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
