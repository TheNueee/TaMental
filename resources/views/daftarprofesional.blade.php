@extends('layouts.app')
@section('title', 'Daftar Profesional')
@section('content')
<style>
    .professional-card {
        background: white;
        border-radius: var(--border-radius-lg);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }
    .professional-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-orange);
    }
    .card-header-custom {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-light);
    position: relative;
    display: grid;
    place-items: center;
}
    .profile-photo-container {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        position: relative;
    }
    .profile-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: var(--shadow-md);
    }
    .professional-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }
    .professional-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        line-height: 1.4;
        text-align: center;
    }
    .professional-title {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 0;
        font-weight: 500;
        text-align: center;
    }
    .professional-specialties {
        padding: 1rem 1.5rem;
        background: white;
    }
    .specialty-tag {
        display: inline-block;
        background: rgba(244, 162, 97, 0.1);
        color: var(--secondary-orange);
        padding: 0.25rem 0.75rem;
        border-radius: var(--border-radius-full);
        font-size: 0.8rem;
        font-weight: 500;
        margin: 0.25rem 0.25rem 0.25rem 0;
        border: 1px solid rgba(244, 162, 97, 0.2);
    }
    .card-actions {
        padding: 1.5rem;
        background: white;
        border-top: 1px solid var(--border-light);
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .btn-detail {
        color: var(--primary-orange);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        padding: 0.5rem;
        border-radius: var(--border-radius-md);
        border: 1px solid var(--primary-orange);
        background: transparent;
        border-radius: var(--border-radius-full);
    }
    .btn-detail:hover {
        color: white;
        background: var(--primary-orange);
        text-decoration: none;
        gap: 0.75rem;
    }
    .page-header {
        background: linear-gradient(135deg, rgba(244, 162, 97, 0.05) 0%, rgba(231, 111, 81, 0.05) 100%);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(244, 162, 97, 0.1);
    }
    .page-title {
        color: var(--text-dark);
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .page-subtitle {
        color: var(--text-light);
        font-size: 1rem;
        margin-bottom: 0;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-light);
    }
    .empty-state-icon {
        width: 64px;
        height: 64px;
        background: rgba(244, 162, 97, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--primary-orange);
        font-size: 1.5rem;
    }
    .null-state-specialties {
        color: var(--text-light);
        font-style: italic;
        font-size: 0.85rem;
        text-align: center;
        padding: 1rem;
        background: rgba(113, 128, 150, 0.05);
        border-radius: 8px;
        margin: 0.5rem 0;
    }

    /* Modal Styles */
    .modal-header {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        color: white;
        border-bottom: none;
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
    }
    .modal-content {
        border: none;
        border-radius: var(--border-radius-lg);
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
    }
    .modal-dialog {
        max-width: 600px;
    }
    .modal-profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        margin: 0 auto;
    }
    .modal-body {
        padding: 2rem;
    }
    .modal-section {
        margin-bottom: 1.5rem;
    }
    .modal-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modal-section-title i {
        color: var(--primary-orange);
        width: 20px;
    }
    .modal-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    .modal-info-item:last-child {
        border-bottom: none;
    }
    .modal-info-label {
        font-weight: 500;
        color: var(--text-light);
        font-size: 0.9rem;
    }
    .modal-info-value {
        font-weight: 600;
        color: var(--text-dark);
        text-align: right;
        flex: 1;
        margin-left: 1rem;
    }
    .license-item {
        background: rgba(244, 162, 97, 0.05);
        border: 1px solid rgba(244, 162, 97, 0.1);
        border-radius: var(--border-radius-md);
        padding: 1rem;
        margin-bottom: 0.75rem;
    }
    .license-item:last-child {
        margin-bottom: 0;
    }
    .license-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }
    .license-number {
        color: var(--primary-orange);
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .license-dates {
        font-size: 0.8rem;
        color: var(--text-light);
    }
    .bio-text {
        color: var(--text-dark);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .card-actions {
            padding: 1rem;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        /* Enhanced Bio Section Styles */
.bio-text {
    color: var(--text-dark);
    line-height: 1.7;
    font-size: 0.95rem;
    text-align: justify;
    word-spacing: 0.1em;
    hyphens: auto;
    overflow-wrap: break-word;
    word-wrap: break-word;
}

/* Bio container with max height and scroll for very long bios */
.bio-container {
    max-height: 300px;
    overflow-y: auto;
    padding-right: 8px;
    scrollbar-width: thin;
    scrollbar-color: rgba(244, 162, 97, 0.3) transparent;
}

.bio-container::-webkit-scrollbar {
    width: 6px;
}

.bio-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 3px;
}

.bio-container::-webkit-scrollbar-thumb {
    background: rgba(244, 162, 97, 0.4);
    border-radius: 3px;
}

.bio-container::-webkit-scrollbar-thumb:hover {
    background: rgba(244, 162, 97, 0.6);
}

/* Bio paragraphs for better spacing */
.bio-text p {
    margin-bottom: 1rem;
}

.bio-text p:last-child {
    margin-bottom: 0;
}

/* Read more/less functionality for very long bios */
.bio-expandable {
    position: relative;
}

.bio-expandable.collapsed .bio-text {
    max-height: 150px;
    overflow: hidden;
    position: relative;
}

.bio-expandable.collapsed .bio-text::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40px;
    background: linear-gradient(transparent, white);
}

.bio-toggle {
    color: var(--primary-orange);
    background: none;
    border: none;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    padding: 0.5rem 0;
    text-decoration: underline;
    transition: color 0.2s ease;
}

.bio-toggle:hover {
    color: var(--secondary-orange);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .bio-text {
        font-size: 0.9rem;
        line-height: 1.6;
        text-align: left;
    }
    
    .bio-container {
        max-height: 250px;
        padding-right: 4px;
    }
    
    .bio-expandable.collapsed .bio-text {
        max-height: 120px;
    }
}

@media (max-width: 480px) {
    .bio-text {
        font-size: 0.88rem;
        line-height: 1.55;
    }
    
    .bio-container {
        max-height: 200px;
    }
    
    .bio-expandable.collapsed .bio-text {
        max-height: 100px;
    }
}
    }
