<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyApiController extends Controller
{
    // GET /api/properties — public, with optional search/filter
    public function index(Request $request)
    {
        $properties = Property::with(['user', 'category'])
            ->where('is_available', true)
            ->when($request->search, fn($q) =>
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('city', 'like', "%{$request->search}%"))
            ->when($request->type, fn($q) =>
                $q->where('property_type', $request->type))
            ->when($request->listing_type, fn($q) =>
                $q->where('listing_type', $request->listing_type))
            ->latest()
            ->paginate(12);

        return response()->json($properties);
    }

    // GET /api/properties/{id} — public
    public function show($id)
    {
        $property = Property::with(['user', 'category', 'inquiries.sender'])
            ->findOrFail($id);

        $inWishlist = auth('sanctum')->check()
            ? auth('sanctum')->user()->wishlist()->where('property_id', $id)->exists()
            : false;

        return response()->json([...$property->toArray(), 'in_wishlist' => $inWishlist]);
    }

    // POST /api/properties — authenticated
    public function store(Request $request)
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
            'has_pool'       => 'nullable',
            'has_gym'        => 'nullable',
            'has_parking'    => 'nullable',
            'image'          => 'nullable|image|max:2048',
        ]);

        $validated['has_pool']    = (bool) ($request->has_pool ?? false);
        $validated['has_gym']     = (bool) ($request->has_gym ?? false);
        $validated['has_parking'] = (bool) ($request->has_parking ?? false);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('properties', 'public');
        }
        unset($validated['image']);

        $property = $request->user()->properties()->create($validated);

        return response()->json($property->load('category'), 201);
    }

    // PUT /api/properties/{id} — owner or admin
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        if ($request->user()->role !== 'admin') {
            abort_if($property->user_id !== $request->user()->id, 403);
        }

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
            'has_pool'       => 'nullable',
            'has_gym'        => 'nullable',
            'has_parking'    => 'nullable',
            'image'          => 'nullable|image|max:2048',
        ]);

        $validated['has_pool']    = (bool) ($request->has_pool ?? false);
        $validated['has_gym']     = (bool) ($request->has_gym ?? false);
        $validated['has_parking'] = (bool) ($request->has_parking ?? false);

        if ($request->hasFile('image')) {
            if ($property->image_path) {
                Storage::disk('public')->delete($property->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('properties', 'public');
        }
        unset($validated['image']);

        $property->update($validated);

        return response()->json($property->fresh('category'));
    }

    // DELETE /api/properties/{id} — owner or admin
    public function destroy(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        if ($request->user()->role !== 'admin') {
            abort_if($property->user_id !== $request->user()->id, 403);
        }

        if ($property->image_path) {
            Storage::disk('public')->delete($property->image_path);
        }
        $property->delete();

        return response()->json(['message' => 'Property deleted']);
    }
}