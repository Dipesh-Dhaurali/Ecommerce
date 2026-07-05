@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="checkoutPage()">
    
    @if(session('error'))
    <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-circle-exclamation text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
        <!-- Order summary -->
        <div class="lg:col-span-5 mb-10 lg:mb-0 lg:sticky lg:top-24">
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Order summary</h2>
                
                <div x-show="cart.length === 0" class="text-center py-6">
                    <p class="text-gray-500">Your cart is empty.</p>
                    <a href="{{ route('shop') }}" class="mt-2 inline-block text-green-600 font-medium">Return to shop</a>
                </div>

                <ul role="list" class="divide-y divide-gray-200" x-show="cart.length > 0">
                    <template x-for="item in cart" :key="item.id">
                        <li class="flex py-4">
                            <img :src="item.image" :alt="item.name" class="flex-none w-16 h-16 rounded-md object-center object-cover border border-gray-200">
                            <div class="ml-4 flex-auto">
                                <h3 class="font-medium text-gray-900" x-text="item.name"></h3>
                                <p class="text-sm text-gray-500">Qty: <span x-text="item.quantity"></span></p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Rs. <span x-text="(item.price * item.quantity).toFixed(2)"></span></p>
                        </li>
                    </template>
                </ul>

                <dl class="border-t border-gray-200 pt-6 space-y-4" x-show="cart.length > 0">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">Rs. <span x-text="cartTotal"></span></dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Shipping</dt>
                        <dd class="text-sm font-medium text-gray-900">Free</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <dt class="text-base font-bold text-gray-900">Total</dt>
                        <dd class="text-base font-bold text-gray-900">Rs. <span x-text="cartTotal"></span></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Checkout form -->
        <div class="lg:col-span-7">
            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" @submit="prepareSubmit" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 sm:p-8">
                @csrf
                <input type="hidden" name="items" x-model="itemsJson">

                <h2 class="text-xl font-bold text-gray-900 mb-6">Delivery Information</h2>
                
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                    <div class="sm:col-span-2">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700">Full name</label>
                        <div class="mt-1">
                            <input type="text" id="customer_name" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone number</label>
                        <div class="mt-1">
                            <input type="text" id="customer_phone" name="customer_phone" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="customer_address" class="block text-sm font-medium text-gray-700">Delivery address</label>
                        <div class="mt-1">
                            <textarea id="customer_address" name="customer_address" rows="3" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-10 border-t border-gray-200 pt-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Payment</h2>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input id="payment_cash" name="payment_method" type="radio" value="cash" x-model="paymentMethod" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                            <label for="payment_cash" class="ml-3 block text-sm font-medium text-gray-700">
                                Cash on Delivery
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="payment_mobile" name="payment_method" type="radio" value="mobile" x-model="paymentMethod" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                            <label for="payment_mobile" class="ml-3 block text-sm font-medium text-gray-700">
                                Mobile Banking
                            </label>
                        </div>
                    </div>

                    <!-- QR Code Display -->
                    <div x-show="paymentMethod === 'mobile'" x-transition class="mt-6 flex justify-center">
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-4 text-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=YOUR_PAYMENT_INFO" alt="Payment QR Code" class="w-48 h-48 mx-auto mb-2">
                            <p class="text-sm text-gray-600">Scan to pay via mobile banking</p>
                        </div>
                    </div>

                    <!-- Payment Screenshot Upload (Optional) -->
                    <div x-show="paymentMethod === 'mobile'" x-transition class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Screenshot (Optional)</label>
                        <p class="text-xs text-gray-500 mb-3">Upload screenshot of your payment confirmation</p>
                        <input type="file" name="payment_screenshot" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                </div>

                <div class="mt-10 border-t border-gray-200 pt-6">
                    <button type="submit" :disabled="cart.length === 0" class="w-full bg-green-600 border border-transparent rounded-xl shadow-sm py-4 px-4 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        Confirm order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('checkoutPage', () => ({
            cart: JSON.parse(localStorage.getItem('cart') || '[]'),
            itemsJson: '',
            paymentMethod: 'cash',
            
            init() {
                this.itemsJson = JSON.stringify(this.cart);
                // Listen for payment method changes
                this.$watch('paymentMethod', (value) => {
                    // Update the radio button when state changes
                    const radio = document.querySelector(`input[name="payment_method"][value="${value}"]`);
                    if (radio) radio.checked = true;
                });
            },

            get cartTotal() {
                return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
            },

            prepareSubmit(e) {
                if(this.cart.length === 0) {
                    e.preventDefault();
                    alert('Your cart is empty!');
                    return false;
                }
                
                // Clear cart after submitting
                setTimeout(() => {
                    localStorage.setItem('cart', '[]');
                    this.cart = [];
                }, 100);
            }
        }));
    });
</script>
@endsection
