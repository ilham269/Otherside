@extends('layouts.admin')
@section('title', isset($post) ? 'Edit Post' : 'Tambah Post')
@section('page-title', isset($post) ? 'Edit Post' : 'Tambah Post')

@section('content')
<form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card mb-3">
                <div class="admin-card-header"><h6 class="card-title">Konten</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
                            class="form-control @error('title') is-invalid @enderror" placeholder="Judul post">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Konten <span class="text-danger">*</span></label>
                        <textarea name="body" rows="12" class="form-control @error('body') is-invalid @enderror"
                            placeholder="Tulis konten post...">{{ old('body', $post->body ?? '') }}</textarea>
                        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header"><h6 class="card-title">SEO</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}"
                            class="form-control" placeholder="Meta title untuk SEO">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="form-control"
                            placeholder="Deskripsi singkat untuk SEO...">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="admin-card-header"><h6 class="card-title">Pengaturan</h6></div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $post->status ?? '') === 'published')>Published</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Tags</label>
                        <input type="text" name="tags" value="{{ old('tags', $post->tags ?? '') }}"
                            class="form-control" placeholder="tag1,tag2,tag3">
                        <div style="font-size:.73rem;color:#94a3b8;margin-top:.3rem;">Pisahkan dengan koma</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Thumbnail</label>
                        @if(isset($post) && $post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" style="width:100%;border-radius:8px;margin-bottom:.5rem;">
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="form-control form-control-sm">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:10px;">
                <i class="fa-solid fa-floppy-disk me-1"></i>
                {{ isset($post) ? 'Update Post' : 'Simpan Post' }}
            </button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:10px;font-size:.85rem;">Batal</a>
        </div>
    </div>
</form>
@endsection
