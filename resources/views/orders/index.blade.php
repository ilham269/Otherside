@extends('layouts.store')

@section('title', 'Pesanan Saya')

@push('styles')
<style>
.order-card {
    background: #fff;
    border: 1px solid #ebebeb;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1rem;
    transition: box-shadow .2s;
    text-decoration: none;
    display: block;
    color: inherit;
}
.order-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.08); color: inherit; }

.order-status-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .28rem .75rem; border-radius: 20px;
    font-size: .72rem; font-weight: 800;
    text-transform: capitalize;
}
.badge-pending    { background: #fef3c7; color: #d97706; }
.badge-processing { background: #dbeafe; color: #2563eb; }
.badge-shipped    { background: #e0e7ff; color: #7c3aed; }
.badge-completed  { background: #d1fae5; color: #059669; }
.badge-cancelled  { background: #fee2e2; color: #dc2626; }
</style>
@endpush

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 style="font-weight:800;margin-bottom:.1rem;">Pesanan Saya</h5>
            <p style="font-size:.83rem;color:#999;margin:0;">Pantau status semua pesananmu di sini</p>
        </div>
        <a href="{{ route('home') }}" class="btn-outline-dark" style="font-size:.8rem;padding:.4rem 1rem;">
            <i class="fa-solid fa-arrow-left me-1"></i> Belanja Lagi
        </a>
    </div>

    @forelse($orders as $order)
    <a href="{{ route('orders.show', $order) }}" class="order-card">
        <div class="d-flex align-items-center gap-3">
            {{-- Gambar produk --}}
            @if($order->product?->primaryImage)
                <img src="{{ Storage::url($order->product->primaryImage->image_path) }}"
                    style="width:60px;height:60px;object-fit:cover;border-radius:10px;border:1px solid #ebebeb;flex-shrink:0;">
            @else
                <div style="width:60px;height:60px;border-radius:10px;background:#f4f4f4;display:flex;align-items:center;justify-content:center;color:#ccc;flex-shrink:0;">
                    <i class="fa-solid fa-image"></i>
                </div>
            @endif

            {{-- Info --}}
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $order->product->name ?? 'Produk dihapus' }}
                </div>
                <div style="font-size:.78rem;color:#999;margin-top:.15rem;">
                    Order #{{ $order->id }} · {{ $order->created_at->format('d M Y') }}
                </div>
                <div style="font-size:.78rem;color:#999;">
                    Qty: {{ $order->qty }} · <strong style="color:#0a0a0a;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>
            </div>

            {{-- Status + arrow --}}
            <div class="d-flex flex-column align-items-end gap-2" style="flex-shrink:0;">
                <span class="order-status-badge badge-{{ $order->status }}">
                    @php
                        $labels = ['pending'=>'Menunggu Konfirmasi','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
                    @endphp
                    {{ $labels[$order->status] ?? ucfirst($order->status) }}
                </span>
                <span style="font-size:.75rem;color:#bbb;">Lihat detail <i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></span>
            </div>
        </div>
    </a>
    @empty
    <div style="text-align:center;padding:4rem 0;">
        <div style="font-size:3rem;color:#e0e0e0;margin-bottom:1rem;"><i class="fa-solid fa-bag-shopping"></i></div>
        <div style="font-weight:700;color:#333;margin-bottom:.4rem;">Belum ada pesanan</div>
        <p style="font-size:.85rem;color:#999;margin-bottom:1.5rem;">Yuk mulai belanja produk favoritmu!</p>
        <a href="{{ route('home') }}" class="btn-dark">Mulai Belanja</a>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="d-flex justify-content-center mt-3 gap-2" style="font-size:.83rem;">
        @if($orders->onFirstPage())
            <span style="padding:.35rem .75rem;border:1px solid #e0e0e0;border-radius:8px;color:#ccc;">‹</span>
        @else
            <a href="{{ $orders->previousPageUrl() }}" style="padding:.35rem .75rem;border:1px solid #e0e0e0;border-radius:8px;color:#333;text-decoration:none;">‹</a>
        @endif

        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
            <a href="{{ $url }}" style="padding:.35rem .75rem;border:1px solid {{ $page == $orders->currentPage() ? '#0a0a0a' : '#e0e0e0' }};border-radius:8px;background:{{ $page == $orders->currentPage() ? '#0a0a0a' : '#fff' }};color:{{ $page == $orders->currentPage() ? '#fff' : '#333' }};text-decoration:none;">{{ $page }}</a>
        @endforeach

        @if($orders->hasMorePages())
            <a href="{{ $orders->nextPageUrl() }}" style="padding:.35rem .75rem;border:1px solid #e0e0e0;border-radius:8px;color:#333;text-decoration:none;">›</a>
        @else
            <span style="padding:.35rem .75rem;border:1px solid #e0e0e0;border-radius:8px;color:#ccc;">›</span>
        @endif
    </div>
    @endif

</div>
@endsection
