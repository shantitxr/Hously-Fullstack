<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function show(Property $property)
    {
        $property->load(['user', 'category', 'inquiries.sender']);

        $inWishlist = auth()->check()
            ? auth()->user()->wishlist()->where('property_id', $property->id)->exists()
            : false;

        return view('property-detail', compact('property', 'inWishlist'));
    }
}