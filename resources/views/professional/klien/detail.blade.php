@extends('layouts.app')

@section('title', 'Detail Klien')

@section('content')
<div class="container py-4">
    <a href="{{ route('professional.klien.index') }}" class="btn btn-link mb-3">&larr; Kembali ke Daftar Klien</a>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-2">{{ $klien->name }}</h4>
            <p><strong>Email:</strong> {{ $klien->email }}</p>
            <p><strong>Telepon:</strong> {{ $klien->telepon ?? '-' }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>📊 Ringkasan Kondisi Terbaru</h5>
            @if($latest)
            <ul class="mb-0">
                <li><strong>Depresi:</strong> {{ $latest->kategori_depresi }}</li>
                <li><strong>Kecemasan:</strong> {{ $latest->kategori_kecemasan }}</li>
                <li><strong>Stres:</strong> {{ $latest->kategori_stres }}</li>
                <li><strong>Tanggal:</strong> {{ $latest->created_at->format('d M Y H:i') }}</li>
            </ul>
            @else
            <p class="text-muted">Belum ada pengujian.</p>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">📊 Rata-Rata Pengujian 7 Hari Terakhir</h5>
        @if($pengujian7HariTerakhir->isEmpty())
            <p class="text-muted">Belum ada pengujian dalam 7 hari terakhir.</p>
        @else
            <ul class="list-group">
                <li class="list-group-item"><strong>Depresi:</strong> {{ $rataKategori['depresi'] }}</li>
                <li class="list-group-item"><strong>Kecemasan:</strong> {{ $rataKategori['kecemasan'] }}</li>
                <li class="list-group-item"><strong>Stres:</strong> {{ $rataKategori['stres'] }}</li>
            </ul>
        @endif
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>📝 Catatan Klien:</h5>
            @if($latestKonsultasi && $latestKonsultasi->notes)
                <p>{{ $latestKonsultasi->notes }}</p>
            @else
                <p class="text-muted">Belum ada catatan dari klien.</p>
            @endif
        </div>
    </div>
</div>
@endsection
