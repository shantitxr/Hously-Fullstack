<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class WishlistApiController extends Controller
{
    // GET /api/wishlist — owner only
    public function index(Request $request)
    {
        $properties = $request->user()
            ->wishlist()
            ->with('category')
            ->get();

        return response()->json($properties);
    }

    // POST /api/wishlist/{id} — toggle add/remove
    public function toggle(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $user     = $request->user();

        if ($user->wishlist()->where('properties.id', $id)->exists()) {
            $user->wishlist()->detach($id);
            $wishlisted = false;
        } else {
            $user->wishlist()->attach($id, ['added_at' => now()]);
            $wishlisted = true;
        }

        return response()->json([
            'wishlisted'  => $wishlisted,
            'property_id' => (int) $id,
        ]);
    }
}