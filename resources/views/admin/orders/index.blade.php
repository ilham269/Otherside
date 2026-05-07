@extends('layouts.admin')
@section('title','Orders')
@section('page-title','Orders')

@section('content')
@include('admin.partials.alert')

<div class="admin-card">
    <div class="admin-card-header">
        <h6 class="card-title">Semua Order</h6>
    </div>

    <div class="p-3 border-bottom" style="border-color:#f1f5f9!important;">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                class="form-control form-control-sm" style="max-width:220px;border-radius:8px;">
            <select name="status" class="form-select form-select-sm" style="max-width:150px;border-radius:8px;">
                <option value="">Semua Status</option>
                @foreach(['pending','processing','shipped','completed','cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Filter</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Customer</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span style="font-weight:700;color:#6366f1;">#{{ $order->id }}</span></td>
                    <td>
                        <div style="font-weight:600;font-size:.83rem;">{{ $order->customer_name }}</div>
                        <div style="font-size:.73rem;color:#94a3b8;">{{ $order->customer_email }}</div>
                    </td>
                    <td style="font-size:.83rem;max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $order->product->name ?? '—' }}
                    </td>
                    <td style="font-size:.83rem;">{{ $order->qty }}</td>
                    <td style="font-weight:700;font-size:.83rem;">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                    <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td style="font-size:.78rem;color:#94a3b8;">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-action view" title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                onsubmit="return confirm('Hapus order ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada order</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        @include('admin.partials.pagination', ['paginator' => $orders])
    </div>
</div>
@endsection
