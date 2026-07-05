@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-6">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back to Orders
    </a>

    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <!-- Order Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Order #{{ $order->id }}</h1>
                    <p class="text-indigo-100 mt-1">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white/20 text-white">
                        {{ $order->status === 'delivered' ? 'Completed' : ucfirst($order->status) }}
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white/20 text-white">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Customer Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h3>
                    <div class="space-y-2 text-gray-600">
                        <p><i class="fa-solid fa-user mr-2 text-gray-400"></i> {{ $order->customer_name }}</p>
                        <p><i class="fa-solid fa-phone mr-2 text-gray-400"></i> {{ $order->customer_phone }}</p>
                        <p><i class="fa-solid fa-location-dot mr-2 text-gray-400"></i> {{ $order->customer_address }}</p>
                    </div>
                </div>

                <!-- Payment Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Details</h3>
                    <div class="space-y-2 text-gray-600">
                        <p><i class="fa-solid fa-credit-card mr-2 text-gray-400"></i> {{ ucfirst($order->payment_method) }}</p>
                        <p><i class="fa-solid fa-tag mr-2 text-gray-400"></i> Order Type: {{ ucfirst($order->order_type) }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Tracking -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Tracking</h3>
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    <div class="space-y-6">
                        <div class="relative flex items-start">
                            <div class="w-8 h-8 rounded-full bg-green-500 border-4 border-white shadow flex items-center justify-center z-10">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="font-medium text-gray-900">Order Placed</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="w-8 h-8 rounded-full {{ $order->status !== 'pending' ? 'bg-green-500' : 'bg-gray-300' }} border-4 border-white shadow flex items-center justify-center z-10">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="font-medium text-gray-900">Processing</p>
                                <p class="text-sm text-gray-500">Your order is being processed</p>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} border-4 border-white shadow flex items-center justify-center z-10">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="font-medium text-gray-900">Shipped</p>
                                <p class="text-sm text-gray-500">Your order has been shipped</p>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="w-8 h-8 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} border-4 border-white shadow flex items-center justify-center z-10">
                                <i class="fa-solid fa-check text-white text-xs"></i>
                            </div>
                            <div class="ml-6">
                                <p class="font-medium text-gray-900">Delivered</p>
                                <p class="text-sm text-gray-500">Your order has been delivered</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $item->inventory->image ?? 'https://via.placeholder.com/100' }}" alt="{{ $item->inventory->name }}" class="w-20 h-20 rounded-lg border border-gray-200 object-cover">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->inventory->name }}</h4>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × Rs. {{ number_format($item->price, 2) }}</p>
                                </div>
                                <p class="font-medium text-gray-900">Rs. {{ number_format($item->total, 2) }}</p>
                            </div>
                            
                            @if($order->status === 'delivered')
                                @php
                                    $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                        ->where('inventory_id', $item->inventory_id)
                                        ->where('order_id', $order->id)
                                        ->first();
                                @endphp
                                
                                @if(!$existingReview)
                                    <!-- Review Form -->
                                    <div class="mt-4 pl-24">
                                        <div x-data="{ reviewOpen: false, selectedRating: 0 }" class="border border-gray-200 rounded-xl p-4 bg-gray-50">
                                            <button @click="reviewOpen = !reviewOpen" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium">
                                                <i class="fa-solid fa-star"></i> Write a Review
                                            </button>
                                            
                                            <div x-show="reviewOpen" x-transition class="mt-4">
                                                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                                    @csrf
                                                    <input type="hidden" name="inventory_id" value="{{ $item->inventory_id }}">
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                                        <div class="flex gap-2">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <label class="cursor-pointer">
                                                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required x-model="selectedRating">
                                                                    <i class="fa-solid fa-star text-2xl transition-colors" 
                                                                       :class="selectedRating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-400'"></i>
                                                                </label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                                                        <textarea name="comment" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Share your experience..."></textarea>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Images (Optional)</label>
                                                        <input type="file" name="images[]" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                    </div>
                                                    
                                                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                                                        Submit Review
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Existing Review -->
                                    <div class="mt-4 pl-24">
                                        <div class="border border-gray-200 rounded-xl p-4 bg-green-50">
                                            <div class="flex items-center gap-2 text-green-700 font-medium mb-2">
                                                <i class="fa-solid fa-check-circle"></i> Review Submitted
                                            </div>
                                            <div class="flex items-center gap-1 mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="text-gray-600 text-sm">{{ $existingReview->comment }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="border-t border-gray-100 pt-6">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-900">Rs. {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-t border-gray-100">
                    <span class="font-semibold text-gray-900">Total</span>
                    <span class="font-bold text-gray-900 text-lg">Rs. {{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 mt-8">
                <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="flex-1 flex items-center justify-center px-6 py-3 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors font-medium">
                    <i class="fa-solid fa-print mr-2"></i> Print Receipt
                </a>
                @if($order->status === 'delivered' && !$order->refund_requested)
                    @php
                        $daysSinceDelivery = $order->updated_at->diffInDays(now());
                        $canRefund = $daysSinceDelivery <= 7;
                    @endphp
                    @if($canRefund)
                        <button x-data="{ refundOpen: false }" class="flex-1 flex items-center justify-center px-6 py-3 bg-red-600 text-white hover:bg-red-700 rounded-xl transition-colors font-medium">
                            <i class="fa-solid fa-rotate-left mr-2"></i> Request Refund
                        </button>
                        <div x-show="refundOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Request Refund</h3>
                                <p class="text-gray-600 mb-4">If defected/size issue related than you can refund within 7 days fully money will be refunded.</p>
                                <form action="{{ route('orders.refund', $order) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Refund</label>
                                        <textarea name="refund_reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Please describe the issue..."></textarea>
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="button" @click="refundOpen = false" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Submit Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            
            @if($order->refund_requested)
                <div class="mt-6 p-4 rounded-xl {{ $order->refund_status === 'approved' ? 'bg-green-50 border border-green-200' : ($order->refund_status === 'rejected' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200') }}">
                    <div class="flex items-center gap-2 font-medium {{ $order->refund_status === 'approved' ? 'text-green-800' : ($order->refund_status === 'rejected' ? 'text-red-800' : 'text-yellow-800') }}">
                        @if($order->refund_status === 'approved')
                            <i class="fa-solid fa-check-circle"></i> Refund Approved
                        @elseif($order->refund_status === 'rejected')
                            <i class="fa-solid fa-times-circle"></i> Refund Rejected
                        @else
                            <i class="fa-solid fa-clock"></i> Refund Requested
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $order->refund_reason }}</p>
                    <p class="text-xs text-gray-500 mt-2">Requested: {{ $order->refund_requested_at->format('F j, Y, g:i a') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection