<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Inventory::with(['category', 'brand'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(1000, 9999);
        $validated['sku'] = strtoupper(Str::random(6));

        Inventory::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }
}
