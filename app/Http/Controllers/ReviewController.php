<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Inventory;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $imagePaths[] = $path;
            }
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'inventory_id' => $validated['inventory_id'],
            'order_id' => $validated['order_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'images' => $imagePaths,
            'approved' => false,
        ]);

        return back()->with('success', 'Review submitted! It will be visible after approval.');
    }
}
