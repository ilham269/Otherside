@extends('layouts.store')
@section('title', 'About Us — Otherside Store')

@section('content')

{{-- Hero --}}
<section style="background:#0a0a0a;padding:7rem 0 4rem;text-align:center;margin-top:64px;">
    <div class="page-wrap">
        <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.4);margin-bottom:.75rem;">Tentang Kami</div>
        <h1 style="font-weight:900;font-size:clamp(2rem,6vw,3.5rem);color:#fff;margin-bottom:1rem;line-height:1.1;">
            We Are <span style="color:rgba(255,255,255,.4);">Otherside</span>
        </h1>
        <p style="color:rgba(255,255,255,.5);font-size:.95rem;max-width:520px;margin:0 auto;line-height:1.75;">
            Brand lokal yang lahir dari passion terhadap fashion custom berkualitas tinggi. Kami percaya setiap orang berhak tampil beda.
        </p>
    </div>
</section>

<div class="page-wrap" style="padding-top:3.5rem;padding-bottom:4rem;">

    {{-- Story --}}
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <div style="background:#f4f4f4;border-radius:20px;aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                <img src="{{ asset('img/logo-otherside.png') }}" alt="Otherside" style="width:180px;opacity:.15;">
            </div>
        </div>
        <div class="col-lg-6">
            <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin-bottom:.75rem;">Our Story</div>
            <h2 style="font-weight:900;font-size:1.6rem;margin-bottom:1rem;line-height:1.2;">Dari Passion Menjadi Brand</h2>
            <p style="font-size:.9rem;color:#555;line-height:1.8;margin-bottom:1rem;">
                Otherside dimulai dari kecintaan terhadap streetwear dan keinginan untuk menghadirkan produk custom berkualitas tinggi yang terjangkau untuk semua kalangan.
            </p>
            <p style="font-size:.9rem;color:#555;line-height:1.8;">
                Kami melayani custom order untuk komunitas, event, hingga kebutuhan personal — dengan proses yang mudah, transparan, dan hasil yang memuaskan.
            </p>
        </div>
    </div>

    {{-- Values --}}
    <div style="margin-bottom:3.5rem;">
        <div style="text-align:center;margin-bottom:2rem;">
            <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin-bottom:.4rem;">What We Stand For</div>
            <h2 style="font-weight:900;font-size:1.5rem;">Nilai Kami</h2>
        </div>
        <div class="row g-3">
            @foreach([
                ['icon'=>'fa-gem',         'title'=>'Kualitas',    'desc'=>'Bahan premium dipilih dengan teliti untuk setiap produk yang kami buat.'],
                ['icon'=>'fa-pen-ruler',   'title'=>'Custom',      'desc'=>'Setiap produk bisa dikustomisasi sesuai kebutuhan dan keinginanmu.'],
                ['icon'=>'fa-handshake',   'title'=>'Terpercaya',  'desc'=>'Ribuan pelanggan puas dengan layanan dan produk kami.'],
                ['icon'=>'fa-truck-fast',  'title'=>'Tepat Waktu', 'desc'=>'Kami berkomitmen menyelesaikan dan mengirim pesanan sesuai jadwal.'],
            ] as $v)
            <div class="col-6 col-md-3">
                <div style="background:#fff;border:1px solid #ebebeb;border-radius:16px;padding:1.5rem;text-align:center;height:100%;">
                    <div style="width:48px;height:48px;background:#f4f4f4;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;font-size:1.1rem;color:#0a0a0a;">
                        <i class="fa-solid {{ $v['icon'] }}"></i>
                    </div>
                    <div style="font-weight:800;font-size:.9rem;margin-bottom:.35rem;">{{ $v['title'] }}</div>
                    <div style="font-size:.78rem;color:#888;line-height:1.5;">{{ $v['desc'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Stats --}}
    <div style="background:#0a0a0a;border-radius:20px;padding:2.5rem;margin-bottom:3.5rem;">
        <div class="row g-4 text-center">
            @foreach([
                ['num'=>'500+',  'label'=>'Pelanggan Puas'],
                ['num'=>'1000+', 'label'=>'Produk Terjual'],
                ['num'=>'50+',   'label'=>'Komunitas Dilayani'],
                ['num'=>'3 Hari','label'=>'Rata-rata Pengerjaan'],
            ] as $s)
            <div class="col-6 col-md-3">
                <div style="font-size:1.75rem;font-weight:900;color:#fff;">{{ $s['num'] }}</div>
                <div style="font-size:.78rem;color:rgba(255,255,255,.4);margin-top:.2rem;">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div style="text-align:center;padding:2rem 0;">
        <h3 style="font-weight:900;font-size:1.4rem;margin-bottom:.75rem;">Siap Buat Produk Custom?</h3>
        <p style="color:#666;font-size:.9rem;margin-bottom:1.5rem;">Hubungi kami atau langsung isi form custom order sekarang.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('custom-order.index') }}" class="btn-dark" style="padding:.65rem 1.75rem;font-size:.9rem;">
                <i class="fa-solid fa-pen-ruler me-2"></i> Custom Order
            </a>
            <a href="{{ route('products.index') }}" class="btn-outline-dark" style="padding:.65rem 1.75rem;font-size:.9rem;">
                <i class="fa-solid fa-bag-shopping me-2"></i> Lihat Produk
            </a>
        </div>
    </div>

</div>
@endsection
