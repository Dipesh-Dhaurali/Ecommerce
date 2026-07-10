@extends('layouts.app')

@section('title', 'Shop - e-mart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Shop All Products</h1>
        <p class="mt-2 text-gray-600">Discover our wide selection of products</p>
    </div>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
        
        <!-- Filters sidebar -->
        <aside class="lg:col-span-3 mb-8 lg:mb-0">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 sticky top-24">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Filters</h2>
                
                <!-- Search -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <form action="{{ route('shop') }}" method="GET">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="flex-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors"><i class="fa-solid fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop', request()->except('category')) }}" class="text-sm {{ request('category') ? 'text-gray-600' : 'text-indigo-600 font-medium' }}">All Categories</a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop', array_merge(request()->except('category'), ['category' => $category->id])) }}" class="text-sm {{ request('category') == $category->id ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Brands -->
                <div>
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Brands</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop', request()->except('brand')) }}" class="text-sm {{ request('brand') ? 'text-gray-600' : 'text-indigo-600 font-medium' }}">All Brands</a>
                        </li>
                        @foreach($brands as $brand)
                        <li>
                            <a href="{{ route('shop', array_merge(request()->except('brand'), ['brand' => $brand->id])) }}" class="text-sm {{ request('brand') == $brand->id ? 'text-indigo-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">{{ $brand->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Products grid -->
        <div class="lg:col-span-9">
            
            @if($products->isEmpty())
                <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center">
                    <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4 animate-bounce"></i>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">No products found</h2>
                    <p class="text-gray-500 mb-6">You currently have both <strong>{{ optional($categories->firstWhere('id', request('category')))->name }}</strong> category and <strong>{{ optional($brands->firstWhere('id', request('brand')))->name }}</strong> brand selected together, which returned no results.</p>
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Clear All Filters
                    </a>
                </div>
            @else
            
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @foreach($products as $product)
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
                            <p class="text-lg font-bold text-indigo-600">Rs. {{ number_format($product->price, 2) }}</p>
                            @if($product->stock > 0)
                            <button @click.stop.prevent="addToCart({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image]) }})" class="p-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-colors" title="Add to Cart">
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

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>

            @endif
        </div>
    </div>

</div>
@endsection

