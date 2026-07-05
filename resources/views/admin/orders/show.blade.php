@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h2>
                <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y g:i A') }}</p>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Update Status Form -->
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        Update Status
                    </button>
                </form>
                
                <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition-colors">
                    <i class="fa-solid fa-print mr-2"></i> Print Receipt
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-user text-gray-400 w-5 mt-0.5"></i>
                    <div>
                        <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-phone text-gray-400 w-5 mt-0.5"></i>
                    <div>
                        <p class="text-gray-700">{{ $order->customer_phone }}</p>
                    </div>
                </div>
                @if($order->customer_address)
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-location-dot text-gray-400 w-5 mt-0.5"></i>
                    <div>
                        <p class="text-gray-700">{{ $order->customer_address }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Subtotal</p>
                    <p class="font-medium text-gray-900">Rs. {{ number_format($order->subtotal, 2) }}</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Order Type</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->order_type === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ ucfirst($order->order_type) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Payment Method</p>
                    <p class="font-medium text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-gray-600">Payment Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                        $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' 
                    }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <hr class="my-4 border-gray-100">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-bold text-gray-900">Total</p>
                    <p class="text-lg font-bold text-indigo-600">Rs. {{ number_format($order->total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold {{ 
                    $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                    ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                    ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                    'bg-blue-100 text-blue-800')) 
                }}">
                    <i class="fa-solid {{ 
                        $order->status === 'delivered' ? 'fa-check-circle' : 
                        ($order->status === 'cancelled' ? 'fa-times-circle' : 
                        ($order->status === 'processing' ? 'fa-spinner' : 
                        'fa-clock')) 
                    }} mr-2"></i>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-semibold text-gray-800">Order Items</h3>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-16 h-16 bg-white rounded-lg border border-gray-100 flex items-center justify-center overflow-hidden">
                        <img src="{{ $item->inventory->image ?? 'https://via.placeholder.com/64' }}" alt="{{ $item->inventory->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $item->inventory->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rs. {{ number_format($item->price, 2) }}</p>
                    </div>
                    <p class="font-semibold text-gray-900">Rs. {{ number_format($item->total, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection