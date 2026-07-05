@extends('layouts.admin')

@section('title', 'Reviews')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-semibold text-gray-800">All Reviews</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-medium">Product</th>
                        <th class="px-6 py-4 font-medium">User</th>
                        <th class="px-6 py-4 font-medium">Rating</th>
                        <th class="px-6 py-4 font-medium">Comment</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $review->inventory->image ?? 'https://via.placeholder.com/40' }}" alt="{{ $review->inventory->name }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                <p class="font-medium text-gray-900">{{ $review->inventory->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid {{ $i <= $review->rating ? 'fa-star' : 'fa-star text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-600">{{ Str::limit($review->comment, 50) }}</p>
                            @if($review->images && count($review->images) > 0)
                            <div class="flex gap-1 mt-2">
                                @foreach(array_slice($review->images, 0, 3) as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Review image" class="w-10 h-10 object-cover rounded border border-gray-200">
                                @endforeach
                                @if(count($review->images) > 3)
                                <span class="text-xs text-gray-500 self-center">+{{ count($review->images) - 3 }}</span>
                                @endif
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $review->approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $review->approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $review->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$review->approved)
                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline mr-2">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 transition-colors">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fa-solid fa-star-half-stroke text-4xl mb-3 text-gray-300"></i>
                            <p>No reviews found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reviews->hasPages())
        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
