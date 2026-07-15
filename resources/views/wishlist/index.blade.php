@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="wishlistPage()">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Wishlist</h1>

    @if($wishlistItems->isEmpty())
        <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center">
            <i class="fa-solid fa-heart text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Your wishlist is empty</h2>
            <p class="text-gray-500 mb-6">Save items you love by adding them to your wishlist.</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                Browse Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($wishlistItems as $item)
                <div class="group relative bg-white border border-gray-100 rounded-2xl p-4 hover:shadow-lg transition-shadow flex flex-col">
                    <div class="w-full h-48 bg-gray-50 rounded-xl overflow-hidden mb-4 flex items-center justify-center relative border border-gray-100">
                        <img src="{{ $item->inventory->image ? asset('storage/' . $item->inventory->image) : 'https://via.placeholder.com/400' }}" alt="{{ $item->inventory->name }}" class="w-full h-full object-center object-contain p-2 group-hover:scale-105 transition-transform duration-300">
                        <button @click="removeFromWishlist({{ $item->id }})" class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center text-red-500 hover:bg-red-50 transition-colors" title="Remove from wishlist">
                            <i class="fa-solid fa-trash text-sm"></i>
                        </button>
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 line-clamp-2">
                                {{ $item->inventory->name }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $item->inventory->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between z-20 relative">
                            <p class="text-lg font-bold text-indigo-600">Rs. {{ number_format($item->inventory->price, 2) }}</p>
                            @if($item->inventory->stock > 0)
                            <button @click.stop.prevent="addToCart({{ json_encode(['id' => $item->inventory->id, 'name' => $item->inventory->name, 'price' => $item->inventory->price, 'image' => $item->inventory->image ? asset('storage/' . $item->inventory->image) : 'https://via.placeholder.com/400']) }})" class="p-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-colors" title="Add to Cart">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                            @else
                            <span class="text-xs text-red-500 font-medium">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('wishlistPage', () => ({
        removeFromWishlist(itemId) {
            if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                fetch(`{{ route('wishlist.destroy', ':id') }}`.replace(':id', itemId), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error removing item from wishlist');
                    }
                })
                .catch(error => {
                    alert('Error removing item from wishlist');
                });
            }
        },

        addToCart(product) {
            @auth
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const index = cart.findIndex(item => item.id === product.id);
            if (index > -1) {
                cart[index].quantity++;
            } else {
                cart.push({ ...product, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Item added to cart!');
            @else
            window.location.href = '{{ route('login') }}';
            @endauth
        }
    }));
});
</script>
@endsection
