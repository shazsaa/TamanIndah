<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product.category')->latest()->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $user = auth()->user();
        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            Wishlist::create(['user_id' => $user->id, 'product_id' => $request->product_id]);
            $saved = true;
        }

        return response()->json(['saved' => $saved]);
    }
}
