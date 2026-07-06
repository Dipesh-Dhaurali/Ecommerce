@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">Edit Product: {{ $product->name }}</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select name="brand_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (Rs.)</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <div>
                        <img onclick="openImageModal({{ $product->id }})" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/40' }}" alt="{{ $product->name }}" class="h-32 object-contain mx-auto cursor-pointer hover:border-indigo-500 border-2 border-dashed border-gray-300 rounded-lg p-4">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Update Modal -->
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

<script>
function openImageModal(productId) {
    document.getElementById('imageModal-' + productId).classList.remove('hidden');
}

function closeImageModal(productId) {
    document.getElementById('imageModal-' + productId).classList.add('hidden');
}

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
</script>
@endsection
