@extends('layouts.store')

@section('title', 'Otherside Official Store')

@section('content')

{{-- ─── Hero Slider ─────────────────────────────────────────────────────────── --}}
<section class="hero-slider" id="hero">
    <div class="hero-slides">

        {{-- Slide 1 --}}
        <div class="hero-slide active">
            <img src="{{ asset('img/OTHERSIDE-HERO.png') }}" alt="Otherside Hero" class="hero-slide-img">
        </div>

        {{-- Slide 2 — placeholder, bisa diganti gambar lain --}}
        <div class="hero-slide">
            <div class="hero-slide-fallback">
                <h1 class="hero-title">Otherside</h1>
                <p class="hero-subtitle">Official Store</p>
            </div>
        </div>

        {{-- Slide 3 --}}
        <div class="hero-slide">
            <div class="hero-slide-fallback">
                <h1 class="hero-title">Custom Order</h1>
                <p class="hero-subtitle">Buat desainmu sendiri</p>
            </div>
        </div>

    </div>

    {{-- Arrows --}}
    <button class="hero-arrow prev" id="heroPrev" aria-label="Previous">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="hero-arrow next" id="heroNext" aria-label="Next">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    {{-- Dots --}}
    <div class="hero-dots">
        <span class="hero-dot active" data-index="0"></span>
        <span class="hero-dot" data-index="1"></span>
        <span class="hero-dot" data-index="2"></span>
    </div>
</section>

<div class="page-wrap">

    {{-- Featured Product --}}
    @if($featured)
    <section class="section" id="featured">
        <div class="featured-card">
            <div class="featured-img-wrap">
                @if($featured->primaryImage)
                    <img src="{{ Storage::url($featured->primaryImage->image_path) }}" alt="{{ $featured->name }}">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:2.5rem;">
                        <i class="fa-solid fa-image"></i>
                    </div>
                @endif
                <span class="badge-new">New product</span>
            </div>
            <div class="featured-info">
                <h2 class="featured-title">{{ $featured->name }}</h2>
                <p class="featured-desc">{{ $featured->description ?? 'Produk unggulan kami dengan kualitas terbaik dan bahan premium.' }}</p>
                <div class="featured-material">Material</div>
                <div class="featured-price">Rp {{ number_format($featured->price, 0, ',', '.') }}</div>
                <div class="featured-actions">
                    <a href="#" class="btn-dark">
                        <i class="fa-solid fa-cart-plus"></i> Add to cart
                    </a>
                    <a href="{{ route('checkout', $featured) }}" class="btn-outline-dark">
                        <i class="fa-solid fa-bolt"></i> Buy now
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Categories --}}
    @if($categories->count())
    <section class="section" id="categories">
        <div class="section-label">Shop by Category</div>
        <div class="d-flex flex-wrap gap-2">
            <a href="#products" class="category-pill active">All</a>
            @foreach($categories as $cat)
                <a href="#products" class="category-pill">
                    {{ $cat->name }}
                    <span style="font-size:.65rem;opacity:.6;">({{ $cat->products_count }})</span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Best Selling Products --}}
    @if($bestSellers->count())
    <section class="section" id="products">
        <div class="section-label">Best Selling Product</div>
        <div class="row g-3">
            @foreach($bestSellers as $product)
            <div class="col-6 col-md-4">
                <div class="product-card">
                    @if($product->primaryImage)
                        <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                            alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="product-img-placeholder">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif
                    <div class="product-body">
                        <div class="product-category">{{ $product->category->name ?? '' }}</div>
                        <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-actions">
                            <a href="#" class="btn-dark" style="flex:1;justify-content:center;">
                                <i class="fa-solid fa-cart-plus"></i> Add to cart
                            </a>
                            <a href="{{ route('checkout', $product) }}" class="btn-outline-dark" style="flex:1;justify-content:center;">
                                <i class="fa-solid fa-bolt"></i> Buy now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- New Arrivals --}}
    @if($newArrivals->count())
    <section class="section">
        <div class="section-label">New Arrivals</div>
        <div class="row g-3">
            @foreach($newArrivals as $product)
            <div class="col-6 col-md-3">
                <div class="product-card">
                    @if($product->primaryImage)
                        <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                            alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="product-img-placeholder">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif
                    <div class="product-body">
                        <div class="product-category">{{ $product->category->name ?? '' }}</div>
                        <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-actions">
                            <a href="#" class="btn-dark" style="flex:1;justify-content:center;">
                                <i class="fa-solid fa-cart-plus"></i> Add
                            </a>
                            <a href="#" class="btn-outline-dark" style="flex:1;justify-content:center;">
                                <i class="fa-solid fa-bolt"></i> Buy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>

@endsection

@push('scripts')
<script>
(function () {
    const slides = document.querySelectorAll('.hero-slide');
    const dots   = document.querySelectorAll('.hero-dot');
    let current  = 0;
    let timer;

    function goTo(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() { timer = setInterval(next, 5000); }
    function resetAuto()  { clearInterval(timer); startAuto(); }

    document.getElementById('heroNext').addEventListener('click', () => { next(); resetAuto(); });
    document.getElementById('heroPrev').addEventListener('click', () => { prev(); resetAuto(); });
    dots.forEach(dot => dot.addEventListener('click', () => { goTo(+dot.dataset.index); resetAuto(); }));

    // Touch / swipe support
    let startX = 0;
    const slider = document.querySelector('.hero-slider');
    slider.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', e => {
        const diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) { diff > 0 ? next() : prev(); resetAuto(); }
    });

    startAuto();
})();
</script>
@endpush
