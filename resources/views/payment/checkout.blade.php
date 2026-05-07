@extends('layouts.store')

@section('title', 'Checkout — ' . $product->name)

@push('styles')
<style>
.checkout-step {
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; font-weight: 700; color: #bbb;
}
.checkout-step .step-num {
    width: 26px; height: 26px; border-radius: 50%;
    background: #e8e8e8; color: #999;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 800; flex-shrink: 0;
}
.checkout-step.active .step-num { background: #0a0a0a; color: #fff; }
.checkout-step.active { color: #0a0a0a; }
.checkout-step.done .step-num { background: #059669; color: #fff; }
.step-divider { flex: 1; height: 1px; background: #e8e8e8; min-width: 24px; }

.form-section {
    background: #fff; border: 1px solid #ebebeb;
    border-radius: 16px; padding: 1.5rem; margin-bottom: 1rem;
}
.form-section-title {
    font-size: .8rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: 1px;
    color: #999; margin-bottom: 1rem;
}
.form-control, .form-select {
    border-radius: 10px !important;
    font-size: .88rem;
    border-color: #e0e0e0;
}
.form-control:focus, .form-select:focus {
    border-color: #0a0a0a; box-shadow: 0 0 0 3px rgba(0,0,0,.06);
}
.form-label { font-size: .82rem; font-weight: 700; margin-bottom: .35rem; }
.invalid-feedback { font-size: .75rem; }
</style>
@endpush

@section('content')
<div class="page-wrap" style="padding-top:5rem;padding-bottom:4rem;">

    {{-- Step Indicator --}}
    <div class="d-flex align-items-center gap-2 mb-4">
        <div class="checkout-step done">
            <div class="step-num"><i class="fa-solid fa-check" style="font-size:.6rem;"></i></div>
            Produk
        </div>
        <div class="step-divider"></div>
        <div class="checkout-step active">
            <div class="step-num">2</div>
            Detail & Alamat
        </div>
        <div class="step-divider"></div>
        <div class="checkout-step">
            <div class="step-num">3</div>
            Pembayaran
        </div>
        <div class="step-divider"></div>
        <div class="checkout-step">
            <div class="step-num">4</div>
            Selesai
        </div>
    </div>

    <div class="row g-4">

        {{-- Left: Form --}}
        <div class="col-lg-7">
            <form id="checkoutForm" novalidate>
                @csrf

                {{-- Informasi Penerima --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-user me-2"></i>Informasi Penerima
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name"
                                value="{{ Auth::user()->name }}"
                                class="form-control" placeholder="Nama penerima" required>
                            <div class="invalid-feedback" id="err_customer_name"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="customer_email" id="customer_email"
                                value="{{ Auth::user()->email }}"
                                class="form-control" required>
                            <div class="invalid-feedback" id="err_customer_email"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone" id="customer_phone"
                                class="form-control" placeholder="08xxxxxxxxxx" required>
                            <div class="invalid-feedback" id="err_customer_phone"></div>
                        </div>
                    </div>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-location-dot me-2"></i>Alamat Pengiriman
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address" id="shipping_address"
                                class="form-control" placeholder="Nama jalan, nomor rumah, RT/RW" required>
                            <div class="invalid-feedback" id="err_shipping_address"></div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_city" id="shipping_city"
                                class="form-control" placeholder="Contoh: Jakarta Selatan" required>
                            <div class="invalid-feedback" id="err_shipping_city"></div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <select name="shipping_province" id="shipping_province" class="form-select" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach(['Aceh','Bali','Banten','Bengkulu','DI Yogyakarta','DKI Jakarta','Gorontalo','Jambi','Jawa Barat','Jawa Tengah','Jawa Timur','Kalimantan Barat','Kalimantan Selatan','Kalimantan Tengah','Kalimantan Timur','Kalimantan Utara','Kepulauan Bangka Belitung','Kepulauan Riau','Lampung','Maluku','Maluku Utara','Nusa Tenggara Barat','Nusa Tenggara Timur','Papua','Papua Barat','Riau','Sulawesi Barat','Sulawesi Selatan','Sulawesi Tengah','Sulawesi Tenggara','Sulawesi Utara','Sumatera Barat','Sumatera Selatan','Sumatera Utara'] as $prov)
                                    <option value="{{ $prov }}">{{ $prov }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="err_shipping_province"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_postal_code" id="shipping_postal_code"
                                class="form-control" placeholder="12345" maxlength="6" required>
                            <div class="invalid-feedback" id="err_shipping_postal_code"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan Pengiriman</label>
                            <textarea name="shipping_notes" id="shipping_notes" rows="2"
                                class="form-control" placeholder="Contoh: Titip ke satpam, warna pagar hijau..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fa-solid fa-box me-2"></i>Jumlah Pesanan
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" id="qtyMinus"
                            style="width:38px;height:38px;border-radius:50%;border:1.5px solid #e0e0e0;background:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;">−</button>
                        <input type="number" name="qty" id="qty" value="1"
                            min="1" max="{{ $product->stock }}"
                            class="form-control text-center"
                            style="width:72px;font-weight:800;" readonly>
                        <button type="button" id="qtyPlus"
                            style="width:38px;height:38px;border-radius:50%;border:1.5px solid #e0e0e0;background:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;">+</button>
                        <span style="font-size:.82rem;color:#999;">Stok tersedia: <strong>{{ $product->stock }}</strong></span>
                    </div>
                    <div class="invalid-feedback d-block" id="err_qty" style="font-size:.75rem;"></div>
                </div>

                {{-- Error global --}}
                <div id="globalError" class="alert alert-danger d-none" style="border-radius:10px;font-size:.85rem;"></div>

                <button type="button" id="payBtn"
                    style="width:100%;padding:.8rem;background:#0a0a0a;color:#fff;border:none;border-radius:12px;font-size:.95rem;font-weight:800;cursor:pointer;transition:background .2s;">
                    <i class="fa-solid fa-lock me-2"></i> Lanjut ke Pembayaran
                </button>
            </form>
        </div>

        {{-- Right: Summary --}}
        <div class="col-lg-5">
            <div style="position:sticky;top:80px;">
                <div class="form-section">
                    <div class="form-section-title">Ringkasan Pesanan</div>

                    <div class="d-flex gap-3 mb-3">
                        @if($product->primaryImage)
                            <img src="{{ Storage::url($product->primaryImage->image_path) }}"
                                style="width:72px;height:72px;object-fit:cover;border-radius:10px;border:1px solid #ebebeb;flex-shrink:0;">
                        @else
                            <div style="width:72px;height:72px;border-radius:10px;background:#f4f4f4;display:flex;align-items:center;justify-content:center;color:#ccc;flex-shrink:0;">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight:700;font-size:.9rem;line-height:1.3;">{{ $product->name }}</div>
                            <div style="font-size:.78rem;color:#999;margin-top:.2rem;">{{ $product->category->name ?? '' }}</div>
                            <div style="font-weight:800;font-size:.95rem;margin-top:.3rem;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#f0f0f0;margin:.75rem 0;">

                    <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                        <span style="color:#666;">Harga satuan</span>
                        <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                        <span style="color:#666;">Jumlah</span>
                        <span id="qtyDisplay">1</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                        <span style="color:#666;">Ongkos kirim</span>
                        <span style="color:#059669;font-weight:700;">Gratis</span>
                    </div>

                    <hr style="border-color:#f0f0f0;margin:.75rem 0;">

                    <div class="d-flex justify-content-between" style="font-weight:800;font-size:1.05rem;">
                        <span>Total</span>
                        <span id="totalPrice">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Info keamanan --}}
                <div style="background:#f8f8f8;border-radius:12px;padding:1rem;font-size:.78rem;color:#888;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="fa-solid fa-shield-halved" style="color:#059669;"></i>
                        <span style="font-weight:700;color:#333;">Pembayaran Aman</span>
                    </div>
                    Transaksi diproses oleh Midtrans dengan enkripsi SSL. Data kamu aman.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ config('midtrans.is_production')
    ? 'https://app.midtrans.com/snap/snap.js'
    : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
const unitPrice = {{ $product->price }};
const maxStock  = {{ $product->stock }};
const qtyInput  = document.getElementById('qty');

function formatRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function updateSummary() {
    const qty = parseInt(qtyInput.value) || 1;
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('totalPrice').textContent  = formatRp(unitPrice * qty);
}

document.getElementById('qtyMinus').addEventListener('click', () => {
    if (parseInt(qtyInput.value) > 1) { qtyInput.value--; updateSummary(); }
});
document.getElementById('qtyPlus').addEventListener('click', () => {
    if (parseInt(qtyInput.value) < maxStock) { qtyInput.value++; updateSummary(); }
});

// Clear error saat user mulai ketik
document.querySelectorAll('.form-control, .form-select').forEach(el => {
    el.addEventListener('input', () => {
        el.classList.remove('is-invalid');
        const errEl = document.getElementById('err_' + el.name);
        if (errEl) errEl.textContent = '';
    });
});

function showErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
        const input = document.querySelector(`[name="${field}"]`);
        const errEl = document.getElementById('err_' + field);
        if (input) input.classList.add('is-invalid');
        if (errEl) errEl.textContent = Array.isArray(messages) ? messages[0] : messages;
    });
}

document.getElementById('payBtn').addEventListener('click', async () => {
    const btn = document.getElementById('payBtn');
    const globalErr = document.getElementById('globalError');

    // Reset errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    globalErr.classList.add('d-none');

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses...';

    const payload = {
        customer_name:        document.getElementById('customer_name').value,
        customer_email:       document.getElementById('customer_email').value,
        customer_phone:       document.getElementById('customer_phone').value,
        qty:                  qtyInput.value,
        shipping_address:     document.getElementById('shipping_address').value,
        shipping_city:        document.getElementById('shipping_city').value,
        shipping_province:    document.getElementById('shipping_province').value,
        shipping_postal_code: document.getElementById('shipping_postal_code').value,
        shipping_notes:       document.getElementById('shipping_notes').value,
    };

    try {
        const res  = await fetch('{{ route('payment.create', $product) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('[name=_token]').value,
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (res.status === 422) {
            showErrors(data.errors);
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Lanjut ke Pembayaran';
            return;
        }

        if (data.error) throw new Error(data.error);

        window.snap.pay(data.snap_token, {
            onSuccess: (result) => {
                window.location.href = '{{ route('payment.finish') }}?order_id=' + result.order_id;
            },
            onPending: (result) => {
                window.location.href = '{{ route('payment.finish') }}?order_id=' + result.order_id;
            },
            onError: () => {
                globalErr.textContent = 'Pembayaran gagal. Silakan coba lagi.';
                globalErr.classList.remove('d-none');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Lanjut ke Pembayaran';
            },
            onClose: () => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Lanjut ke Pembayaran';
            },
        });

    } catch (e) {
        globalErr.textContent = e.message;
        globalErr.classList.remove('d-none');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-lock me-2"></i> Lanjut ke Pembayaran';
    }
});
</script>
@endpush
