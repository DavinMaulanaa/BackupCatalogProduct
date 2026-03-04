<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Collarbone - Categories</title>
    <link rel="icon" type="image/png" href="{{ asset('img/collarbone.jpg') }}">
    <meta name="description" content="Explore our curated T-shirt collections." />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
                    },
                    letterSpacing: {
                        'widest': '0.15em',
                        'super': '0.3em',
                        'mega': '0.5em',
                    },
                    colors: {
                        orbis: {
                            teal: '#2a9d9d',
                            charcoal: '#262626',
                        }
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        },
                        slideOut: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        }
                    },
                    animation: {
                        'slide-in': 'slideIn 0.4s ease-out forwards',
                        'slide-out': 'slideOut 0.4s ease-in forwards',
                    }
                },
            },
        }
    </script>

    <style>
        * {
            border-color: hsl(0 0% 90%);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Scroll Animation Base Styles */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card-zoom-image {
            transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .group:hover .card-zoom-image {
            transform: scale(1.05);
        }

        /* Staggered transition delays */
        .delay-100 {
            transition-delay: 100ms;
        }

        .delay-200 {
            transition-delay: 200ms;
        }

        .delay-300 {
            transition-delay: 300ms;
        }

        /* Flip Card Styles */
        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }

        .backface-hidden {
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .rotate-y-180 {
            transform: rotateY(180deg);
        }

        /* ===== TikTok-Style Image Slider ===== */
        .product-slider {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            touch-action: pan-y;
        }

        .product-slider-track {
            display: flex;
            width: 100%;
            height: 100%;
            transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }

        .product-slider-track.is-dragging {
            transition: none;
        }

        .product-slider-slide {
            min-width: 100%;
            width: 100%;
            height: 100%;
            flex-shrink: 0;
        }

        .product-slider-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
        }

        /* Dot Indicators */
        .slider-dots {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 6px;
            z-index: 10;
            padding: 4px 8px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(4px);
        }

        .slider-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.45);
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            padding: 0;
        }

        .slider-dot.active {
            background: #ffffff;
            transform: scale(1.3);
            box-shadow: 0 0 4px rgba(255, 255, 255, 0.5);
        }

        /* Slide counter (optional) */
        .slider-counter {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            font-size: 11px;
            font-weight: 500;
            color: white;
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(4px);
            padding: 2px 8px;
            border-radius: 10px;
            letter-spacing: 0.05em;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-white text-black">

    <!-- Header -->
    <header
        class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm transition-all duration-300 border-b border-neutral-200/50">
        <div class="flex items-center justify-between px-6 lg:px-12 h-[4.5rem]">
            <a href="/" class="flex items-center group">
                <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone Logo"
                    class="h-10 w-auto object-contain group-hover:opacity-80 transition-opacity duration-300 rounded-full">
            </a>

            <nav class="hidden lg:flex items-center gap-10">
                <a href="{{ route('home') }}" class="relative group py-2 block">
                    <span
                        class="text-xs font-medium tracking-[0.15em] uppercase text-neutral-900 transition-colors group-hover:text-orbis-teal">Dashboard</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
                <a href="{{ route('new_arrivals') }}" class="relative group py-2 block">
                    <span
                        class="text-xs font-medium tracking-[0.15em] uppercase text-neutral-900 transition-colors group-hover:text-orbis-teal">New
                        Arrivals</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
                <a href="{{ route('categories') }}" class="relative group py-2 block">
                    <span
                        class="text-xs font-medium tracking-[0.15em] uppercase text-orbis-teal transition-colors group-hover:text-orbis-teal">Categories</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
            </nav>
            <button id="menuToggle" class="lg:hidden group p-2 hover:bg-neutral-100 rounded-full transition-colors">
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="group-hover:stroke-orbis-teal transition-colors">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg id="closeIcon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" class="group-hover:stroke-orbis-teal transition-colors">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <nav id="mobileMenu"
            class="lg:hidden hidden absolute top-full left-0 right-0 bg-white/95 backdrop-blur-md border-b border-neutral-200 animate-slide-in shadow-lg">
            <div class="py-8 px-6 space-y-6 flex flex-col items-center">
                <a href="{{ route('home') }}"
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

    <!-- Main Content -->
    <main class="flex-1 w-full overflow-hidden">

        <!-- SECTION 1: GREETINGS (HERO) -->
        <section class="h-[60vh] md:h-[80vh] relative flex items-center justify-center overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1920&q=80"
                    alt="Categories Hero" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-neutral-900/40"></div>
            </div>

            <div class="relative z-10 text-center text-white px-6 max-w-4xl mx-auto">
                <p class="reveal-on-scroll text-xs tracking-mega mb-4 text-white/80">EST. 2024</p>
                <h1 class="reveal-on-scroll delay-100 text-4xl md:text-7xl font-light tracking-widest mb-6">THE ARCHIVE
                </h1>
                <p
                    class="reveal-on-scroll delay-200 text-sm md:text-base font-light tracking-wide leading-relaxed max-w-2xl mx-auto text-white/90">
                    Welcome to the complete catalog. Explore our dedicated collections of premium streetwear essentials
                    and exclusive accessories.
                </p>
            </div>
        </section>

        <!-- SECTION 2: T-SHIRT EXPLANATION -->
        <section class="py-20 md:py-32 bg-white">
            <div
                class="max-w-[1400px] mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-24 items-center">
                <div class="reveal-on-scroll order-2 md:order-1">
                    <span class="text-xs tracking-mega text-neutral-500 block mb-4">01. PRODUCT</span>
                    <h2 class="text-3xl md:text-5xl font-light tracking-wide mb-8 text-neutral-900">PREMIUM
                        COTTON<br>T-SHIRTS</h2>
                    <div class="space-y-6 text-sm text-neutral-600 leading-relaxed font-light">
                        <p>
                            Crafted from heavyweight 100% cotton, our t-shirts are designed to stand the test of time.
                            The fabric is pre-shrunk and treated with a vintage wash process to ensure a soft, broken-in
                            feel from the very first wear.
                        </p>
                        <p>
                            Featuring a relaxed, boxy fit with dropped shoulders and a high ribbed collar,
                            these tees define the modern streetwear silhouette. Available in a range of earth tones and
                            monochromatic staples.
                        </p>
                    </div>
                </div>
                <div class="reveal-on-scroll delay-100 order-1 md:order-2 relative aspect-[3/4] overflow-hidden group">
                    <img src="{{ 'img/1.png' }}" alt="T-Shirt Detail"
                        class="w-full h-full object-cover card-zoom-image bg-neutral-100">
                </div>
            </div>
        </section>

        <!-- SECTION 3: PIN BUTTON EXPLANATION -->
        <section class="py-20 md:py-32 bg-neutral-50">
            <div
                class="max-w-[1400px] mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-24 items-center">
                <div class="reveal-on-scroll relative aspect-square overflow-hidden group">
                    <img src="{{ asset('img/merchBG.png') }}" alt="Pin Button Detail"
                        class="w-full h-full object-cover card-zoom-image bg-neutral-200">
                </div>
                <div class="reveal-on-scroll delay-100 md:pl-12">
                    <span class="text-xs tracking-mega text-neutral-500 block mb-4">02. ACCESSORIES</span>
                    <h2 class="text-3xl md:text-5xl font-light tracking-wide mb-8 text-neutral-900">SIGNATURE<br>PIN
                        BUTTONS</h2>
                    <div class="space-y-6 text-sm text-neutral-600 leading-relaxed font-light">
                        <p>
                            Add a personal touch to your gear with our exclusive collection of pin buttons.
                            Each pin features unique artwork designed in-house, reflecting the culture and spirit of
                            Jakarta's streets.
                        </p>
                        <p>
                            Made with high-quality metal components and a durable matte finish,
                            these pins are perfect for customizing your jackets, bags, or caps. Collect them all to tell
                            your own story.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: T-SHIRT PRODUCTS GRID -->
        <section class="py-20 md:py-32 px-6 lg:px-12 bg-white" id="tshirt-section">
            <div class="max-w-[1400px] mx-auto">
                <div class="flex items-end justify-between mb-12 reveal-on-scroll">
                    <div>
                        <span class="text-xs tracking-mega text-neutral-500 block mb-2">COLLECTION</span>
                        <h2 class="text-2xl md:text-4xl font-light tracking-wide text-neutral-900">T-SHIRTS</h2>
                    </div>
                    <button id="viewAllTeesBtn"
                        class="text-xs border-b border-neutral-900 pb-1 hover:text-neutral-500 transition-colors uppercase tracking-widest bg-transparent cursor-pointer">View
                        All Tees</button>
                </div>

                <div id="tshirtGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-10">
                    
                    @foreach($tshirts as $index => $product)
                    <article class="group cursor-pointer tshirt-card 
                        @if($loop->index < 4) reveal-on-scroll @endif 
                        @if($loop->index >= 4) tshirt-hidden hidden opacity-0 transform translate-y-8 @endif
                        delay-{{ ($loop->index % 4) * 100 }}">
                        
                        <div class="perspective-1000 mb-4">
                            <div class="relative transition-all duration-700 transform-style-3d w-full aspect-[3/4]">
                                <div class="absolute inset-0 backface-hidden bg-neutral-100 overflow-hidden border-2 border-black rounded-sm">
                                    <div class="product-slider" data-slider>
                                        <div class="product-slider-track">
                                            @if(!empty($product->image_urls))
                                                @foreach($product->image_urls as $img)
                                                <div class="product-slider-slide">
                                                    <img src="{{ Str::startsWith($img, 'http') ? $img : asset($img) }}" alt="{{ $product->name }}">
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="product-slider-slide">
                                                    <img src="{{ asset('img/placeholder.jpg') }}" alt="Placeholder">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="slider-dots"></div>
                                        <div class="slider-counter">1 / {{ is_array($product->image_urls) ? count($product->image_urls) : 0 }}</div>
                                    </div>
                                </div>
                                <div
                                    class="absolute inset-0 backface-hidden rotate-y-180 bg-white border border-neutral-100 p-6 flex flex-col items-center justify-center text-center rounded-sm">
                                    <h3 class="text-xs font-medium uppercase tracking-widest mb-4">{{ Str::before($product->name, ' -') }}</h3>
                                    <p class="text-xs text-neutral-500 leading-relaxed mb-6">{{ Str::limit($product->description, 60) }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] tracking-widest text-neutral-500 mb-1">T-SHIRTS</p>
                        <h3 class="text-sm font-medium text-neutral-900 mb-1">{{ $product->name }}</h3>
                        <div class="flex items-end justify-between mb-2">
                            <div>
                                <p class="text-sm font-medium mb-1">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                                <div class="flex gap-2 text-[10px] font-medium tracking-wider">
                                     @foreach($product->sizes ?? ['S','M','L','XL'] as $size)
                                        <span class="text-green-600">{{ $size }}</span>
                                     @endforeach
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <div class="flex gap-1">
                                     @php
                                        $colorName = $product->colors[0] ?? 'Black';
                                        $colorHex = match(strtolower($colorName)) {
                                            'black' => '#000000',
                                            'white' => '#ffffff',
                                            'grey' => '#808080',
                                            'cream' => '#E5D0B1',
                                            'navy' => '#000080',
                                            'olive' => '#808000',
                                            'blue' => '#0000ff',
                                            'charcoal' => '#36454F',
                                            default => '#000000'
                                        };
                                     @endphp
                                    <span class="w-3 h-3 rounded-full border border-neutral-200"
                                        style="background-color: {{ $colorHex }}"
                                        title="{{ $colorName }}"></span>
                                </div>
                                <button
                                    class="details-btn uppercase tracking-widest px-3 py-1.5 border border-neutral-900 bg-white hover:bg-neutral-900 text-neutral-900 hover:text-white transition-all duration-300 rounded-sm text-[10px] font-medium">Details</button>
                            </div>
                        </div>
                    </article>
                    @endforeach

                </div>
            </div>
        </section>

        <!-- SECTION 5: PIN BUTTON PRODUCTS GRID -->
        <section class="py-20 md:py-32 px-6 lg:px-12 bg-neutral-50">
            <div class="max-w-[1400px] align-center mx-auto">
                <div class="flex items-end justify-between mb-12 reveal-on-scroll">
                    <div>
                        <span class="text-xs tracking-mega text-neutral-500 block mb-2">COLLECTION</span>
                        <h2 class="text-2xl md:text-4xl font-light tracking-wide text-neutral-900">PIN BUTTONS</h2>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-10 align-center ">
                   
                   @foreach($pins as $pin)
                    <article class="group cursor-pointer reveal-on-scroll delay-{{ ($loop->index % 3) * 100 }}">
                        <div class="perspective-1000 mb-4 rounded-lg border-2 border-gray-200 p-2 bg-white">
                            <div class="relative transition-all duration-700 transform-style-3d w-full aspect-square">
                                <div class="absolute inset-0 bg-white overflow-hidden rounded-full border border-neutral-100 shadow-sm hover:shadow-md transition-shadow">
                                    <img src="{{ $pin->thumbnail ?? asset('img/placeholder.jpg') }}" alt="{{ $pin->name }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 p-2">
                                </div>
                                <div class="absolute inset-0 backface-hidden rotate-y-180 bg-white border border-neutral-100 p-4 flex flex-col items-center justify-center text-center rounded-full shadow-sm">
                                    <h3 class="text-xs font-medium uppercase tracking-widest mb-2">{{ $pin->name }}</h3>
                                    <p class="text-[10px] text-neutral-500 leading-relaxed mb-4">{{ Str::limit($pin->description, 50) }}</p>
                                    <button class="text-[10px] border-b border-black pb-0.5 hover:text-neutral-500 transition-colors uppercase tracking-widest back-btn">Back</button>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-center text-neutral-900 mb-1">{{ $pin->name }}</h3>
                        <div class="flex flex-col items-center gap-1">
                            <p class="text-xs text-center text-neutral-500">IDR {{ number_format($pin->price, 0, ',', '.') }}</p>
                            <button class="details-btn uppercase tracking-widest px-3 py-1.5 border border-neutral-900 bg-white hover:bg-neutral-900 text-neutral-900 hover:text-white transition-all duration-300 rounded-sm text-[10px] font-medium mt-1">Details</button>
                        </div>
                    </article>
                    @endforeach

                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 bg-black">
        <div class="w-full mx-auto px-4 max-w-[1400px] py-12 text-center">
            <p class="text-xs text-gray-500">
                © 2026 Collarbone. Banyumas.
            </p>
        </div>
    </footer>

    <!-- Scroll Animation Script -->
    <script>
        // ===== TikTok-Style Product Slider =====
        class ProductSlider {
            constructor(el) {
                this.el = el;
                this.track = el.querySelector('.product-slider-track');
                this.slides = el.querySelectorAll('.product-slider-slide');
                this.dotsContainer = el.querySelector('.slider-dots');
                this.counter = el.querySelector('.slider-counter');
                this.currentIndex = 0;
                this.totalSlides = this.slides.length;
                this.isDragging = false;
                this.startX = 0;
                this.currentTranslate = 0;
                this.prevTranslate = 0;
                this.animationID = null;

                if (this.totalSlides > 0) this.init();
            }

            init() {
                // Create dots
                for (let i = 0; i < this.totalSlides; i++) {
                    const dot = document.createElement('button');
                    dot.classList.add('slider-dot');
                    if (i === 0) dot.classList.add('active');
                    dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                    dot.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.goToSlide(i);
                    });
                    this.dotsContainer.appendChild(dot);
                }

                // Touch events
                this.el.addEventListener('touchstart', this.touchStart.bind(this), { passive: true });
                this.el.addEventListener('touchmove', this.touchMove.bind(this), { passive: false });
                this.el.addEventListener('touchend', this.touchEnd.bind(this));

                // Mouse events (for desktop)
                this.el.addEventListener('mousedown', this.touchStart.bind(this));
                this.el.addEventListener('mousemove', this.touchMove.bind(this));
                this.el.addEventListener('mouseup', this.touchEnd.bind(this));
                this.el.addEventListener('mouseleave', () => {
                    if (this.isDragging) this.touchEnd();
                });

                // Prevent context menu on long press
                this.el.addEventListener('contextmenu', (e) => e.preventDefault());
            }

            getPositionX(event) {
                return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
            }

            touchStart(event) {
                this.isDragging = true;
                this.startX = this.getPositionX(event);
                this.track.classList.add('is-dragging');
                this.animationID = requestAnimationFrame(this.animation.bind(this));
            }

            touchMove(event) {
                if (!this.isDragging) return;
                const currentX = this.getPositionX(event);
                const diff = currentX - this.startX;
                this.currentTranslate = this.prevTranslate + diff;

                // Prevent default to stop page scrolling while swiping horizontally
                if (Math.abs(diff) > 5) {
                    event.preventDefault();
                }
            }

            touchEnd() {
                this.isDragging = false;
                cancelAnimationFrame(this.animationID);
                this.track.classList.remove('is-dragging');

                const movedBy = this.currentTranslate - this.prevTranslate;
                const threshold = this.el.offsetWidth * 0.15; // 15% swipe threshold

                if (movedBy < -threshold && this.currentIndex < this.totalSlides - 1) {
                    this.currentIndex++;
                } else if (movedBy > threshold && this.currentIndex > 0) {
                    this.currentIndex--;
                }

                this.setPositionByIndex();
                this.updateDots();
                this.updateCounter();
            }

            animation() {
                this.setSliderPosition();
                if (this.isDragging) {
                    requestAnimationFrame(this.animation.bind(this));
                }
            }

            setSliderPosition() {
                this.track.style.transform = `translateX(${this.currentTranslate}px)`;
            }

            setPositionByIndex() {
                this.currentTranslate = this.currentIndex * -this.el.offsetWidth;
                this.prevTranslate = this.currentTranslate;
                this.track.style.transform = `translateX(${this.currentTranslate}px)`;
            }

            goToSlide(index) {
                this.currentIndex = index;
                this.setPositionByIndex();
                this.updateDots();
                this.updateCounter();
            }

            updateDots() {
                const dots = this.dotsContainer.querySelectorAll('.slider-dot');
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === this.currentIndex);
                });
            }

            updateCounter() {
                if (this.counter) {
                    this.counter.textContent = `${this.currentIndex + 1} / ${this.totalSlides}`;
                }
            }
        }

        // Simple Intersection Observer for scroll animations
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // Only animate once
                    }
                });
            }, observerOptions);

            const elements = document.querySelectorAll('.reveal-on-scroll');
            elements.forEach(el => observer.observe(el));

            // Initialize Sliders
            document.querySelectorAll('[data-slider]').forEach(slider => {
                new ProductSlider(slider);
            });

            // View All Tees Button Handler
            const viewAllTeesBtn = document.getElementById('viewAllTeesBtn');
            // We need to re-select these when button is clicked because dynamic implementation might differ slightly
            // But here we rely on the classes added in the loop
            let teesExpanded = false;

            if (viewAllTeesBtn) {
                viewAllTeesBtn.addEventListener('click', () => {
                   const hiddenTshirts = document.querySelectorAll('.tshirt-hidden'); // Select dynamically here

                    if (!teesExpanded) {
                        // Show hidden products with staggered animation
                        hiddenTshirts.forEach((card, index) => {
                            card.classList.remove('hidden');
                            
                            // Small delay to ensure display:none is removed before opacity transition
                            requestAnimationFrame(() => {
                                setTimeout(() => {
                                    card.classList.remove('opacity-0', 'translate-y-8');
                                    card.classList.add('opacity-100', 'translate-y-0');
                                    card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                                }, index * 100); 
                            });
                        });

                        viewAllTeesBtn.textContent = 'Show Less';
                        teesExpanded = true;
                    } else {
                        // Hide products with animation
                        hiddenTshirts.forEach((card, index) => {
                            card.classList.remove('opacity-100', 'translate-y-0');
                            card.classList.add('opacity-0', 'translate-y-8');

                            // Hide after animation completes
                            setTimeout(() => {
                                card.classList.add('hidden');
                            }, 600);
                        });

                        viewAllTeesBtn.textContent = 'View All Tees';
                        teesExpanded = false;
                    }
                });
            }
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                const menuIcon = document.getElementById('menuIcon');
                const closeIcon = document.getElementById('closeIcon');

                if (isHidden) {
                    // Open
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('animate-slide-in');
                    mobileMenu.classList.remove('animate-slide-out');
                    if (menuIcon) menuIcon.classList.add('hidden');
                    if (closeIcon) closeIcon.classList.remove('hidden');
                } else {
                    // Close
                    mobileMenu.classList.add('animate-slide-out');
                    mobileMenu.classList.remove('animate-slide-in');

                    mobileMenu.addEventListener('animationend', () => {
                        if (mobileMenu.classList.contains('animate-slide-out')) {
                            mobileMenu.classList.add('hidden');
                            mobileMenu.classList.remove('animate-slide-out');
                        }
                    }, { once: true });

                    if (menuIcon) menuIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                }
            });
        }

        // Flip Card Logic
        document.addEventListener('DOMContentLoaded', () => {
            // Flip Card Logic - Combined Details/Back Button
            document.querySelectorAll('.details-btn, .back-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const article = btn.closest('article');
                    const cardInner = article ? article.querySelector('.transform-style-3d') : null;

                    if (cardInner) {
                       // Find the details button specifically if clicked back button
                       const detailsBtn = article.querySelector('.details-btn');
                       
                        // Animate button
                        if(detailsBtn) detailsBtn.classList.add('opacity-0', 'scale-90');

                        // Toggle flip immediately
                        const isFlippingToBack = !cardInner.classList.contains('rotate-y-180');
                        if (isFlippingToBack) {
                            cardInner.classList.add('rotate-y-180');
                        } else {
                            cardInner.classList.remove('rotate-y-180');
                        }

                        // Change text after fade out
                        setTimeout(() => {
                            if(detailsBtn) {
                                detailsBtn.textContent = isFlippingToBack ? 'Back' : 'Details';
                                detailsBtn.classList.remove('opacity-0', 'scale-90');
                            }
                        }, 300);
                    }
                });
            });
        });
    </script>

</body>

</html>
