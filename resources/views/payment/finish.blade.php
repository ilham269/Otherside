@extends('layouts.store')

@section('title', 'Pembayaran Selesai')

@section('content')
<div class="page-wrap" style="padding-top:6rem;padding-bottom:4rem;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 text-center">

            @if($order && $order->status === 'processing')
                {{-- Sukses --}}
                <div style="width:72px;height:72px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.75rem;color:#059669;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h4 style="font-weight:800;margin-bottom:.5rem;">Pembayaran Berhasil!</h4>
                <p style="color:#666;font-size:.9rem;margin-bottom:1.5rem;">
                    Terima kasih, pesananmu sedang diproses. Kami akan menghubungimu segera.
                </p>
            @elseif($order && $order->status === 'pending')
                {{-- Pending --}}
                <div style="width:72px;height:72px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.75rem;color:#d97706;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h4 style="font-weight:800;margin-bottom:.5rem;">Menunggu Konfirmasi Penjual</h4>
                <p style="color:#666;font-size:.9rem;margin-bottom:1.5rem;">
                    Pembayaranmu sudah kami terima. Tim kami akan segera memverifikasi dan memproses pesananmu.
                </p>
            @else
                {{-- Default --}}
                <div style="width:72px;height:72px;background:#eef2ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.75rem;color:#6366f1;">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h4 style="font-weight:800;margin-bottom:.5rem;">Transaksi Diproses</h4>
                <p style="color:#666;font-size:.9rem;margin-bottom:1.5rem;">
                    Status pembayaranmu sedang diverifikasi.
                </p>
            @endif

            @if($order)
            <div style="background:#f8f8f8;border-radius:12px;padding:1.25rem;text-align:left;margin-bottom:1.5rem;">
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span style="color:#666;">Order ID</span>
                    <span style="font-weight:700;">#{{ $order->id }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span style="color:#666;">Produk</span>
                    <span style="font-weight:700;">{{ $order->product->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span style="color:#666;">Total</span>
                    <span style="font-weight:800;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between" style="font-size:.85rem;">
                    <span style="color:#666;">Status</span>
                    <span style="font-weight:700;text-transform:capitalize;">{{ $order->status }}</span>
                </div>
            </div>
            @endif

            <a href="{{ route('home') }}" class="btn-dark" style="display:inline-flex;padding:.65rem 1.75rem;">
                <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
            </a>

            @if($order)
            <a href="{{ route('orders.show', $order) }}" class="btn-outline-dark" style="display:inline-flex;padding:.65rem 1.75rem;margin-left:.5rem;">
                <i class="fa-solid fa-magnifying-glass me-2"></i> Lacak Pesanan
            </a>
            @endif

        </div>
    </div>
</div>
@endsection
