@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('shop') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-6">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back to Shop
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
        </div>
        
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
            
            <div class="flex items-center gap-4 mb-6">
                @if($product->average_rating)
                <div class="flex items-center gap-1 text-yellow-500">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-solid {{ $i <= round($product->average_rating) ? 'fa-star' : 'fa-star text-gray-300' }}"></i>
                    @endfor
                    <span class="ml-2 text-gray-600">({{ $product->reviews->count() }} reviews)</span>
                </div>
                @endif
            </div>
            
            <p class="text-3xl font-bold text-indigo-600 mb-6">Rs. {{ number_format($product->price, 2) }}</p>
            
            <p class="text-gray-600 mb-8">{{ $product->description }}</p>
            
            <div class="flex items-center gap-4 mb-8">
                <span class="text-sm text-gray-500">Stock: </span>
                <span class="text-sm font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}
                </span>
            </div>
            
            <div class="flex gap-4">
                @if($product->stock > 0)
                <button @click="addToCart({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image]) }})" class="flex-1 px-8 py-4 bg-gradient-to-r from-indigo-600 to-pink-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all shadow-lg">
                    <i class="fa-solid fa-cart-plus mr-2"></i> Add to Cart
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">Reviews</h2>
        </div>
        
        <div class="p-6">
            @auth
            <div class="mb-8 p-6 bg-gray-50 rounded-xl">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Write a Review</h3>
                <form action="{{ route('reviews.store', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required>
                                <i class="fa-solid fa-star text-2xl text-gray-300 hover:text-yellow-500 transition-colors rating-star" data-rating="{{ $i }}"></i>
                            </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Comment (optional)</label>
                        <textarea name="comment" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"></textarea>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        Submit Review
                    </button>
                </form>
            </div>
            @endauth

            @if($product->reviews->count() > 0)
            <div class="space-y-6">
                @foreach($product->reviews as $review)
                <div class="p-6 border border-gray-100 rounded-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ $review->user->name }}&background=4F46E5&color=fff" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $review->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid {{ $i <= $review->rating ? 'fa-star' : 'fa-star text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                    <p class="text-gray-600">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class="fa-solid fa-star-half-stroke text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Rating star selection
document.querySelectorAll('.rating-star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.getAttribute('data-rating');
        document.querySelectorAll('.rating-star').forEach((s, index) => {
            s.classList.toggle('text-yellow-500', index < rating);
            s.classList.toggle('text-gray-300', index >= rating);
        });
        document.querySelector(`input[name="rating"][value="${rating}"]`).checked = true;
    });
});
</script>
@endsection
