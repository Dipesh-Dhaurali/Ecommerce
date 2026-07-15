@extends('layouts.admin')

@section('title', 'POS Counter')

@section('content')
<div class="h-[calc(100vh-8rem)]" x-data="posSystem()">
    <div class="flex flex-col lg:flex-row h-full gap-6">
        
        <!-- Left Side: Products & Search -->
        <div class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Search Bar -->
            <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                    <input type="text" x-model="searchQuery" @input.debounce.300ms="searchProducts" placeholder="Search by name or SKU..." class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-colors">
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto p-4 bg-gray-50/30">
                
                <div x-show="loading" class="flex justify-center items-center h-full">
                    <i class="fa-solid fa-circle-notch fa-spin text-3xl text-green-600"></i>
                </div>

                <div x-show="!loading && products.length === 0" class="flex flex-col justify-center items-center h-full text-gray-400">
                    <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                    <p>No products found.</p>
                </div>

                <div x-show="!loading && products.length > 0" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    <template x-for="product in products" :key="product.id">
                        <div @click="addToCart(product)" class="bg-white border border-gray-100 rounded-xl overflow-hidden cursor-pointer hover:border-green-300 hover:shadow-md transition-all group relative">
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                <img :src="product.image || 'https://via.placeholder.com/150'" class="object-cover w-full h-32">
                            </div>
                            <div class="p-3">
                                <h4 class="text-sm font-medium text-gray-800 line-clamp-2 mb-1" x-text="product.name"></h4>
                                <p class="text-green-600 font-semibold text-sm">Rs. <span x-text="product.price"></span></p>
                                <p class="text-xs text-gray-500 mt-1">Stock: <span x-text="product.stock"></span></p>
                            </div>
                            <div class="absolute inset-0 bg-green-600/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <div class="bg-green-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transform scale-90 group-hover:scale-100 transition-transform">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Side: Cart -->
        <div class="w-full lg:w-96 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-cart-shopping mr-2 text-green-600"></i> Current Sale</h3>
                <button @click="clearCart" x-show="cart.length > 0" class="text-xs text-red-500 hover:text-red-700">Clear</button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/30">
                <div x-show="cart.length === 0" class="flex flex-col justify-center items-center h-full text-gray-400">
                    <i class="fa-solid fa-cart-arrow-down text-4xl mb-3"></i>
                    <p>Cart is empty</p>
                </div>

                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="bg-white border border-gray-100 rounded-xl p-3 flex gap-3 items-center shadow-sm">
                        <img :src="item.image || 'https://via.placeholder.com/50'" class="w-12 h-12 rounded object-cover">
                        <div class="flex-1">
                            <h5 class="text-sm font-medium text-gray-800 line-clamp-1" x-text="item.name"></h5>
                            <p class="text-xs text-green-600 font-semibold">Rs. <span x-text="item.price"></span></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="updateQuantity(index, -1)" class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center hover:bg-gray-200 text-gray-600">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <span class="text-sm font-medium w-4 text-center" x-text="item.quantity"></span>
                            <button @click="updateQuantity(index, 1)" class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center hover:bg-gray-200 text-gray-600">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Checkout Area -->
            <div class="p-4 border-t border-gray-100 bg-white">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 font-medium">Total</span>
                    <span class="text-2xl font-bold text-gray-800">Rs. <span x-text="cartTotal"></span></span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer transition-colors" :class="paymentMethod === 'cash' ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-200 hover:bg-gray-50 text-gray-600'">
                        <input type="radio" x-model="paymentMethod" value="cash" class="hidden">
                        <i class="fa-solid fa-money-bill"></i> Cash
                    </label>
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer transition-colors" :class="paymentMethod === 'online' ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-200 hover:bg-gray-50 text-gray-600'">
                        <input type="radio" x-model="paymentMethod" value="online" class="hidden">
                        <i class="fa-solid fa-qrcode"></i> Online
                    </label>
                </div>

                <!-- QR Code Display -->
                <div x-show="paymentMethod === 'online'" x-transition class="mb-4 flex justify-center">
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-4 text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=YOUR_PAYMENT_INFO" alt="Payment QR Code" class="w-48 h-48 mx-auto mb-2">
                        <p class="text-sm text-gray-600">Scan to pay online</p>
                    </div>
                </div>

                <button @click="checkout" :disabled="cart.length === 0 || processing" class="w-full py-3 px-4 bg-green-600 text-white rounded-xl font-medium flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-green-700 transition-colors shadow-sm shadow-green-200">
                    <span x-show="!processing">Complete Sale</span>
                    <span x-show="processing"><i class="fa-solid fa-circle-notch fa-spin"></i> Processing...</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('posSystem', () => ({
        searchQuery: '',
        products: [],
        cart: [],
        loading: false,
        processing: false,
        paymentMethod: 'cash',

        init() {
            this.searchProducts();
        },

        async searchProducts() {
            this.loading = true;
            try {
                const response = await axios.get(`{{ route('admin.pos.search') }}?q=${this.searchQuery}`);
                this.products = response.data;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        addToCart(product) {
            const index = this.cart.findIndex(item => item.id === product.id);
            if (index > -1) {
                this.cart[index].quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
        },

        updateQuantity(index, change) {
            const newQuantity = this.cart[index].quantity + change;
            if (newQuantity <= 0) {
                this.cart.splice(index, 1);
            } else {
                this.cart[index].quantity = newQuantity;
            }
        },

        clearCart() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.cart = [];
                    Swal.fire('Cleared!', 'Cart has been cleared.', 'success');
                }
            });
        },

        get cartTotal() {
            return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
        },

        async checkout() {
            if (this.cart.length === 0) return;
            this.processing = true;
            
            try {
                const response = await axios.post(`{{ route('admin.pos.checkout') }}`, {
                    items: this.cart,
                    payment_method: this.paymentMethod,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                });
                
                if (response.data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Sale completed successfully!',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Great!'
                    });
                    this.cart = [];
                    this.searchProducts(); // refresh stock
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: error.response?.data?.message || error.message,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            } finally {
                this.processing = false;
            }
        }
    }));
});
</script>
@endsection
