<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class AdminPropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::with(['user', 'images'])
            ->when($request->search, fn($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->status !== null && $request->status !== '', fn($q) => $q->where('is_active', $request->status))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(15);
 
        return view('admin.admin-properties', compact('properties'));
    }
 
    public function create()
    {
        $amenities = Amenity::all();
        return view('user.create-property', compact('amenities')); // reuse the form
    }
 
    public function store(Request $request)
    {
        // same validation as user PropertyController@store
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'type'           => 'required|in:apartment,house,villa,studio',
            'listing_type'   => 'required|in:sale,rent',
            'price'          => 'required|numeric|min:0',
            'area_sqm'       => 'required|numeric|min:1',
            'bedrooms'       => 'nullable|integer|min:0',
            'bathrooms'      => 'nullable|integer|min:0',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'country'        => 'required|string',
            'available_from' => 'required|date',
            'amenities'      => 'nullable|array',
            'amenities.*'    => 'exists:amenities,id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|max:2048',
        ]);
 
        $property = auth()->user()->properties()->create($validated);
        $property->amenities()->sync($request->amenities ?? []);
 
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $property->images()->create(['path' => $img->store('properties', 'public')]);
            }
        }
 
        return redirect()->route('admin.properties.index')->with('success', 'Property created.');
    }
 
    public function edit(Property $property)
    {
        $property->load(['images', 'amenities']);
        $amenities = Amenity::all();
        return view('user.edit-property', compact('property', 'amenities'));
    }
 
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'type'           => 'required|in:apartment,house,villa,studio',
            'listing_type'   => 'required|in:sale,rent',
            'price'          => 'required|numeric|min:0',
            'area_sqm'       => 'required|numeric|min:1',
            'bedrooms'       => 'nullable|integer|min:0',
            'bathrooms'      => 'nullable|integer|min:0',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'country'        => 'required|string',
            'available_from' => 'required|date',
            'is_active'      => 'nullable|boolean',
        ]);
 
        $validated['is_active'] = $request->boolean('is_active');
        $property->update($validated);
        $property->amenities()->sync($request->amenities ?? []);
 
        return redirect()->route('admin.properties.index')->with('success', 'Property updated.');
    }
 
    public function destroy(Property $property)
    {
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted.');
    }
}
?>