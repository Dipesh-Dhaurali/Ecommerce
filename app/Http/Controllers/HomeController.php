<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Inventory::with('category')->where('is_popular', true)->limit(8)->get();
        if($featuredProducts->isEmpty()) {
            $featuredProducts = Inventory::with('category')->limit(8)->get(); // fallback
        }
        $categories = Category::whereNotIn('name', ['Chips', 'Biscuits'])->get();
        
        $wishlistItems = [];
        if (auth()->check()) {
            $wishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())
                ->pluck('id', 'inventory_id')
                ->toArray();
        }
        
        return view('welcome', compact('featuredProducts', 'categories', 'wishlistItems'));
    }

    public function shop(Request $request)
    {
        $query = Inventory::with(['category', 'brand']);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        $products = $query->paginate(12)->withQueryString();
        
        $categories = Category::all();
        $brands = Brand::all();

        $wishlistItems = [];
        if (auth()->check()) {
            $wishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())
                ->pluck('id', 'inventory_id')
                ->toArray();
        }

        return view('shop', compact('products', 'categories', 'brands', 'wishlistItems'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|digits:10',
            'customer_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash,mobile',
            'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'items' => 'required|string', // JSON string from local storage
        ]);

        $items = json_decode($validated['items'], true);
        
        if (empty($items)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
            }
            return back()->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            // Fetch all products at once to avoid N+1 queries
            $productIds = array_column($items, 'id');
            $products = Inventory::whereIn('id', $productIds)->get()->keyBy('id');

            $subtotal = 0;
            $orderItems = [];

            foreach ($items as $item) {
                if (!isset($products[$item['id']])) {
                    throw new \Exception('Product not found: ' . $item['id']);
                }
                
                $product = $products[$item['id']];
                $subtotal += $product->price * $item['quantity'];
                
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

            // Handle payment screenshot upload
            $paymentScreenshotPath = null;
            if ($request->hasFile('payment_screenshot')) {
                $paymentScreenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
            }

            $order = Order::create([
                'user_id' => auth()->id(), 
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'order_type' => 'online',
                'status' => 'pending',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_screenshot' => $paymentScreenshotPath,
            ]);

            // Insert all order items at once
            $order->items()->createMany($orderItems);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Order placed successfully!', 'order_id' => $order->id]);
            }

            return redirect()->route('home')->with('success', 'Order placed successfully! Your order number is #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error placing order: ' . $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Error placing order: ' . $e->getMessage());
        }
    }

    public function instantSearch(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $products = Inventory::with('category')
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    public function productShow(Inventory $product)
    {
        $product->load(['reviews' => function($q) {
            $q->latest();
        }, 'reviews.user']);
        
        $relatedProducts = Inventory::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $wishlistItems = [];
        if (auth()->check()) {
            $wishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())
                ->pluck('id', 'inventory_id')
                ->toArray();
        }
        
        return view('product', compact('product', 'relatedProducts', 'wishlistItems'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        \App\Models\ContactMessage::create($validated);

        return back()->with('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    }
}
