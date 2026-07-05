@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">All Brands</h2>
        <a href="{{ route('admin.brands.create') }}" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
            <i class="fa-solid fa-plus mr-2"></i> Add Brand
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-medium">Name</th>
                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $brand->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="text-gray-400 hover:text-green-600 transition-colors p-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this brand?');" class="inline">
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
                    <td colspan="2" class="px-6 py-8 text-center text-gray-500">
                        No brands found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($brands->hasPages())
    <div class="p-6 border-t border-gray-100 bg-gray-50/50">
        {{ $brands->links() }}
    </div>
    @endif
</div>
@endsection
