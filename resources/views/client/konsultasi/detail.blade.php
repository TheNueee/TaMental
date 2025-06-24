@extends('layouts.app')
@section('title', 'Detail Konsultasi')
@section('content')
<div class="reschedule-container">
    <!-- Header -->
    <div class="reschedule-header">
        <h2>📋 Detail Konsultasi</h2>
        <p class="reschedule-subtitle">Informasi lengkap tentang janji konsultasi Anda</p>
    </div>

    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="progress-step">
            <div class="step-circle completed">✓</div>
            <span class="step-label">Booked</span>
        </div>
        <div class="step-connector completed"></div>
        <div class="progress-step">
            <div class="step-circle {{ $konsultasi->status === 'scheduled' ? 'active' : ($konsultasi->status === 'completed' ? 'completed' : 'pending') }}">
                @if($konsultasi->status === 'completed')
                    ✓
                @elseif($konsultasi->status === 'scheduled')
                    2
                @else
                    2
                @endif
            </div>
            <span class="step-label">Scheduled</span>
        </div>
        <div class="step-connector {{ $konsultasi->status === 'completed' ? 'completed' : '' }}"></div>
        <div class="progress-step">
            <div class="step-circle {{ $konsultasi->status === 'completed' ? 'completed' : 'pending' }}">
                @if($konsultasi->status === 'completed')
                    ✓
                @else
                    3
                @endif
            </div>
            <span class="step-label">Completed</span>
        </div>
    </div>

    <!-- Status Alert -->
    @if($konsultasi->status === 'cancelled')
    <div class="policy-notice" style="background-color: #fee; border-color: #fcc; margin-bottom: 20px;">
        <span class="policy-icon">❌</span>
        <div class="policy-text">
            <strong>Status:</strong> Konsultasi ini telah dibatalkan.
        </div>
    </div>
    @elseif($konsultasi->status === 'completed')
    <div class="policy-notice" style="background-color: #efe; border-color: #cfc; margin-bottom: 20px;">
        <span class="policy-icon">✅</span>
        <div class="policy-text">
            <strong>Status:</strong> Konsultasi telah selesai dilaksanakan.
        </div>
    </div>
    @endif

    <!-- Main Card -->
    <div class="reschedule-card">
        <!-- Appointment Details -->
        <div class="card-section">
            <h3 class="section-title">
                <span>📋</span>
                Informasi Konsultasi
            </h3>
            
            <div class="current-appointment">
                <div class="appointment-detail">
                    <span class="detail-icon">🏥</span>
                    <span class="detail-label">Layanan:</span>
                    <span class="detail-value">{{ $konsultasi->layanan->name }}</span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-icon">👨‍⚕️</span>
                    <span class="detail-label">Profesional:</span>
                    <span class="detail-value">{{ $konsultasi->professional->name }}</span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-icon">📅</span>
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">{{ $konsultasi->scheduled_at->format('l, d F Y') }}</span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-icon">🕐</span>
                    <span class="detail-label">Waktu:</span>
                    <span class="detail-value">{{ $konsultasi->scheduled_at->format('H:i') }} WIB</span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-icon">⏱️</span>
                    <span class="detail-label">Durasi:</span>
                    <span class="detail-value">{{ $konsultasi->layanan->duration_minutes }} Menit</span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-icon">💰</span>
                    <span class="detail-label">Biaya:</span>
                    <span class="detail-value">Rp {{ number_format($konsultasi->layanan->price, 0, ',', '.') }}</span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-icon">🏷️</span>
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" style="
                        @if($konsultasi->status === 'scheduled') color: #28a745; 
                        @elseif($konsultasi->status === 'completed') color: #007bff; 
                        @elseif($konsultasi->status === 'cancelled') color: #dc3545; 
                        @endif
                        font-weight: bold; text-transform: capitalize;">
                        {{ $konsultasi->status }}
                    </span>
                </div>
                @if($konsultasi->notes)
                <div class="appointment-detail">
                    <span class="detail-icon">📝</span>
                    <span class="detail-label">Catatan:</span>
                    <span class="detail-value">{{ $konsultasi->notes }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Meeting Link Section (Only for scheduled consultations) -->
        @if($konsultasi->status === 'scheduled')
        <div class="card-section">
            <h3 class="section-title">
                <span>💻</span>
                Link Meeting
            </h3>
            
            <div class="confirmation-card">
                <div class="confirmation-details">
                    <div class="confirmation-item">
                        <span class="confirmation-label">Link Konsultasi:</span>
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                            <input type="text" value="{{ $konsultasi->meeting_link }}" 
                                   id="meetingLink" readonly 
                                   style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                            <button type="button" onclick="copyLink()" 
                                    style="padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                📋 Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Policy Notice -->
        <div class="policy-notice">
            <span class="policy-icon">ℹ️</span>
            <div class="policy-text">
                <strong>Informasi Penting:</strong> 
                @if($konsultasi->status === 'scheduled')
                    Harap bergabung tepat waktu pada link meeting yang telah disediakan. Reschedule hanya dapat dilakukan minimal 6 jam sebelum waktu konsultasi.
                @elseif($konsultasi->status === 'completed')
                    Konsultasi telah selesai dilaksanakan. Terima kasih atas kepercayaan Anda.
                @else
                    Konsultasi ini telah dibatalkan. Silakan buat janji baru jika diperlukan.
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('client.konsultasi.index') }}" class="btn-back">
                <span>←</span>
                Ke Riwayat
            </a>
            
        </div>
    </div>
</div>

<script>
function copyLink() {
    const linkInput = document.getElementById('meetingLink');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(linkInput.value).then(function() {
        // Change button text temporarily
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '✅ Copied!';
        button.style.background = '#28a745';
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.style.background = '#007bff';
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Link berhasil disalin');
    });
}
</script>

@if(session('success'))
<script>
    // You can add success notification here if needed
    console.log('{{ session('success') }}');
</script>
@endif
@endsection