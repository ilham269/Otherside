@extends('layouts.admin')
@section('title', 'Order #'.$order->id)
@section('page-title', 'Detail Order')

@section('content')
@include('admin.partials.alert')

<div class="row g-3">
    <div class="col-lg-8">
        <div class="admin-card mb-3">
            <div class="admin-card-header">
                <h6 class="card-title">Order #{{ $order->id }}</h6>
                <span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div style="font-size:.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Customer</div>
                        <div style="font-weight:600;margin-top:.25rem;">{{ $order->customer_name }}</div>
                        <div style="font-size:.83rem;color:#64748b;">{{ $order->customer_email }}</div>
                        <div style="font-size:.83rem;color:#64748b;">{{ $order->customer_phone }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Produk</div>
                        <div style="font-weight:600;margin-top:.25rem;">{{ $order->product->name ?? '—' }}</div>
                        <div style="font-size:.83rem;color:#64748b;">Qty: {{ $order->qty }}</div>
                        <div style="font-size:.83rem;font-weight:700;color:#6366f1;">Rp {{ number_format($order->total_price,0,',','.') }}</div>
                    </div>

                    @if($order->shipping_address)
                    <div class="col-12 pt-2 border-top" style="border-color:#f1f5f9!important;">
                        <div style="font-size:.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:.4rem;">Alamat Pengiriman</div>
                        <div style="font-size:.85rem;font-weight:600;">{{ $order->shipping_address }}</div>
                        <div style="font-size:.83rem;color:#64748b;">
                            {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                        </div>
                        @if($order->shipping_notes)
                        <div style="font-size:.78rem;color:#94a3b8;margin-top:.25rem;font-style:italic;">
                            Catatan: {{ $order->shipping_notes }}
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($order->payment_type)
                    <div class="col-sm-6">
                        <div style="font-size:.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Metode Bayar</div>
                        <div style="font-weight:600;margin-top:.25rem;text-transform:capitalize;">{{ str_replace('_', ' ', $order->payment_type) }}</div>
                    </div>
                    @endif
                </div>

                @if($order->payment_proof)
                <div class="mt-3 pt-3 border-top" style="border-color:#f1f5f9!important;">
                    <div style="font-size:.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:.5rem;">Bukti Pembayaran</div>
                    <img src="{{ Storage::url($order->payment_proof) }}" style="max-width:200px;border-radius:10px;border:1px solid #e2e8f0;">
                </div>
                @endif
            </div>
        </div>

        {{-- Upload Proof --}}
        <div class="admin-card">
            <div class="admin-card-header"><h6 class="card-title">Upload Bukti Pembayaran</h6></div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.orders.proof', $order) }}" enctype="multipart/form-data" class="d-flex gap-2">
                    @csrf
                    <input type="file" name="payment_proof" accept="image/*,.pdf" class="form-control form-control-sm" style="border-radius:8px;">
                    <button type="submit" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px;white-space:nowrap;">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Update Status --}}
        <div class="admin-card mb-3">
            <div class="admin-card-header"><h6 class="card-title">Update Status</h6></div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm mb-2" style="border-radius:8px;">
                        @foreach(['pending','processing','shipped','completed','cancelled'] as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm w-100" style="background:#6366f1;color:#fff;border-radius:8px;">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><h6 class="card-title">Info</h6></div>
            <div class="admin-card-body" style="font-size:.83rem;">
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Dibuat</span>
                    <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Diupdate</span>
                    <span>{{ $order->updated_at->format('d M Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span style="color:#64748b;">User</span>
                    <span>{{ $order->user->name ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
