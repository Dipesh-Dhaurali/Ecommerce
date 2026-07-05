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
                        <img onclick="openImageModal({{ $product->id }})" src="{{ $product->image ?? 'https://via.placeholder.com/40' }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 cursor-pointer hover:border-indigo-500 transition-colors">
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

<!-- Image Update Modals -->
@foreach($products as $product)
<div id="imageModal-{{ $product->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Update Product Image</h3>
        <p class="text-sm text-gray-600 mb-4">Product: {{ $product->name }}</p>
        <form id="imageForm-{{ $product->id }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Image</label>
                <input type="file" id="imageInput-{{ $product->id }}" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="closeImageModal({{ $product->id }})" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">Update Image</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function openImageModal(productId) {
    document.getElementById('imageModal-' + productId).classList.remove('hidden');
}

function closeImageModal(productId) {
    document.getElementById('imageModal-' + productId).classList.add('hidden');
}

@foreach($products as $product)
document.getElementById('imageForm-{{ $product->id }}').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData();
    const fileInput = document.getElementById('imageInput-{{ $product->id }}');
    
    if (fileInput.files.length > 0) {
        formData.append('image', fileInput.files[0]);
    }
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('{{ route('admin.products.updateImage', $product) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Error updating image');
        }
    })
    .catch(error => {
        alert('Error updating image');
    });
});
@endforeach
</script>
@endsection
