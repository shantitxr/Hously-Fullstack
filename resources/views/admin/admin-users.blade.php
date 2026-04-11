
@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
  {{-- Stats --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-users text-blue-500 text-xl"></i>
        </div>
        <div>
          <h3 class="text-2xl font-bold text-secondary">{{ $totalUsers }}</h3>
          <p class="text-gray-500 text-sm">Total Users</p>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
          <i class="fas fa-user-slash text-red-500 text-xl"></i>
        </div>
        <div>
          <h3 class="text-2xl font-bold text-secondary">{{ $suspendedUsers }}</h3>
          <p class="text-gray-500 text-sm">Suspended</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Filters --}}
  <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="flex flex-wrap items-center gap-4">
      <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search users..."
               class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-64">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
      </div>
      <select name="role" class="border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
        <option value="">All Roles</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
      </select>
      <select name="status" class="border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
        <option value="">All Status</option>
        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Suspended</option>
      </select>
      <button type="submit"
              class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition">Filter</button>
    </form>
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">User</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Email</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Role</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Properties</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Status</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Joined</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-secondary">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($users as $user)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                  {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                  <h4 class="font-semibold text-secondary">{{ $user->name }}</h4>
                  <p class="text-sm text-gray-500">@{{ Str::lower(Str::replace(' ', '', $user->name)) }}</p>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
            <td class="px-6 py-4">
              <span class="px-3 py-1 rounded-full text-sm
                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($user->role) }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-600">{{ $user->properties_count }}</td>
            <td class="px-6 py-4">
              <span class="px-3 py-1 rounded-full text-sm
                {{ $user->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $user->is_active ? 'Active' : 'Suspended' }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                {{-- Toggle active/suspended --}}
                @if($user->id !== auth()->id())
                  <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <button type="submit"
                            class="p-2 rounded-lg transition
                              {{ $user->is_active ? 'text-red-500 hover:bg-red-50' : 'text-green-500 hover:bg-green-50' }}"
                            title="{{ $user->is_active ? 'Suspend' : 'Reactivate' }}">
                      <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-undo' }}"></i>
                    </button>
                  </form>
                  {{-- Toggle role --}}
                  <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                    <input type="hidden" name="is_active" value="{{ $user->is_active ? 1 : 0 }}">
                    <button type="submit"
                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                            title="Toggle role">
                      <i class="fas fa-user-shield"></i>
                    </button>
                  </form>
                  {{-- Delete --}}
                  <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                        onsubmit="return confirm('Delete this user permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                @else
                  <span class="text-xs text-gray-400 italic">You</span>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-6 py-12 text-center text-gray-500">No users found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-100">
      {{ $users->withQueryString()->links() }}
    </div>
  </div>
@endsection
