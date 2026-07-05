@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center">
            <i class="fa-solid fa-receipt text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h2>
            <p class="text-gray-500 mb-4">You haven't placed any orders yet.</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700">Start Shopping</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-400">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="text-lg font-bold text-gray-900">Rs. {{ number_format($order->total, 2) }}</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4">
                                    <img src="{{ $item->inventory->image ?? 'https://via.placeholder.com/100' }}" alt="{{ $item->inventory->name }}" class="w-16 h-16 rounded-lg border border-gray-200 object-cover">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $item->inventory->name }}</h4>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="font-medium text-gray-900">Rs. {{ number_format($item->total, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                            <a href="{{ route('orders.show', $order) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                View Details
                            </a>
                            <a href="{{ route('orders.receipt', $order) }}" target="_blank" class="flex-1 text-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-xl hover:bg-indigo-50 transition-colors">
                                <i class="fa-solid fa-print mr-1"></i> Receipt
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

