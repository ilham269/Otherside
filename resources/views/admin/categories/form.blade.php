@extends('layouts.admin')
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">{{ isset($category) ? 'Edit' : 'Tambah' }} Kategori</h6>
                <a href="{{ route('admin.categories.index') }}" class="card-action">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                    @csrf
                    @if(isset($category)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Kaos Polos">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Parent Kategori</label>
                        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">— Tidak ada (root) —</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    @selected(old('parent_id', $category->parent_id ?? '') == $parent->id)>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Deskripsi singkat...">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                                {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive" style="font-size:.85rem;">Aktif</label>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:10px;">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        {{ isset($category) ? 'Update Kategori' : 'Simpan Kategori' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
