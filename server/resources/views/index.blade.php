<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hously - Find Your Next Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: { colors: {
        primary: '#7FB3FF', secondary: '#A8C8FF',
        background: '#F5F9FF', accent: '#DCE9FF', dark: '#1F2937',
      }}}
    }
  </script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" />
  <style>
    body { background-color: #F5F9FF; }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(127,179,255,0.15); }
    .card-hover { transition: all 0.3s ease; }
  </style>
</head>
<body class="min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-[1280px] mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
          <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
          </div>
          <span class="text-2xl font-bold text-dark">Hously</span>
        </a>
        <div class="hidden md:flex items-center gap-8">
          <a href="{{ route('home') }}" class="text-primary font-semibold">Home</a>
          <a href="#properties" class="text-dark hover:text-primary transition-colors">Properties</a>
          @auth
            <a href="{{ route('wishlist.index') }}" class="text-dark hover:text-primary transition-colors">Wishlist</a>
          @endauth
        </div>
        <div class="flex items-center gap-3">
          @auth
            <a href="{{ route('dashboard') }}" class="btn btn-ghost text-dark hover:bg-accent">Dashboard</a>
            @if(auth()->user()->role === 'admin')
              <a href="{{ route('admin.dashboard') }}" class="btn bg-accent text-dark border-none rounded-xl">Admin</a>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn btn-ghost text-dark hover:bg-accent">Login</a>
            <a href="{{ route('register') }}" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl">Sign Up</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero + Search -->
  <section class="py-16 md:py-24">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-dark mb-6">Find Your Next Home</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover the perfect property from our curated collection across Europe.</p>
      </div>
      <form method="GET" action="{{ route('home') }}" class="bg-white rounded-2xl shadow-lg p-6 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div class="form-control">
            <label class="label"><span class="label-text text-dark font-medium">Location</span></label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="City or address"
                   class="input input-bordered bg-background border-accent focus:border-primary rounded-xl" />
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text text-dark font-medium">Property Type</span></label>
            <select name="type" class="select select-bordered bg-background border-accent focus:border-primary rounded-xl">
              <option value="">All types</option>
              <option value="apartment" {{ request('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
              <option value="house"     {{ request('type') === 'house'     ? 'selected' : '' }}>House</option>
              <option value="studio"    {{ request('type') === 'studio'    ? 'selected' : '' }}>Studio</option>
              <option value="villa"     {{ request('type') === 'villa'     ? 'selected' : '' }}>Villa</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label"><span class="label-text text-dark font-medium">Listing</span></label>
            <select name="listing_type" class="select select-bordered bg-background border-accent focus:border-primary rounded-xl">
              <option value="">For rent or sale</option>
              <option value="rent" {{ request('listing_type') === 'rent' ? 'selected' : '' }}>For Rent</option>
              <option value="sale" {{ request('listing_type') === 'sale' ? 'selected' : '' }}>For Sale</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label opacity-0"><span class="label-text">Search</span></label>
            <button type="submit" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl h-12">
              Search
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- Properties -->
  <section id="properties" class="py-16 bg-white">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="flex items-center justify-between mb-10">
        <div>
          <h2 class="text-3xl font-bold text-dark mb-2">
            {{ request('search') || request('type') || request('listing_type') ? 'Search Results' : 'Featured Properties' }}
          </h2>
          <p class="text-gray-600">{{ $properties->total() }} {{ Str::plural('property', $properties->total()) }} found</p>
        </div>
      </div>

      @if($properties->isEmpty())
        <div class="text-center py-16 text-gray-500">
          <p class="text-xl mb-4">No properties found.</p>
          <a href="{{ route('home') }}" class="btn bg-primary text-white border-none rounded-xl">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @foreach($properties as $property)
            <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
              <figure class="relative">
                @if($property->image_path)
                  <img src="{{ Storage::url($property->image_path) }}"
                       alt="{{ $property->title }}" class="w-full h-56 object-cover" />
                @else
                  <div class="w-full h-56 bg-accent flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                  </div>
                @endif
                <div class="absolute top-4 left-4">
                  <span class="badge {{ $property->listing_type === 'rent' ? 'bg-primary' : 'bg-green-500' }} text-white border-none px-3 py-2">
                    For {{ ucfirst($property->listing_type) }}
                  </span>
                </div>
                @auth
                  @php $inWishlist = in_array($property->id, $wishlistIds ?? []); @endphp
                  <button
                    onclick="toggleWishlist(this, {{ $property->id }})"
                    data-wishlisted="{{ $inWishlist ? 'true' : 'false' }}"
                    class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
                    <svg class="w-5 h-5 transition-colors {{ $inWishlist ? 'text-red-500' : 'text-gray-400' }}"
                         fill="{{ $inWishlist ? 'currentColor' : 'none' }}"
                         stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                  </button>
                @endauth
              </figure>
              <div class="card-body p-5">
                <h3 class="card-title text-dark text-lg">{{ $property->title }}</h3>
                <p class="text-gray-500 text-sm">{{ $property->city }}</p>
                <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
                  <span>{{ $property->bedrooms }} Beds</span>
                  <span>•</span>
                  <span>{{ $property->bathrooms }} Baths</span>
                  <span>•</span>
                  <span>{{ $property->sq_meters }} m²</span>
                </div>
                <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
                  <span class="text-xl font-bold text-primary">
                    €{{ number_format($property->price) }}{{ $property->listing_type === 'rent' ? '/mo' : '' }}
                  </span>
                  <a href="{{ route('properties.show', $property) }}"
                     class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
          {{ $properties->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </section>

  <!-- CTA -->
  <section class="py-16">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="bg-gradient-to-r from-primary to-secondary rounded-3xl p-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">List Your Property with Us</h2>
        <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">Join thousands of property owners who trust Hously.</p>
        @auth
          @if(auth()->user()->role !== 'admin')
            <a href="{{ route('user.properties.create') }}" class="btn bg-white text-primary hover:bg-accent border-none rounded-xl px-8">
              List Your Property
            </a>
          @else
            <a href="{{ route('admin.dashboard') }}" class="btn bg-white text-primary hover:bg-accent border-none rounded-xl px-8">
              Go to Admin Panel
            </a>
          @endif
        @else
          <a href="{{ route('login') }}" class="btn bg-white text-primary hover:bg-accent border-none rounded-xl px-8">
            Get Started
          </a>
        @endauth
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-12">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div class="col-span-1 md:col-span-2">
          <span class="text-2xl font-bold">Hously</span>
          <p class="text-gray-400 max-w-md mt-2">Find your perfect home with Hously.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Quick Links</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
            <li><a href="#properties" class="hover:text-primary transition-colors">Properties</a></li>
            @auth
              <li><a href="{{ route('wishlist.index') }}" class="hover:text-primary transition-colors">Wishlist</a></li>
              <li><a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a></li>
            @endauth
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Contact</h4>
          <ul class="space-y-2 text-gray-400">
            <li>contact@hously.com</li>
            <li>+36 1 234 5678</li>
            <li>Budapest, Hungary</li>
          </ul>
        </div>
      </div>
      <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
        <p>&copy; {{ date('Y') }} Hously. All rights reserved.</p>
      </div>
    </div>
  </footer>
@auth
<script>
function applyHeart(svg, wishlisted) {
    svg.setAttribute('fill', wishlisted ? 'currentColor' : 'none');
    svg.style.color = wishlisted ? '#ef4444' : '#9ca3af';
    svg.classList.remove('text-red-500', 'text-gray-400');
}

async function toggleWishlist(btn, propertyId) {
    const svg = btn.querySelector('svg');
    const wasWishlisted = btn.dataset.wishlisted === 'true';
    const nowWishlisted = !wasWishlisted;

    // Optimistic update
    btn.dataset.wishlisted = nowWishlisted ? 'true' : 'false';
    applyHeart(svg, nowWishlisted);

    try {
        const res = await fetch(`/wishlist/${propertyId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });
        if (!res.ok) throw new Error('Failed');
    } catch (e) {
        // Revert on failure
        btn.dataset.wishlisted = wasWishlisted ? 'true' : 'false';
        applyHeart(svg, wasWishlisted);
    }
}
</script>
@endauth
</body>
</html>