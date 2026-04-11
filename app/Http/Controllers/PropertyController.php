<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function show(Property $property)
    {
        $property->load(['user', 'category', 'inquiries']);
        return view('property-detail', compact('property'));
    }
}
