@extends('layouts.admin')
@section('title','Custom Orders')
@section('page-title','Custom Orders')

@section('content')
@include('admin.partials.alert')

<div class="admin-card">
    <div class="admin-card-header"><h6 class="card-title">Semua Custom Order</h6></div>

    <div class="p-3 border-bottom" style="border-color:#f1f5f9!important;">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari subject / email..."
                class="form-control form-control-sm" style="max-width:220px;border-radius:8px;">
            <select name="status" class="form-select form-select-sm" style="max-width:150px;border-radius:8px;">
                <option value="">Semua Status</option>
                @foreach(['pending','processing','completed','cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <select name="type" class="form-select form-select-sm" style="max-width:130px;border-radius:8px;">
                <option value="">Semua Tipe</option>
                @foreach(['bulk','personal','event'] as $t)
                    <option value="{{ $t }}" @selected(request('type') === $t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">Filter</button>
            @if(request()->hasAny(['search','status','type']))
                <a href="{{ route('admin.custom-orders.index') }}" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Customer</th>
                    <th>Tipe</th>
                    <th>Qty</th>
                    <th>Est. Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customOrders as $co)
                <tr>
                    <td><span style="font-weight:700;color:#6366f1;">#{{ $co->id }}</span></td>
                    <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:.83rem;font-weight:600;">
                        {{ $co->subject }}
                    </td>
                    <td style="font-size:.83rem;color:#64748b;">{{ $co->customer_email }}</td>
                    <td>
                        <span style="font-size:.73rem;background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:20px;font-weight:600;">
                            {{ ucfirst($co->type ?? '—') }}
                        </span>
                    </td>
                    <td style="font-size:.83rem;">{{ $co->qty }}</td>
                    <td style="font-size:.83rem;font-weight:700;">
                        {{ $co->estimated_price ? 'Rp '.number_format($co->estimated_price,0,',','.') : '—' }}
                    </td>
                    <td><span class="status-badge {{ $co->status }}">{{ ucfirst($co->status) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.custom-orders.show', $co) }}" class="btn-action view">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.custom-orders.destroy', $co) }}"
                                onsubmit="return confirm('Hapus custom order ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada custom order</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        @include('admin.partials.pagination', ['paginator' => $customOrders])
    </div>
</div>
@endsection
