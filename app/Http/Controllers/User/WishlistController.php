<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;

class WishlistController extends Controller
{
    public function index()
    {
        $properties = auth()->user()->wishlist()->with('category')->get();
        return view('user.wishlist', compact('properties'));
    }

    public function toggle(Property $property)
    {
        $user = auth()->user();
        // If already wishlisted, remove it; otherwise add it
        if ($user->wishlist()->where('property_id', $property->id)->exists()) {
            $user->wishlist()->detach($property->id);
        } else {
            $user->wishlist()->attach($property->id, ['added_at' => now()]);
        }
        return back();
    }
}
