
@extends('layouts.admin')

@section('title', 'Manage Properties')
@section('page-title', 'Manage Properties')

@section('content')
  {{-- Filters --}}
  <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
    <form method="GET" action="{{ route('admin.properties.index') }}"
          class="flex flex-wrap items-center justify-between gap-4">
      <div class="flex flex-wrap items-center gap-4">
        <div class="relative">
          <input type="text" name="search" value="{{ request('search') }}"
                 placeholder="Search properties..."
                 class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-64">
          <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <select name="status" class="border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
          <option value="">All Status</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <select name="type" class="border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
          <option value="">All Types</option>
          <option value="house"     {{ request('type') === 'house'     ? 'selected' : '' }}>House</option>
          <option value="apartment" {{ request('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
          <option value="villa"     {{ request('type') === 'villa'     ? 'selected' : '' }}>Villa</option>
          <option value="studio"    {{ request('type') === 'studio'    ? 'selected' : '' }}>Studio</option>
        </select>
        <button type="submit"
                class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition">Filter</button>
      </div>
      <a href="{{ route('admin.properties.create') }}"
         class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Add Property
      </a>
    </form>
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Property</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Owner</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Type</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Price</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Status</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Date</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($properties as $property)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
          @if($property->image_path)
            <img src="{{ Storage::url($property->image_path) }}"
                class="w-12 h-12 rounded-lg object-cover">
          @else
            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
              <i class="fas fa-home text-gray-400"></i>
            </div>
          @endif
          <div>
            <h4 class="font-semibold text-secondary">{{ $property->title }}</h4>
            <p class="text-sm text-gray-500">{{ $property->city }}</p>
          </div>
              </div>
            </td>
            <td class="px-6 py-4 text-gray-600">{{ $property->user->name }}</td>
            <td class="px-6 py-4 text-gray-600">{{ ucfirst($property->type) }}</td>
            <td class="px-6 py-4 font-semibold text-secondary">€{{ number_format($property->price) }}</td>
            <td class="px-6 py-4">
              <span class="px-3 py-1 rounded-full text-sm
                {{ $property->is_active ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                {{ $property->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-600">{{ $property->created_at->format('M d, Y') }}</td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <a href="{{ route('properties.show', $property) }}"
                   class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.properties.edit', $property) }}"
                   class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <form method="POST" action="{{ route('admin.properties.destroy', $property) }}"
                      onsubmit="return confirm('Delete this property permanently?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-6 py-12 text-center text-gray-500">No properties found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-100">
      {{ $properties->withQueryString()->links() }}
    </div>
  </div>
@endsection
