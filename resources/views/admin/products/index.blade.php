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
                        <img onclick="openImageModal({{ $product->id }})" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/40' }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 cursor-pointer hover:border-indigo-500 transition-colors">
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
<div id="imageModal-{{ $product->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl border border-gray-100 transform transition-all">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-image text-indigo-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Update Product Image</h3>
                <p class="text-sm text-gray-500">{{ $product->name }}</p>
            </div>
        </div>
        <form id="imageForm-{{ $product->id }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Upload New Image</label>
                <div class="relative">
                    <input type="file" id="imageInput-{{ $product->id }}" name="image" accept="image/*" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <p class="text-xs text-gray-400 mt-2">Supported formats: JPEG, PNG, JPG, GIF (Max 2MB)</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeImageModal({{ $product->id }})" class="flex-1 px-4 py-3 border-2 border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-200">Update Image</button>
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
