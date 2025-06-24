@extends('layouts.app')

@section('title', 'Riwayat Pengujian Saya')

@section('content')
<div class="consultation-container">
    <!-- Header Section -->
    <div class="header-section">
        <div class="header-content">
            <h1 class="header-title">Riwayat Pengujian DASS-21</h1>
            <p class="header-subtitle">Pantau hasil pengujian mental Anda dari waktu ke waktu</p>
            <a href="{{ route('disclaimer') }}" class="new-consultation-btn rounded-full">
                <span style="font-size: 20px;">🧠</span>
                Mulai Pengujian
            </a>
        </div>
    </div>

    <!-- Riwayat Section -->
    <div class="timeline-section">
        <div class="timeline-header">
            <div class="timeline-icon">📋</div>
            <span>Riwayat Hasil Pengujian</span>
        </div>

        @if($pengujian->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📄</div>
            <h3 class="empty-title">Belum ada hasil pengujian</h3>
            <p class="empty-description">Lakukan pengujian pertama Anda untuk melihat hasil di sini</p>
            <a href="{{ route('disclaimer') }}" class="btn-cta">
                <span>🧠</span>
                Mulai Pengujian
            </a>
        </div>
        @else
        <div class="grid gap-4">
            @foreach ($pengujian as $index => $uji)
            <div class="consultation-card">
                <div class="card-header">
                    <div class="layanan-info">
                        <h3 class="layanan-name">Hasil Pengujian ke-{{ $index + 1 }}</h3>
                        <div class="professional-name"><span>🧾</span> {{ $uji->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="status-badge status-completed">Selesai</div>
                </div>

                <div class="datetime-info">
                    <div class="datetime-item"><span class="datetime-icon"></span> Depresi: <strong>{{ $uji->kategori_depresi }}</strong></div>
                    <div class="datetime-item"><span class="datetime-icon"></span> Kecemasan: <strong>{{ $uji->kategori_kecemasan }}</strong></div>
                    <div class="datetime-item"><span class="datetime-icon"></span> Stres: <strong>{{ $uji->kategori_stres }}</strong></div>
                </div>

                <div class="actions-section">
                    <a href="{{ route('client.pengujian.lihat', $uji->id) }}" class="action-btn btn-join" title="Lihat Detail">
                        🔍 Detail
                    </a>
                    <form action="{{ route('client.pengujian.hapus', $uji->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data riwayat pengujian ini?')" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-cancel" title="Hapus">🗑️ Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.consultation-card');
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);

        rows.forEach(row => {
            row.style.opacity = '0';
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeIn 0.6s ease forwards';
                    }
                });
            }, { threshold: 0.1 });
            observer.observe(row);
        });
    });
</script>
@endsection
