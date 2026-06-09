<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::with(['user', 'category'])
            ->when($request->search, fn($q) => $q->where('title', 'like', '%'.$request->search.'%')
                                                   ->orWhere('city', 'like', '%'.$request->search.'%'))
            ->when($request->status !== null && $request->status !== '', fn($q) => $q->where('is_available', $request->status))
            ->when($request->type, fn($q) => $q->where('property_type', $request->type))
            ->latest()
            ->paginate(15);

        return view('admin.admin-properties', compact('properties'));
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
            'image'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('properties', 'public');
        }

        $validated['user_id'] = auth()->id();
        Property::create($validated);

        return redirect()->route('admin.properties.index')->with('success', 'Property created.');
    }

    public function edit(Property $property)
    {
        $categories = Category::all();
        return view('user.edit-property', compact('property', 'categories'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'category_id'    => 'required|exists:categories,id',
            'property_type'  => 'required|in:apartment,house,studio,villa',
            'listing_type'   => 'required|in:rent,sale',
            'price'          => 'required|integer|min:0',
            'sq_meters'      => 'required|integer|min:1',
            'bedrooms'       => 'nullable|integer|min:0',
            'bathrooms'      => 'nullable|integer|min:0',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'available_from' => 'required|date',
            'is_available'   => 'nullable|boolean',
            'image'          => 'nullable|image|max:2048',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($property->image_path) Storage::disk('public')->delete($property->image_path);
            $validated['image_path'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($validated);

        return redirect()->route('admin.properties.index')->with('success', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        if ($property->image_path) Storage::disk('public')->delete($property->image_path);
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted.');
    }
}
