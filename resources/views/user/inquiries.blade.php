@extends('layouts.dashboard')

@section('title', 'Inquiries')
@section('page-title', 'Inquiries')

@section('content')
  <div class="space-y-6">
    @forelse($properties as $property)
      <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-accent">
          <div class="flex items-center gap-4">
            @if($property->image_path)
              <img src="{{ Storage::url($property->image_path) }}"
                   alt="{{ $property->title }}" class="w-24 h-16 object-cover rounded-xl" />
            @else
              <div class="w-24 h-16 bg-accent rounded-xl"></div>
            @endif
            <div class="flex-1">
              <h2 class="text-lg font-semibold text-dark">{{ $property->title }}</h2>
              <p class="text-gray-500 text-sm">{{ $property->city }} — €{{ number_format($property->price) }}</p>
            </div>
            <span class="badge bg-primary text-white border-none px-4 py-3">
              {{ $property->inquiries->count() }} {{ Str::plural('Inquiry', $property->inquiries->count()) }}
            </span>
          </div>
        </div>
        <div class="p-6 space-y-4">
          @foreach($property->inquiries as $inquiry)
            <div class="bg-background rounded-xl p-4 {{ $inquiry->is_read ? 'opacity-70' : '' }}">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center shrink-0">
                  {{-- sender is the User model --}}
                  <span class="text-primary font-semibold">{{ strtoupper(substr($inquiry->sender->name ?? '?', 0, 2)) }}</span>
                </div>
                <div class="flex-1">
                  <div class="flex items-center justify-between mb-2">
                    <div>
                      <h3 class="font-semibold text-dark">{{ $inquiry->sender->name ?? 'Unknown' }}</h3>
                      <p class="text-xs text-gray-500">{{ $inquiry->sender->email ?? '' }}</p>
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
                    {{-- preferred_contact is the actual DB column --}}
                    <span class="text-sm text-primary">Prefers {{ ucfirst($inquiry->preferred_contact) }}</span>
                    <div class="flex gap-2">
                      <a href="mailto:{{ $inquiry->sender->email }}"
                         class="btn btn-sm bg-primary hover:bg-secondary text-white border-none rounded-lg">Reply</a>
                      @if(!$inquiry->is_read)
                        <form method="POST" action="{{ route('inquiries.read', $inquiry) }}">
                          @csrf
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
      </div>
    @endforelse
  </div>
@endsection