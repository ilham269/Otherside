@extends('layouts.admin')
@section('title', $user->name)
@section('page-title', 'Detail User')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-body text-center py-4">
                <div style="width:64px;height:64px;border-radius:50%;background:#eef2ff;color:#6366f1;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.5rem;margin:0 auto .75rem;">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div style="font-weight:700;font-size:1rem;">{{ $user->name }}</div>
                <div style="font-size:.83rem;color:#64748b;">{{ $user->email }}</div>
                <div class="mt-2">
                    <span class="status-badge {{ $user->email_verified_at ? 'completed' : 'pending' }}">
                        {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                    </span>
                </div>
                <div style="font-size:.78rem;color:#94a3b8;margin-top:.5rem;">
                    Bergabung {{ $user->created_at->format('d M Y') }}
                </div>
            </div>
            <div class="admin-card-body border-top pt-3" style="border-color:#f1f5f9!important;">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn w-100 mb-2" style="background:#6366f1;color:#fff;border-radius:10px;font-size:.85rem;">
                    <i class="fa-solid fa-pen me-1"></i> Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100" style="border-radius:10px;font-size:.85rem;">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header"><h6 class="card-title">Riwayat Order</h6></div>
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr><th>#</th><th>Produk</th><th>Total</th><th>Status</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $order)
                        <tr>
                            <td><span style="font-weight:700;color:#6366f1;">#{{ $order->id }}</span></td>
                            <td style="font-size:.83rem;">{{ $order->product->name ?? '—' }}</td>
                            <td style="font-weight:700;font-size:.83rem;">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                            <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td style="font-size:.78rem;color:#94a3b8;">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
