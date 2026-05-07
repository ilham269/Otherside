@extends('layouts.admin')
@section('title','Users')
@section('page-title','Users')

@section('content')
@include('admin.partials.alert')

<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="card-title">Semua User</h6>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="fa-solid fa-plus me-1"></i> Tambah
        </a>
    </div>

    <div class="p-3 border-bottom" style="border-color:#f1f5f9!important;">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                class="form-control form-control-sm" style="max-width:260px;border-radius:8px;">
            <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Total Order</th>
                    <th>Verified</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:34px;height:34px;border-radius:50%;background:#eef2ff;color:#6366f1;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <span style="font-weight:600;font-size:.85rem;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:.83rem;color:#64748b;">{{ $user->email }}</td>
                    <td style="font-size:.83rem;font-weight:600;">{{ $user->orders_count }}</td>
                    <td>
                        <span class="status-badge {{ $user->email_verified_at ? 'completed' : 'pending' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                        </span>
                    </td>
                    <td style="font-size:.78rem;color:#94a3b8;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-action view">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-action edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        @include('admin.partials.pagination', ['paginator' => $users])
    </div>
</div>
@endsection
