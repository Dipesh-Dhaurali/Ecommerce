<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'items.inventory'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'items.inventory']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,sales_return'
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated!');
    }

    public function updateRefundStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'refund_status' => 'required|in:pending,approved,rejected'
        ]);

        $order->update(['refund_status' => $validated['refund_status']]);

        return back()->with('success', 'Refund status updated!');
    }

    public function receipt(Order $order)
    {
        $order->load(['items', 'items.inventory']);
        return view('receipts.show', compact('order'));
    }
}