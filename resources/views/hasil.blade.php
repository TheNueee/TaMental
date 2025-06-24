@extends('layouts.app')

@section('title', 'Hasil Tes Kesehatan Mental')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <!-- Header Section -->
            <div class="card shadow-sm rounded-4 border-0 mb-4" style="background: linear-gradient(135deg, #F4A261 0%, #E76F51 100%);">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-heart text-white" style="font-size: 3rem; opacity: 0.9;"></i>
                    </div>
                    <h2 class="text-white mb-2 fw-bold">Hasil Tes DASS-21 Kamu</h2>
                    <p class="text-white mb-3" style="opacity: 0.9; font-size: 1.1rem;">
                        Selamat! Kamu telah menyelesaikan salah satu langkah dini dalam mengetahui perjalanan kesehatan mentalmu.
                    </p>
                    @if(!$is_guest && $model)
                        <small class="text-white" style="opacity: 0.8;">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $model->created_at->format('d M Y H:i') }}
                        </small>
                    @endif
                </div>
            </div>

            <!-- Results Section -->
            <div class="row g-4 mb-4">
                {{-- Tingkat Depresi --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm rounded-4 border-0 h-100" style="border-left: 4px solid #6C5CE7 !important;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-cloud-rain" style="font-size: 2.5rem; color: #6C5CE7; opacity: 0.8;"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--text-dark);">Tingkat Depresi</h5>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                Seberapa sering Anda merasa sedih atau kehilangan minat
                            </p>
                            
                            <div class="mb-3">
                                <span class="badge rounded-pill px-3 py-2 fw-normal" style="font-size: 1rem;
                                    @if($kategori_depresi == 'Normal') background: #10b981; color: white;
                                    @elseif($kategori_depresi == 'Ringan') background: #f2d43c; color: white;
                                    @elseif($kategori_depresi == 'Sedang') background: #efa544; color: var(--text-dark);
                                    @elseif($kategori_depresi == 'Parah') background: #ed523a; color: white;
                                    @else background: #d42c2c; color:white;
                                    @endif">
                                    @if($kategori_depresi == 'Normal') 
                                        Normal
                                    @elseif($kategori_depresi == 'Ringan') 
                                        Ringan
                                    @elseif($kategori_depresi == 'Sedang') 
                                        Sedang
                                    @elseif($kategori_depresi == 'Parah') 
                                        Parah
                                    @else 
                                        Sangat Parah
                                    @endif
                                </span>
                            </div>

                            @if($kategori_depresi == 'Normal')
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Bagus! Tingkat kesedihan Anda dalam batas normal
                                </p>
                            @elseif($kategori_depresi == 'Ringan')
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Ada sedikit tanda kesedihan, tapi masih dapat dikelola dengan baik
                                </p>
                            @else
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Mungkin saatnya untuk berbicara dengan seseorang yang dapat membantu
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tingkat Kecemasan --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm rounded-4 border-0 h-100" style="border-left: 4px solid #FDCB6E !important;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-brain" style="font-size: 2.5rem; color: #FDCB6E; opacity: 0.8;"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--text-dark);">Tingkat Kecemasan</h5>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                Seberapa sering pikiran Anda dipenuhi kekhawatiran
                            </p>
                            
                            <div class="mb-3">
                                <span class="badge rounded-pill px-3 py-2 fw-normal" style="font-size: 1rem;
                                    @if($kategori_kecemasan == 'Normal') background: #10b981; color: white;
                                    @elseif($kategori_kecemasan == 'Ringan') background: #f2d43c; color: white;
                                    @elseif($kategori_kecemasan == 'Sedang') background: #efa544; color: var(--text-dark);
                                    @elseif($kategori_kecemasan == 'Parah') background: #ed523a; color: white;
                                    @else background: #d42c2c; color:white;
                                    @endif">
                                    @if($kategori_kecemasan == 'Normal') 
                                        Normal
                                    @elseif($kategori_kecemasan == 'Ringan') 
                                        Ringan
                                    @elseif($kategori_kecemasan == 'Sedang') 
                                        Sedang
                                    @elseif($kategori_kecemasan == 'Parah') 
                                        Parah
                                    @else 
                                        Sangat Parah
                                    @endif
                                </span>
                            </div>

                            @if($kategori_kecemasan == 'Normal')
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Hebat! Anda dapat mengelola kekhawatiran dengan baik
                                </p>
                            @elseif($kategori_kecemasan == 'Ringan')
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Wajar merasakan kekhawatiran ringan, cobalah teknik relaksasi
                                </p>
                            @else
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Kekhawatiran yang berlebih dapat mengganggu aktivitas harian
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tingkat Stress --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm rounded-4 border-0 h-100" style="border-left: 4px solid #00D4AA !important;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-battery-half" style="font-size: 2.5rem; color: #00D4AA; opacity: 0.8;"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--text-dark);">Tingkat Stress</h5>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                Seberapa sering Anda merasa tegang atau tidak sabar
                            </p>
                            
                            <div class="mb-3">
                                <span class="badge rounded-pill px-3 py-2 fw-normal" style="font-size: 1rem;
                                    @if($kategori_stres == 'Normal') background: #10b981; color: white;
                                    @elseif($kategori_stres == 'Ringan') background: #f2d43c; color: white;
                                    @elseif($kategori_stres == 'Sedang') background: #efa544; color: var(--text-dark);
                                    @elseif($kategori_stres == 'Parah') background: #ed523a; color: white;
                                    @else background: #d42c2c; color:white;
                                    @endif">
                                    @if($kategori_stres == 'Normal') 
                                        Normal
                                    @elseif($kategori_stres == 'Ringan') 
                                        Ringan
                                    @elseif($kategori_stres == 'Sedang') 
                                        Sedang
                                    @elseif($kategori_stres == 'Parah') 
                                        Parah
                                    @else 
                                        Sangat Parah
                                    @endif
                                </span>
                            </div>

                            @if($kategori_stres == 'Normal')
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Bagus! Anda bisa menjaga ketenangan dengan baik
                                </p>
                            @elseif($kategori_stres == 'Ringan')
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Ketegangan ringan masih normal, cobalah aktivitas yang menenangkan
                                </p>
                            @else
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    Tingkat ketegangan yang tinggi dapat memengaruhi kesehatan Anda
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

 <!-- Guest Notice & Action Buttons -->
            @if($is_guest)
                <div class="card shadow-sm rounded-4 border-0 mb-4" style="background: #f8f9ff;">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-circle" style="font-size: 2.5rem; color: var(--primary-orange); opacity: 0.8;"></i>
                        </div>
                        <h5 class="fw-semibold mb-2" style="color: var(--text-dark);">Catatan Penting:</h5>
                        <p class="text-muted mb-4" style="font-size: 1rem;">
                            Hasil ini tidak tersimpan karena Anda belum login. Daftar akun untuk menyimpan riwayat tes Anda.
                        </p>
                        
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-4">
                                <a href="{{ route('register.form') }}" class="btn-cta2 w-100">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Akun Gratis
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('login.form') }}" class="btn btn-outline-cta rounded-pill w-100" style="padding: 14px 32px; font-size: 1.1rem;">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Sudah Punya Akun? Login
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('pengujiandass21') }}" class="btn btn-outline-secondary rounded-pill w-100" style="padding: 14px 32px; font-size: 1.1rem;">
                                    <i class="fas fa-redo me-2"></i>
                                    Tes Ulang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Action Buttons for Logged Users -->
                <div class="card shadow-sm rounded-4 border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-4">
                                <a href="{{ route('client.pengujian.riwayat') }}" class="btn-cta2 w-100">
                                    <i class="fas fa-history me-2"></i>
                                    Lihat Riwayat Tes
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('pengujiandass21') }}" class="btn btn-outline-secondary rounded-pill w-100" style="padding: 14px 32px; font-size: 1.1rem;">
                                    <i class="fas fa-redo me-2"></i>
                                    Tes Ulang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Disclaimer -->
                        <div class="text-center mt-4 mb-4">
                            <p class="text-muted" style="font-size: 0.8rem;">
                                <i class="fas fa-shield-alt me-1"></i>
                                <h5 class="mb-1 fw-semibold">Penting untuk Diketahui</h5>
                                        <p class="mb-0" style="color: var(--text-light); font-size: 0.9rem;">
                                            Ini <strong>bukan diagnosis medis</strong> - hanya gambaran awal kondisimu, hasilnya dapat berubah seiring waktu/situasi.
                                Jika Anda memiliki kekhawatiran serius tentang kesehatan mental, 
                                segera hubungi profesional kesehatan mental atau layanan kesehatan terdekat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Professionals Section -->
            @if(($show_recommendation && count($rekomendasi_profesional)))
                <div id="professionals" class="card mb-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="fw-semibold mb-2" style="color: var(--text-dark);">
                                👨‍⚕️ Profesional Terpercaya untuk Anda
                            </h4>
                            <p class="text-muted">
                                Kami telah memilihkan beberapa ahli kesehatan mental yang tepat untuk membantu Anda
                            </p>
                        </div>

                        @if(count($rekomendasi_profesional))
                            <div class="row g-4">
                                @foreach($rekomendasi_profesional as $index => $pro)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card border-0 shadow-sm rounded-4 h-100" style="transition: transform 0.3s ease;">
                                            <div class="card-body p-4 text-center">
                                                <div class="mb-3">
                                                </div>
                                                <h6 class="fw-semibold mb-1" style="color: var(--text-dark);">
                                                    {{ $pro->name }}
                                                </h6>
                                                <p class="text-muted mb-2" style="font-size: 0.9rem;">
                                                    {{ $pro->gelar ?? 'Psikolog' }}
                                                </p>
                                                <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                                    {{ $pro->spesialisasi ?? 'Spesialis Kesehatan Mental & Psikiatri' }}
                                                </p>
                                                
                                              
                                                <div class="d-grid">
                                                    @if($is_guest)
                                                        <a href="{{ route('login.form') }}" class="btn-cta">
                                                            <i class="fas fa-calendar-plus me-2"></i>
                                                            Konsultasi
                                                        </a>
                                                    @else
                                                        <a href="{{ route('booking.page', ['professional' => $pro->id]) }}" class="btn-cta">
                                                            <i class="fas fa-calendar-plus me-2"></i>
                                                            Buat Janji
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('daftarprofesional') }}" class="btn btn-outline-cta rounded-pill">
                                    <i class="fas fa-users me-2"></i>
                                    Lihat Semua Profesional
                                </a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-user-md" style="font-size: 3rem; color: var(--text-light);"></i>
                                </div>
                                <h6 class="text-muted mb-3">Belum ada profesional yang tersedia</h6>
                                <a href="{{ route('daftarprofesional') }}" class="btn-cta">
                                    <i class="fas fa-search me-2"></i>
                                    Cari Profesional Lainnya
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Self-Care Tips -->
            <div id="tips" class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-semibold mb-2" style="color: var(--text-dark);">
                            💝 Tips Menjaga Kesehatan Mental
                        </h4>
                        <p class="text-muted">
                            Hal-hal sederhana yang bisa Anda lakukan untuk merawat diri sendiri
                        </p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; background: #E8F5E8; color: #00D4AA; flex-shrink: 0;">
                                    <i class="fas fa-moon"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Tidur yang Cukup</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                        Tidur 7-8 jam setiap malam untuk menjaga keseimbangan emosi
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; background: #E3F2FD; color: #74B9FF; flex-shrink: 0;">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Olahraga Teratur</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                        Minimal 30 menit aktivitas fisik untuk melepas endorfin
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; background: #FFF8DC; color: #FDCB6E; flex-shrink: 0;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Berkomunikasi</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                        Berbagi cerita dengan orang terpercaya atau keluarga
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px; background: #FFE8E8; color: #FD79A8; flex-shrink: 0;">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Relaksasi</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                        Luangkan waktu untuk meditasi, yoga, atau hobi favorit
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           

           

<style>
.badge {
    transition: all 0.3s ease;
}

.alert {
    border: none !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .btn-cta, .btn-cta2 {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .row.g-4 {
        gap: 1rem !important;
    }
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Animation for cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

/* Tooltip styling */
.badge {
    position: relative;
    cursor: help;
}

/* Loading state for buttons */
.btn-cta:active, .btn-cta2:active {
    transform: scale(0.98);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading state to buttons
    document.querySelectorAll('.btn-cta, .btn-cta2').forEach(button => {
        button.addEventListener('click', function() {
            if (!this.href.includes('#')) {
                this.style.opacity = '0.7';
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.opacity = '1';
                }, 2000);
            }
        });
    });

    // Add stagger animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection