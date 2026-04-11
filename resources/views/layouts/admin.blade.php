
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') - Hously</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: { extend: { colors: {
        primary: '#10B981', secondary: '#1E293B', accent: '#F59E0B'
      }}}
    }
  </script>
</head>
<body class="bg-gray-100">

  <aside class="fixed top-0 left-0 h-full w-64 bg-secondary text-white z-50">
    <div class="p-6 border-b border-gray-700">
      <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">Hously</a>
      <p class="text-sm text-gray-400 mt-1">Admin Panel</p>
    </div>
    <nav class="p-4">
      <ul class="space-y-2">
        <li>
          <a href="{{ route('admin.dashboard') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 text-primary' : 'hover:bg-gray-700' }} transition">
            <i class="fas fa-tachometer-alt w-5"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="{{ route('admin.properties.index') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.properties.*') ? 'bg-primary/20 text-primary' : 'hover:bg-gray-700' }} transition">
            <i class="fas fa-building w-5"></i> Properties
          </a>
        </li>
        <li>
          <a href="{{ route('admin.users.index') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary/20 text-primary' : 'hover:bg-gray-700' }} transition">
            <i class="fas fa-users w-5"></i> Users
          </a>
        </li>
      </ul>
    </nav>
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition text-gray-400">
          <i class="fas fa-sign-out-alt w-5"></i> Logout
        </button>
      </form>
    </div>
  </aside>

  <main class="ml-64 min-h-screen">
    <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-secondary">@yield('page-title')</h1>
      <div class="flex items-center gap-3">
        <p class="font-semibold text-secondary">{{ auth()->user()->name }}</p>
        <p class="text-sm text-gray-500">Super Admin</p>
      </div>
    </header>

    <div class="p-8">
      @yield('content')
    </div>
  </main>

</body>
</html>
