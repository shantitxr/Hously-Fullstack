<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') - Hously</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: { colors: {
        primary: '#7FB3FF', secondary: '#A8C8FF',
        background: '#F5F9FF', accent: '#DCE9FF', dark: '#1F2937',
      }}}
    }
  </script>
  <style>body { background-color: #F5F9FF; }</style>
</head>
<body class="min-h-screen">
<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg hidden lg:block">
    <div class="p-6">
      <a href="{{ route('home') }}" class="flex items-center gap-2">
        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
        </div>
        <span class="text-2xl font-bold text-dark">Hously</span>
      </a>
    </div>
    <nav class="px-4 pb-6">
      <ul class="space-y-2">
        <li>
          <a href="{{ route('dashboard') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-accent text-primary font-medium' : 'text-dark hover:bg-accent' }} transition-colors">
            Dashboard
          </a>
        </li>
        <li>
          <a href="{{ route('user.properties.index') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.properties.*') ? 'bg-accent text-primary font-medium' : 'text-dark hover:bg-accent' }} transition-colors">
            My Properties
          </a>
        </li>
        <li>
          <a href="{{ route('wishlist.index') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('wishlist.*') ? 'bg-accent text-primary font-medium' : 'text-dark hover:bg-accent' }} transition-colors">
            Wishlist
          </a>
        </li>
        <li>
          <a href="{{ route('inquiries.index') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('inquiries.*') ? 'bg-accent text-primary font-medium' : 'text-dark hover:bg-accent' }} transition-colors">
            Inquiries
          </a>
        </li>
      </ul>
      @if(auth()->user()->role === 'admin')
      <div class="border-t border-accent mt-6 pt-6">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Admin</p>
        <ul class="space-y-2">
          <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium {{ request()->routeIs('admin.*') ? 'bg-primary text-white' : 'text-dark hover:bg-accent' }} transition-colors">
              Admin Panel
            </a>
          </li>
        </ul>
      </div>
      @endif
      <div class="border-t border-accent mt-6 pt-6">
        <ul class="space-y-2">
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-colors">
                Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>
  </aside>

  <!-- Right side: topbar + content -->
  <div class="flex-1">
    <header class="bg-white shadow-sm px-6 py-4">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-dark">@yield('page-title')</h1>
          <p class="text-gray-500 text-sm">Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <div class="flex items-center gap-3">
          <div class="dropdown dropdown-end">
            <button tabindex="0"
                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center hover:bg-secondary transition-colors focus:outline-none"
                    title="{{ auth()->user()->name }}">
              <span class="text-white font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
            </button>
            <ul tabindex="0" class="dropdown-content menu bg-white rounded-2xl shadow-lg w-52 p-2 mt-2 z-50 border border-accent">
              <li class="px-3 py-2 border-b border-accent mb-1">
                <p class="font-semibold text-dark text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
              </li>
              <li>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-dark hover:bg-accent">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                  Dashboard
                </a>
              </li>
              <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-dark hover:bg-accent">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  Edit Profile
                </a>
              </li>
              <li class="border-t border-accent mt-1 pt-1">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-red-500 hover:bg-red-50 w-full text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <main class="p-6">
      @yield('content')
    </main>
  </div>

</div>
@stack('scripts')
</body>
</html>