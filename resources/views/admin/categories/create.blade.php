@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl mx-auto">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">Add New Category</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent Category (Optional)</label>
                    <select name="parent_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image URL (Optional)</label>
                    <input type="url" name="image" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="https://example.com/image.jpg">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

