@extends('layouts.store')
@section('title', 'Lupa Password — Otherside Store')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:5rem 1rem 3rem;background:#f8f8f8;">
    <div style="width:100%;max-width:420px;">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:2rem;">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo-otherside.png') }}" alt="Otherside" style="width:56px;height:56px;border-radius:50%;border:2px solid #0a0a0a;">
            </a>
            <h4 style="font-weight:900;margin-top:.75rem;margin-bottom:.2rem;">Lupa Password?</h4>
            <p style="font-size:.83rem;color:#999;margin:0;max-width:300px;margin:0 auto;">
                Masukkan emailmu dan kami akan kirimkan link untuk reset password.
            </p>
        </div>

        <div style="background:#fff;border-radius:20px;padding:2rem;box-shadow:0 4px 24px rgba(0,0,0,.06);">

            @if(session('status'))
            <div style="background:#d1fae5;color:#065f46;border-radius:12px;padding:.9rem 1.1rem;margin-bottom:1.25rem;font-size:.85rem;font-weight:600;display:flex;align-items:center;gap:.6rem;">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label style="font-size:.82rem;font-weight:700;display:block;margin-bottom:.35rem;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        style="width:100%;border:1.5px solid {{ $errors->has('email') ? '#dc2626' : '#e0e0e0' }};border-radius:10px;padding:.6rem .9rem;font-size:.88rem;outline:none;transition:border-color .2s;"
                        placeholder="email@kamu.com" required autofocus
                        onfocus="this.style.borderColor='#0a0a0a'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#dc2626' : '#e0e0e0' }}'">
                    @error('email')
                        <div style="color:#dc2626;font-size:.75rem;margin-top:.3rem;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    style="width:100%;padding:.75rem;background:#0a0a0a;color:#fff;border:none;border-radius:12px;font-size:.92rem;font-weight:800;cursor:pointer;transition:background .2s;"
                    onmouseover="this.style.background='#333'" onmouseout="this.style.background='#0a0a0a'">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Link Reset
                </button>
            </form>
        </div>

        <p style="text-align:center;font-size:.83rem;color:#999;margin-top:1.25rem;">
            Ingat password?
            <a href="{{ route('login') }}" style="color:#0a0a0a;font-weight:800;text-decoration:none;">Kembali login</a>
        </p>

    </div>
</div>
@endsection
