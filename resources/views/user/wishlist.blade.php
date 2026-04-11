
@extends('layouts.dashboard')

@section('title', 'My Wishlist')
@section('page-title', 'My Wishlist')

@section('content')
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($properties as $property)
      <div class="card bg-white shadow-md rounded-2xl overflow-hidden">
        <figure class="relative">
          @if($property->images->isNotEmpty())
            <img src="{{ Storage::url($property->images->first()->path) }}"
                 alt="{{ $property->title }}" class="w-full h-48 object-cover" />
          @else
            <div class="w-full h-48 bg-accent flex items-center justify-center">
              <span class="text-primary">No image</span>
            </div>
          @endif
          <div class="absolute top-4 left-4">
            <span class="badge bg-primary text-white border-none px-3 py-2">
              For {{ ucfirst($property->listing_type) }}
            </span>
          </div>
          {{-- Remove from wishlist heart button --}}
          <form method="POST" action="{{ route('wishlist.toggle', $property) }}"
                class="absolute top-4 right-4">
            @csrf
            <button type="submit"
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors">
              <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </form>
        </figure>
        <div class="card-body p-5">
          <h3 class="card-title text-dark text-lg">{{ $property->title }}</h3>
          <p class="text-gray-500 text-sm">{{ $property->city }}, {{ $property->country }}</p>
          <div class="flex items-center gap-4 text-gray-600 text-sm mt-2">
            <span>{{ $property->bedrooms }} Beds</span>
            <span>•</span>
            <span>{{ $property->bathrooms }} Baths</span>
            <span>•</span>
            <span>{{ $property->area_sqm }} m²</span>
          </div>
          <div class="flex items-center justify-between mt-4 pt-4 border-t border-accent">
            <span class="text-xl font-bold text-primary">
              €{{ number_format($property->price) }}{{ $property->listing_type === 'rent' ? '/month' : '' }}
            </span>
            <div class="flex gap-2">
              <a href="{{ route('properties.show', $property) }}"
                 class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View</a>
              <form method="POST" action="{{ route('wishlist.toggle', $property) }}">
                @csrf
                <button type="submit"
                        class="btn btn-sm bg-red-100 hover:bg-red-200 text-red-600 border-none rounded-lg">Remove</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-3 text-center py-16 text-gray-500 bg-white rounded-2xl shadow-md">
        <p class="text-lg mb-4">Your wishlist is empty.</p>
        <a href="{{ route('home') }}" class="btn bg-primary text-white border-none rounded-xl">Browse Properties</a>
      </div>
    @endforelse
  </div>
@endsection
