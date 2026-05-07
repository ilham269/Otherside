@extends('layouts.admin')
@section('title','Products')
@section('page-title','Products')

@section('content')
@include('admin.partials.alert')

<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="card-title">Semua Produk</h6>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="fa-solid fa-plus me-1"></i> Tambah
        </a>
    </div>

    <div class="p-3 border-bottom" style="border-color:#f1f5f9!important;">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                class="form-control form-control-sm" style="max-width:220px;border-radius:8px;">
            <select name="category_id" class="form-select form-select-sm" style="max-width:160px;border-radius:8px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="is_available" class="form-select form-select-sm" style="max-width:140px;border-radius:8px;">
                <option value="">Semua Status</option>
                <option value="1" @selected(request('is_available')==='1')>Tersedia</option>
                <option value="0" @selected(request('is_available')==='0')>Tidak Tersedia</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Filter</button>
            @if(request()->hasAny(['search','category_id','is_available']))
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>SKU</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->primaryImage)
                                <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                    style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
                            @else
                                <div style="width:40px;height:40px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-image" style="color:#cbd5e1;"></i>
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:600;font-size:.85rem;">{{ $product->name }}</div>
                                @if($product->is_best)
                                    <span style="font-size:.68rem;background:#fef3c7;color:#d97706;padding:1px 6px;border-radius:20px;font-weight:700;">Best Seller</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.83rem;color:#64748b;">{{ $product->category->name ?? '—' }}</td>
                    <td style="font-weight:700;font-size:.83rem;">Rp {{ number_format($product->price,0,',','.') }}</td>
                    <td>
                        <span style="font-size:.83rem;font-weight:600;color:{{ $product->stock < 10 ? '#dc2626' : '#059669' }};">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td><code style="font-size:.75rem;background:#f1f5f9;padding:2px 6px;border-radius:4px;">{{ $product->sku ?? '—' }}</code></td>
                    <td>
                        <span class="status-badge {{ $product->is_available ? 'completed' : 'cancelled' }}">
                            {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn-action view" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-action edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        @include('admin.partials.pagination', ['paginator' => $products])
    </div>
</div>
@endsection
