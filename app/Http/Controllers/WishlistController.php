<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('inventory')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to add to wishlist'], 401);
        }

        $validated = $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        // Check if already in wishlist
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('inventory_id', $validated['inventory_id'])
            ->first();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Item already in wishlist'], 400);
        }

        $wishlist = Wishlist::create([
            'user_id' => Auth::id(),
            'inventory_id' => $validated['inventory_id'],
        ]);

        return response()->json(['success' => true, 'message' => 'Added to wishlist', 'wishlist_id' => $wishlist->id]);
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $wishlist->delete();
        return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
    }
}
