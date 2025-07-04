@extends('layouts.app')
@section('title', 'Daftar Klien Saya')

@section('content')
<style>
    :root {
        --primary-orange: #F4A261;
        --secondary-orange: #E76F51;
        --text-dark: #2D3748;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --border-radius-lg: 12px;
        --border-radius-md: 8px;
        --border-radius-full: 9999px;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(244, 162, 97, 0.05) 0%, rgba(231, 111, 81, 0.05) 100%);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(244, 162, 97, 0.1);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
        opacity: 0.1;
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .page-title {
        color: var(--text-dark);
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 1rem;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .stats-container {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--border-radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
    }

    .stat-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .stat-content p {
        color: var(--text-light);
        margin: 0;
        font-size: 0.9rem;
    }

    .client-card {
        background: white;
        border-radius: var(--border-radius-lg);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .client-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-orange);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-light);
        position: relative;
        text-align: center;
    }

    .client-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }

    .client-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .client-email {
        color: var(--text-light);
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    .client-info {
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .info-icon {
        width: 16px;
        height: 16px;
        color: var(--primary-orange);
    }

    .last-test-info {
        background: rgba(244, 162, 97, 0.05);
        border: 1px solid rgba(244, 162, 97, 0.1);
        border-radius: var(--border-radius-md);
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .last-test-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .test-date {
        font-size: 0.8rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
    }

    .status-indicators {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .status-indicator {
        padding: 0.25rem 0.5rem;
        border-radius: var(--border-radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-normal {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .status-ringan {
        background: rgba(251, 191, 36, 0.1);
        color: #d97706;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .status-sedang {
        background: rgba(249, 115, 22, 0.1);
        color: #ea580c;
        border: 1px solid rgba(249, 115, 22, 0.2);
    }

    .status-parah, .status-sangat-parah {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .consultation-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: var(--border-radius-md);
        font-size: 0.9rem;
    }

    .consultation-scheduled {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .consultation-none {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
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
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius-full);
        border: 1px solid var(--primary-orange);
        background: transparent;
        width: 100%;
    }

    .btn-detail:hover {
        color: white;
        background: var(--primary-orange);
        text-decoration: none;
        gap: 0.75rem;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-light);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: rgba(244, 162, 97, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--primary-orange);
        font-size: 2rem;
    }

    .empty-state h3 {
        color: var(--text-dark);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-light);
        font-size: 1rem;
        margin-bottom: 0;
    }

    .filter-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
    }

    .filter-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .filter-options {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-light);
        border-radius: var(--border-radius-full);
        background: white;
        color: var(--text-light);
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-btn.active, .filter-btn:hover {
        background: var(--primary-orange);
        color: white;
        border-color: var(--primary-orange);
    }

    @media (max-width: 768px) {
        .stats-container {
            flex-direction: column;
        }
        
        .stat-card {
            min-width: auto;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>
<div class="bg-professional"></div>
<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">👥 Daftar Klien Saya</h1>
        <p class="page-subtitle">Kelola dan pantau perkembangan klien yang berkonsultasi dengan Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $klien->count() }}</h3>
                <p>Total Klien</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $klien->sum(function($k) { return $k->konsultasi_data->where('status', 'scheduled')->count(); }) }}</h3>
                <p>Konsultasi Terjadwal</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $klien->sum(function($k) { return $k->pengujian->count(); }) }}</h3>
                <p>Total Pengukuran DASS-21 Klien Terkait</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">Filter Klien</div>
        <div class="filter-options">
            <button class="filter-btn active" onclick="filterClients('all')">Semua Klien</button>
            <button class="filter-btn" onclick="filterClients('scheduled')">Terjadwal</button>
            <button class="filter-btn" onclick="filterClients('completed')">Completed</button>
            <button class="filter-btn" onclick="filterClients('cancelled')">Cancelled</button>
        </div>
    </div>


    <!-- Clients Grid -->
    @if($klien->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="clients-grid">
            @foreach($klien as $k)
                <div class="col client-item" 
                     data-has-scheduled="{{ $k->has_scheduled ? 'true' : 'false' }}"
                     data-has-completed="{{ $k->has_completed ? 'true' : 'false' }}"
                     data-has-cancelled="{{ $k->has_cancelled ? 'true' : 'false' }}">
                    <div class="client-card">
                        <!-- Card Header -->
                        <div class="card-header-custom">
                            <div class="client-avatar">
                                {{ strtoupper(substr($k->name, 0, 1)) }}
                            </div>
                            <h5 class="client-name">{{ $k->name }}</h5>
                            <p class="client-email">{{ $k->email }}</p>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="card-body-custom">
                            <!-- Client Info -->
                            <div class="client-info">
                                <div class="info-item">
                                    <i class="fas fa-phone info-icon"></i>
                                    <span>{{ $k->telepon ?? 'Tidak tersedia' }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-vial info-icon"></i>
                                    <span>{{ $k->pengujian->count() }} Pengukuran DASS-21</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-comments info-icon"></i>
                                    <span>{{ $k->konsultasi_data->count() }} Konsultasi</span>
                                </div>
                            </div>


                            <!-- Action Button -->
                            <a href="{{ route('professional.klien.detail', $k->id) }}" class="btn-detail">
                                <i class="fas fa-eye"></i>
                                <span>Lihat Detail</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Belum Ada Klien</h3>
            <p>Anda belum memiliki klien yang berkonsultasi. Klien akan muncul di sini setelah mereka menjadwalkan konsultasi dengan Anda.</p>
        </div>
    @endif
</div>

<script>
function filterClients(filter) {
    // Update active filter button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filter clients
    const clients = document.querySelectorAll('.client-item');
    
    clients.forEach(client => {
        let show = false;
        
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'scheduled':
                show = client.dataset.hasScheduled === 'true';
                break;
            case 'completed':
                show = client.dataset.hasCompleted === 'true';
                break;
            case 'cancelled':
                show = client.dataset.hasCancelled === 'true';
                break;
        }
        
        if (show) {
            client.style.display = 'block';
            client.style.animation = 'fadeIn 0.3s ease-in';
        } else {
            client.style.display = 'none';
        }
    });
    
    // Update stats if needed
    updateFilterStats(filter);
}

function updateFilterStats(filter) {
    const clients = document.querySelectorAll('.client-item');
    let visibleCount = 0;
    
    clients.forEach(client => {
        if (client.style.display !== 'none') {
            visibleCount++;
        }
    });
    
    // You can update a counter here if needed
    console.log(`Showing ${visibleCount} clients for filter: ${filter}`);
}

</script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection