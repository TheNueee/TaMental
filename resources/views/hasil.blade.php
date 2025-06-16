@extends('layouts.app')

@section('title', 'Hasil Pengujian DASS-21')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Hasil Pengujian DASS-21</h4>
                    @if(!$is_guest && $model)
                        <small class="text-muted">Tanggal: {{ $model->created_at->format('d M Y H:i') }}</small>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Depresi</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if(!$is_guest && $model)
                                        <h2 class="text-primary">{{ $model->skor_depresi }}</h2>
                                    @endif
                                    <h4 class="badge 
                                        @if($kategori_depresi == 'Normal') badge-success text-dark
                                        @elseif($kategori_depresi == 'Ringan') badge-info text-dark
                                        @elseif($kategori_depresi == 'Sedang') badge-warning text-dark
                                        @elseif($kategori_depresi == 'Parah') badge-danger text-dark
                                        @else badge-dark text-dark
                                        @endif">
                                        {{ $kategori_depresi }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">Kecemasan</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if(!$is_guest && $model)
                                        <h2 class="text-warning">{{ $model->skor_kecemasan }}</h2>
                                    @endif
                                    <h4 class="badge 
                                        @if($kategori_kecemasan == 'Normal') badge-success text-dark
                                        @elseif($kategori_kecemasan == 'Ringan') badge-info text-dark
                                        @elseif($kategori_kecemasan == 'Sedang') badge-warning text-dark
                                        @elseif($kategori_kecemasan == 'Parah') badge-danger text-dark
                                        @else badge-dark text-dark
                                        @endif">
                                        {{ $kategori_kecemasan }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Stres</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if(!$is_guest && $model)
                                        <h2 class="text-info">{{ $model->skor_stres }}</h2>
                                    @endif
                                    <h4 class="badge 
                                        @if($kategori_stres == 'Normal') badge-success text-dark
                                        @elseif($kategori_stres == 'Ringan') badge-info text-dark
                                        @elseif($kategori_stres == 'Sedang') badge-warning text-dark
                                        @elseif($kategori_stres == 'Parah') badge-danger text-dark
                                        @else badge-dark text-dark
                                        @endif">
                                        {{ $kategori_stres }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="alert alert-info">
                            <h5>Interpretasi Hasil:</h5>
                            <p><strong>Normal:</strong> Tingkat yang wajar dan sehat</p>
                            <p><strong>Ringan:</strong> Tingkat yang sedikit di atas normal, perlu perhatian</p>
                            <p><strong>Sedang:</strong> Tingkat yang cukup tinggi, disarankan untuk berkonsultasi</p>
                            <p><strong>Parah:</strong> Tingkat yang tinggi, sangat disarankan untuk berkonsultasi dengan profesional</p>
                            <p class="mb-0"><strong>Sangat Parah:</strong> Tingkat yang sangat tinggi, segera berkonsultasi dengan profesional kesehatan mental</p>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        @if($is_guest)
                            <div class="alert alert-warning">
                                <strong>Catatan:</strong> Hasil ini tidak disimpan karena Anda belum login. 
                                <a href="{{ route('register.form') }}">Daftar</a> atau 
                                <a href="{{ route('login.form') }}">Login</a> untuk menyimpan riwayat pengujian.
                            </div>
                        @else
                            <a href="{{ route('client.pengujian.riwayat') }}" class="btn btn-info">Lihat Riwayat Pengujian</a>
                        @endif
                        
                        <a href="{{ route('pengujiandass21') }}" class="btn btn-secondary">Lakukan Pengujian Lagi</a>
                        {{-- <a href="{{ route('landing') }}" class="btn btn-primary">Kembali ke Beranda</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection