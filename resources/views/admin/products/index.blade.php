@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">All Products</h2>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
            <i class="fa-solid fa-plus mr-2"></i> Add Product
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-medium">Product</th>
                    <th class="px-6 py-4 font-medium">SKU</th>
                    <th class="px-6 py-4 font-medium">Category/Brand</th>
                    <th class="px-6 py-4 font-medium">Price</th>
                    <th class="px-6 py-4 font-medium">Stock</th>
                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 flex items-center gap-4">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/40' }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                        <div>
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $product->sku }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 mb-1">
                            {{ $product->category->name ?? 'N/A' }}
                        </span>
                        <br>
                        <span class="text-xs text-gray-500">{{ $product->brand->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4 font-medium">Rs. {{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4">
                        @if($product->stock <= 5)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                {{ $product->stock }} (Low)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                {{ $product->stock }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-gray-400 hover:text-green-600 transition-colors p-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No products found. <a href="{{ route('admin.products.create') }}" class="text-green-600 hover:underline">Add your first product.</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="p-6 border-t border-gray-100 bg-gray-50/50">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
