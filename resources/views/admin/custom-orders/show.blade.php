@extends('layouts.admin')
@section('title', 'Custom Order #'.$customOrder->id)
@section('page-title', 'Detail Custom Order')

@section('content')
@include('admin.partials.alert')

<div class="row g-3">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">Custom Order #{{ $customOrder->id }}</h6>
                <span class="status-badge {{ $customOrder->status }}">{{ ucfirst($customOrder->status) }}</span>
            </div>
            <div class="admin-card-body">
                <table style="width:100%;font-size:.85rem;">
                    @foreach([
                        'Subject'       => $customOrder->subject,
                        'Customer'      => $customOrder->customer_email,
                        'Tipe'          => ucfirst($customOrder->type ?? '—'),
                        'Qty'           => $customOrder->qty,
                        'Track ID POS'  => $customOrder->track_id_pos ?? '—',
                        'Track ID Store'=> $customOrder->track_id_store ?? '—',
                        'Produk'        => $customOrder->product->name ?? '—',
                    ] as $label => $value)
                    <tr class="border-bottom" style="border-color:#f1f5f9!important;">
                        <td style="padding:.6rem 0;color:#64748b;width:140px;">{{ $label }}</td>
                        <td style="padding:.6rem 0;font-weight:600;">{{ $value }}</td>
                    </tr>
                    @endforeach
                </table>

                @if($customOrder->notes)
                <div class="mt-3 pt-3 border-top" style="border-color:#f1f5f9!important;">
                    <div style="font-size:.75rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:.4rem;">Catatan</div>
                    <p style="font-size:.85rem;color:#475569;">{{ $customOrder->notes }}</p>
                </div>
                @endif

                @if($customOrder->reference_file)
                <div class="mt-2">
                    <a href="{{ Storage::url($customOrder->reference_file) }}" target="_blank"
                        class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.8rem;">
                        <i class="fa-solid fa-file me-1"></i> Lihat File Referensi
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Update Status --}}
        <div class="admin-card mb-3">
            <div class="admin-card-header"><h6 class="card-title">Update Status</h6></div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.custom-orders.status', $customOrder) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm mb-2" style="border-radius:8px;">
                        @foreach(['pending','processing','completed','cancelled'] as $s)
                            <option value="{{ $s }}" @selected($customOrder->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm w-100" style="background:#6366f1;color:#fff;border-radius:8px;">Update</button>
                </form>
            </div>
        </div>

        {{-- Set Price --}}
        <div class="admin-card mb-3">
            <div class="admin-card-header"><h6 class="card-title">Estimasi Harga</h6></div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.custom-orders.price', $customOrder) }}">
                    @csrf @method('PATCH')
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="estimated_price" value="{{ $customOrder->estimated_price }}"
                            class="form-control" placeholder="0" min="0">
                    </div>
                    <button type="submit" class="btn btn-sm w-100" style="background:#059669;color:#fff;border-radius:8px;">Simpan Harga</button>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.custom-orders.index') }}" class="btn btn-outline-secondary w-100" style="border-radius:10px;font-size:.85rem;">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
