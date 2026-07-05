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
}
