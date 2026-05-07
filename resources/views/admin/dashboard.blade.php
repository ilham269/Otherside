@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ─── Greeting ─────────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="fw-bold mb-0" style="color:#0f172a;">
            Selamat datang, {{ Auth::guard('admin')->user()->name }} 👋
        </h5>
        <p class="text-muted mb-0" style="font-size:.85rem;">
            {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>
    <a href="#" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:10px;font-size:.82rem;padding:.45rem 1rem;">
        <i class="fa-solid fa-plus me-1"></i> New Order
    </a>
</div>

{{-- ─── Stat Cards ──────────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff;color:#6366f1;">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +12% bulan ini</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +8% bulan ini</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;color:#059669;">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_products']) }}</div>
            <div class="stat-label">Total Products</div>
            <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +3 produk baru</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce7f3;color:#db2777;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-label">Total Users</div>
            <div class="stat-change up"><i class="fa-solid fa-arrow-trend-up"></i> +5 user baru</div>
        </div>
    </div>
</div>

{{-- ─── Alert Badges ────────────────────────────────────────────────────────── --}}
@if($stats['pending_orders'] > 0 || $stats['pending_custom'] > 0 || $stats['unread_messages'] > 0)
<div class="d-flex flex-wrap gap-2 mb-4">
    @if($stats['pending_orders'] > 0)
    <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
       style="background:#fef3c7;color:#d97706;font-size:.8rem;font-weight:600;">
        <i class="fa-solid fa-clock"></i>
        {{ $stats['pending_orders'] }} order menunggu konfirmasi
    </a>
    @endif
    @if($stats['pending_custom'] > 0)
    <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
       style="background:#e0e7ff;color:#7c3aed;font-size:.8rem;font-weight:600;">
        <i class="fa-solid fa-pen-ruler"></i>
        {{ $stats['pending_custom'] }} custom order baru
    </a>
    @endif
    @if($stats['unread_messages'] > 0)
    <a href="#" class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
       style="background:#dbeafe;color:#2563eb;font-size:.8rem;font-weight:600;">
        <i class="fa-solid fa-envelope"></i>
        {{ $stats['unread_messages'] }} pesan belum dibaca
    </a>
    @endif
</div>
@endif

{{-- ─── Charts Row ──────────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    {{-- Revenue Chart --}}
    <div class="col-lg-8">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h6 class="card-title">Revenue 7 Hari Terakhir</h6>
                <span style="font-size:.75rem;color:#94a3b8;">Completed orders only</span>
            </div>
            <div class="admin-card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Status Donut --}}
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h6 class="card-title">Status Orders</h6>
            </div>
            <div class="admin-card-body">
                <div class="chart-container" style="height:200px;">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="mt-3">
                    @foreach(['pending'=>'#d97706','processing'=>'#2563eb','shipped'=>'#7c3aed','completed'=>'#059669','cancelled'=>'#dc2626'] as $status => $color)
                    <div class="d-flex align-items-center justify-content-between mb-1" style="font-size:.78rem;">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $color }};display:inline-block;"></span>
                            <span class="text-capitalize">{{ $status }}</span>
                        </div>
                        <span class="fw-bold">{{ $orderStatus[$status] ?? 0 }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── Recent Orders + Messages ───────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    {{-- Recent Orders --}}
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">Recent Orders</h6>
                <a href="#" class="card-action">Lihat semua</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><span style="font-weight:700;color:#6366f1;">#{{ $order->id }}</span></td>
                            <td>
                                <div style="font-weight:600;font-size:.83rem;">{{ $order->customer_name }}</div>
                                <div style="font-size:.73rem;color:#94a3b8;">{{ $order->customer_email }}</div>
                            </td>
                            <td style="max-width:160px;">
                                <div style="font-size:.83rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $order->product->name ?? '-' }}
                                </div>
                                <div style="font-size:.73rem;color:#94a3b8;">Qty: {{ $order->qty }}</div>
                            </td>
                            <td style="font-weight:700;font-size:.83rem;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td style="font-size:.78rem;color:#94a3b8;">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h6 class="card-title">Pesan Masuk</h6>
                <a href="#" class="card-action">Lihat semua</a>
            </div>
            <div class="admin-card-body" style="padding-top:.5rem;">
                @forelse($recentMessages as $msg)
                <div class="activity-item">
                    <div class="activity-dot" style="background:#eef2ff;color:#6366f1;">
                        <i class="fa-solid fa-user" style="font-size:.7rem;"></i>
                    </div>
                    <div class="activity-text">
                        <div class="title">{{ $msg->sender_name }}</div>
                        <div style="font-size:.78rem;color:#475569;margin-top:2px;
                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                            {{ $msg->message }}
                        </div>
                        <div class="time">{{ $msg->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$msg->read_at)
                    <span style="width:8px;height:8px;background:#6366f1;border-radius:50%;flex-shrink:0;margin-top:4px;"></span>
                    @endif
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:.83rem;">Tidak ada pesan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ─── Custom Orders + Top Products ──────────────────────────────────────── --}}
<div class="row g-3">
    {{-- Custom Orders --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">Custom Orders Terbaru</h6>
                <a href="#" class="card-action">Lihat semua</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Est. Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomOrders as $co)
                        <tr>
                            <td><span style="font-weight:700;color:#6366f1;">#{{ $co->id }}</span></td>
                            <td style="max-width:150px;">
                                <div style="font-size:.83rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $co->subject }}
                                </div>
                                <div style="font-size:.73rem;color:#94a3b8;">{{ $co->customer_email }}</div>
                            </td>
                            <td>
                                <span style="font-size:.73rem;background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:20px;font-weight:600;">
                                    {{ ucfirst($co->type ?? '-') }}
                                </span>
                            </td>
                            <td style="font-size:.83rem;font-weight:700;">
                                {{ $co->estimated_price ? 'Rp '.number_format($co->estimated_price,0,',','.') : '-' }}
                            </td>
                            <td><span class="status-badge {{ $co->status }}">{{ ucfirst($co->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada custom order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">Top Products</h6>
                <a href="#" class="card-action">Lihat semua</a>
            </div>
            <div class="admin-card-body" style="padding-top:.5rem;">
                @forelse($topProducts as $i => $product)
                <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color:#f1f5f9!important;">
                    <div style="width:28px;height:28px;border-radius:8px;background:{{ ['#eef2ff','#fef3c7','#d1fae5','#fce7f3','#dbeafe'][$i] }};
                        display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;
                        color:{{ ['#6366f1','#d97706','#059669','#db2777','#2563eb'][$i] }};flex-shrink:0;">
                        {{ $i + 1 }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.83rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $product->name }}
                        </div>
                        <div style="font-size:.73rem;color:#94a3b8;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-end" style="flex-shrink:0;">
                        <div style="font-size:.83rem;font-weight:700;color:#0f172a;">
                            {{ number_format($product->total_sold ?? 0) }} terjual
                        </div>
                        <div style="font-size:.73rem;color:#94a3b8;">Stok: {{ $product->stock }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:.83rem;">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ─── Revenue Chart ────────────────────────────────────────────────────────
    const labels = @json($chartLabels->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M')));
    const data   = @json($chartData->values());

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Revenue',
                data,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#6366f1',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: .4,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 11 },
                        callback: v => 'Rp ' + Intl.NumberFormat('id').format(v)
                    }
                }
            }
        }
    });

    // ─── Status Donut Chart ───────────────────────────────────────────────────
    const statusData = @json($orderStatus);
    const statusLabels = ['pending','processing','shipped','completed','cancelled'];
    const statusColors = ['#d97706','#2563eb','#7c3aed','#059669','#dc2626'];

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: statusLabels.map(s => statusData[s] ?? 0),
                backgroundColor: statusColors,
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });

});
</script>
@endpush
