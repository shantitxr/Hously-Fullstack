@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
  <!-- Stats Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-md">
      <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 bg-accent rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <span class="text-sm text-green-500 bg-green-50 px-2 py-1 rounded-lg">+{{ $propertiesThisMonth }} this month</span>
      </div>
      <h3 class="text-3xl font-bold text-dark mb-1">{{ $totalProperties }}</h3>
      <p class="text-gray-500">Total Properties</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-md">
      <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 bg-accent rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
        </div>
        <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">+{{ $wishlistThisWeek }} this week</span>
      </div>
      <h3 class="text-3xl font-bold text-dark mb-1">{{ $totalWishlist }}</h3>
      <p class="text-gray-500">Wishlist Items</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-md">
      <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 bg-accent rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
          </svg>
        </div>
        <span class="text-sm text-primary bg-accent px-2 py-1 rounded-lg">{{ $newInquiries }} new</span>
      </div>
      <h3 class="text-3xl font-bold text-dark mb-1">{{ $totalInquiries }}</h3>
      <p class="text-gray-500">Total Inquiries</p>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-white rounded-2xl p-6 shadow-md mb-8">
    <h2 class="text-xl font-semibold text-dark mb-4">Quick Actions</h2>
    <div class="flex flex-wrap gap-4">
      @if(auth()->user()->role !== 'admin')
        <a href="{{ route('user.properties.create') }}" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl">
          Add New Property
        </a>
        <a href="{{ route('user.properties.index') }}" class="btn bg-accent hover:bg-secondary text-dark border-none rounded-xl">
          View All Properties
        </a>
        <a href="{{ route('inquiries.index') }}" class="btn bg-accent hover:bg-secondary text-dark border-none rounded-xl">
          Check Inquiries
        </a>
      @else
        <a href="{{ route('admin.dashboard') }}" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl">
          Go to Admin Panel
        </a>
      @endif
    </div>
  </div>

  <!-- Recent Activity -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Inquiries -->
    <div class="bg-white rounded-2xl p-6 shadow-md">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-dark">Recent Inquiries</h2>
        @if(auth()->user()->role !== 'admin')
          <a href="{{ route('inquiries.index') }}" class="text-primary text-sm hover:underline">View all</a>
        @endif
      </div>
      <div class="space-y-4">
        @forelse($recentInquiries as $inquiry)
          <div class="flex items-start gap-4 p-4 bg-background rounded-xl">
            <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center shrink-0">
              <span class="text-primary font-semibold text-sm">
                {{ strtoupper(substr($inquiry->sender->name ?? 'U', 0, 2)) }}
              </span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between">
                <p class="font-medium text-dark">{{ $inquiry->sender->name ?? 'Unknown' }}</p>
                <span class="text-xs text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</span>
              </div>
              <p class="text-sm text-gray-500 truncate">{{ $inquiry->message }}</p>
              <p class="text-xs text-primary mt-1">Via {{ ucfirst($inquiry->preferred_contact) }}</p>
            </div>
          </div>
        @empty
          <p class="text-gray-500 text-sm">No inquiries yet.</p>
        @endforelse
      </div>
    </div>

    <!-- Your Properties -->
    <div class="bg-white rounded-2xl p-6 shadow-md">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-dark">Your Properties</h2>
        @if(auth()->user()->role !== 'admin')
          <a href="{{ route('user.properties.index') }}" class="text-primary text-sm hover:underline">View all</a>
        @endif
      </div>
      <div class="space-y-4">
        @forelse($recentProperties as $property)
          <div class="flex items-center gap-4 p-3 bg-background rounded-xl">
            <img src="{{ $property->image_path ? Storage::url($property->image_path) : 'https://placehold.co/100x80' }}"
                 alt="{{ $property->title }}"
                 class="w-16 h-14 object-cover rounded-lg"/>
            <div class="flex-1 min-w-0">
              <p class="font-medium text-dark truncate">{{ $property->title }}</p>
              <p class="text-sm text-gray-500">€{{ number_format($property->price) }}</p>
            </div>
            <span class="badge {{ $property->is_available ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} border-none">
              {{ $property->is_available ? 'Active' : 'Inactive' }}
            </span>
          </div>
        @empty
          <p class="text-gray-500 text-sm">No properties yet.</p>
        @endforelse
      </div>
    </div>
  </div>
@endsection