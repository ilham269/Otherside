@extends('layouts.store')
@section('title', 'Products — Otherside Store')

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h5 style="font-weight:800;margin:0;">
                {{ $activeCategory ? $activeCategory->name : 'Semua Produk' }}
            </h5>
            <p style="font-size:.82rem;color:#999;margin:0;">{{ $products->total() }} produk ditemukan</p>
        </div>

        {{-- Sort --}}
        <form method="GET" class="d-flex gap-2 align-items-center">
            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
            <select name="sort" onchange="this.form.submit()"
                style="border:1.5px solid #e0e0e0;border-radius:20px;padding:.35rem .9rem;font-size:.8rem;font-weight:600;background:#fff;cursor:pointer;outline:none;">
                <option value="newest"     @selected(!request('sort') || request('sort')==='newest')>Terbaru</option>
                <option value="price_asc"  @selected(request('sort')==='price_asc')>Harga Terendah</option>
                <option value="price_desc" @selected(request('sort')==='price_desc')>Harga Tertinggi</option>
            </select>
        </form>
    </div>

    <div class="row g-4">
        {{-- Sidebar kategori --}}
        <div class="col-lg-3 d-none d-lg-block">
            <div style="position:sticky;top:80px;">
                <div style="font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin-bottom:.75rem;">Kategori</div>
                <a href="{{ route('products.index', request()->except('category')) }}"
                    class="d-block py-2 px-3 mb-1 rounded-3 text-decoration-none"
                    style="font-size:.85rem;font-weight:{{ !request('category') ? '800' : '600' }};background:{{ !request('category') ? '#0a0a0a' : 'transparent' }};color:{{ !request('category') ? '#fff' : '#444' }};">
                    Semua Produk
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->except('category'), ['category' => $cat->slug])) }}"
                    class="d-block py-2 px-3 mb-1 rounded-3 text-decoration-none"
                    style="font-size:.85rem;font-weight:{{ request('category') === $cat->slug ? '800' : '600' }};background:{{ request('category') === $cat->slug ? '#0a0a0a' : 'transparent' }};color:{{ request('category') === $cat->slug ? '#fff' : '#444' }};">
                    {{ $cat->name }}
                    <span style="font-size:.72rem;opacity:.5;">({{ $cat->products_count }})</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Products grid --}}
        <div class="col-lg-9">
            {{-- Search bar --}}
            <form method="GET" class="mb-4">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                <div class="d-flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari produk..."
                        style="flex:1;border:1.5px solid #e0e0e0;border-radius:20px;padding:.45rem 1.1rem;font-size:.85rem;outline:none;">
                    <button type="submit" class="btn-dark" style="border-radius:20px;padding:.45rem 1.1rem;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    @if(request('search'))
                    <a href="{{ route('products.index', request()->except('search')) }}" class="btn-outline-dark" style="border-radius:20px;padding:.45rem 1rem;">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                </div>
            </form>

            {{-- Mobile kategori pills --}}
            <div class="d-flex gap-2 flex-wrap mb-3 d-lg-none">
                <a href="{{ route('products.index', request()->except('category')) }}" class="category-pill {{ !request('category') ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->except('category'), ['category' => $cat->slug])) }}"
                    class="category-pill {{ request('category') === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            @if($products->count())
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-md-4">
                    <div class="product-card">
                        <a href="{{ route('products.show', $product) }}" style="text-decoration:none;display:block;">
                            @if($product->primaryImage)
                                <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                    alt="{{ $product->name }}" class="product-img">
                            @else
                                <div class="product-img-placeholder"><i class="fa-solid fa-image"></i></div>
                            @endif
                        </a>
                        <div class="product-body">
                            <div class="product-category">{{ $product->category->name ?? '' }}</div>
                            <a href="{{ route('products.show', $product) }}" style="text-decoration:none;">
                                <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                            </a>
                            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="product-actions">
                                <a href="{{ route('checkout', $product) }}" class="btn-dark" style="flex:1;justify-content:center;">
                                    <i class="fa-solid fa-bolt"></i> Beli
                                </a>
                                <a href="{{ route('products.show', $product) }}" class="btn-outline-dark" style="flex:1;justify-content:center;">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('vendor.pagination.simple') }}
            </div>

            @else
            <div style="text-align:center;padding:4rem 0;">
                <div style="font-size:3rem;color:#e0e0e0;margin-bottom:1rem;"><i class="fa-solid fa-box-open"></i></div>
                <div style="font-weight:700;color:#333;">Produk tidak ditemukan</div>
                <p style="font-size:.85rem;color:#999;margin-top:.4rem;">Coba kata kunci atau kategori lain</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
