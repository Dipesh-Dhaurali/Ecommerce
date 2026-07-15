<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with('items');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $totalSales = $query->sum('total');
        $totalOrders = $query->count();

        return view('admin.reports.index', compact('orders', 'totalSales', 'totalOrders'));
    }

    public function export(Request $request)
    {
        $fileName = 'sales_report_' . date('Y_m_d_His') . '.xlsx';
        return Excel::download(new SalesExport($request->start_date, $request->end_date), $fileName);
    }
}
