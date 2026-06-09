<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPropertyApiController extends Controller
{
    // GET /api/admin/properties
    public function index(Request $request)
    {
        $properties = Property::with(['user:id,name', 'category'])
            ->when($request->search, fn($q) =>
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('city', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return response()->json($properties);
    }

    // PUT /api/admin/properties/{id}
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'category_id'    => 'required|exists:categories,id',
            'property_type'  => 'required|in:apartment,house,studio,villa',
            'listing_type'   => 'required|in:rent,sale',
            'price'          => 'required|integer|min:0',
            'sq_meters'      => 'required|integer|min:1',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'available_from' => 'required|date',
            'is_available'   => 'boolean',
        ]);

        $property->update($validated);

        return response()->json($property->fresh('category'));
    }

    // DELETE /api/admin/properties/{id}
    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        if ($property->image_path) {
            Storage::disk('public')->delete($property->image_path);
        }

        $property->delete();

        return response()->json(['message' => 'Property deleted.']);
    }
}