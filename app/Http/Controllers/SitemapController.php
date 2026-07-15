<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Brand;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Inventory::all();
        $categories = Category::all();
        $brands = Brand::all();

        return response()->view('sitemap.index', compact('products', 'categories', 'brands'))->header('Content-Type', 'text/xml');
    }
}
