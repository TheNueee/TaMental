@extends('layouts.app')

@section('title', 'Tentang Kami - KamiDengar')

@section('content')
<div class="tentangkami-about-page">
    {{-- Hero Section --}}
    <section class="tentangkami-hero-about">
        <div class="tentangkami-container">
            <div class="tentangkami-hero-content">
                <div class="tentangkami-hero-text">
                    <h1 class="tentangkami-hero-title">Tentang <span class="primarytext">KamiDengar</span></h1>
                    <p class="tentangkami-hero-subtitle">Aplikasi ini dirancang untuk membantu Anda mengenali kondisi emosional melalui pengukuran standar (DASS-21), memahami dampak stres, kecemasan, dan depresi, serta terhubung langsung dengan profesional kesehatan mental yang siap mendampingi proses pemulihan dan pertumbuhan Anda.</p>
                </div>
                <div class="tentangkami-hero-stats">
                    <div class="tentangkami-stat-item">
                        <div class="tentangkami-stat-number">Mendengar Banyak</div>
                        <div class="tentangkami-stat-label">Pengguna Terdaftar</div>
                    </div>
                    <div class="tentangkami-stat-item">
                        <div class="tentangkami-stat-number">Profesional</div>
                        <div class="tentangkami-stat-label">Berpengalaman</div>
                    </div>
                    <div class="tentangkami-stat-item">
                        <div class="tentangkami-stat-number">24/7</div>
                        <div class="tentangkami-stat-label">Dukungan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission Vision Section --}}
    <section class="tentangkami-mission-vision">
        <div class="tentangkami-container">
            <div class="tentangkami-section-header">
                <h2>Visi & Misi Kami</h2>
                <p>Komitmen kami dalam memberikan layanan kesehatan mental terbaik</p>
            </div>
            
            <div class="tentangkami-mv-grid">
                <div class="tentangkami-mv-card tentangkami-vision-card">
                    <div class="tentangkami-mv-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <h3>Visi</h3>
                    <p>Menjadi platform kesehatan mental terdepan yang mudah diakses, terpercaya, dan memberikan dampak positif bagi kesejahteraan mental masyarakat Indonesia.</p>
                </div>
                
                <div class="tentangkami-mv-card tentangkami-mission-card">
                    <div class="tentangkami-mv-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3>Misi</h3>
                    <p>Menyediakan layanan konsultasi psikologi berkualitas tinggi, alat skrining DASS-21 yang akurat, dan menciptakan lingkungan yang aman untuk mendukung perjalanan kesehatan mental setiap individu.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- About Platform Section --}}
    <section class="tentangkami-about-platform">
        <div class="tentangkami-container">
            <div class="tentangkami-platform-content">
                <div class="tentangkami-platform-text">
                    <h2>Tentang Platform <span class="primarytext">KamiDengar</span></h2>
                    <p class="tentangkami-platform-desc">KamiDengar adalah aplikasi inovatif yang dirancang khusus untuk mendukung kesehatan mental masyarakat Indonesia. Kami menyediakan platform terintegrasi yang memungkinkan pengguna untuk melakukan pengukuran mandiri kondisi depresi, kecemasan, dan stres menggunakan instrumen DASS-21 yang telah tervalidasi secara ilmiah.</p>
                    
                    <div class="tentangkami-features-list">
                        <div class="tentangkami-feature-item">
                            <div class="tentangkami-feature-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12l2 2 4-4"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                            </div>
                            <div class="tentangkami-feature-text">
                                <h4>Pengukuran DASS-21 Tervalidasi</h4>
                                <p>Instrumen Pengukuran yang telah diakui secara internasional untuk mengukur tingkat depresi, kecemasan, dan stres</p>
                            </div>
                        </div>
                        
                        <div class="tentangkami-feature-item">
                            <div class="tentangkami-feature-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="m22 21-3-3"/>
                                </svg>
                            </div>
                            <div class="tentangkami-feature-text">
                                <h4>Konsultasi dengan Profesional</h4>
                                <p>Akses langsung ke psikolog dan konselor berlisensi melalui sesi konsultasi daring yang fleksibel</p>
                            </div>
                        </div>
                        
                        <div class="tentangkami-feature-item">
                            <div class="tentangkami-feature-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 3v18h18"/>
                                    <path d="m19 9-5 5-4-4-3 3"/>
                                </svg>
                            </div>
                            <div class="tentangkami-feature-text">
                                <h4>Pemantauan Perkembangan</h4>
                                <p>Riwayat dan tracking kondisi mental dari waktu ke waktu untuk memantau kemajuan Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Section --}}
    <section class="tentangkami-team-section">
        <div class="tentangkami-container">
            <div class="tentangkami-section-header">
                <h2>Tim <span class="primarytext">KamiDengar</span></h2>
                <p>Para ahli dan profesional yang berdedikasi untuk kesehatan mental Anda</p>
            </div>
            
            <div class="tentangkami-team-roles">
                <div class="tentangkami-role-card">
                    <div class="tentangkami-role-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="m22 21-3-3"/>
                        </svg>
                    </div>
                    <h3>Tim Klinis</h3>
                    <p>Psikolog dan konselor berlisensi dengan pengalaman bertahun-tahun dalam bidang kesehatan mental</p>
                    <div class="tentangkami-role-stats">
                        <span class="tentangkami-stat">Profesional Berpengalaman</span>
                    </div>
                </div>
                
                <div class="tentangkami-role-card">
                    <div class="tentangkami-role-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <h3>Tim Teknologi</h3>
                    <p>Developer dan engineer yang memastikan platform berjalan dengan optimal dan aman</p>
                    <div class="tentangkami-role-stats">
                        <span class="tentangkami-stat">24/7 Support</span>
                    </div>
                </div>
                
                <div class="tentangkami-role-card">
                    <div class="tentangkami-role-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3>Tim Kualitas</h3>
                    <p>Memastikan setiap layanan memenuhi standar kualitas tertinggi dalam pelayanan kesehatan mental</p>
                    <div class="tentangkami-role-stats">
                        <span class="tentangkami-stat">Keamanan Privasi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values Section --}}
    <section class="tentangkami-values-section">
        <div class="tentangkami-container">
            <div class="tentangkami-section-header">
                <h2>Nilai-Nilai Kami</h2>
                <p>Prinsip yang menjadi fondasi dalam setiap layanan yang kami berikan</p>
            </div>
            
            <div class="tentangkami-values-grid">
                <div class="tentangkami-value-card">
                    <div class="tentangkami-value-number">01</div>
                    <h3>Kepercayaan</h3>
                    <p>Menjaga keamanan dan kerahasiaan data pribadi Anda dengan standar keamanan tertinggi</p>
                </div>
                
                <div class="tentangkami-value-card">
                    <div class="tentangkami-value-number">02</div>
                    <h3>Profesionalisme</h3>
                    <p>Layanan berkualitas tinggi dari para ahli yang kompeten dan berpengalaman</p>
                </div>
                
                <div class="tentangkami-value-card">
                    <div class="tentangkami-value-number">03</div>
                    <h3>Aksesibilitas</h3>
                    <p>Membuat layanan kesehatan mental mudah diakses oleh siapa saja, kapan saja</p>
                </div>
                
                <div class="tentangkami-value-card">
                    <div class="tentangkami-value-number">04</div>
                    <h3>Empati</h3>
                    <p>Memahami dan mendampingi setiap perjalanan kesehatan mental dengan penuh perhatian</p>
                </div>
            </div>
        </div>
    </section>