@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Stat Card: Total Products -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-2xl">
            <i class="fa-solid fa-box"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Products</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</h3>
        </div>
    </div>

    <!-- Stat Card: Total Orders -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-2xl">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Orders</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</h3>
        </div>
    </div>

    <!-- Stat Card: Revenue -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-2xl">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Revenue</p>
            <h3 class="text-2xl font-bold text-gray-800">Rs. {{ number_format($totalRevenue ?? 0, 2) }}</h3>
        </div>
    </div>

    <!-- Stat Card: Low Stock -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-red-50 flex items-center justify-center text-red-600 text-2xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Low Stock</p>
            <h3 class="text-2xl font-bold text-red-600">{{ $lowStockCount ?? 0 }} items</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Sales - Last 7 Days</h3>
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <span class="font-medium text-gray-700 group-hover:text-green-700">Add New Product</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-green-500"></i>
            </a>
            
            <a href="{{ route('admin.pos.index') }}" class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-colors group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                    <span class="font-medium text-gray-700 group-hover:text-emerald-700">Open POS Counter</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-emerald-500"></i>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Prepare data from backend
        const dates = {!! json_encode($chartDates ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!};
        const totals = {!! json_encode($chartTotals ?? [1200, 1900, 800, 1500, 2200, 3100, 2800]) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Revenue (Rs.)',
                    data: totals,
                    backgroundColor: 'rgba(79, 70, 229, 0.8)', // Indigo-600
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rs. ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f3f4f6' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
