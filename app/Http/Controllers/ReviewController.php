<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Inventory;

class ReviewController extends Controller
{
    public function store(Request $request, Inventory $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'inventory_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false,
        ]);

        return back()->with('success', 'Review submitted! It will be visible after approval.');
    }
}
