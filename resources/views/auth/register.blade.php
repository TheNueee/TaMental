@extends('layouts.app')

@section('title', 'Masuk ke Akun Anda')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-container w-100" style="max-width: 420px; background-color: white; padding: 30px; border-radius: 12px; box-shadow: var(--shadow-md);">
        <h2 class="text-center mb-4" style="color: var(--primary-orange); font-weight: 600;">Masuk ke Akun</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Masukkan email yang terdaftar"
                    value="{{ old('email') }}" 
                    required>
            </div>

            <div class="form-group mb-4">
                <label for="password">Kata Sandi</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Masukkan kata sandimu" 
                    required>
            </div>

            <button type="submit" class="btn btn-cta w-100">Masuk</button>
        </form>

        <div class="text-center mt-4">
            <p style="font-size: 0.9rem;">Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary-orange); font-weight: 600;">Daftar sekarang</a></p>
        </div>
    </div>
</div>
@endsection
