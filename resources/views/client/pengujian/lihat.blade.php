@extends('layouts.app')

@section('title', 'Detail Pengujian DASS-21')

@section('content')
<div class="detail-container mb-4">
    <!-- Header -->
    <div class="detail-header">
        <h1 class="detail-title">Detail Pengujian DASS-21</h1>
        <p class="detail-subtitle">Hasil lengkap pengujian depresi, kecemasan, dan stres</p>
    </div>

    <!-- Basic Info -->
    <div class="detail-info-grid">
        <div class="detail-info-card">
            <div class="detail-info-label">Tanggal Pengujian</div>
            <div class="detail-info-value">{{ $pengujian->created_at->format('d M Y') }}</div>
        </div>
        <div class="detail-info-card">
            <div class="detail-info-label">Waktu Pengujian</div>
            <div class="detail-info-value">{{ $pengujian->created_at->format('H:i') }} WIB</div>
        </div>
    </div>

    <!-- Score Cards -->
    <div class="score-cards">
        <!-- Depresi Card -->
        <div class="score-card">
            <div class="score-type">Tingkat Depresi</div>
            <div class="score-category 
                @if(strtolower($kategoriDepresi) == 'normal') category-normal
                @elseif(strtolower($kategoriDepresi) == 'ringan' || strtolower($kategoriDepresi) == 'mild') category-mild
                @elseif(strtolower($kategoriDepresi) == 'sedang' || strtolower($kategoriDepresi) == 'moderate') category-moderate
                @elseif(strtolower($kategoriDepresi) == 'berat' || strtolower($kategoriDepresi) == 'severe') category-severe
                @else category-extremely-severe
                @endif">
                {{ $kategoriDepresi }}
            </div>
        </div>

        <!-- Kecemasan Card -->
        <div class="score-card">
            <div class="score-type">Tingkat Kecemasan</div>
            <div class="score-category 
                @if(strtolower($kategoriKecemasan) == 'normal') category-normal
                @elseif(strtolower($kategoriKecemasan) == 'ringan' || strtolower($kategoriKecemasan) == 'mild') category-mild
                @elseif(strtolower($kategoriKecemasan) == 'sedang' || strtolower($kategoriKecemasan) == 'moderate') category-moderate
                @elseif(strtolower($kategoriKecemasan) == 'berat' || strtolower($kategoriKecemasan) == 'severe') category-severe
                @else category-extremely-severe
                @endif">
                {{ $kategoriKecemasan }}
            </div>
        </div>

        <!-- Stres Card -->
        <div class="score-card">
            <div class="score-type">Tingkat Stres</div>
            <div class="score-category 
                @if(strtolower($kategoriStres) == 'normal') category-normal
                @elseif(strtolower($kategoriStres) == 'ringan' || strtolower($kategoriStres) == 'mild') category-mild
                @elseif(strtolower($kategoriStres) == 'sedang' || strtolower($kategoriStres) == 'moderate') category-moderate
                @elseif(strtolower($kategoriStres) == 'berat' || strtolower($kategoriStres) == 'severe') category-severe
                @else category-extremely-severe
                @endif">
                {{ $kategoriStres }}
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="detail-actions">
        <a href="{{ route('client.pengujian.riwayat') }}" class="btn-secondary">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Kembali ke Riwayat
        </a>
        <form action="{{ route('client.pengujian.hapus', $pengujian->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data riwayat pengujian ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">
                🗑️ Hapus
            </button>
        </form>
    </div>
</div>
@endsection