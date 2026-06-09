@extends('layouts.app')

@section('title', $property->title)

@section('content')
  {{-- Breadcrumb --}}
  <div class="max-w-[1280px] mx-auto px-6 py-4">
    <div class="text-sm breadcrumbs text-gray-500">
      <ul>
        <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
        <li><a href="{{ route('home') }}#properties" class="hover:text-primary">Properties</a></li>
        <li class="text-dark">{{ $property->title }}</li>
      </ul>
    </div>
  </div>

  <main class="max-w-[1280px] mx-auto px-6 pb-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      {{-- Left: Details --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- Image --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-md">
          <div class="relative">
            @if($property->image_path)
              <img src="{{ Storage::url($property->image_path) }}"
                   alt="{{ $property->title }}" class="w-full h-[400px] object-cover" />
            @else
              <div class="w-full h-[400px] bg-accent flex items-center justify-center">
                <span class="text-primary text-xl">No image available</span>
              </div>
            @endif
            <div class="absolute top-4 left-4">
              <span class="badge bg-primary text-white border-none px-4 py-3 text-sm">
                For {{ ucfirst($property->listing_type) }}
              </span>
            </div>
            @auth
              <form method="POST" action="{{ route('wishlist.toggle', $property) }}"
                    class="absolute top-4 right-4">
                @csrf
                <button type="submit"
                        class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-lg">
                  <svg class="w-6 h-6 {{ $inWishlist ? 'text-red-500 fill-current' : 'text-gray-600' }}"
                       stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                  </svg>
                </button>
              </form>
            @endauth
          </div>
        </div>

        {{-- Info --}}
        <div class="bg-white rounded-2xl p-6 shadow-md">
          <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-dark mb-2">{{ $property->title }}</h1>
              <p class="text-gray-500">{{ $property->address }}, {{ $property->city }}</p>
            </div>
            <div class="text-right">
              <span class="text-3xl font-bold text-primary">€{{ number_format($property->price) }}</span>
              @if($property->listing_type === 'rent')
                <span class="text-gray-500">/month</span>
              @endif
            </div>
          </div>

          {{-- Features - NOTE: uses sq_meters and property_type (actual DB column names) --}}
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-background rounded-xl mb-6">
            <div class="text-center">
              <p class="font-semibold text-dark">{{ $property->sq_meters }} m²</p>
              <p class="text-sm text-gray-500">Area</p>
            </div>
            <div class="text-center">
              <p class="font-semibold text-dark">{{ $property->bedrooms }} Beds</p>
              <p class="text-sm text-gray-500">Bedrooms</p>
            </div>
            <div class="text-center">
              <p class="font-semibold text-dark">{{ $property->bathrooms }} Bath</p>
              <p class="text-sm text-gray-500">Bathrooms</p>
            </div>
            <div class="text-center">
              <p class="font-semibold text-dark">{{ ucfirst($property->property_type) }}</p>
              <p class="text-sm text-gray-500">Type</p>
            </div>
          </div>

          {{-- Description --}}
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-dark mb-3">Description</h2>
            <p class="text-gray-600 leading-relaxed">{{ $property->description }}</p>
          </div>

          {{-- Amenities (boolean fields) --}}
          @if($property->has_pool || $property->has_gym || $property->has_parking)
            <div class="mb-6">
              <h2 class="text-xl font-semibold text-dark mb-4">Amenities</h2>
              <div class="flex flex-wrap gap-3">
                @if($property->has_pool)
                  <div class="flex items-center gap-2 px-4 py-2 bg-background rounded-xl">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-dark">Swimming Pool</span>
                  </div>
                @endif
                @if($property->has_gym)
                  <div class="flex items-center gap-2 px-4 py-2 bg-background rounded-xl">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-dark">Gym</span>
                  </div>
                @endif
                @if($property->has_parking)
                  <div class="flex items-center gap-2 px-4 py-2 bg-background rounded-xl">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-dark">Parking</span>
                  </div>
                @endif
              </div>
            </div>
          @endif

          {{-- Availability --}}
          <div class="p-4 bg-green-50 rounded-xl border border-green-200">
            <p class="font-semibold text-green-800">
              Available from {{ $property->available_from?->format('F j, Y') ?? 'Now' }}
            </p>
          </div>
        </div>
      </div>

      {{-- Right: Owner + Inquiry --}}
      <div class="space-y-6">

        {{-- Owner --}}
        <div class="bg-white rounded-2xl p-6 shadow-md">
          <h2 class="text-lg font-semibold text-dark mb-4">Listed By</h2>
          <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-accent rounded-full flex items-center justify-center">
              <span class="text-xl font-semibold text-primary">
                {{ strtoupper(substr($property->user->name, 0, 2)) }}
              </span>
            </div>
            <div>
              <p class="font-semibold text-dark">{{ $property->user->name }}</p>
              <p class="text-sm text-gray-500">Property Owner</p>
            </div>
          </div>
        </div>

        {{-- Inquiry Form --}}
        <div class="bg-white rounded-2xl p-6 shadow-md">
          <h2 class="text-lg font-semibold text-dark mb-4">Contact Owner</h2>

          @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
          @endif

          @guest
            <p class="text-gray-500 text-sm mb-4">
              <a href="{{ route('login') }}" class="text-primary font-semibold">Log in</a> to send an inquiry.
            </p>
          @endguest

          @auth
            <form method="POST" action="{{ route('inquiries.store', $property) }}" class="space-y-4">
              @csrf
              {{-- The inquiry model stores sender_id from auth, message, preferred_contact --}}
              <div class="form-control">
                <label class="label"><span class="label-text text-dark font-medium">Message *</span></label>
                <textarea name="message" rows="4"
                          class="textarea textarea-bordered bg-background border-accent focus:border-primary rounded-xl w-full"
                          placeholder="I'm interested in this property..." required>{{ old('message') }}</textarea>
                @error('message')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text text-dark font-medium">Preferred Contact</span></label>
                <div class="flex flex-wrap gap-3 mt-1">
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="preferred_contact" value="email" class="radio radio-primary radio-sm"
                           {{ old('preferred_contact', 'email') === 'email' ? 'checked' : '' }} />
                    <span class="text-sm">Email</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="preferred_contact" value="phone" class="radio radio-primary radio-sm"
                           {{ old('preferred_contact') === 'phone' ? 'checked' : '' }} />
                    <span class="text-sm">Phone</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="preferred_contact" value="whatsapp" class="radio radio-primary radio-sm"
                           {{ old('preferred_contact') === 'whatsapp' ? 'checked' : '' }} />
                    <span class="text-sm">WhatsApp</span>
                  </label>
                </div>
                @error('preferred_contact')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
              </div>
              <button type="submit"
                      class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl w-full">
                Send Inquiry
              </button>
            </form>
          @endauth
        </div>

        @guest
          <a href="{{ route('login') }}"
             class="btn bg-accent hover:bg-secondary text-dark border-none rounded-xl w-full">
            Login to Save to Wishlist
          </a>
        @endguest

      </div>
    </div>
  </main>
@endsection