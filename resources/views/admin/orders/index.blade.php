@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-semibold text-gray-800">All Orders</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-medium">Order ID</th>
                        <th class="px-6 py-4 font-medium">Customer</th>
                        <th class="px-6 py-4 font-medium">Type</th>
                        <th class="px-6 py-4 font-medium">Total</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Payment</th>
                        <th class="px-6 py-4 font-medium text-right">Date</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-indigo-600">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->order_type === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rs. {{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-blue-100 text-blue-800')) 
                            }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' 
                            }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ ucfirst($order->payment_method) }}</p>
                        </td>
                        <td class="px-6 py-4 text-right text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors mr-3">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="text-green-600 hover:text-green-800 transition-colors">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fa-solid fa-receipt text-4xl mb-3 text-gray-300"></i>
                            <p>No orders found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection