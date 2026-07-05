<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items', 'items.inventory'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with(['items', 'items.inventory'])
            ->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function receipt($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with(['items', 'items.inventory'])
            ->findOrFail($id);
        return view('receipts.show', compact('order'));
    }

    public function requestRefund(Request $request, $id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        
        if ($order->status !== 'delivered') {
            return back()->with('error', 'Refunds can only be requested for delivered orders.');
        }

        if ($order->refund_requested) {
            return back()->with('error', 'Refund has already been requested for this order.');
        }

        $daysSinceDelivery = $order->updated_at->diffInDays(now());
        if ($daysSinceDelivery > 7) {
            return back()->with('error', 'Refund requests can only be made within 7 days of delivery.');
        }

        $validated = $request->validate([
            'refund_reason' => 'required|string|max:1000',
        ]);

        $order->update([
            'refund_requested' => true,
            'refund_reason' => $validated['refund_reason'],
            'refund_requested_at' => now(),
            'refund_status' => 'pending',
        ]);

        return back()->with('success', 'Refund request submitted successfully.');
    }
}
