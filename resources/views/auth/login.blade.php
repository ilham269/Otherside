@extends('layouts.store')
@section('title', 'Login — Otherside Store')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:5rem 1rem 3rem;background:#f8f8f8;">
    <div style="width:100%;max-width:420px;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:2rem;">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo-otherside.png') }}" alt="Otherside" style="width:56px;height:56px;border-radius:50%;border:2px solid #0a0a0a;">
            </a>
            <h4 style="font-weight:900;margin-top:.75rem;margin-bottom:.2rem;">Selamat Datang</h4>
            <p style="font-size:.83rem;color:#999;margin:0;">Masuk ke akun Otherside kamu</p>
        </div>

        <div style="background:#fff;border-radius:20px;padding:2rem;box-shadow:0 4px 24px rgba(0,0,0,.06);">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="@error('email') is-invalid @enderror"
                        style="width:100%;border:1.5px solid {{ $errors->has('email') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                        placeholder="email@kamu.com" required autofocus
                        onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#dc2626' : '#e0e0e0' }}'">
                    @error('email')
                        <div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center" style="margin-bottom:.35rem;">
                        <label style="font-size:.82rem;font-weight:700;margin:0;">Password</label>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:.75rem;color:#666;text-decoration:none;">Lupa password?</a>
                        @endif
                    </div>
                    <div style="position:relative;">
                        <input type="password" name="password" id="passwordInput"
                            class="@error('password') is-invalid @enderror"
                            style="width:100%;border:1.5px solid {{ $errors->has('password') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.6rem 2.5rem .6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                            placeholder="••••••••" required
                            onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='{{ $errors->has('password') ? '#dc2626' : '#e0e0e0' }}'">
                        <button type="button" onclick="togglePass()" tabindex="-1"
                            style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:#aaa;cursor:pointer;padding:0;font-size:.85rem;">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-2 mb-4">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        style="width:16px;height:16px;accent-color:#0a0a0a;cursor:pointer;">
                    <label for="remember" style="font-size:.82rem;color:#555;cursor:pointer;margin:0;">Ingat saya</label>
                </div>

                <button type="submit"
                    style="width:100%;padding:.75rem;background:#0a0a0a;color:#fff;border:none;border-radius:12px;font-size:.92rem;font-weight:800;cursor:pointer;transition:background .2s;"
                    onmouseover="this.style.background='#333'" onmouseout="this.style.background='#0a0a0a'">
                    Masuk
                </button>
            </form>
        </div>

        <p style="text-align:center;font-size:.83rem;color:#999;margin-top:1.25rem;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#0a0a0a;font-weight:800;text-decoration:none;">Daftar sekarang</a>
        </p>

    </div>
</div>

@push('scripts')
<script>
function togglePass() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
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
