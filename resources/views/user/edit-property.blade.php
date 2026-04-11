
@extends('layouts.dashboard')

@section('title', 'Edit Property')
@section('page-title', 'Edit Property')

@section('content')
  <form method="POST" action="{{ route('user.properties.update', $property) }}"
        enctype="multipart/form-data" class="max-w-4xl">
    @csrf @method('PUT')

    @if($errors->any())
      <div class="alert alert-error mb-6">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Basic Info --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Basic Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-control md:col-span-2">
          <label class="label"><span class="label-text text-dark font-medium">Title *</span></label>
          <input type="text" name="title" value="{{ old('title', $property->title) }}"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control md:col-span-2">
          <label class="label"><span class="label-text text-dark font-medium">Description *</span></label>
          <textarea name="description" rows="4"
                    class="textarea textarea-bordered bg-background border-accent focus:border-primary rounded-xl w-full">{{ old('description', $property->description) }}</textarea>
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Property Type *</span></label>
          <select name="type" class="select select-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required>
            @foreach(['apartment','house','villa','studio'] as $type)
              <option value="{{ $type }}" {{ old('type', $property->type) === $type ? 'selected' : '' }}>
                {{ ucfirst($type) }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Listing Type *</span></label>
          <div class="flex gap-6 mt-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="listing_type" value="rent" class="radio radio-primary"
                     {{ old('listing_type', $property->listing_type) === 'rent' ? 'checked' : '' }} />
              <span>For Rent</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="listing_type" value="sale" class="radio radio-primary"
                     {{ old('listing_type', $property->listing_type) === 'sale' ? 'checked' : '' }} />
              <span>For Sale</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    {{-- Details --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Property Details</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Price (€) *</span></label>
          <input type="number" name="price" value="{{ old('price', $property->price) }}" min="0"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Area (m²) *</span></label>
          <input type="number" name="area_sqm" value="{{ old('area_sqm', $property->area_sqm) }}" min="1"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Available From *</span></label>
          <input type="date" name="available_from" value="{{ old('available_from', $property->available_from?->format('Y-m-d')) }}"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Bedrooms</span></label>
          <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Bathrooms</span></label>
          <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
        </div>
        <div class="form-control flex-row items-center gap-3 mt-8">
          <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-primary"
                 {{ old('is_active', $property->is_active) ? 'checked' : '' }} />
          <label class="label-text text-dark font-medium">Active listing</label>
        </div>
      </div>
    </div>

    {{-- Location --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Location</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-control md:col-span-2">
          <label class="label"><span class="label-text text-dark font-medium">Address *</span></label>
          <input type="text" name="address" value="{{ old('address', $property->address) }}"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">City *</span></label>
          <input type="text" name="city" value="{{ old('city', $property->city) }}"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Country *</span></label>
          <input type="text" name="country" value="{{ old('country', $property->country) }}"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
      </div>
    </div>

    {{-- Amenities --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Amenities</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($amenities as $amenity)
          <label class="flex items-center gap-3 p-3 bg-background rounded-xl cursor-pointer hover:bg-accent transition-colors">
            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                   class="checkbox checkbox-primary"
                   {{ in_array($amenity->id, old('amenities', $property->amenities->pluck('id')->toArray())) ? 'checked' : '' }} />
            <span class="text-dark">{{ $amenity->name }}</span>
          </label>
        @endforeach
      </div>
    </div>

    {{-- Existing Images --}}
    @if($property->images->isNotEmpty())
      <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
        <h2 class="text-xl font-semibold text-dark mb-4">Current Images</h2>
        <div class="flex flex-wrap gap-3">
          @foreach($property->images as $image)
            <div class="relative">
              <img src="{{ Storage::url($image->path) }}" class="w-24 h-20 object-cover rounded-lg" />
              <form method="POST" action="{{ route('user.properties.images.destroy', $image) }}"
                    onsubmit="return confirm('Remove this image?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs flex items-center justify-center">✕</button>
              </form>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- New Images --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Add More Images</h2>
      <input type="file" name="images[]" multiple accept="image/*"
             class="file-input file-input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
    </div>

    {{-- Submit --}}
    <div class="flex gap-4">
      <button type="submit" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl px-8">
        Save Changes
      </button>
      <a href="{{ route('user.properties.index') }}" class="btn bg-accent hover:bg-secondary text-dark border-none rounded-xl px-8">
        Cancel
      </a>
    </div>
  </form>
@endsection
