<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Hously</title>
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
    body { background-color: #F5F9FF; }
  </style>
</head>
<body class="min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="bg-white shadow-sm">
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
          <a href="{{ route('home') }}" class="text-dark hover:text-primary transition-colors">Home</a>
          <a href="{{ route('home') }}#properties" class="text-dark hover:text-primary transition-colors">Properties</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sign Up Form -->
  <main class="flex-1 flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-lg p-8">

        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-accent rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
          </div>
          <h1 class="text-2xl font-bold text-dark">Create Account</h1>
          <p class="text-gray-500 mt-2">Join Hously and find your dream home</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
          @csrf

          {{-- Name --}}
          <div class="form-control">
            <label class="label" for="name">
              <span class="label-text text-dark font-medium">Full Name</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </span>
              <input id="name" type="text" name="name" value="{{ old('name') }}"
                     placeholder="John Doe" required autofocus autocomplete="name"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full pl-12 @error('name') border-red-400 @enderror" />
            </div>
            @error('name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Email --}}
          <div class="form-control">
            <label class="label" for="email">
              <span class="label-text text-dark font-medium">Email Address</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </span>
              <input id="email" type="email" name="email" value="{{ old('email') }}"
                     placeholder="you@example.com" required autocomplete="username"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full pl-12 @error('email') border-red-400 @enderror" />
            </div>
            @error('email')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Password --}}
          <div class="form-control">
            <label class="label" for="password">
              <span class="label-text text-dark font-medium">Password</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
              </span>
              <input id="password" type="password" name="password"
                     placeholder="Create a password" required autocomplete="new-password"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full pl-12 @error('password') border-red-400 @enderror" />
            </div>
            <label class="label">
              <span class="label-text-alt text-gray-500">Must be at least 8 characters</span>
            </label>
            @error('password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Confirm Password --}}
          <div class="form-control">
            <label class="label" for="password_confirmation">
              <span class="label-text text-dark font-medium">Confirm Password</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
              </span>
              <input id="password_confirmation" type="password" name="password_confirmation"
                     placeholder="Confirm your password" required autocomplete="new-password"
                     class="input input-bordered bg-background border-accent focus:border-primary rounded-xl w-full pl-12" />
            </div>
          </div>

          <button type="submit" class="btn bg-primary hover:bg-secondary text-white border-none rounded-xl w-full h-12">
            Create Account
          </button>
        </form>

        <p class="text-center text-gray-500 mt-6">
          Already have an account?
          <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Sign in</a>
        </p>

      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-accent py-6">
    <div class="max-w-[1280px] mx-auto px-6 text-center text-gray-500">
      <p>&copy; 2024 Hously. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>