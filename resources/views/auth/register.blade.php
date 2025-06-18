@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-container w-100" style="max-width: 460px; background-color: white; padding: 30px; border-radius: 12px; box-shadow: var(--shadow-md);">
        <h2 class="text-center mb-4" style="color: var(--primary-orange); font-weight: 600;">Daftar Akun Baru</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    placeholder="Tulis nama lengkapmu"
                    value="{{ old('name') }}"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Alamat Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="contoh@email.com"
                    value="{{ old('email') }}"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Kata Sandi</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Buat kata sandi yang aman"
                    required>
            </div>

            <div class="form-group mb-4">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi kata sandimu"
                    required>
            </div>

            <button type="submit" class="btn btn-cta w-100">Daftar Sekarang</button>
        </form>

        <div class="text-center mt-4">
            <p style="font-size: 0.9rem;">Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary-orange); font-weight: 600;">Masuk di sini</a></p>
        </div>
    </div>
</div>
@endsection
