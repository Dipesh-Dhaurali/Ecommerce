@extends('layouts.admin')

@section('title', 'Sales Reports')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Sales Reports</h2>
            <p class="text-sm text-gray-500">View and export your store's sales data</p>
        </div>
        
        <a href="{{ route('admin.reports.export', request()->all()) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-200 flex items-center gap-2">
            <i class="fa-solid fa-file-excel"></i> Export to Excel
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Sales (Filtered)</p>
                <h3 class="text-2xl font-bold text-gray-800">Rs. {{ number_format($totalSales, 2) }}</h3>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Orders (Filtered)</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</h3>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                @csrf
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm">
                        Filter
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Clear
                    </a>
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-medium">Order ID</th>
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium">Customer</th>
                        <th class="px-6 py-4 font-medium">Type/Payment</th>
                        <th class="px-6 py-4 font-medium">Total</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $order->order_type == 'online' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                            <br>
                            <span class="text-xs text-gray-500 mt-1 inline-block">{{ ucfirst($order->payment_method) }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium">Rs. {{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-4">
                            @if($order->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Shipped</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Delivered</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No orders found for the selected period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
            {{ $orders->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
