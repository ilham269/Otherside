@extends('layouts.store')
@section('title', 'Register — Otherside Store')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:5rem 1rem 3rem;background:#f8f8f8;">
    <div style="width:100%;max-width:440px;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:2rem;">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo-otherside.png') }}" alt="Otherside" style="width:56px;height:56px;border-radius:50%;border:2px solid #0a0a0a;">
            </a>
            <h4 style="font-weight:900;margin-top:.75rem;margin-bottom:.2rem;">Buat Akun</h4>
            <p style="font-size:.83rem;color:#999;margin:0;">Bergabung dengan Otherside Official Store</p>
        </div>

        <div style="background:#fff;border-radius:20px;padding:2rem;box-shadow:0 4px 24px rgba(0,0,0,.06);">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        style="width:100%;border:1.5px solid {{ $errors->has('name') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                        placeholder="Nama kamu" required autofocus
                        onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='{{ $errors->has('name') ? '#dc2626' : '#e0e0e0' }}'">
                    @error('name')
                        <div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        style="width:100%;border:1.5px solid {{ $errors->has('email') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                        placeholder="email@kamu.com" required
                        onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#dc2626' : '#e0e0e0' }}'">
                    @error('email')
                        <div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="passInput"
                            style="width:100%;border:1.5px solid {{ $errors->has('password') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.6rem 2.5rem .6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                            placeholder="Min. 8 karakter" required
                            onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='{{ $errors->has('password') ? '#dc2626' : '#e0e0e0' }}'">
                        <button type="button" onclick="togglePass('passInput','eyePass')" tabindex="-1"
                            style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer;padding:0;font-size:.85rem;">
                            <i class="fa-regular fa-eye" id="eyePass"></i>
                        </button>
                    </div>
                    @error('password')
                        <div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Konfirmasi Password</label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" id="passConfirm"
                            style="width:100%;border:1.5px solid #e0e0e0;border-radius:10px;padding:.6rem 2.5rem .6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                            placeholder="Ulangi password" required
                            onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='#e0e0e0'">
                        <button type="button" onclick="togglePass('passConfirm','eyeConfirm')" tabindex="-1"
                            style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer;padding:0;font-size:.85rem;">
                            <i class="fa-regular fa-eye" id="eyeConfirm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    style="width:100%;padding:.75rem;background:#0a0a0a;color:#fff;border:none;border-radius:12px;font-size:.92rem;font-weight:800;cursor:pointer;transition:background .2s;"
                    onmouseover="this.style.background='#333'" onmouseout="this.style.background='#0a0a0a'">
                    Buat Akun
                </button>
            </form>
        </div>

        <p style="text-align:center;font-size:.83rem;color:#999;margin-top:1.25rem;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#0a0a0a;font-weight:800;text-decoration:none;">Masuk di sini</a>
        </p>

    </div>
</div>

@push('scripts')
<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-regular fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa-regular fa-eye';
    }
}
</script>
@endpush
@endsection
