<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Inventory::count();
        $lowStockCount = Inventory::where('stock', '<=', 5)->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');

        // Chart Data (Last 7 Days) - Single query instead of 7
        $startDate = Carbon::today()->subDays(6)->startOfDay();
        $endDate = Carbon::today()->endOfDay();
        
        $chartData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COALESCE(SUM(total), 0) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('status', '!=', 'cancelled')
        ->groupBy('date')
        ->pluck('total', 'date')
        ->toArray();

        $chartDates = [];
        $chartTotals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $chartDates[] = Carbon::today()->subDays($i)->format('D');
            $chartTotals[] = $chartData[$date] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalProducts', 'lowStockCount', 'totalOrders', 'totalRevenue', 'chartDates', 'chartTotals'
        ));
    }
}

