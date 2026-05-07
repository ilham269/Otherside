@extends('layouts.admin')
@section('title', $product->name)
@section('page-title', 'Detail Produk')

@section('content')
@include('admin.partials.alert')

<div class="row g-3">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">{{ $product->name }}</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="card-action">Edit</a>
                </div>
            </div>
            <div class="admin-card-body">
                {{-- Images --}}
                @if($product->images->count())
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($product->images as $img)
                    <img src="{{ Storage::url($img->image_path) }}"
                        style="width:100px;height:100px;object-fit:cover;border-radius:10px;border:2px solid {{ $img->is_primary ? '#6366f1' : '#e2e8f0' }};">
                    @endforeach
                </div>
                @endif

                <table style="width:100%;font-size:.85rem;">
                    <tr class="border-bottom" style="border-color:#f1f5f9!important;">
                        <td style="padding:.6rem 0;color:#64748b;width:140px;">Kategori</td>
                        <td style="padding:.6rem 0;font-weight:600;">{{ $product->category->name ?? '—' }}</td>
                    </tr>
                    <tr class="border-bottom" style="border-color:#f1f5f9!important;">
                        <td style="padding:.6rem 0;color:#64748b;">Harga</td>
                        <td style="padding:.6rem 0;font-weight:700;color:#6366f1;">Rp {{ number_format($product->price,0,',','.') }}</td>
                    </tr>
                    <tr class="border-bottom" style="border-color:#f1f5f9!important;">
                        <td style="padding:.6rem 0;color:#64748b;">Stok</td>
                        <td style="padding:.6rem 0;font-weight:600;">{{ $product->stock }}</td>
                    </tr>
                    <tr class="border-bottom" style="border-color:#f1f5f9!important;">
                        <td style="padding:.6rem 0;color:#64748b;">SKU</td>
                        <td style="padding:.6rem 0;"><code>{{ $product->sku ?? '—' }}</code></td>
                    </tr>
                    <tr class="border-bottom" style="border-color:#f1f5f9!important;">
                        <td style="padding:.6rem 0;color:#64748b;">Status</td>
                        <td style="padding:.6rem 0;">
                            <span class="status-badge {{ $product->is_available ? 'completed' : 'cancelled' }}">
                                {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:.6rem 0;color:#64748b;">Best Seller</td>
                        <td style="padding:.6rem 0;">{{ $product->is_best ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                </table>

                @if($product->description)
                <div class="mt-3 pt-3 border-top" style="border-color:#f1f5f9!important;">
                    <div style="font-size:.8rem;color:#64748b;font-weight:600;margin-bottom:.4rem;">DESKRIPSI</div>
                    <p style="font-size:.85rem;color:#475569;line-height:1.6;">{{ $product->description }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header"><h6 class="card-title">Aksi</h6></div>
            <div class="admin-card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:10px;font-size:.85rem;">
                    <i class="fa-solid fa-pen me-1"></i> Edit Produk
                </a>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" style="border-radius:10px;font-size:.85rem;">
                        <i class="fa-solid fa-trash me-1"></i> Hapus Produk
                    </button>
                </form>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100" style="border-radius:10px;font-size:.85rem;">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
