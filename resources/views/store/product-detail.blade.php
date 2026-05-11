@extends('layouts.store')
@section('title', $product->name . ' — Otherside Store')

@push('styles')
<style>
.thumb-img {
    width: 68px; height: 68px; object-fit: cover;
    border-radius: 10px; border: 2px solid transparent;
    cursor: pointer; transition: border-color .2s; flex-shrink: 0;
}
.thumb-img.active, .thumb-img:hover { border-color: #0a0a0a; }

.star-rating { display: flex; gap: .2rem; }
.star { font-size: 1.1rem; color: #e0e0e0; cursor: pointer; transition: color .15s; }
.star.filled, .star:hover ~ .star { color: #e0e0e0; }
.star.filled { color: #f59e0b; }
#starGroup:hover .star { color: #f59e0b; }
#starGroup .star:hover ~ .star { color: #e0e0e0; }

.review-card {
    padding: 1.1rem 0;
    border-bottom: 1px solid #f5f5f5;
}
.review-card:last-child { border-bottom: none; }

.rating-bar-wrap { display: flex; align-items: center; gap: .75rem; margin-bottom: .4rem; }
.rating-bar-bg { flex: 1; height: 6px; background: #f0f0f0; border-radius: 3px; overflow: hidden; }
.rating-bar-fill { height: 100%; background: #f59e0b; border-radius: 3px; transition: width .4s; }
</style>
@endpush

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    {{-- Breadcrumb --}}
    <div style="font-size:.78rem;color:#999;margin-bottom:1.5rem;">
        <a href="{{ route('home') }}" style="color:#999;text-decoration:none;">Home</a> ›
        <a href="{{ route('products.index') }}" style="color:#999;text-decoration:none;">Products</a> ›
        <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" style="color:#999;text-decoration:none;">{{ $product->category->name ?? '' }}</a> ›
        <span style="color:#333;">{{ Str::limit($product->name, 40) }}</span>
    </div>

    {{-- ─── Product Info ──────────────────────────────────────────────────── --}}
    <div class="row g-5 mb-5">

        {{-- Images --}}
        <div class="col-lg-6">
            <div style="border-radius:18px;overflow:hidden;background:#f4f4f4;aspect-ratio:1;margin-bottom:.75rem;position:relative;">
                @if($product->images->count())
                    <img id="mainImg"
                        src="{{ Storage::url($product->images->firstWhere('is_primary', true)?->image_path ?? $product->images->first()->image_path) }}"
                        alt="{{ $product->name }}"
                        style="width:100%;height:100%;object-fit:cover;display:block;transition:opacity .2s;">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:4rem;">
                        <i class="fa-solid fa-image"></i>
                    </div>
                @endif
                @if($product->is_best)
                <span style="position:absolute;top:12px;left:12px;background:#f59e0b;color:#fff;font-size:.65rem;font-weight:800;padding:3px 10px;border-radius:20px;letter-spacing:.5px;">
                    ⭐ BEST SELLER
                </span>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="d-flex gap-2 flex-wrap">
                @foreach($product->images as $img)
                <img src="{{ Storage::url($img->image_path) }}"
                    class="thumb-img {{ $img->is_primary ? 'active' : '' }}"
                    onclick="switchImg(this)"
                    alt="">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Detail --}}
        <div class="col-lg-6">
            <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#999;margin-bottom:.3rem;">
                {{ $product->category->name ?? '' }}
            </div>
            <h1 style="font-weight:900;font-size:1.5rem;line-height:1.2;margin-bottom:.75rem;">{{ $product->name }}</h1>

            {{-- Rating summary --}}
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="d-flex gap-1">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fa-{{ $i <= round($avgRating) ? 'solid' : 'regular' }} fa-star"
                        style="color:{{ $i <= round($avgRating) ? '#f59e0b' : '#e0e0e0' }};font-size:.9rem;"></i>
                    @endfor
                </div>
                <span style="font-weight:800;font-size:.9rem;">{{ number_format($avgRating, 1) }}</span>
                <span style="font-size:.8rem;color:#999;">({{ $reviewsCount }} ulasan)</span>
                @if($product->sku)
                <span style="font-size:.75rem;color:#ccc;">|</span>
                <span style="font-size:.75rem;color:#aaa;">SKU: {{ $product->sku }}</span>
                @endif
            </div>

            {{-- Harga --}}
            <div style="font-size:2rem;font-weight:900;margin-bottom:.5rem;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            {{-- Stok --}}
            <div style="font-size:.83rem;font-weight:700;margin-bottom:1.25rem;color:{{ $product->stock > 10 ? '#059669' : ($product->stock > 0 ? '#d97706' : '#dc2626') }};">
                @if($product->stock > 10)
                    <i class="fa-solid fa-circle-check me-1"></i> Stok tersedia ({{ $product->stock }} pcs)
                @elseif($product->stock > 0)
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Stok terbatas — {{ $product->stock }} tersisa
                @else
                    <i class="fa-solid fa-circle-xmark me-1"></i> Stok habis
                @endif
            </div>

            {{-- Deskripsi --}}
            @if($product->description)
            <p style="font-size:.88rem;color:#555;line-height:1.75;margin-bottom:1.5rem;">{{ $product->description }}</p>
            @endif

            {{-- Spesifikasi --}}
            <div style="background:#f8f8f8;border-radius:12px;padding:1rem 1.1rem;margin-bottom:1.5rem;">
                <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#999;margin-bottom:.6rem;">Spesifikasi</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.4rem .75rem;font-size:.82rem;">
                    <div style="color:#888;">Material</div>
                    <div style="font-weight:600;">Premium Waterproof</div>
                    <div style="color:#888;">Tersedia Ukuran</div>
                    <div style="font-weight:600;">13", 14", 15.6"</div>
                    <div style="color:#888;">Warna</div>
                    <div style="font-weight:600;">Hitam, Abu</div>
                    <div style="color:#888;">Garansi</div>
                    <div style="font-weight:600;">30 hari</div>
                </div>
            </div>

            {{-- CTA --}}
            @if($product->stock > 0)
            <div class="d-flex gap-2 flex-wrap mb-3">
                <a href="{{ route('checkout', $product) }}" class="btn-dark" style="padding:.7rem 2rem;font-size:.92rem;flex:1;justify-content:center;">
                    <i class="fa-solid fa-bolt me-1"></i> Beli Sekarang
                </a>
                <a href="{{ route('custom-order.index') }}" class="btn-outline-dark" style="padding:.7rem 1.25rem;font-size:.88rem;">
                    <i class="fa-solid fa-pen-ruler me-1"></i> Custom
                </a>
            </div>
            @else
            <button disabled style="width:100%;padding:.7rem;background:#e0e0e0;color:#999;border:none;border-radius:20px;font-weight:700;cursor:not-allowed;margin-bottom:.75rem;">
                Stok Habis
            </button>
            @endif

            {{-- Share --}}
            <div class="d-flex align-items-center gap-2">
                <span style="font-size:.75rem;color:#aaa;font-weight:700;">Share:</span>
                @foreach(['whatsapp'=>'fa-whatsapp','twitter'=>'fa-x-twitter','facebook'=>'fa-facebook-f'] as $name => $icon)
                <a href="#" style="width:30px;height:30px;border-radius:50%;border:1px solid #e0e0e0;display:inline-flex;align-items:center;justify-content:center;color:#888;font-size:.75rem;text-decoration:none;transition:all .2s;"
                    onmouseover="this.style.background='#0a0a0a';this.style.color='#fff';this.style.borderColor='#0a0a0a'"
                    onmouseout="this.style.background='';this.style.color='#888';this.style.borderColor='#e0e0e0'">
                    <i class="fa-brands {{ $icon }}"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ─── Rating & Ulasan ───────────────────────────────────────────────── --}}
    <div style="border-top:1px solid #f0f0f0;padding-top:2.5rem;margin-bottom:3rem;">
        <h4 style="font-weight:900;font-size:1.2rem;margin-bottom:1.5rem;">Rating & Ulasan</h4>

        <div class="row g-4 mb-4">
            {{-- Rating overview --}}
            <div class="col-md-3 text-center">
                <div style="font-size:3.5rem;font-weight:900;line-height:1;">{{ number_format($avgRating, 1) }}</div>
                <div class="d-flex justify-content-center gap-1 my-1">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fa-{{ $i <= round($avgRating) ? 'solid' : 'regular' }} fa-star"
                        style="color:{{ $i <= round($avgRating) ? '#f59e0b' : '#e0e0e0' }};font-size:1rem;"></i>
                    @endfor
                </div>
                <div style="font-size:.78rem;color:#999;">{{ $reviewsCount }} ulasan</div>
            </div>

            {{-- Rating breakdown --}}
            <div class="col-md-9">
                @for($i = 5; $i >= 1; $i--)
                <div class="rating-bar-wrap">
                    <div style="font-size:.78rem;font-weight:700;width:14px;text-align:right;">{{ $i }}</div>
                    <i class="fa-solid fa-star" style="color:#f59e0b;font-size:.75rem;"></i>
                    <div class="rating-bar-bg">
                        <div class="rating-bar-fill" style="width:{{ $ratingBreakdown[$i]['percent'] }}%;"></div>
                    </div>
                    <div style="font-size:.75rem;color:#999;width:28px;">{{ $ratingBreakdown[$i]['count'] }}</div>
                </div>
                @endfor
            </div>
        </div>

        {{-- Form ulasan --}}
        @auth
            @if(session('review_success'))
            <div style="background:#d1fae5;color:#065f46;border-radius:12px;padding:.9rem 1.1rem;margin-bottom:1.25rem;font-size:.85rem;font-weight:600;">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('review_success') }}
            </div>
            @endif

            @if($canReviewData['can'])
            <div style="background:#f8f8f8;border-radius:16px;padding:1.5rem;margin-bottom:2rem;">
                <div style="font-weight:800;font-size:.9rem;margin-bottom:1rem;">Tulis Ulasanmu</div>
                <form method="POST" action="{{ route('products.review', $product) }}">
                    @csrf
                    {{-- Star picker --}}
                    <div class="mb-3">
                        <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.5rem;">Rating <span class="text-danger">*</span></label>
                        <div id="starGroup" class="star-rating" style="font-size:1.6rem;">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fa-regular fa-star star" data-value="{{ $i }}"
                                onclick="setRating({{ $i }})"
                                onmouseover="hoverRating({{ $i }})"
                                onmouseout="resetHover()"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="">
                        @error('rating')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Ulasan</label>
                        <textarea name="body" rows="3"
                            style="width:100%;border:1.5px solid #e0e0e0;border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none;resize:vertical;"
                            placeholder="Ceritakan pengalamanmu dengan produk ini...">{{ old('body') }}</textarea>
                        @error('body')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-dark" style="padding:.5rem 1.5rem;font-size:.85rem;">
                        <i class="fa-solid fa-paper-plane me-1"></i> Kirim Ulasan
                    </button>
                </form>
            </div>

            @elseif($canReviewData['reason'] === 'already_reviewed')
            <div style="background:#eef2ff;border-radius:12px;padding:1rem 1.25rem;margin-bottom:2rem;font-size:.85rem;color:#4338ca;font-weight:600;">
                <i class="fa-solid fa-circle-check me-2"></i> Kamu sudah memberikan ulasan untuk produk ini.
            </div>

            @elseif($canReviewData['reason'] === 'no_purchase')
            <div style="background:#f8f8f8;border-radius:12px;padding:1rem 1.25rem;margin-bottom:2rem;font-size:.85rem;color:#666;">
                <i class="fa-solid fa-lock me-2"></i>
                Ulasan hanya bisa diberikan setelah membeli dan menerima produk ini.
                <a href="{{ route('products.index') }}" style="color:#0a0a0a;font-weight:700;margin-left:.25rem;">Beli sekarang →</a>
            </div>
            @endif

        @else
        <div style="background:#f8f8f8;border-radius:12px;padding:1rem 1.25rem;margin-bottom:2rem;font-size:.85rem;color:#666;">
            <i class="fa-solid fa-lock me-2"></i>
            <a href="{{ route('login') }}" style="color:#0a0a0a;font-weight:700;">Login</a> untuk memberikan ulasan.
        </div>
        @endauth

        {{-- Daftar ulasan --}}
        @if($reviews->count())
        <div>
            @foreach($reviews as $review)
            <div class="review-card">
                <div class="d-flex align-items-start gap-3">
                    <div style="width:38px;height:38px;border-radius:50%;background:#0a0a0a;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.85rem;flex-shrink:0;">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div style="flex:1;">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span style="font-weight:700;font-size:.88rem;">{{ $review->user->name }}</span>
                            <div class="d-flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"
                                    style="color:{{ $i <= $review->rating ? '#f59e0b' : '#e0e0e0' }};font-size:.72rem;"></i>
                                @endfor
                            </div>
                            <span style="font-size:.73rem;color:#bbb;">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        @if($review->body)
                        <p style="font-size:.85rem;color:#444;margin-top:.4rem;line-height:1.6;margin-bottom:0;">{{ $review->body }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Pagination ulasan --}}
            @if($reviews->hasPages())
            <div class="d-flex gap-2 mt-3">
                @if(!$reviews->onFirstPage())
                <a href="{{ $reviews->previousPageUrl() }}#ulasan" class="btn-outline-dark" style="font-size:.78rem;padding:.35rem .9rem;">‹ Sebelumnya</a>
                @endif
                @if($reviews->hasMorePages())
                <a href="{{ $reviews->nextPageUrl() }}#ulasan" class="btn-outline-dark" style="font-size:.78rem;padding:.35rem .9rem;">Selanjutnya ›</a>
                @endif
            </div>
            @endif
        </div>
        @else
        <div style="text-align:center;padding:2rem 0;color:#bbb;">
            <i class="fa-regular fa-comment-dots" style="font-size:2rem;margin-bottom:.5rem;display:block;"></i>
            <div style="font-size:.85rem;">Belum ada ulasan. Jadilah yang pertama!</div>
        </div>
        @endif
    </div>

    {{-- ─── Related Products ──────────────────────────────────────────────── --}}
    @if($related->count())
    <div style="border-top:1px solid #f0f0f0;padding-top:2rem;">
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

@push('scripts')
<script>
// ─── Image switcher ───────────────────────────────────────────────────────────
function switchImg(el) {
    const main = document.getElementById('mainImg');
    if (main) {
        main.style.opacity = '0';
        setTimeout(() => { main.src = el.src; main.style.opacity = '1'; }, 150);
    }
    document.querySelectorAll('.thumb-img').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// ─── Star rating picker ───────────────────────────────────────────────────────
let selectedRating = 0;

function setRating(val) {
    selectedRating = val;
    document.getElementById('ratingInput').value = val;
    renderStars(val, true);
}

function hoverRating(val) {
    renderStars(val, false);
}

function resetHover() {
    renderStars(selectedRating, true);
}

function renderStars(val, isFinal) {
    document.querySelectorAll('#starGroup .star').forEach((star, i) => {
        const filled = i < val;
        star.className = filled ? 'fa-solid fa-star star filled' : 'fa-regular fa-star star';
        star.style.color = filled ? '#f59e0b' : '#e0e0e0';
    });
}
</script>
@endpush
