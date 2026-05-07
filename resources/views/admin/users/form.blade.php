@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')
@section('page-title', isset($user) ? 'Edit User' : 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6 class="card-title">{{ isset($user) ? 'Edit' : 'Tambah' }} User</h6>
                <a href="{{ route('admin.users.index') }}" class="card-action">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">
                            Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '*' }}
                        </label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @if(!isset($user) || request()->has('password'))
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:.85rem;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    @endif

                    <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:10px;">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        {{ isset($user) ? 'Update User' : 'Simpan User' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
