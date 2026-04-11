<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = auth()->user()->properties()->with('category')->latest()->paginate(10);
        return view('user.my-properties', compact('properties'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.create-property', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category_id'     => 'required|exists:categories,id',
            'property_type'   => 'required|in:apartment,house,studio,villa',
            'listing_type'    => 'required|in:rent,sale',
            'price'           => 'required|integer|min:0',
            'sq_meters'       => 'required|integer|min:1',
            'bedrooms'        => 'nullable|integer|min:0',
            'bathrooms'       => 'nullable|integer|min:0',
            'address'         => 'required|string',
            'city'            => 'required|string',
            'available_from'  => 'required|date',
            'has_pool'        => 'nullable|boolean',
            'has_gym'         => 'nullable|boolean',
            'has_parking'     => 'nullable|boolean',
            'image'           => 'nullable|image|max:2048',
        ]);

        $validated['has_pool']    = $request->boolean('has_pool');
        $validated['has_gym']     = $request->boolean('has_gym');
        $validated['has_parking'] = $request->boolean('has_parking');

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('properties', 'public');
        }

        // Remove the 'image' key — the DB column is 'image_path', not 'image'
        unset($validated['image']);

        auth()->user()->properties()->create($validated);

        return redirect()->route('user.properties.index')->with('success', 'Property created!');
    }

    public function edit(Property $property)
    {
         abort_if($property->user_id !== auth()->id(), 403);
        $categories = Category::all();
        return view('user.edit-property', compact('property', 'categories'));
    }

    public function update(Request $request, Property $property)
    {
        abort_if($property->user_id !== auth()->id(), 403);
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category_id'     => 'required|exists:categories,id',
            'property_type'   => 'required|in:apartment,house,studio,villa',
            'listing_type'    => 'required|in:rent,sale',
            'price'           => 'required|integer|min:0',
            'sq_meters'       => 'required|integer|min:1',
            'bedrooms'        => 'nullable|integer|min:0',
            'bathrooms'       => 'nullable|integer|min:0',
            'address'         => 'required|string',
            'city'            => 'required|string',
            'available_from'  => 'required|date',
            'has_pool'        => 'nullable|boolean',
            'has_gym'         => 'nullable|boolean',
            'has_parking'     => 'nullable|boolean',
            'image'           => 'nullable|image|max:2048',
        ]);

        $validated['has_pool']    = $request->boolean('has_pool');
        $validated['has_gym']     = $request->boolean('has_gym');
        $validated['has_parking'] = $request->boolean('has_parking');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($property->image_path) {
                Storage::disk('public')->delete($property->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('properties', 'public');
        }

        // Remove the 'image' key — the DB column is 'image_path', not 'image'
        unset($validated['image']);

        $property->update($validated);

        return redirect()->route('user.properties.index')->with('success', 'Property updated!');
    }

    public function destroy(Property $property)
    {
        abort_if($property->user_id !== auth()->id(), 403);
        if ($property->image_path) {
            Storage::disk('public')->delete($property->image_path);
        }
        $property->delete();
        return redirect()->route('user.properties.index')->with('success', 'Property deleted!');
    }
}