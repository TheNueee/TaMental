@extends('layouts.app')

@section('title', 'Pengujian Sehat Mental')

@section('content')
<div class="site-disclaimer mt-2">
    <div class="row align-items-center" style="min-height: 80vh;">
        <!-- Kolom Kiri: Gambar -->
        <div class="col-md-6 d-flex justify-content-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/disclaimer/Disclaimer.png') }}" alt="Ilustrasi Pengujian Mental"
                    class="img-fluid" style="max-height: 460px; object-fit: contain;">
            </div>
        </div>

        <!-- Kolom Kanan: Teks -->
        <div class="col-md-6">
            <h1 class="mb-3">@yield('title')</h1>
            <p class="lead">Yuk, bersama KamiDengar memahami kondisimu akhir-akhir ini!</p>

            <p><strong>Kenali kondisi mentalmu lewat tes singkat DASS-21</strong><br>
                Tes ini terdiri dari 21 pertanyaan sederhana yang membantumu memahami tingkat risiko terhadap depresi,
                kecemasan, dan stres. Hasilnya bukan diagnosis, tapi bisa jadi langkah awal untuk lebih mengenal diri
                dan jadi bahan diskusi dengan tenaga profesional jika dibutuhkan.
            </p>

            <div class="mb-3">
                <strong>Panduan Pengisian</strong>
                <ol>
                    <li>Luangkan waktu di tempat yang nyaman agar kamu bisa lebih rileks dan fokus saat mengisi.</li>
                    <li>Tidak ada jawaban benar atau salah, isilah sesuai dengan kondisi dirimu dengan jujur.</li>
                    <li>Pengujian ini tidak dibatasi waktu.</li>
                    <li>Apabila keluar saat pengisian, proses akan terhenti dan mohon mengisi ulang.</li>
                    <li>Hasil pengujian bisa didapatkan setelah mengisi semua pertanyaan.</li>
                </ol>
            </div>

            <div class="mb-4">
                <a href="{{ route('pengujiandass21') }}" class="btn btn-lg text-white btn-cta">Mulai Pengujian Sekarang</a>
            </div>
        </div>

        <div class="alert alert-warning">
            <strong>Informasi Darurat:</strong><br>
            Jika Anda sedang mengalami krisis psikologis yang mengancam hidup Anda, segera hubungi <strong>119</strong>.
        </div>
    </div>
</div>
@endsection
