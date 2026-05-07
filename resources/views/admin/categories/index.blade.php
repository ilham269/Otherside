@extends('layouts.admin')
@section('title','Categories')
@section('page-title','Categories')

@section('content')
@include('admin.partials.alert')

<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="card-title">Semua Kategori</h6>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="fa-solid fa-plus me-1"></i> Tambah
        </a>
    </div>

    {{-- Filter --}}
    <div class="p-3 border-bottom" style="border-color:#f1f5f9!important;">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                class="form-control form-control-sm" style="max-width:220px;border-radius:8px;">
            <select name="is_active" class="form-select form-select-sm" style="max-width:140px;border-radius:8px;">
                <option value="">Semua Status</option>
                <option value="1" @selected(request('is_active')==='1')>Aktif</option>
                <option value="0" @selected(request('is_active')==='0')>Nonaktif</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Filter</button>
            @if(request()->hasAny(['search','is_active']))
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td style="color:#94a3b8;font-size:.78rem;">{{ $cat->id }}</td>
                    <td style="font-weight:600;">{{ $cat->name }}</td>
                    <td><code style="font-size:.75rem;background:#f1f5f9;padding:2px 6px;border-radius:4px;">{{ $cat->slug }}</code></td>
                    <td style="color:#64748b;">{{ $cat->parent->name ?? '—' }}</td>
                    <td>
                        <span class="status-badge {{ $cat->is_active ? 'completed' : 'cancelled' }}">
                            {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-action edit" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        @include('admin.partials.pagination', ['paginator' => $categories])
    </div>
</div>
@endsection
