@extends('layouts.app')

@section('title', $product->name . ' - E-Mart Nepal | Dipesh Dhaurali')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article itemscope itemtype="https://schema.org/Product">
    <a href="{{ route('shop') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-6">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back to Shop
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}" alt="{{ $product->name }} - E-Mart Nepal Product by Dipesh Dhaurali" class="w-full h-96 object-cover">
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
                <button @click="addToCart({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'image' => $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400']) }})" class="flex-1 px-8 py-4 bg-gradient-to-r from-indigo-600 to-pink-600 text-white font-semibold rounded-xl hover:opacity-90 transition-all shadow-lg">
                    <i class="fa-solid fa-cart-plus mr-2"></i> Add to Cart
                </button>
                @endif
                <button @click="addToWishlist({{ $product->id }})" class="px-8 py-4 {{ in_array($product->id, $wishlistItems ?? []) ? 'bg-red-50 text-red-600' : 'bg-gray-100 text-gray-700' }} font-semibold rounded-xl hover:bg-red-50 hover:text-red-600 transition-all shadow-lg" data-wishlist-id="{{ $wishlistItems[$product->id] ?? '' }}">
                    <i class="fa-solid fa-heart mr-2"></i> Wishlist
                </button>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <a href="{{ route('product.show', $relatedProduct) }}" class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
                <div class="w-full h-48 bg-gray-50 flex items-center justify-center border-b border-gray-100 overflow-hidden relative">
                    <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 'https://via.placeholder.com/400' }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-center object-contain p-2">
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <h3 class="font-medium text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                    <p class="text-indigo-600 font-bold">Rs. {{ number_format($relatedProduct->price, 2) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Reviews Section -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">Reviews</h2>
        </div>
        
        <div class="p-6">
            @auth
            <div class="mb-8 p-6 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3 text-gray-600">
                    <i class="fa-solid fa-info-circle text-indigo-600"></i>
                    <p>You can only review products after purchasing them. Please check your order history to submit reviews.</p>
                </div>
            </div>
            @else
            <div class="mb-8 p-6 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3 text-gray-600">
                    <i class="fa-solid fa-info-circle text-indigo-600"></i>
                    <p>Please <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">login</a> to view and submit reviews.</p>
                </div>
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
                    <p class="text-gray-600 mb-4">{{ $review->comment }}</p>
                    @endif
                    @if($review->images && count($review->images) > 0)
                    <div class="flex gap-2 flex-wrap">
                        @foreach($review->images as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Review image" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        @endforeach
                    </div>
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
    </article>
</main>
@endsection
