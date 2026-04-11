
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

      {{-- Left: Property Details --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- Image Gallery --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-md">
          <div class="relative">
            @if($property->images->isNotEmpty())
              <img src="{{ Storage::url($property->images->first()->path) }}"
                   alt="{{ $property->title }}" class="w-full h-[400px] object-cover" id="main-image" />
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
            {{-- Wishlist toggle --}}
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

          {{-- Thumbnails --}}
          @if($property->images->count() > 1)
            <div class="p-4 flex gap-3 overflow-x-auto">
              @foreach($property->images as $image)
                <img src="{{ Storage::url($image->path) }}"
                     alt="Gallery"
                     onclick="document.getElementById('main-image').src='{{ Storage::url($image->path) }}'"
                     class="w-24 h-20 object-cover rounded-lg border-2 border-transparent hover:border-primary cursor-pointer transition-colors" />
              @endforeach
            </div>
          @endif
        </div>

        {{-- Property Info --}}
        <div class="bg-white rounded-2xl p-6 shadow-md">
          <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-dark mb-2">{{ $property->title }}</h1>
              <p class="text-gray-500 flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $property->address }}, {{ $property->city }}, {{ $property->country }}
              </p>
            </div>
            <div class="text-right">
              <span class="text-3xl font-bold text-primary">€{{ number_format($property->price) }}</span>
              @if($property->listing_type === 'rent')
                <span class="text-gray-500">/month</span>
              @endif
            </div>
          </div>

          {{-- Features --}}
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-background rounded-xl mb-6">
            <div class="text-center">
              <p class="font-semibold text-dark">{{ $property->area_sqm }} m²</p>
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
              <p class="font-semibold text-dark">{{ ucfirst($property->type) }}</p>
              <p class="text-sm text-gray-500">Type</p>
            </div>
          </div>

          {{-- Description --}}
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-dark mb-3">Description</h2>
            <p class="text-gray-600 leading-relaxed">{{ $property->description }}</p>
          </div>

          {{-- Amenities --}}
          @if($property->amenities->isNotEmpty())
            <div class="mb-6">
              <h2 class="text-xl font-semibold text-dark mb-4">Amenities</h2>
              <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($property->amenities as $amenity)
                  <div class="flex items-center gap-3 p-3 bg-background rounded-xl">
                    <div class="w-10 h-10 bg-accent rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                      </svg>
                    </div>
                    <span class="text-dark">{{ $amenity->name }}</span>
                  </div>
                @endforeach
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

      {{-- Right: Owner + Inquiry Form --}}
      <div class="space-y-6">

        {{-- Owner Info --}}
        <div class="bg-white rounded-2xl p-6 shadow-md">
          <h2 class="text-lg font-semibold text-dark mb-4">Listed By</h2>
          <div class="flex items-center gap-4 mb-4">
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

          @if(session('inquiry_sent'))
            <div class="alert alert-success mb-4">Inquiry sent successfully!</div>
          @endif

          <form method="POST" action="{{ route('inquiries.store', $property) }}" class="space-y-4">
            @csrf
            <div class="form-control">
              <label class="label"><span class="label-text text-dark font-medium">Your Name</span></label>
              <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}"
                     placeholder="Enter your name"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full"
                     required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text text-dark font-medium">Email</span></label>
              <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                     placeholder="Enter your email"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full"
                     required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text text-dark font-medium">Phone (Optional)</span></label>
              <input type="tel" name="phone" value="{{ old('phone') }}"
                     placeholder="Enter your phone"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text text-dark font-medium">Message</span></label>
              <textarea name="message" rows="4"
                        class="textarea textarea-bordered bg-background border-accent focus:border-primary rounded-xl w-full"
                        placeholder="I'm interested in this property..." required>{{ old('message') }}</textarea>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text text-dark font-medium">Preferred Contact Method</span></label>
              <div class="flex flex-wrap gap-3">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="contact_method" value="email" class="radio radio-primary radio-sm"
                         {{ old('contact_method', 'email') === 'email' ? 'checked' : '' }} />
                  <span class="text-sm">Email</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="contact_method" value="phone" class="radio radio-primary radio-sm"
                         {{ old('contact_method') === 'phone' ? 'checked' : '' }} />
                  <span class="text-sm">Phone</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="contact_method" value="whatsapp" class="radio radio-primary radio-sm"
                         {{ old('contact_method') === 'whatsapp' ? 'checked' : '' }} />
                  <span class="text-sm">WhatsApp</span>
                </label>
              </div>
            </div>
            <button type="submit"
                    class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl w-full">
              Send Inquiry
            </button>
          </form>
        </div>

        {{-- Wishlist button (non-auth) --}}
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
