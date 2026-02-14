@extends('layouts.frontend')

@section('title', 'Collarbone')

@push('styles')
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
          },
          colors: {
            orbis: {
              teal: '#2a9d9d',
              'dark-teal': '#1a6b6b',
              charcoal: '#262626',
              grey: '#808080',
              'light-grey': '#f5f5f5',
            },
          },
          letterSpacing: {
            'orbis': '0.3em',
            'orbis-wide': '0.5em',
          },
          animation: {
            'fade-up': 'fadeUp 0.8s ease-out',
            'slide-in': 'slideIn 0.4s ease-out',
            'slide-out': 'slideOut 0.4s ease-in forwards',
            'marquee': 'marquee 40s linear infinite',
          },
          keyframes: {
            fadeUp: {
              '0%': { opacity: '0', transform: 'translateY(20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            slideIn: {
              '0%': { transform: 'translateX(-100%)' },
              '100%': { transform: 'translateX(0)' },
            },
            slideOut: {
              '0%': { transform: 'translateX(0)' },
              '100%': { transform: 'translateX(-100%)' },
            },
            marquee: {
              '0%': { transform: 'translateX(0)' },
              '100%': { transform: 'translateX(-50%)' },
            },
          },
        },
      },
    }
</script>
<style>
    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', system-ui, sans-serif;
    }


    /* Hero overlay */
    .hero-overlay {
      background: linear-gradient(to top, rgba(0, 0, 0, 0.3), transparent, transparent);
    }

    /* Slider dots */
    .slider-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.4);
      transition: all 0.3s;
      cursor: pointer;
    }

    .slider-dot.active {
      background: white;
    }

    /* Hide scrollbar */
    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Scroll Reveal Animation */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all 1s cubic-bezier(0.5, 0, 0, 1);
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

    /* Stagger delays */
    .delay-100 {
      transition-delay: 0.1s;
    }

    .delay-200 {
      transition-delay: 0.2s;
    }

    .delay-300 {
      transition-delay: 0.3s;
    }

    /* Hero Image Zoom */
    .slide img {
      transition: transform 8s ease;
      transform: scale(1);
    }

    .slide.active img {
      transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<main>
    <!-- Hero Slider -->
    <section id="heroSlider" class="relative h-[calc(100vh-4.5rem-0.375rem)] overflow-hidden">
      <!-- Slides -->
      <div class="slide active absolute inset-0 transition-opacity duration-1000 opacity-100">
        <img src="{{ asset('img/baju.jpg') }}" alt="Straight edge" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
      </div>
      <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0">
        <img src="{{ asset('img/7.png') }}" alt="Room for Air Collection" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
      </div>
      <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0">
        <img src="{{ asset('img/MerchBG.png') }}" alt="Wooden Sun Collection" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
      </div>
      <!-- Content -->
      <div class="absolute bottom-16 left-6 lg:left-12 z-10">
        <p id="slideLabel" class="text-white text-xs tracking-orbis-wide mb-2 animate-fade-up">NEW ARRIVALS</p>
        <h2 id="slideTitle" class="text-white text-3xl lg:text-5xl font-light tracking-orbis mb-6 animate-fade-up">
          T Shirt</h2>
        <a href="#"
          class="inline-flex items-center justify-center px-8 py-3 text-xs font-medium tracking-[0.2em] uppercase bg-white text-neutral-900 border border-white hover:bg-neutral-900 hover:text-white transition-all duration-300">ORDER
          NOW</a>
      </div>
      <!-- Dots Navigation -->
      <div class="absolute bottom-16 right-6 lg:right-12 flex gap-3 z-10">
        <button class="slider-dot active" data-slide="0"></button>
        <button class="slider-dot" data-slide="1"></button>
        <button class="slider-dot" data-slide="2"></button>
      </div>
    </section>

    <!-- Collection Grid -->
    <section class="py-16 lg:py-24 px-6 lg:px-12 text-black">
      <div class="flex items-center justify-between mb-12 reveal">
        <h2 class="text-xl lg:text-2xl font-light tracking-orbis">COLLECTIONS</h2>
      </div>
      <div class="text-black grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        @forelse($collections as $index => $collection)
        <a href="{{ $collection->link ?? '#' }}" class="group relative aspect-[3/4] overflow-hidden reveal delay-{{ ($index + 1) * 100 }} rounded-lg">
          <img src="{{ $collection->image_url }}" alt="{{ $collection->title }}"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 bg-gray-200">
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
          <div class="absolute bottom-6 left-6">
            <p class="text-white text-xs tracking-orbis-wide mb-2">{{ $collection->subtitle ?? 'CATEGORY' }}</p>
            <h3 class="text-white text-xl lg:text-2xl font-light tracking-orbis">{{ $collection->title }}</h3>
          </div>
        </a>
        @empty
        <div class="col-span-3 text-center py-12 text-neutral-400">Belum ada collection</div>
        @endforelse
      </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 lg:py-24 px-6 lg:px-12">
      <div class="flex items-center justify-between mb-12 reveal">
        <h2 class="text-xl lg:text-2xl font-light tracking-orbis">FEATURED</h2>
      </div>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Product 1 -->
        <a href="#" class="group reveal delay-100 block">
          <div
            class="aspect-square overflow-hidden mb-4 rounded-sm bg-neutral-100 relative shadow-sm group-hover:shadow-md transition-all duration-300 border-2 border-black">
            <img src="{{ asset('img/2_DEPAN.png') }}" alt="Graphic Tee"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 ">
          </div>
          <p class="text-[10px] tracking-orbis text-neutral-500 mb-1">T-SHIRTS</p>
          <h3 class="text-sm font-medium text-neutral-900 mb-1 group-hover:text-orbis-teal transition-colors">Straight
            Edge - Black
            Edition</h3>
          <p class="text-sm font-medium text-neutral-900">IDR 180,000</p>
        </a>
        <!-- Product 2 -->
        <a href="#" class="group reveal delay-200 block">
          <div
            class="aspect-square overflow-hidden mb-4 rounded-sm bg-neutral-100 relative shadow-sm group-hover:shadow-md transition-all duration-300 border-2 border-black">
            <img src="{{ asset('img/3_DEPAN.png') }}" alt="Essential Hoodie"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
          </div>
          <p class="text-[10px] tracking-orbis text-neutral-500 mb-1">T-SHIRTS</p>
          <h3 class="text-sm font-medium text-neutral-900 mb-1 group-hover:text-orbis-teal transition-colors">Straight
            Edge - Green
            Edition</h3>
          <p class="text-sm font-medium text-neutral-900">IDR 850,000</p>
        </a>
        <!-- Product 3 -->
        <a href="#" class="group reveal delay-300 block">
          <div
            class="aspect-square overflow-hidden mb-4 rounded-sm bg-neutral-100 relative shadow-sm group-hover:shadow-md transition-all duration-300 border-2 border-black">
            <img src="{{ asset('img/5_DEPAN.png') }}" alt="Vintage Cap"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
          </div>
          <p class="text-[10px] tracking-orbis text-neutral-500 mb-1">T-SHIRTS</p>
          <h3 class="text-sm font-medium text-neutral-900 mb-1 group-hover:text-orbis-teal transition-colors">Adalah
            Pokonya</h3>
          <p class="text-sm font-medium text-neutral-900">IDR 320,000</p>
        </a>
        <!-- Product 4 -->
        <a href="#" class="group reveal delay-100 block">
          <div
            class="aspect-square overflow-hidden mb-4 rounded-sm bg-neutral-100 relative shadow-sm group-hover:shadow-md transition-all duration-300 border-2 border-black">
            <img src="{{ asset('img/Merch-3.jpeg') }}" alt="Oversized Tee"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
          </div>
          <p class="text-[10px] tracking-orbis text-neutral-500 mb-1">Pin Button</p>
          <h3 class="text-sm font-medium text-neutral-900 mb-1 group-hover:text-orbis-teal transition-colors">Bundling
            Pin Button</h3>
          <p class="text-sm font-medium text-neutral-900">IDR 20,000</p>
        </a>
      </div>
    </section>

    <!-- Brand Banner -->
    <section class="relative h-[60vh] lg:h-[80vh] overflow-hidden">
      <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&q=80" alt="Brand Story"
        class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-neutral-900/40"></div>

      <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 reveal">
        <div
          class="bg-neutral-900/30 backdrop-blur-md p-8 md:p-12 rounded-xl max-w-4xl mx-auto border border-white/10 shadow-2xl">
          <p class="text-white text-xs tracking-orbis-wide mb-4">Collarbone</p>
          <h2 class="text-white text-3xl lg:text-5xl font-light tracking-orbis mb-6">TIMELESS STREETWEAR FOR THE
            MODERN ERA</h2>
          <a href="{{ route('categories') }}"
            class="inline-flex items-center justify-center px-8 py-3 text-xs font-medium tracking-[0.2em] uppercase bg-white text-neutral-900 border border-white hover:bg-transparent hover:text-white hover:border-white transition-all duration-300">DISCOVER
            MORE</a>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 lg:py-24 px-6 lg:px-12 reveal">
      <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-xl lg:text-2xl font-light tracking-orbis mb-4">JOIN THE CIRCLE</h2>
        <p class="text-sm text-neutral-500 mb-8">Subscribe to receive updates on new arrivals, exclusive offers, and
          more.</p>

        <form class="flex flex-col sm:flex-row gap-4">
          <input type="email" placeholder="Enter your email"
            class="flex-1 bg-transparent border-b border-neutral-900 py-3 text-sm tracking-wide placeholder:text-neutral-500 focus:outline-none focus:border-orbis-teal transition-colors">
          <button type="submit"
            class="inline-flex items-center justify-center px-8 py-3 text-xs font-medium tracking-[0.2em] uppercase bg-neutral-900 text-white border border-neutral-900 hover:bg-white hover:text-neutral-900 transition-all duration-300">
            SUBSCRIBE
          </button>
        </form>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 lg:py-28 bg-neutral-50 overflow-hidden">
      <div class="px-6 lg:px-12 mb-16 text-center reveal">
        <h2 class="text-3xl lg:text-5xl font-light tracking-orbis text-neutral-900 mb-8">What They Say
          <br>About Our's Products
        </h2>
      </div>

      <div class="relative w-full">
        <!-- Gradient Masks -->
        <div class="absolute inset-y-0 left-0 w-20 lg:w-40 bg-gradient-to-r from-neutral-50 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-20 lg:w-40 bg-gradient-to-l from-neutral-50 to-transparent z-10 pointer-events-none"></div>

        <!-- Marquee Container -->
        <div class="flex w-max animate-marquee hover:[animation-play-state:paused] items-stretch">
          <!-- Original Cards -->
          <div class="flex gap-6 mx-3">
            @foreach($testimonials as $testimonial)
            <div class="bg-white p-8 rounded-2xl shadow-sm w-[400px] flex-shrink-0 flex flex-col justify-between">
              <div>
                <svg class="w-10 h-10 text-orbis-teal mb-6 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z" />
                </svg>
                <p class="text-neutral-600 font-light leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
              </div>
              <div class="flex items-center gap-4">
                @if($testimonial->photo_url)
                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                @else
                <div class="w-12 h-12 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-500 text-lg font-semibold">{{ substr($testimonial->name, 0, 1) }}</div>
                @endif
                <div>
                  <h4 class="font-medium text-sm text-neutral-900">{{ $testimonial->name }}</h4>
                  <p class="text-xs text-neutral-500">{{ $testimonial->role }}</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Duplicate Cards (for seamless marquee loop) -->
          <div class="flex gap-6 mx-3" aria-hidden="true">
            @foreach($testimonials as $testimonial)
            <div class="bg-white p-8 rounded-2xl shadow-sm w-[400px] flex-shrink-0 flex flex-col justify-between">
              <div>
                <svg class="w-10 h-10 text-orbis-teal mb-6 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z" />
                </svg>
                <p class="text-neutral-600 font-light leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
              </div>
              <div class="flex items-center gap-4">
                @if($testimonial->photo_url)
                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                @else
                <div class="w-12 h-12 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-500 text-lg font-semibold">{{ substr($testimonial->name, 0, 1) }}</div>
                @endif
                <div>
                  <h4 class="font-medium text-sm text-neutral-900">{{ $testimonial->name }}</h4>
                  <p class="text-xs text-neutral-500">{{ $testimonial->role }}</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    // Hero slider
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const slideLabel = document.getElementById('slideLabel');
    const slideTitle = document.getElementById('slideTitle');

    const slideData = [
      { label: 'NEW ARRIVALS', title: 'Straight Edge' },
      { label: 'COLLECTION', title: 'Gatau mau di isi apa' },
      { label: 'ACCESSORIES', title: 'Button Pins' }
    ];

    let currentSlide = 0;
    function goToSlide(index) {
      slides.forEach((slide, i) => {
        slide.style.opacity = i === index ? '1' : '0';
        // Add active class for zoom effect
        if (i === index) {
          slide.classList.add('active');
        } else {
          slide.classList.remove('active');
        }
      });
      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });
      if (slideLabel) slideLabel.textContent = slideData[index].label;
      if (slideTitle) slideTitle.textContent = slideData[index].title;
      currentSlide = index;
    }
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => goToSlide(index));
    });

    // Intersection Observer for Scroll Animation
    const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          observer.unobserve(entry.target); // Only animate once
        }
      });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => {
      observer.observe(el);
    });
    // Auto-advance slider
    setInterval(() => {
      goToSlide((currentSlide + 1) % slides.length);
    }, 5000);
</script>
@endpush
