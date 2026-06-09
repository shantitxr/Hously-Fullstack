@extends('layouts.dashboard')

@section('title', 'My Properties')
@section('page-title', 'My Properties')

@section('content')
  @if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
  @endif

  <div class="flex justify-end mb-6">
    @if(auth()->user()->role !== 'admin')
      <a href="{{ route('user.properties.create') }}" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl">
        + Add New Property
      </a>
    @endif
  </div>

  {{-- Filter Bar --}}
  <div class="bg-white rounded-2xl p-4 shadow-md mb-6">
    <form method="GET" action="{{ route('user.properties.index') }}" class="flex flex-wrap items-center gap-4">
      <div class="form-control flex-1 min-w-[200px]">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search properties..."
               class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
      </div>
      <select name="listing_type" class="select select-bordered bg-background border-accent focus:border-primary rounded-xl">
        <option value="">All types</option>
        <option value="rent" {{ request('listing_type') === 'rent' ? 'selected' : '' }}>For Rent</option>
        <option value="sale" {{ request('listing_type') === 'sale' ? 'selected' : '' }}>For Sale</option>
      </select>
      <button type="submit" class="btn bg-primary text-white border-none rounded-xl">Filter</button>
    </form>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($properties as $property)
      <div class="card bg-white shadow-md rounded-2xl overflow-hidden">
        <figure class="relative">
          @if($property->image_path)
            <img src="{{ Storage::url($property->image_path) }}"
                 alt="{{ $property->title }}" class="w-full h-48 object-cover" />
          @else
            <div class="w-full h-48 bg-accent flex items-center justify-center">
              <span class="text-primary">No image</span>
            </div>
          @endif
          <div class="absolute top-4 left-4">
            <span class="badge {{ $property->is_available ? 'bg-green-500' : 'bg-yellow-500' }} text-white border-none px-3 py-2">
              {{ $property->is_available ? 'Active' : 'Inactive' }}
            </span>
          </div>
          <div class="absolute top-4 right-4">
            <span class="badge bg-primary text-white border-none px-3 py-2">
              For {{ ucfirst($property->listing_type) }}
            </span>
          </div>
        </figure>
        <div class="card-body p-5">
          <h3 class="card-title text-dark text-lg">{{ $property->title }}</h3>
          <p class="text-gray-500 text-sm">{{ $property->city }}</p>
          <p class="text-xl font-bold text-primary mt-2">
            €{{ number_format($property->price) }}{{ $property->listing_type === 'rent' ? '/month' : '' }}
          </p>
          <div class="flex items-center gap-2 text-gray-500 text-sm mt-2">
            <span>{{ $property->bedrooms }} Beds</span><span>•</span>
            <span>{{ $property->bathrooms }} Bath</span><span>•</span>
            <span>{{ $property->sq_meters }} m²</span>
          </div>
          <div class="flex gap-2 mt-4 pt-4 border-t border-accent">
            <a href="{{ route('properties.show', $property) }}"
               class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg flex-1">View</a>
            <a href="{{ route('user.properties.edit', $property) }}"
               class="btn btn-sm bg-primary hover:bg-secondary text-white border-none rounded-lg flex-1">Edit</a>
            <form method="POST" action="{{ route('user.properties.destroy', $property) }}"
                  onsubmit="return confirm('Delete this property?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm bg-red-100 hover:bg-red-200 text-red-600 border-none rounded-lg">✕</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-3 text-center py-16 text-gray-500">
        <p class="text-lg mb-4">You haven't listed any properties yet.</p>
        @if(auth()->user()->role !== 'admin')
          <a href="{{ route('user.properties.create') }}" class="btn bg-primary text-white border-none rounded-xl">Add Your First Property</a>
        @endif
      </div>
    @endforelse
  </div>

  <div class="mt-8">{{ $properties->links() }}</div>
@endsection