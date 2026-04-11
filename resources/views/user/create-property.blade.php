
@extends('layouts.dashboard')

@section('title', 'Create Property')
@section('page-title', 'Create New Property')

@section('content')
  <form method="POST" action="{{ route('user.properties.store') }}"
        enctype="multipart/form-data" class="max-w-4xl">
    @csrf

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
          <input type="text" name="title" value="{{ old('title') }}"
                 placeholder="e.g., Modern Apartment in Budapest"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control md:col-span-2">
          <label class="label"><span class="label-text text-dark font-medium">Description *</span></label>
          <textarea name="description" rows="4"
                    class="textarea textarea-bordered bg-background border-accent focus:border-primary rounded-xl w-full"
                    placeholder="Describe your property in detail...">{{ old('description') }}</textarea>
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Property Type *</span></label>
          <select name="type" class="select select-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required>
            <option disabled {{ old('type') ? '' : 'selected' }}>Select type</option>
            <option value="apartment" {{ old('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
            <option value="house"     {{ old('type') === 'house'     ? 'selected' : '' }}>House</option>
            <option value="villa"     {{ old('type') === 'villa'     ? 'selected' : '' }}>Villa</option>
            <option value="studio"    {{ old('type') === 'studio'    ? 'selected' : '' }}>Studio</option>
          </select>
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Listing Type *</span></label>
          <div class="flex gap-6 mt-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="listing_type" value="rent" class="radio radio-primary"
                     {{ old('listing_type', 'rent') === 'rent' ? 'checked' : '' }} />
              <span>For Rent</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="listing_type" value="sale" class="radio radio-primary"
                     {{ old('listing_type') === 'sale' ? 'checked' : '' }} />
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
          <input type="number" name="price" value="{{ old('price') }}" min="0"
                 placeholder="e.g., 850"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Area (m²) *</span></label>
          <input type="number" name="area_sqm" value="{{ old('area_sqm') }}" min="1"
                 placeholder="e.g., 65"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Available From *</span></label>
          <input type="date" name="available_from" value="{{ old('available_from') }}"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Bedrooms</span></label>
          <input type="number" name="bedrooms" value="{{ old('bedrooms', 1) }}" min="0"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Bathrooms</span></label>
          <input type="number" name="bathrooms" value="{{ old('bathrooms', 1) }}" min="0"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
        </div>
      </div>
    </div>

    {{-- Location --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Location</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-control md:col-span-2">
          <label class="label"><span class="label-text text-dark font-medium">Address *</span></label>
          <input type="text" name="address" value="{{ old('address') }}"
                 placeholder="e.g., Váci utca 15"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">City *</span></label>
          <input type="text" name="city" value="{{ old('city') }}"
                 placeholder="e.g., Budapest"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
        <div class="form-control">
          <label class="label"><span class="label-text text-dark font-medium">Country *</span></label>
          <input type="text" name="country" value="{{ old('country') }}"
                 placeholder="e.g., Hungary"
                 class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" required />
        </div>
      </div>
    </div>

    {{-- Amenities (checkbox list) --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Amenities</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($amenities as $amenity)
          <label class="flex items-center gap-3 p-3 bg-background rounded-xl cursor-pointer hover:bg-accent transition-colors">
            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                   class="checkbox checkbox-primary"
                   {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }} />
            <span class="text-dark">{{ $amenity->name }}</span>
          </label>
        @endforeach
      </div>
    </div>

    {{-- Images (file upload) --}}
    <div class="bg-white rounded-2xl p-6 shadow-md mb-6">
      <h2 class="text-xl font-semibold text-dark mb-6">Property Images</h2>
      <div class="form-control">
        <label class="label"><span class="label-text text-dark font-medium">Upload Images (max 10)</span></label>
        <input type="file" name="images[]" multiple accept="image/*"
               class="file-input file-input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
        <label class="label"><span class="label-text-alt text-gray-500">JPEG, PNG, max 2MB each</span></label>
      </div>
    </div>

    {{-- Submit --}}
    <div class="flex gap-4">
      <button type="submit" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl px-8">
        Create Property
      </button>
      <a href="{{ route('user.properties.index') }}" class="btn bg-accent hover:bg-secondary text-dark border-none rounded-xl px-8">
        Cancel
      </a>
    </div>
  </form>
@endsection
