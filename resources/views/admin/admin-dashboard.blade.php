
@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')
@section('content')
  {{-- Stats --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <h3 class="text-3xl font-bold text-secondary">{{ $totalProperties }}</h3>
      <p class="text-gray-500">Total Properties</p>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <h3 class="text-3xl font-bold text-secondary">{{ $totalUsers }}</h3>
      <p class="text-gray-500">Registered Users</p>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <h3 class="text-3xl font-bold text-secondary">{{ $totalInquiries }}</h3>
      <p class="text-gray-500">Total Inquiries</p>
    </div>
  </div>
  {{-- Recent Properties & Users side by side --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-secondary">Recent Properties</h2>
        <a href="{{ route('admin.properties.index') }}" class="text-primary hover:underline text-sm">View All</a>
      </div>
      @foreach($recentProperties as $p)
        <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50">
          <div class="flex-1"><h4 class="font-semibold text-secondary">{{ $p->title }}</h4>
          <p class="text-sm text-gray-500">{{ $p->city }}</p></div>
          <span class="px-3 py-1 {{ $p->is_active ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }} rounded-full text-sm">
            {{ $p->is_active ? 'Active' : 'Pending' }}
          </span>
        </div>
      @endforeach
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-secondary">Recent Users</h2>
        <a href="{{ route('admin.users.index') }}" class="text-primary hover:underline text-sm">View All</a>
      </div>
      @foreach($recentUsers as $u)
        <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50">
          <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
            {{ strtoupper(substr($u->name, 0, 2)) }}
          </div>
          <div class="flex-1"><h4 class="font-semibold text-secondary">{{ $u->name }}</h4>
          <p class="text-sm text-gray-500">{{ $u->email }}</p></div>
          <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">{{ ucfirst($u->role) }}</span>
        </div>
      @endforeach
    </div>
  </div>
@endsection
