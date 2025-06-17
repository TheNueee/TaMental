@extends('layouts.app')

@section('title', 'Hasil Pengujian DASS-21')

@section('content')
<div class="container" style="padding-top: 40px;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <h3 class="mb-2 text-center primarytext fw-semibold">Hasil Pengujian DASS-21</h3>

                    @if(!$is_guest && $model)
                        <p class="text-muted text-center mb-4" style="font-size: 0.9rem;">Tanggal: {{ $model->created_at->format('d M Y H:i') }}</p>
                    @endif

                    <div class="row g-4">
                        {{-- Depresi --}}
                        <div class="col-md-4">
                            <div class="card border-primary shadow-sm">
                                <div class="card-header bg-primary text-white text-center fw-semibold">Depresi</div>
                                <div class="card-body text-center">
                                    @if(!$is_guest && $model)
                                        <h2 class="text-primary">{{ $model->skor_depresi }}</h2>
                                    @endif
                                    <span class="badge 
                                        @if($kategori_depresi == 'Normal') bg-success
                                        @elseif($kategori_depresi == 'Ringan') bg-info
                                        @elseif($kategori_depresi == 'Sedang') bg-warning
                                        @elseif($kategori_depresi == 'Parah' || $kategori_depresi == 'Sangat Parah') bg-danger
                                        @else bg-dark
                                        @endif">
                                        {{ $kategori_depresi }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Kecemasan --}}
                        <div class="col-md-4">
                            <div class="card border-warning shadow-sm">
                                <div class="card-header bg-warning text-white text-center fw-semibold">Kecemasan</div>
                                <div class="card-body text-center">
                                    @if(!$is_guest && $model)
                                        <h2 class="text-warning">{{ $model->skor_kecemasan }}</h2>
                                    @endif
                                    <span class="badge 
                                        @if($kategori_kecemasan == 'Normal') bg-success
                                        @elseif($kategori_kecemasan == 'Ringan') bg-info
                                        @elseif($kategori_kecemasan == 'Sedang') bg-warning
                                        @elseif($kategori_kecemasan == 'Parah' || $kategori_kecemasan == 'Sangat Parah') bg-danger
                                        @else bg-dark
                                        @endif">
                                        {{ $kategori_kecemasan }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Stres --}}
                        <div class="col-md-4">
                            <div class="card border-info shadow-sm">
                                <div class="card-header bg-info text-white text-center fw-semibold">Stres</div>
                                <div class="card-body text-center">
                                    @if(!$is_guest && $model)
                                        <h2 class="text-info">{{ $model->skor_stres }}</h2>
                                    @endif
                                    <span class="badge 
                                        @if($kategori_stres == 'Normal') bg-success
                                        @elseif($kategori_stres == 'Ringan') bg-info
                                        @elseif($kategori_stres == 'Sedang') bg-warning
                                        @elseif($kategori_stres == 'Parah' || $kategori_stres == 'Sangat Parah') bg-danger
                                        @else bg-dark
                                        @endif">
                                        {{ $kategori_stres }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Interpretasi --}}
                    <div class="mt-4 alert alert-info">
                        <h5 class="fw-semibold mb-2">Interpretasi Hasil:</h5>
                        <ul class="mb-0">
                            <li><strong>Normal:</strong> Tingkat yang wajar dan sehat</li>
                            <li><strong>Ringan:</strong> Perlu perhatian ringan</li>
                            <li><strong>Sedang:</strong> Disarankan konsultasi</li>
                            <li><strong>Parah:</strong> Sangat disarankan konsultasi dengan profesional</li>
                            <li><strong>Sangat Parah:</strong> Segera konsultasi dengan profesional</li>
                        </ul>
                    </div>

                    {{-- Saran Konsultasi Jika Parah atau Sangat Parah --}}
                    @php
                        $perlu_konsultasi = in_array($kategori_depresi, ['Parah', 'Sangat Parah']) ||
                                            in_array($kategori_kecemasan, ['Parah', 'Sangat Parah']) ||
                                            in_array($kategori_stres, ['Parah', 'Sangat Parah']);
                    @endphp

                    @if($perlu_konsultasi)
                        <div class="alert alert-warning mt-4 p-4 rounded-3 shadow-sm">
                            <h5 class="fw-semibold text-danger">Kami menyarankan Anda untuk berkonsultasi.</h5>
                            <p class="mb-3">Berdasarkan hasil pengujian, ada indikasi tingkat yang tinggi pada salah satu aspek. Konsultasi dengan profesional dapat membantu Anda menemukan solusi terbaik.</p>

                            @if(!$is_guest)
                                <a href="" class="btn btn-cta">Konsultasi Sekarang</a>
                                {{-- {{ route('client.konsultasi') }} --}}
                            @else
                                <a href="{{ route('register.form') }}" class="btn btn-outline-primary me-2">Daftar Akun</a>
                                <a href="{{ route('login.form') }}" class="btn btn-outline-secondary">Login untuk Konsultasi</a>
                            @endif
                        </div>
                    @endif

                    {{-- Navigasi --}}
                    <div class="d-grid gap-2 mt-4">
                        @if($is_guest)
                            <div class="alert alert-warning">
                                <strong>Catatan:</strong> Hasil ini tidak disimpan karena Anda belum login. 
                                <a href="{{ route('register.form') }}">Daftar</a> atau 
                                <a href="{{ route('login.form') }}">Login</a> untuk menyimpan riwayat pengujian.
                            </div>
                        @else
                            <a href="{{ route('client.pengujian.riwayat') }}" class="btn btn-outline-info">Lihat Riwayat Pengujian</a>
                        @endif

                        <a href="{{ route('pengujiandass21') }}" class="btn btn-secondary">Lakukan Pengujian Lagi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
