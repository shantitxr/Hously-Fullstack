<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hously - Find Your Next Home</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7FB3FF',
            secondary: '#A8C8FF',
            background: '#F5F9FF',
            accent: '#DCE9FF',
            dark: '#1F2937',
          }
        }
      }
    }
  </script>
  <style>
    body {
      background-color: #F5F9FF;
    }
    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(127, 179, 255, 0.15);
    }
    .card-hover {
      transition: all 0.3s ease;
    }
  </style>
</head>
<body class="min-h-screen">
  <!-- Navbar -->
  <nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-[1280px] mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
          <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
          </div>
          <span class="text-2xl font-bold text-dark">Hously</span>
        </a>
        
        <!-- Navigation Links -->
        <div class="hidden md:flex items-center gap-8">
          <a href="{{ route('home') }}" class="text-primary font-semibold">Home</a>
          <a href="{{ route('home') }}#properties" class="text-dark hover:text-primary transition-colors">Properties</a>
          <a href="{{ route('wishlist.index') }}" class="text-dark hover:text-primary transition-colors">Wishlist</a>
        </div>
        
        <!-- Auth Buttons -->
        <div class="flex items-center gap-3">
          <a href="{{ route('login') }}" class="btn btn-ghost text-dark hover:bg-accent">Login</a>
          <a href="{{ route('register') }}" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl">Sign Up</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="py-16 md:py-24">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-dark mb-6">Find Your Next Home</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover the perfect property from our curated collection of apartments, houses, and villas across Europe.</p>
      </div>
      
      <!-- Search Bar -->
      <div class="bg-white rounded-2xl shadow-lg p-6 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div class="form-control">
            <label class="label">
              <span class="label-text text-dark font-medium">Location</span>
            </label>
            <input type="text" placeholder="City or address" class="input input-bordered bg-background border-accent focus:border-primary rounded-xl" />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text text-dark font-medium">Property Type</span>
            </label>
            <select class="select select-bordered bg-background border-accent focus:border-primary rounded-xl">
              <option disabled selected>Select type</option>
              <option>Apartment</option>
              <option>House</option>
              <option>Studio</option>
              <option>Villa</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text text-dark font-medium">Price Range</span>
            </label>
            <select class="select select-bordered bg-background border-accent focus:border-primary rounded-xl">
              <option disabled selected>Select range</option>
              <option>€0 - €500/mo</option>
              <option>€500 - €1,000/mo</option>
              <option>€1,000 - €2,000/mo</option>
              <option>€2,000+/mo</option>
            </select>
          </div>
          <div class="form-control">
            <label class="label opacity-0">
              <span class="label-text">Search</span>
            </label>
            <button class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl h-12">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              Search
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Properties -->
  <section id="properties" class="py-16 bg-white">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="flex items-center justify-between mb-10">
        <div>
          <h2 class="text-3xl font-bold text-dark mb-2">Featured Properties</h2>
          <p class="text-gray-600">Handpicked properties for you</p>
        </div>
        <a href="#" class="btn btn-ghost text-primary hover:bg-accent rounded-xl">View All</a>
      </div>
      
      <!-- Property Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Property Card 1 -->
        <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
          <figure class="relative">
            <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&h=400&fit=crop" alt="Modern Apartment in Budapest" class="w-full h-56 object-cover" />
            <div class="absolute top-4 left-4">
              <span class="badge bg-primary text-white border-none px-3 py-2">For Rent</span>
            </div>
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </figure>
          <div class="card-body p-5">
            <h3 class="card-title text-dark text-lg">Modern Apartment in Budapest</h3>
            <p class="text-gray-500 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Budapest, Hungary
            </p>
            <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                2 Beds
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                1 Bath
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                65 m²
              </span>
            </div>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
              <span class="text-xl font-bold text-primary">€850/month</span>
              <a href="{{ route('properties.show', 1) }}" class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
            </div>
          </div>
        </div>

        <!-- Property Card 2 -->
        <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
          <figure class="relative">
            <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&h=400&fit=crop" alt="Luxury Villa in Lisbon" class="w-full h-56 object-cover" />
            <div class="absolute top-4 left-4">
              <span class="badge bg-green-500 text-white border-none px-3 py-2">For Sale</span>
            </div>
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </figure>
          <div class="card-body p-5">
            <h3 class="card-title text-dark text-lg">Luxury Villa in Lisbon</h3>
            <p class="text-gray-500 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Lisbon, Portugal
            </p>
            <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                5 Beds
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                4 Baths
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                320 m²
              </span>
            </div>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
              <span class="text-xl font-bold text-primary">€1,250,000</span>
              <a href="{{ route('properties.show', 1) }}" class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
            </div>
          </div>
        </div>

        <!-- Property Card 3 -->
        <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
          <figure class="relative">
            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&h=400&fit=crop" alt="Cozy Studio in Vienna" class="w-full h-56 object-cover" />
            <div class="absolute top-4 left-4">
              <span class="badge bg-primary text-white border-none px-3 py-2">For Rent</span>
            </div>
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </figure>
          <div class="card-body p-5">
            <h3 class="card-title text-dark text-lg">Cozy Studio in Vienna</h3>
            <p class="text-gray-500 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Vienna, Austria
            </p>
            <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                1 Bed
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                1 Bath
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                35 m²
              </span>
            </div>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
              <span class="text-xl font-bold text-primary">€550/month</span>
              <a href="{{ route('properties.show', 1) }}" class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
            </div>
          </div>
        </div>

        <!-- Property Card 4 -->
        <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
          <figure class="relative">
            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=600&h=400&fit=crop" alt="Family House in Prague" class="w-full h-56 object-cover" />
            <div class="absolute top-4 left-4">
              <span class="badge bg-green-500 text-white border-none px-3 py-2">For Sale</span>
            </div>
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </figure>
          <div class="card-body p-5">
            <h3 class="card-title text-dark text-lg">Family House in Prague</h3>
            <p class="text-gray-500 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Prague, Czech Republic
            </p>
            <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                4 Beds
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                2 Baths
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                180 m²
              </span>
            </div>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
              <span class="text-xl font-bold text-primary">€420,000</span>
              <a href="{{ route('properties.show', 1) }}" class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
            </div>
          </div>
        </div>

        <!-- Property Card 5 -->
        <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
          <figure class="relative">
            <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=600&h=400&fit=crop" alt="Penthouse in Berlin" class="w-full h-56 object-cover" />
            <div class="absolute top-4 left-4">
              <span class="badge bg-primary text-white border-none px-3 py-2">For Rent</span>
            </div>
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </figure>
          <div class="card-body p-5">
            <h3 class="card-title text-dark text-lg">Penthouse in Berlin</h3>
            <p class="text-gray-500 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Berlin, Germany
            </p>
            <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                3 Beds
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                2 Baths
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                120 m²
              </span>
            </div>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
              <span class="text-xl font-bold text-primary">€1,800/month</span>
              <a href="{{ route('properties.show', 1) }}" class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
            </div>
          </div>
        </div>

        <!-- Property Card 6 -->
        <div class="card bg-white shadow-md rounded-2xl overflow-hidden card-hover">
          <figure class="relative">
            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600&h=400&fit=crop" alt="Modern Villa in Barcelona" class="w-full h-56 object-cover" />
            <div class="absolute top-4 left-4">
              <span class="badge bg-green-500 text-white border-none px-3 py-2">For Sale</span>
            </div>
            <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors">
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </button>
          </figure>
          <div class="card-body p-5">
            <h3 class="card-title text-dark text-lg">Modern Villa in Barcelona</h3>
            <p class="text-gray-500 flex items-center gap-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Barcelona, Spain
            </p>
            <div class="flex items-center gap-4 text-gray-600 text-sm mt-3">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                6 Beds
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                5 Baths
              </span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                450 m²
              </span>
            </div>
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-accent">
              <span class="text-xl font-bold text-primary">€2,100,000</span>
              <a href="{{ route('properties.show', 1) }}" class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">View Details</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Property Categories -->
  <section class="py-16">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-dark mb-2">Browse by Category</h2>
        <p class="text-gray-600">Find the perfect property type for your needs</p>
      </div>
      
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Apartment -->
        <div class="bg-white rounded-2xl p-8 text-center shadow-md card-hover cursor-pointer">
          <div class="w-16 h-16 bg-accent rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-dark mb-1">Apartment</h3>
          <p class="text-gray-500 text-sm">156 listings</p>
        </div>
        
        <!-- House -->
        <div class="bg-white rounded-2xl p-8 text-center shadow-md card-hover cursor-pointer">
          <div class="w-16 h-16 bg-accent rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-dark mb-1">House</h3>
          <p class="text-gray-500 text-sm">89 listings</p>
        </div>
        
        <!-- Studio -->
        <div class="bg-white rounded-2xl p-8 text-center shadow-md card-hover cursor-pointer">
          <div class="w-16 h-16 bg-accent rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-dark mb-1">Studio</h3>
          <p class="text-gray-500 text-sm">64 listings</p>
        </div>
        
        <!-- Villa -->
        <div class="bg-white rounded-2xl p-8 text-center shadow-md card-hover cursor-pointer">
          <div class="w-16 h-16 bg-accent rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-dark mb-1">Villa</h3>
          <p class="text-gray-500 text-sm">42 listings</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-16 bg-white">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="bg-gradient-to-r from-primary to-secondary rounded-3xl p-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">List Your Property with Us</h2>
        <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">Join thousands of property owners who trust Hously to find the perfect tenants and buyers.</p>
        <a href="{{ route('user.properties.create') }}" class="btn bg-white text-primary hover:bg-accent border-none rounded-xl px-8">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          List Your Property
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-12">
    <div class="max-w-[1280px] mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <!-- Brand -->
        <div class="col-span-1 md:col-span-2">
          <div class="flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>
            <span class="text-2xl font-bold">Hously</span>
          </div>
          <p class="text-gray-400 max-w-md">Find your perfect home with Hously. We connect property seekers with their dream homes across Europe.</p>
        </div>
        
        <!-- Quick Links -->
        <div>
          <h4 class="font-semibold mb-4">Quick Links</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
            <li><a href="{{ route('home') }}#properties" class="hover:text-primary transition-colors">Properties</a></li>
            <li><a href="{{ route('wishlist.index') }}" class="hover:text-primary transition-colors">Wishlist</a></li>
            <li><a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a></li>
          </ul>
        </div>
        
        <!-- Contact -->
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
        <p>&copy; 2024 Hously. All rights reserved.</p>
      </div>
    </div>
  </footer>
</body>