</style>

<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Daftar Profesional</h1>
        <p class="page-subtitle">Pilih profesional yang tepat untuk kebutuhan konseling Anda</p>
    </div>

    @if($professionals->count() > 0)
        <div class="row">
            @foreach($professionals as $pro)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="professional-card">
                    <!-- Card Header with Photo -->
                    <div class="card-header-custom">
                        <div class="profile-photo-container">
                            @if($pro->photo && file_exists(public_path('storage/photos/' . $pro->photo)))
                                <img src="{{ asset('storage/photos/' . $pro->photo) }}" 
                                     class="profile-photo" 
                                     alt="Foto {{ $pro->name }}">
                            @else
                                <div class="profile-photo d-flex align-items-center justify-content-center" 
                                     style="background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%); color: white; font-size: 1.5rem; font-weight: 600;">
                                    {{ strtoupper(substr($pro->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="professional-badge">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        
                        <h5 class="professional-name">{{ $pro->name }}</h5>
                        <p class="professional-title">
                            {{ isset($pro->professional->str_number) && $pro->professional->str_number ? 'STR: ' . $pro->professional->str_number : 'Profesional Konseling' }}
                        </p>
                    </div>

                    <!-- Specialties Section -->
                    <div class="professional-specialties">
                        @if(isset($pro->professional->spesialisasi) && $pro->professional->spesialisasi)
                            @php
                                $specialties = is_string($pro->professional->spesialisasi) 
                                    ? explode(',', $pro->professional->spesialisasi) 
                                    : (is_array($pro->professional->spesialisasi) ? $pro->professional->spesialisasi : []);
                                $specialties = array_map('trim', $specialties);
                                $specialties = array_filter($specialties);
                            @endphp
                            
                            @if(count($specialties) > 0)
                                @foreach(array_slice($specialties, 0, 3) as $specialty)
                                    <span class="specialty-tag">{{ $specialty }}</span>
                                @endforeach
                                @if(count($specialties) > 3)
                                    <span class="specialty-tag">+{{ count($specialties) - 3 }} lainnya</span>
                                @endif
                            @else
                                <div class="null-state-specialties">
                                    Spesialisasi dalam berbagai bidang konseling dan psikologi
                                </div>
                            @endif
                        @else
                            <div class="null-state-specialties">
                                Spesialisasi dalam berbagai bidang konseling dan psikologi
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="card-actions">
                        <button type="button" class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $pro->id }}">
                            <i class="fas fa-info-circle"></i>
                            Lihat Profil Lengkap
                        </button>   
                        
                        @if(auth()->guest() || auth()->user()->isClient())
                            <a href="{{ auth()->guest() ? route('login.form') : route('booking.page', ['professional' => $pro->id]) }}"
                               class="btn-cta w-100">
                                <i class="fas fa-calendar-plus"></i>
                                {{ auth()->guest() ? 'Login untuk Buat Janji' : 'Buat Janji' }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Professional Detail Modal -->
            <div class="modal fade" id="modalDetail{{ $pro->id }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $pro->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailLabel{{ $pro->id }}">
                                <i class="fas fa-user-md me-2"></i>
                                Profil Profesional
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Profile Photo and Basic Info -->
                            <div class="text-center mb-4">
                                @if($pro->photo && file_exists(public_path('storage/photos/' . $pro->photo)))
                                    <img src="{{ asset('storage/photos/' . $pro->photo) }}" 
                                         class="modal-profile-photo" 
                                         alt="Foto {{ $pro->name }}">
                                @else
                                    <div class="modal-profile-photo d-flex align-items-center justify-content-center mx-auto" 
                                         style="background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%); color: white; font-size: 2.5rem; font-weight: 600;">
                                        {{ strtoupper(substr($pro->name, 0, 1)) }}
                                    </div>
                                @endif
                                <h4 class="mt-3 mb-1" style="color: var(--text-dark); font-weight: 600;">{{ $pro->name }}</h4>
                                <p class="text-muted mb-0">{{ $pro->email }}</p>
                            </div>

                            <!-- Professional Information -->
                            <div class="modal-section">
                                <h6 class="modal-section-title">
                                    <i class="fas fa-id-card"></i>
                                    Informasi Profesional
                                </h6>
                                <div class="modal-info-item">
                                    <span class="modal-info-label">Nomor STR</span>
                                    <span class="modal-info-value">
                                        {{ isset($pro->professional->str_number) && $pro->professional->str_number ? $pro->professional->str_number : 'Tidak tersedia' }}
                                    </span>
                                </div>
                                <div class="modal-info-item">
                                    <span class="modal-info-label">Pengalaman</span>
                                    <span class="modal-info-value">
                                        {{ isset($pro->professional->pengalaman_tahun) && $pro->professional->pengalaman_tahun ? $pro->professional->pengalaman_tahun . ' tahun' : 'Tidak tersedia' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Specializations -->
                            @if(isset($pro->professional->spesialisasi) && $pro->professional->spesialisasi)
                            <div class="modal-section">
                                <h6 class="modal-section-title">
                                    <i class="fas fa-star"></i>
                                    Spesialisasi
                                </h6>
                                @php
                                    $specialties = is_string($pro->professional->spesialisasi) 
                                        ? explode(',', $pro->professional->spesialisasi) 
                                        : (is_array($pro->professional->spesialisasi) ? $pro->professional->spesialisasi : []);
                                    $specialties = array_map('trim', $specialties);
                                    $specialties = array_filter($specialties);
                                @endphp
                                
                                @if(count($specialties) > 0)
                                    <div>
                                        @foreach($specialties as $specialty)
                                            <span class="specialty-tag">{{ $specialty }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Spesialisasi dalam berbagai bidang konseling dan psikologi</p>
                                @endif
                            </div>
                            @endif

                            <!-- Licenses -->
                            @if(isset($pro->professional->licenses) && $pro->professional->licenses->count() > 0)
                            <div class="modal-section">
                                <h6 class="modal-section-title">
                                    <i class="fas fa-certificate"></i>
                                    Lisensi & Sertifikasi
                                </h6>
                                @foreach($pro->professional->licenses as $license)
                                <div class="license-item">
                                    <div class="license-name">{{ $license->nama }}</div>
                                    <div class="license-number">No. {{ $license->nomor }}</div>
                                    <div class="license-dates">
                                        Berlaku: {{ \Carbon\Carbon::parse($license->tanggal_terbit)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($license->tanggal_expired)->format('d M Y') }}
                                    </div>
                                    @if($license->deskripsi)
                                        <div class="mt-2 text-muted" style="font-size: 0.85rem;">{{ $license->deskripsi }}</div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- Bio/Description -->
                            @if(isset($pro->professional->bio) && $pro->professional->bio)
                            <div class="modal-section">
                                <h6 class="modal-section-title">
                                    <i class="fas fa-user"></i>
                                    Tentang
                                </h6>
                                <p class="bio-text">{{ $pro->professional->bio }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            @if(auth()->guest() || auth()->user()->isClient())
                                <a href="{{ auth()->guest() ? route('login.form') : route('booking.page', ['professional' => $pro->id]) }}"
                                   class="btn-cta w-100">
                                    <i class="fas fa-calendar-plus"></i>
                                    {{ auth()->guest() ? 'Login untuk Buat Janji' : 'Buat Janji Konsultasi' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-user-friends"></i>
            </div>
            <h4 style="color: var(--text-dark); margin-bottom: 1rem;">Belum Ada Profesional Tersedia</h4>
            <p>Saat ini belum ada profesional yang terdaftar. Silakan coba lagi nanti atau hubungi administrator.</p>
        </div>
    @endif
</div>

<!-- Add Font Awesome if not already included -->
@if(!isset($fontAwesomeIncluded))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endif

<!-- Add Bootstrap JS if not already included -->
@if(!isset($bootstrapJSIncluded))
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endif

@endsection