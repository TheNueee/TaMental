@extends('layouts.app')
@section('title', 'KamiDengar')
@section('content')
<!-- Hero Section (Existing) -->
<div class="site-index mt">
    <div class="bg-transparent rounded-3">
        <div class="container-fluid pt-3 pb-5 text-center">
            <h1 class="display-4 mb-3">Terima kasih telah memberi ruang untuk mengenali perasaanmu 🌱</h1>
            <img src="{{ asset('images/landing/Heros.png') }}" alt="Ilustrasi Emosi"
                class="img-fluid rounded mx-auto d-block" style="max-width: 450px; height: auto; margin-bottom: 30px;">
            <p class="fs-5 fw-light mb-4">
                Kamu sedang tumbuh dan belajar memahami diri, dan itu luar biasa.
                <br> Apa yang bisa aku bantu?
            </p>
            <div class="d-flex justify-content-center gap-4 mt-3">
                <a class="btn btn-lg text-white btn-cta2" href="{{ route('disclaimer') }}">
                    Yuk, Kenali Kondisimu
                </a>
                <a class="btn btn-lg btn-cta3" href="{{ route('daftarprofesional') }}">
                    Konsultasi Daring
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="landing-features">
    <div class="container">
        <div class="landing-section-header">
            <h2 class="landing-section-title">Fitur Unggulan KamiDengar</h2>
            <p class="landing-section-subtitle">Platform terintegrasi untuk kesehatan mental yang mudah diakses</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="landing-feature-card">
                    <div class="landing-feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"/>
                            <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"/>
                            <path d="M12 3c0 1-1 3-3 3s-3-2-3-3 1-3 3-3 3 2 3 3"/>
                            <path d="M12 21c0-1 1-3 3-3s3 2 3 3-1 3-3 3-3-2-3-3"/>
                        </svg>
                    </div>
                    <h3 class="landing-feature-title">Pengukuran DASS-21</h3>
                    <p class="landing-feature-description">Tes mandiri untuk mengukur tingkat depresi, kecemasan, dan stres dengan instrumen yang telah tervalidasi secara ilmiah.</p>
                    <div class="landing-feature-highlight">
                        <span class="landing-highlight-tag">Gratis</span>
                        <span class="landing-highlight-tag">21 Pertanyaan</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-feature-card">
                    <div class="landing-feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="landing-feature-title">Konsultasi Daring</h3>
                    <p class="landing-feature-description">Sesi konseling online dengan profesional berpengalaman yang siap membantu mengatasi masalah psikologis Anda.</p>
                    <div class="landing-feature-highlight">
                        <span class="landing-highlight-tag">Profesional</span>
                        <span class="landing-highlight-tag">Fleksibel</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="landing-feature-card">
                    <div class="landing-feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18"/>
                            <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>
                        </svg>
                    </div>
                    <h3 class="landing-feature-title">Riwayat & Perkembangan</h3>
                    <p class="landing-feature-description">Pantau progres kondisi mental Anda dari waktu ke waktu dengan riwayat tes yang tersimpan dengan aman.</p>
                    <div class="landing-feature-highlight">
                        <span class="landing-highlight-tag">Tracking</span>
                        <span class="landing-highlight-tag">Privat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="landing-how-it-works">
    <div class="container">
        <div class="landing-section-header">
            <h2 class="landing-section-title">Bagaimana Cara Kerjanya?</h2>
            <p class="landing-section-subtitle">Proses sederhana dalam 3 langkah untuk mendapatkan bantuan yang Anda butuhkan</p>
        </div>
        
        <div class="landing-steps-container">
            <div class="landing-step">
                <div class="landing-step-number">1</div>
                <div class="landing-step-content">
                    <h4 class="landing-step-title">Kenali Kondisimu</h4>
                    <p class="landing-step-description">Lakukan Pengukuran DASS-21 untuk mengukur tingkat depresi, kecemasan, dan stres yang Anda alami saat ini.</p>
                </div>
            </div>
            
            <div class="landing-step-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"/>
                </svg>
            </div>
            
            <div class="landing-step">
                <div class="landing-step-number">2</div>
                <div class="landing-step-content">
                    <h4 class="landing-step-title">Pilih Profesional</h4>
                    <p class="landing-step-description">Jika diperlukan, pilih konselor atau psikolog yang sesuai dengan kebutuhan dan jadwalkan sesi konsultasi.</p>
                </div>
            </div>
            
            <div class="landing-step-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"/>
                </svg>
            </div>
            
            <div class="landing-step">
                <div class="landing-step-number">3</div>
                <div class="landing-step-content">
                    <h4 class="landing-step-title">Mulai Perjalanan</h4>
                    <p class="landing-step-description">Ikuti sesi konsultasi dan pantau perkembangan kondisi mental Anda secara berkelanjutan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="landing-benefits">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="landing-benefits-content">
                    <h2 class="landing-section-title">Mengapa Memilih KamiDengar?</h2>
                    <p class="landing-section-subtitle">Platform yang dirancang khusus untuk mendukung kesehatan mental Anda</p>
                    
                    <div class="landing-benefits-list">
                        <div class="landing-benefit-item">
                            <div class="landing-benefit-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20,6 9,17 4,12"/>
                                </svg>
                            </div>
                            <div class="landing-benefit-text">
                                <h5>Tes Tervalidasi Ilmiah</h5>
                                <p>Menggunakan instrumen DASS-21 yang telah terbukti akurat dalam mengukur kondisi psikologis.</p>
                            </div>
                        </div>
                        
                        <div class="landing-benefit-item">
                            <div class="landing-benefit-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20,6 9,17 4,12"/>
                                </svg>
                            </div>
                            <div class="landing-benefit-text">
                                <h5>Profesional Berpengalaman</h5>
                                <p>Konselor dan psikolog berlisensi siap membantu dengan pendekatan yang personal dan profesional.</p>
                            </div>
                        </div>
                        
                        <div class="landing-benefit-item">
                            <div class="landing-benefit-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20,6 9,17 4,12"/>
                                </svg>
                            </div>
                            <div class="landing-benefit-text">
                                <h5>Keamanan Data Terjamin</h5>
                                <p>Semua data dan riwayat Anda disimpan dengan standar keamanan tinggi dan privasi terjaga.</p>
                            </div>
                        </div>
                        
                        <div class="landing-benefit-item">
                            <div class="landing-benefit-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20,6 9,17 4,12"/>
                                </svg>
                            </div>
                            <div class="landing-benefit-text">
                                <h5>Fleksibilitas Jadwal</h5>
                                <p>Atur dan ubah jadwal konsultasi sesuai kebutuhan Anda dengan mudah dan praktis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="landing-benefits-visual">
                    <div class="landing-visual-card">
                        <div class="landing-visual-header">
                            <div class="landing-visual-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="landing-visual-content">
                            <div class="landing-visual-stats">
                                <div class="landing-stat-item">
                                    <div class="landing-stat-number">Mendengar Banyak</div>
                                    <div class="landing-stat-label">Pengguna Terdaftar</div>
                                </div>
                                <div class="landing-stat-item">
                                    <div class="landing-stat-number">Profesional</div>
                                    <div class="landing-stat-label">Bersertifikat dan Berlisensi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="landing-cta">
    <div class="container">
        <div class="landing-cta-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="landing-cta-title">Siap Memulai Perjalanan Kesehatan Mental Anda?</h2>
                    <p class="landing-cta-description">Jangan biarkan masalah mental menghambat potensi Anda. Mulai dengan Pengukuran gratis atau konsultasi dengan profesional kami.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="landing-cta-buttons">
                        <a href="{{ route('disclaimer') }}" class="btn btn-cta2 mb-2">
                            Mulai Pengukuran Gratis
                        </a>
                        <a href="{{ route('daftarprofesional') }}" class="btn btn-cta3">
                            Lihat Profesional
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection