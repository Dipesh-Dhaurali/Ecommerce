<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('admin.pos.index');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $products = Inventory::where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->limit(20)
            ->get()
            ->map(function($product) {
                // Handle both external URLs and local storage paths
                if ($product->image && !str_starts_with($product->image, 'http')) {
                    $product->image = asset('storage/' . $product->image);
                }
                return $product;
            });
            
        return response()->json($products);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Fetch all products at once to avoid N+1 queries
            $productIds = array_column($validated['items'], 'id');
            $products = Inventory::whereIn('id', $productIds)->get()->keyBy('id');

            $subtotal = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = $products[$item['id']];
                $subtotal += $product->price * $item['quantity'];
                
                // Optional: decrease stock here
                if ($product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                }

                $orderItems[] = [
                    'inventory_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ];
            }

            $order = Order::create([
                'user_id' => auth()->id(), // Admin processing the order
                'customer_name' => $validated['customer_name'] ?? 'Walk-in Customer',
                'customer_phone' => $validated['customer_phone'] ?? null,
                'order_type' => 'counter',
                'status' => 'delivered',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'payment_status' => 'paid',
                'payment_method' => $validated['payment_method'],
            ]);

            // Insert all order items at once
            $order->items()->createMany($orderItems);

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Sale completed successfully!',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
