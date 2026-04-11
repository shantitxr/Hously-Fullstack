
@extends('layouts.dashboard')

@section('title', 'Inquiries')
@section('page-title', 'Inquiries')

@section('content')
  <div class="space-y-6">
    @forelse($properties as $property)
      <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        {{-- Property Header --}}
        <div class="p-6 border-b border-accent">
          <div class="flex items-center gap-4">
            @if($property->images->isNotEmpty())
              <img src="{{ Storage::url($property->images->first()->path) }}"
                   alt="{{ $property->title }}" class="w-24 h-16 object-cover rounded-xl" />
            @else
              <div class="w-24 h-16 bg-accent rounded-xl flex items-center justify-center">
                <span class="text-primary text-xs">No img</span>
              </div>
            @endif
            <div class="flex-1">
              <h2 class="text-lg font-semibold text-dark">{{ $property->title }}</h2>
              <p class="text-gray-500 text-sm">{{ $property->city }}, {{ $property->country }} — €{{ number_format($property->price) }}</p>
            </div>
            <span class="badge bg-primary text-white border-none px-4 py-3">
              {{ $property->inquiries->count() }} {{ Str::plural('Inquiry', $property->inquiries->count()) }}
            </span>
          </div>
        </div>

        {{-- Inquiries List --}}
        <div class="p-6 space-y-4">
          @foreach($property->inquiries as $inquiry)
            <div class="bg-background rounded-xl p-4 {{ $inquiry->is_read ? 'opacity-70' : '' }}">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center shrink-0">
                  <span class="text-primary font-semibold">{{ strtoupper(substr($inquiry->name, 0, 2)) }}</span>
                </div>
                <div class="flex-1">
                  <div class="flex items-center justify-between mb-2">
                    <div>
                      <h3 class="font-semibold text-dark">{{ $inquiry->name }}</h3>
                      <p class="text-xs text-gray-500">{{ $inquiry->email }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                      @if($inquiry->is_read)
                        <span class="badge bg-gray-200 text-gray-600 border-none text-xs">Read</span>
                      @endif
                      <span class="text-xs text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</span>
                    </div>
                  </div>
                  <p class="text-gray-600 text-sm mb-3">{{ $inquiry->message }}</p>
                  <div class="flex items-center justify-between">
                    <span class="text-sm text-primary">Prefers {{ ucfirst($inquiry->contact_method) }}</span>
                    <div class="flex gap-2">
                      <a href="mailto:{{ $inquiry->email }}"
                         class="btn btn-sm bg-primary hover:bg-secondary text-white border-none rounded-lg">Reply</a>
                      @if(!$inquiry->is_read)
                        <form method="POST" action="{{ route('inquiries.read', $inquiry) }}">
                          @csrf @method('PATCH')
                          <button type="submit"
                                  class="btn btn-sm bg-accent hover:bg-secondary text-dark border-none rounded-lg">Mark as Read</button>
                        </form>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @empty
      <div class="bg-white rounded-2xl p-12 text-center text-gray-500 shadow-md">
        <p class="text-lg">No inquiries yet.</p>
        <p class="text-sm mt-2">When someone contacts you about a property, it will appear here.</p>
      </div>
    @endforelse
  </div>
@endsection
