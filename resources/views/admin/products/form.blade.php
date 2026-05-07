@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<form method="POST" action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="row g-3">
        {{-- Left --}}
        <div class="col-lg-8">
            <div class="admin-card mb-3">
                <div class="admin-card-header">
                    <h6 class="card-title">Informasi Produk</h6>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Nama produk">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Deskripsi</label>
                        <textarea name="description" rows="5" class="form-control" placeholder="Deskripsi produk...">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.85rem;">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:.83rem;">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                                    class="form-control @error('price') is-invalid @enderror" placeholder="0" min="0">
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.85rem;">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                                class="form-control @error('stock') is-invalid @enderror" min="0">
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h6 class="card-title">Foto Produk</h6>
                </div>
                <div class="admin-card-body">
                    @if(isset($product) && $product->images->count())
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($product->images as $img)
                        <div style="position:relative;">
                            <img src="{{ Storage::url($img->image_path) }}"
                                style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:2px solid {{ $img->is_primary ? '#6366f1' : '#e2e8f0' }};">
                            @if($img->is_primary)
                                <span style="position:absolute;top:-6px;right:-6px;background:#6366f1;color:#fff;font-size:.6rem;padding:2px 5px;border-radius:20px;font-weight:700;">Utama</span>
                            @else
                                <form method="POST" action="{{ route('admin.products.primary-image', $product) }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="image_id" value="{{ $img->id }}">
                                    <button type="submit" style="position:absolute;top:-6px;left:-6px;background:#fff;border:1px solid #e2e8f0;border-radius:20px;font-size:.6rem;padding:2px 5px;cursor:pointer;color:#64748b;" title="Jadikan utama">★</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.products.delete-image', $img) }}" onsubmit="return confirm('Hapus foto?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="position:absolute;bottom:-6px;right:-6px;background:#ef4444;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:.6rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <input type="file" name="images[]" multiple accept="image/*" class="form-control @error('images.*') is-invalid @enderror">
                    <div style="font-size:.75rem;color:#94a3b8;margin-top:.4rem;">Format: JPG, PNG. Maks 2MB per foto.</div>
                    @error('images.*')<div class="text-danger" style="font-size:.8rem;">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Right --}}
        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="admin-card-header"><h6 class="card-title">Pengaturan</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
                            class="form-control @error('sku') is-invalid @enderror" placeholder="Kode produk">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_available" value="1" id="isAvailable"
                                {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isAvailable" style="font-size:.85rem;">Tersedia</label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_best" value="1" id="isBest"
                                {{ old('is_best', $product->is_best ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isBest" style="font-size:.85rem;">Best Seller</label>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:10px;">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                {{ isset($product) ? 'Update Produk' : 'Simpan Produk' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:10px;font-size:.85rem;">
                Batal
            </a>
        </div>
    </div>
</form>
@endsection
