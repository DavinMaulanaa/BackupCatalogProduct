<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Collarbone')</title>
  <link rel="icon" href="{{ asset('img/collarbone.jpg') }}">
  <meta name="description"
    content="Purwokerto-based unisex streetwear brand focused on quality, comfort, and timeless design.">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('dist/output.css') }}">

  @stack('styles')
</head>

<body class="bg-white text-neutral-900 antialiased">

  <!-- Accent Bar -->
  <div class="h-1.5 accent-bar"></div>

  <!-- Header -->
  <header
    class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm transition-all duration-300 border-b border-neutral-200/50">
    <div class="flex items-center justify-between px-6 lg:px-12 h-[4.5rem]">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="flex items-center group">
        <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone Logo"
          class="h-10 w-auto object-contain group-hover:opacity-80 transition-opacity duration-300 rounded-full">
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center gap-10">
        <a href="{{ url('/') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase @if(Request::is('/')) text-orbis-teal @else text-neutral-900 @endif transition-colors group-hover:text-orbis-teal">Dashboard</span>
          <span
            class="absolute bottom-0 left-0 @if(Request::is('/')) w-full @else w-0 @endif h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
        <a href="{{ route('new_arrivals') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase @if(Route::currentRouteName() == 'new_arrivals') text-orbis-teal @else text-neutral-900 @endif transition-colors group-hover:text-orbis-teal">New
            Arrivals</span>
          <span
            class="absolute bottom-0 left-0 @if(Route::currentRouteName() == 'new_arrivals') w-full @else w-0 @endif h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
        <a href="{{ route('categories') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase @if(Route::currentRouteName() == 'categories') text-orbis-teal @else text-neutral-900 @endif transition-colors group-hover:text-orbis-teal">Categories</span>
          <span
            class="absolute bottom-0 left-0 @if(Route::currentRouteName() == 'categories') w-full @else w-0 @endif h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
      </nav>

      <!-- Mobile Menu Toggle -->
      <button id="menuToggle" class="lg:hidden group p-2 hover:bg-neutral-100 rounded-full transition-colors">
        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
          class="group-hover:stroke-orbis-teal transition-colors">
          <line x1="3" x2="21" y1="6" y2="6" />
          <line x1="3" x2="21" y1="12" y2="12" />
          <line x1="3" x2="21" y1="18" y2="18" />
        </svg>
        <svg id="closeIcon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
          class="group-hover:stroke-orbis-teal transition-colors">
          <path d="M18 6 6 18" />
          <path d="m6 6 12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Navigation -->
    <nav id="mobileMenu"
      class="lg:hidden hidden absolute top-full left-0 right-0 bg-white/95 backdrop-blur-md border-b border-neutral-200 animate-slide-in shadow-lg">
      <div class="py-8 px-6 space-y-6 flex flex-col items-center">
        <a href="{{ url('/') }}"
          class="text-sm font-medium tracking-[0.2em] uppercase hover:text-orbis-teal transition-colors relative group">
          Dashboard
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-orbis-teal transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('new_arrivals') }}"
          class="text-sm font-medium tracking-[0.2em] uppercase hover:text-orbis-teal transition-colors relative group">
          New Arrivals
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-orbis-teal transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('categories') }}"
          class="text-sm font-medium tracking-[0.2em] uppercase hover:text-orbis-teal transition-colors relative group">
          Categories
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-orbis-teal transition-all duration-300 group-hover:w-full"></span>
        </a>
      </div>
    </nav>
  </header>

  @yield('content')

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 bg-black">
    <div class="w-full mx-auto px-4 max-w-[1400px] py-12 text-center">
      <p class="text-xs text-gray-500">
        © 2026 Collarbone. Banyumas.
      </p>
    </div>
  </footer>

  <!-- JavaScript for interactivity -->
  <script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    if (menuToggle) {
      menuToggle.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.contains('hidden');
        if (isHidden) {
          mobileMenu.classList.remove('hidden');
          mobileMenu.classList.add('animate-slide-in');
          mobileMenu.classList.remove('animate-slide-out');
        } else {
          mobileMenu.classList.add('animate-slide-out');
          mobileMenu.classList.remove('animate-slide-in');

          mobileMenu.addEventListener('animationend', () => {
            if (mobileMenu.classList.contains('animate-slide-out')) {
              mobileMenu.classList.add('hidden');
              mobileMenu.classList.remove('animate-slide-out');
            }
          }, { once: true });
        }
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
      });
    }
  </script>
  @stack('scripts')
</body>

</html>
