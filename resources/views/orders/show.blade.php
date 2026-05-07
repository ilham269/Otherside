@extends('layouts.store')

@section('title', 'Tracking Order #' . $order->id)

@push('styles')
<style>
.tracking-timeline {
    position: relative;
    padding-left: 2rem;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 11px; top: 0; bottom: 0;
    width: 2px;
    background: #e8e8e8;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.75rem;
}

.timeline-item:last-child { padding-bottom: 0; }

.timeline-dot {
    position: absolute;
    left: -2rem;
    top: 2px;
    width: 24px; height: 24px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem;
    border: 2px solid #e8e8e8;
    background: #fff;
    z-index: 1;
}

.timeline-item.done .timeline-dot    { background: #059669; border-color: #059669; color: #fff; }
.timeline-item.active .timeline-dot  { background: #0a0a0a; border-color: #0a0a0a; color: #fff; box-shadow: 0 0 0 4px rgba(0,0,0,.08); }
.timeline-item.upcoming .timeline-dot{ background: #fff; border-color: #e0e0e0; color: #ccc; }
.timeline-item.cancelled .timeline-dot{ background: #dc2626; border-color: #dc2626; color: #fff; }

.timeline-label {
    font-size: .88rem; font-weight: 700;
    color: #0a0a0a;
}
.timeline-item.upcoming .timeline-label { color: #bbb; }

.timeline-desc {
    font-size: .78rem; color: #999;
    margin-top: .2rem; line-height: 1.5;
}
.timeline-item.upcoming .timeline-desc { color: #ddd; }

.info-row {
    display: flex; justify-content: space-between;
    font-size: .85rem; padding: .5rem 0;
    border-bottom: 1px solid #f5f5f5;
}
.info-row:last-child { border-bottom: none; }
.info-row .label { color: #999; }
.info-row .value { font-weight: 600; text-align: right; max-width: 60%; }
</style>
@endpush

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('orders.index') }}" style="width:36px;height:36px;border-radius:50%;border:1.5px solid #e0e0e0;display:flex;align-items:center;justify-content:center;color:#333;text-decoration:none;flex-shrink:0;">
            <i class="fa-solid fa-arrow-left" style="font-size:.8rem;"></i>
        </a>
        <div>
            <h5 style="font-weight:800;margin:0;">Order #{{ $order->id }}</h5>
            <div style="font-size:.78rem;color:#999;">{{ $order->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Left: Tracking + Info --}}
        <div class="col-lg-7">

            {{-- Tracking Timeline --}}
            <div style="background:#fff;border:1px solid #ebebeb;border-radius:16px;padding:1.5rem;margin-bottom:1rem;">
                <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#999;margin-bottom:1.25rem;">
                    <i class="fa-solid fa-location-dot me-2"></i>Status Pengiriman
                </div>

                <div class="tracking-timeline">
                    @foreach($timeline as $step)
                    <div class="timeline-item {{ $step['status'] }}">
                        <div class="timeline-dot">
                            @if($step['status'] === 'done')
                                <i class="fa-solid fa-check"></i>
                            @elseif($step['status'] === 'cancelled')
                                <i class="fa-solid fa-xmark"></i>
                            @else
                                <i class="fa-solid {{ $step['icon'] }}"></i>
                            @endif
                        </div>
                        <div class="timeline-label">{{ $step['label'] }}</div>
                        <div class="timeline-desc">{{ $step['desc'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Alamat Pengiriman --}}
            @if($order->shipping_address)
            <div style="background:#fff;border:1px solid #ebebeb;border-radius:16px;padding:1.5rem;margin-bottom:1rem;">
                <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#999;margin-bottom:.75rem;">
                    <i class="fa-solid fa-location-dot me-2"></i>Alamat Pengiriman
                </div>
                <div style="font-weight:700;font-size:.9rem;">{{ $order->customer_name }}</div>
                <div style="font-size:.83rem;color:#555;margin-top:.25rem;">{{ $order->customer_phone }}</div>
                <div style="font-size:.83rem;color:#555;margin-top:.25rem;line-height:1.6;">
                    {{ $order->shipping_address }},<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
                </div>
                @if($order->shipping_notes)
                <div style="font-size:.78rem;color:#999;margin-top:.4rem;font-style:italic;">
                    <i class="fa-solid fa-note-sticky me-1"></i>{{ $order->shipping_notes }}
                </div>
                @endif
            </div>
            @endif

            {{-- Info Pembayaran --}}
            <div style="background:#fff;border:1px solid #ebebeb;border-radius:16px;padding:1.5rem;">
                <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#999;margin-bottom:.75rem;">
                    <i class="fa-solid fa-credit-card me-2"></i>Info Pembayaran
                </div>
                <div class="info-row">
                    <span class="label">Metode Bayar</span>
                    <span class="value">
                        @if($order->payment_type)
                            {{ ucwords(str_replace('_', ' ', $order->payment_type)) }}
                        @elseif($order->snap_token && $order->status !== 'cancelled')
                            Sudah dibayar via Midtrans
                        @else
                            Belum dibayar
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">ID Transaksi</span>
                    <span class="value" style="font-size:.78rem;word-break:break-all;">{{ $order->midtrans_order_id ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Status</span>
                    <span class="value">
                        @php
                            $labels = ['pending'=>'Menunggu Konfirmasi','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
                            $colors = ['pending'=>'#d97706','processing'=>'#2563eb','shipped'=>'#7c3aed','completed'=>'#059669','cancelled'=>'#dc2626'];
                        @endphp
                        <span style="color:{{ $colors[$order->status] ?? '#333' }};font-weight:800;">
                            {{ $labels[$order->status] ?? ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
            </div>

        </div>

        {{-- Right: Ringkasan Produk --}}
        <div class="col-lg-5">
            <div style="position:sticky;top:80px;">
                <div style="background:#fff;border:1px solid #ebebeb;border-radius:16px;padding:1.5rem;">
                    <div style="font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#999;margin-bottom:1rem;">
                        <i class="fa-solid fa-box me-2"></i>Detail Produk
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        @if($order->product?->primaryImage)
                            <img src="{{ Storage::url($order->product->primaryImage->image_path) }}"
                                style="width:72px;height:72px;object-fit:cover;border-radius:10px;border:1px solid #ebebeb;flex-shrink:0;">
                        @else
                            <div style="width:72px;height:72px;border-radius:10px;background:#f4f4f4;display:flex;align-items:center;justify-content:center;color:#ccc;flex-shrink:0;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight:700;font-size:.9rem;line-height:1.3;">
                                {{ $order->product->name ?? 'Produk dihapus' }}
                            </div>
                            <div style="font-size:.78rem;color:#999;margin-top:.2rem;">
                                {{ $order->product->category->name ?? '' }}
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="label">Harga satuan</span>
                        <span class="value">Rp {{ number_format($order->product->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Jumlah</span>
                        <span class="value">{{ $order->qty }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Ongkos kirim</span>
                        <span class="value" style="color:#059669;">Gratis</span>
                    </div>
                    <div class="info-row" style="border-top:2px solid #f0f0f0;margin-top:.25rem;padding-top:.75rem;">
                        <span style="font-weight:800;font-size:.95rem;">Total</span>
                        <span style="font-weight:800;font-size:1rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Butuh bantuan --}}
                <div style="background:#f8f8f8;border-radius:12px;padding:1rem;margin-top:1rem;font-size:.8rem;color:#666;">
                    <div style="font-weight:700;color:#333;margin-bottom:.3rem;">
                        <i class="fa-solid fa-headset me-2"></i>Butuh Bantuan?
                    </div>
                    Hubungi kami jika ada pertanyaan tentang pesananmu.
                    <div class="mt-2">
                        <a href="https://wa.me/" target="_blank" class="btn-dark" style="font-size:.75rem;padding:.4rem .9rem;">
                            <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
