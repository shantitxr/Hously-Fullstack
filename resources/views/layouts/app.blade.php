
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Hously')</title>
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
          <a href="{{ route('home') }}#properties" class="text-dark hover:text-primary transition-colors">Properties</a>
          @auth
            <a href="{{ route('wishlist.index') }}" class="text-dark hover:text-primary transition-colors">Wishlist</a>
          @endauth
        </div>
        <div class="flex items-center gap-3">
          @auth
            <a href="{{ route('dashboard') }}" class="btn btn-ghost text-dark hover:bg-accent">Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="btn btn-ghost text-dark hover:bg-accent">Login</a>
            <a href="{{ route('register') }}" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl">Sign Up</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Page content goes here -->
  @yield('content')

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
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Contact</h4>
          <ul class="space-y-2 text-gray-400">
            <li>contact@hously.com</li>
            <li>Budapest, Hungary</li>
          </ul>
        </div>
      </div>
      <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
        <p>&copy; {{ date('Y') }} Hously. All rights reserved.</p>
      </div>
    </div>
  </footer>

</body>
</html>
