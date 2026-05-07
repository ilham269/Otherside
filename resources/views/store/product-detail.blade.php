@extends('layouts.store')
@section('title', $product->name . ' — Otherside Store')

@push('styles')
<style>
.thumb-img {
    width: 70px; height: 70px; object-fit: cover;
    border-radius: 10px; border: 2px solid transparent;
    cursor: pointer; transition: border-color .2s;
}
.thumb-img.active, .thumb-img:hover { border-color: #0a0a0a; }
</style>
@endpush

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    {{-- Breadcrumb --}}
    <div style="font-size:.78rem;color:#999;margin-bottom:1.5rem;">
        <a href="{{ route('home') }}" style="color:#999;text-decoration:none;">Home</a>
        <span class="mx-1">›</span>
        <a href="{{ route('products.index') }}" style="color:#999;text-decoration:none;">Products</a>
        <span class="mx-1">›</span>
        <span style="color:#333;">{{ $product->name }}</span>
    </div>

    <div class="row g-5">
        {{-- Images --}}
        <div class="col-lg-6">
            <div style="border-radius:16px;overflow:hidden;background:#f4f4f4;aspect-ratio:1;margin-bottom:.75rem;">
                @if($product->images->count())
                    <img id="mainImg" src="{{ Storage::url($product->images->firstWhere('is_primary', true)?->image_path ?? $product->images->first()->image_path) }}"
                        alt="{{ $product->name }}"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:4rem;">
                        <i class="fa-solid fa-image"></i>
                    </div>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="d-flex gap-2 flex-wrap">
                @foreach($product->images as $img)
                <img src="{{ Storage::url($img->image_path) }}"
                    class="thumb-img {{ $img->is_primary ? 'active' : '' }}"
                    onclick="document.getElementById('mainImg').src=this.src;document.querySelectorAll('.thumb-img').forEach(t=>t.classList.remove('active'));this.classList.add('active');"
                    alt="">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="col-lg-6">
            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#999;margin-bottom:.4rem;">
                {{ $product->category->name ?? '' }}
            </div>
            <h2 style="font-weight:800;font-size:1.6rem;margin-bottom:.5rem;">{{ $product->name }}</h2>

            @if($product->is_best)
            <span style="background:#fef3c7;color:#d97706;font-size:.7rem;font-weight:800;padding:3px 10px;border-radius:20px;letter-spacing:.5px;">
                ⭐ BEST SELLER
            </span>
            @endif

            <div style="font-size:1.75rem;font-weight:900;margin:1rem 0 .25rem;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <div style="font-size:.83rem;color:{{ $product->stock > 0 ? '#059669' : '#dc2626' }};font-weight:700;margin-bottom:1.25rem;">
                @if($product->stock > 10)
                    <i class="fa-solid fa-circle-check me-1"></i> Stok tersedia ({{ $product->stock }})
                @elseif($product->stock > 0)
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Stok terbatas ({{ $product->stock }} tersisa)
                @else
                    <i class="fa-solid fa-circle-xmark me-1"></i> Stok habis
                @endif
            </div>

            @if($product->description)
            <p style="font-size:.88rem;color:#555;line-height:1.7;margin-bottom:1.5rem;">{{ $product->description }}</p>
            @endif

            @if($product->sku)
            <div style="font-size:.78rem;color:#aaa;margin-bottom:1.25rem;">SKU: {{ $product->sku }}</div>
            @endif

            @if($product->stock > 0)
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('checkout', $product) }}" class="btn-dark" style="padding:.65rem 1.75rem;font-size:.9rem;">
                    <i class="fa-solid fa-bolt me-1"></i> Beli Sekarang
                </a>
                <a href="{{ route('custom-order.index') }}" class="btn-outline-dark" style="padding:.65rem 1.5rem;font-size:.9rem;">
                    <i class="fa-solid fa-pen-ruler me-1"></i> Custom Order
                </a>
            </div>
            @else
            <button disabled style="padding:.65rem 1.75rem;background:#e0e0e0;color:#999;border:none;border-radius:20px;font-weight:700;cursor:not-allowed;">
                Stok Habis
            </button>
            @endif

            {{-- Share --}}
            <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f0f0f0;">
                <span style="font-size:.78rem;color:#999;font-weight:700;">Share:</span>
                <div class="d-inline-flex gap-2 ms-2">
                    @foreach(['whatsapp'=>'fa-whatsapp','twitter'=>'fa-x-twitter','facebook'=>'fa-facebook-f'] as $name => $icon)
                    <a href="#" style="width:30px;height:30px;border-radius:50%;border:1px solid #e0e0e0;display:inline-flex;align-items:center;justify-content:center;color:#666;font-size:.75rem;text-decoration:none;transition:all .2s;"
                        onmouseover="this.style.background='#0a0a0a';this.style.color='#fff';this.style.borderColor='#0a0a0a'"
                        onmouseout="this.style.background='';this.style.color='#666';this.style.borderColor='#e0e0e0'">
                        <i class="fa-brands {{ $icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid #f0f0f0;">
        <div class="section-label">Produk Terkait</div>
        <div class="row g-3">
            @foreach($related as $rel)
            <div class="col-6 col-md-3">
                <div class="product-card">
                    <a href="{{ route('products.show', $rel) }}" style="text-decoration:none;">
                        @if($rel->primaryImage)
                            <img src="{{ Storage::url($rel->primaryImage->image_path) }}" alt="{{ $rel->name }}" class="product-img">
                        @else
                            <div class="product-img-placeholder"><i class="fa-solid fa-image"></i></div>
                        @endif
                    </a>
                    <div class="product-body">
                        <div class="product-name">{{ $rel->name }}</div>
                        <div class="product-price">Rp {{ number_format($rel->price, 0, ',', '.') }}</div>
                        <a href="{{ route('products.show', $rel) }}" class="btn-dark" style="width:100%;justify-content:center;font-size:.75rem;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
