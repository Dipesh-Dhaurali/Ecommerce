@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">Edit Product: {{ $product->name }}</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
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
                    <div x-data="{ imageModalOpen: false }">
                        <div @click="imageModalOpen = true" class="cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-indigo-500 transition-colors">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-32 object-contain mx-auto">
                            @else
                                <div class="text-center text-gray-500">
                                    <i class="fa-solid fa-image text-3xl mb-2"></i>
                                    <p>Click to add image</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Image Update Modal -->
                        <div x-show="imageModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="imageModalOpen = false">
                            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Update Product Image</h3>
                                <form x-data="{ updating: false }" @submit.prevent="
                                    updating = true;
                                    const formData = new FormData();
                                    const fileInput = document.getElementById('imageInput');
                                    
                                    if (fileInput.files.length > 0) {
                                        formData.append('image', fileInput.files[0]);
                                    }
                                    formData.append('_token', document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'));
                                    
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
                                            updating = false;
                                        }
                                    })
                                    .catch(error => {
                                        alert('Error updating image');
                                        updating = false;
                                    });
                                ">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Image</label>
                                        <input type="file" id="imageInput" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="button" @click="imageModalOpen = false" :disabled="updating" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                                        <button type="submit" :disabled="updating" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            <span x-show="!updating">Update Image</span>
                                            <span x-show="updating">Updating...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
@endsection
