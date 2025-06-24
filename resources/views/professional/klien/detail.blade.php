@extends('layouts.app')

@section('title', 'Detail Klien - ' . $klien->name)

@section('content')
<div class="container py-4">
    <!-- Back Button -->
    <a href="{{ route('professional.klien.index') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Daftar Klien
    </a>

    <!-- Client Header -->
    <div class="client-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="client-avatar">
                    {{ strtoupper(substr($klien->name, 0, 1)) }}
                </div>
                <h2 class="mb-2">{{ $klien->name }}</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span>{{ $klien->email }}</span>
                    </div>
                    @if($klien->telepon)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <span>{{ $klien->telepon }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="stats-row">
        <!-- Latest Condition Summary -->
        <div class="info-card">
            <div class="section-title">
                <div class="section-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                Kondisi Terbaru
            </div>
            
            @if($latest)
                <div class="condition-grid">
                    <div class="condition-item {{ strtolower($latest->kategori_depresi) === 'normal' ? 'normal' : (strtolower($latest->kategori_depresi) === 'ringan' ? 'mild' : (strtolower($latest->kategori_depresi) === 'sedang' ? 'moderate' : 'severe')) }}">
                        <div class="condition-label">Depresi</div>
                        <div class="condition-value">{{ $latest->kategori_depresi }}</div>
                        <div class="condition-date">{{ $latest->created_at->format('d M Y') }}</div>
                    </div>
                    
                    <div class="condition-item {{ strtolower($latest->kategori_kecemasan) === 'normal' ? 'normal' : (strtolower($latest->kategori_kecemasan) === 'ringan' ? 'mild' : (strtolower($latest->kategori_kecemasan) === 'sedang' ? 'moderate' : 'severe')) }}">
                        <div class="condition-label">Kecemasan</div>
                        <div class="condition-value">{{ $latest->kategori_kecemasan }}</div>
                        <div class="condition-date">{{ $latest->created_at->format('d M Y') }}</div>
                    </div>
                    
                    <div class="condition-item {{ strtolower($latest->kategori_stres) === 'normal' ? 'normal' : (strtolower($latest->kategori_stres) === 'ringan' ? 'mild' : (strtolower($latest->kategori_stres) === 'sedang' ? 'moderate' : 'severe')) }}">
                        <div class="condition-label">Stres</div>
                        <div class="condition-value">{{ $latest->kategori_stres }}</div>
                        <div class="condition-date">{{ $latest->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i>
                        Terakhir diperbarui: {{ $latest->created_at->diffForHumans() }}
                    </small>
                </div>
            @else
                <div class="empty-notes">
                    <i class="fas fa-chart-line fa-2x mb-3 text-muted"></i>
                    <p>Belum ada data pengujian dari klien ini.</p>
                    <small class="text-muted">Data akan muncul setelah klien melakukan tes kondisi mental.</small>
                </div>
            @endif
        </div>

        <!-- 7-Day Average -->
        <div class="info-card">
            <div class="section-title">
                <div class="section-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                Rata-Rata 7 Hari Terakhir
            </div>
            
            @if(!$pengujian7HariTerakhir->isEmpty())
                <div class="condition-grid">
                    <div class="condition-item {{ strtolower($rataKategori['depresi']) === 'normal' ? 'normal' : (strtolower($rataKategori['depresi']) === 'ringan' ? 'mild' : (strtolower($rataKategori['depresi']) === 'sedang' ? 'moderate' : 'severe')) }}">
                        <div class="condition-label">Depresi</div>
                        <div class="condition-value">{{ $rataKategori['depresi'] }}</div>
                        <div class="trend-indicator trend-stable">
                            <i class="fas fa-minus"></i>
                            Stabil
                        </div>
                    </div>
                    
                    <div class="condition-item {{ strtolower($rataKategori['kecemasan']) === 'normal' ? 'normal' : (strtolower($rataKategori['kecemasan']) === 'ringan' ? 'mild' : (strtolower($rataKategori['kecemasan']) === 'sedang' ? 'moderate' : 'severe')) }}">
                        <div class="condition-label">Kecemasan</div>
                        <div class="condition-value">{{ $rataKategori['kecemasan'] }}</div>
                        <div class="trend-indicator trend-stable">
                            <i class="fas fa-minus"></i>
                            Stabil
                        </div>
                    </div>
                    
                    <div class="condition-item {{ strtolower($rataKategori['stres']) === 'normal' ? 'normal' : (strtolower($rataKategori['stres']) === 'ringan' ? 'mild' : (strtolower($rataKategori['stres']) === 'sedang' ? 'moderate' : 'severe')) }}">
                        <div class="condition-label">Stres</div>
                        <div class="condition-value">{{ $rataKategori['stres'] }}</div>
                        <div class="trend-indicator trend-stable">
                            <i class="fas fa-minus"></i>
                            Stabil
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Berdasarkan {{ $pengujian7HariTerakhir->count() }} pengujian dalam 7 hari terakhir
                    </small>
                </div>
            @else
                <div class="empty-notes">
                    <i class="fas fa-calendar-times fa-2x mb-3 text-muted"></i>
                    <p>Belum ada pengujian dalam 7 hari terakhir.</p>
                    <small class="text-muted">Rata-rata akan ditampilkan setelah ada data pengujian.</small>
                </div>
            @endif
        </div>
    </div>

    <!-- Client Notes Section -->
    <div class="info-card">
        <div class="section-title">
            <div class="section-icon">
                <i class="fas fa-sticky-note"></i>
            </div>
            Catatan dari Klien
        </div>
        
        @if($latestKonsultasi && $latestKonsultasi->notes)
            <div class="notes-section">
                <div class="notes-content">
                    "{{ $latestKonsultasi->notes }}"
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i>
                        {{ $latestKonsultasi->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
        @else
            <div class="empty-notes">
                <i class="fas fa-comment-slash fa-2x mb-3 text-muted"></i>
                <p>Belum ada catatan dari klien.</p>
                <small class="text-muted">Catatan akan muncul ketika klien memberikan informasi tambahan saat konsultasi.</small>
            </div>
        @endif
    </div>
@endsection