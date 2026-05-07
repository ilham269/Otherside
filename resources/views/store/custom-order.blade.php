@extends('layouts.store')
@section('title', 'Custom Order — Otherside Store')

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    {{-- Header --}}
    <div style="text-align:center;margin-bottom:2.5rem;">
        <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:2px;color:#999;margin-bottom:.5rem;">Layanan Khusus</div>
        <h2 style="font-weight:900;font-size:2rem;margin-bottom:.5rem;">Custom Order</h2>
        <p style="color:#666;font-size:.9rem;max-width:480px;margin:0 auto;line-height:1.7;">
            Buat produk sesuai keinginanmu. Isi form di bawah dan tim kami akan menghubungimu dengan estimasi harga.
        </p>
    </div>

    {{-- Steps info --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['icon'=>'fa-file-pen',    'step'=>'01', 'title'=>'Isi Form',         'desc'=>'Ceritakan kebutuhanmu secara detail'],
            ['icon'=>'fa-comments',    'step'=>'02', 'title'=>'Diskusi',           'desc'=>'Tim kami akan menghubungimu untuk konfirmasi'],
            ['icon'=>'fa-tag',         'step'=>'03', 'title'=>'Estimasi Harga',    'desc'=>'Kami kirimkan penawaran harga terbaik'],
            ['icon'=>'fa-circle-check','step'=>'04', 'title'=>'Produksi & Kirim',  'desc'=>'Pesanan diproses dan dikirim ke alamatmu'],
        ] as $s)
        <div class="col-6 col-md-3">
            <div style="background:#f8f8f8;border-radius:14px;padding:1.1rem;text-align:center;">
                <div style="font-size:1.3rem;margin-bottom:.4rem;color:#0a0a0a;"><i class="fa-solid {{ $s['icon'] }}"></i></div>
                <div style="font-size:.65rem;font-weight:800;color:#bbb;letter-spacing:1px;">STEP {{ $s['step'] }}</div>
                <div style="font-size:.85rem;font-weight:800;margin:.2rem 0 .2rem;">{{ $s['title'] }}</div>
                <div style="font-size:.75rem;color:#999;line-height:1.4;">{{ $s['desc'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            @if(session('success'))
            <div style="background:#d1fae5;color:#065f46;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.25rem;font-size:.88rem;font-weight:600;">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('custom-order.store') }}" enctype="multipart/form-data"
                style="background:#fff;border:1px solid #ebebeb;border-radius:16px;padding:1.75rem;">
                @csrf

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">
                        Judul / Subject <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                        style="width:100%;border:1.5px solid {{ $errors->has('subject') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.55rem .9rem;font-size:.88rem;outline:none;"
                        placeholder="Contoh: Custom kaos komunitas motor 50 pcs">
                    @error('subject')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Tipe Order <span class="text-danger">*</span></label>
                        <select name="type" style="width:100%;border:1.5px solid #e0e0e0;border-radius:10px;padding:.55rem .9rem;font-size:.88rem;outline:none;background:#fff;">
                            <option value="">Pilih tipe</option>
                            @foreach(['bulk'=>'Bulk / Massal','personal'=>'Personal','event'=>'Event / Komunitas'] as $val => $label)
                                <option value="{{ $val }}" @selected(old('type')===$val)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="qty" value="{{ old('qty', 1) }}" min="1"
                            style="width:100%;border:1.5px solid #e0e0e0;border-radius:10px;padding:.55rem .9rem;font-size:.88rem;outline:none;">
                        @error('qty')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Referensi Produk (opsional)</label>
                    <select name="product_id" style="width:100%;border:1.5px solid #e0e0e0;border-radius:10px;padding:.55rem .9rem;font-size:.88rem;outline:none;background:#fff;">
                        <option value="">— Tidak ada referensi produk —</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" @selected(old('product_id')==$p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">
                        Detail Kebutuhan <span class="text-danger">*</span>
                    </label>
                    <textarea name="notes" rows="5"
                        style="width:100%;border:1.5px solid {{ $errors->has('notes') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.55rem .9rem;font-size:.88rem;outline:none;resize:vertical;"
                        placeholder="Ceritakan detail kebutuhanmu: ukuran, warna, bahan, desain, deadline, dll...">{{ old('notes') }}</textarea>
                    @error('notes')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">File Referensi (opsional)</label>
                    <input type="file" name="reference_file" accept=".jpg,.jpeg,.png,.pdf"
                        style="width:100%;border:1.5px solid #e0e0e0;border-radius:10px;padding:.45rem .9rem;font-size:.83rem;">
                    <div style="font-size:.73rem;color:#aaa;margin-top:.3rem;">Format: JPG, PNG, PDF. Maks 5MB.</div>
                    @error('reference_file')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-dark" style="width:100%;padding:.75rem;font-size:.95rem;border-radius:12px;justify-content:center;">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Custom Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
