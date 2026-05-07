@extends('layouts.admin')
@section('title','Posts')
@section('page-title','Posts')

@section('content')
@include('admin.partials.alert')

<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="card-title">Semua Post</h6>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="fa-solid fa-plus me-1"></i> Tambah
        </a>
    </div>

    <div class="p-3 border-bottom" style="border-color:#f1f5f9!important;">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                class="form-control form-control-sm" style="max-width:220px;border-radius:8px;">
            <select name="status" class="form-select form-select-sm" style="max-width:140px;border-radius:8px;">
                <option value="">Semua Status</option>
                <option value="draft" @selected(request('status')==='draft')>Draft</option>
                <option value="published" @selected(request('status')==='published')>Published</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Filter</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>Tags</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:.85rem;">{{ $post->title }}</div>
                        <div style="font-size:.73rem;color:#94a3b8;">{{ $post->slug }}</div>
                    </td>
                    <td style="font-size:.83rem;color:#64748b;">{{ $post->admin->name ?? '—' }}</td>
                    <td style="font-size:.75rem;color:#64748b;max-width:120px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $post->tags ?? '—' }}
                    </td>
                    <td><span class="status-badge {{ $post->status }}">{{ ucfirst($post->status) }}</span></td>
                    <td style="font-size:.78rem;color:#94a3b8;">
                        {{ $post->published_at ? $post->published_at->format('d M Y') : '—' }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn-action edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                onsubmit="return confirm('Hapus post ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada post</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        @include('admin.partials.pagination', ['paginator' => $posts])
    </div>
</div>
@endsection
