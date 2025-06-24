@extends('layouts.app')
@section('title', 'Janji Konsultasi Saya')
@section('content')

<div class="client-calendar-consultation-container">

     <!-- Tambah -->
            <div class="header-section">
                <div class="header-content">
                    <h1 class="header-title">Timeline Konsultasi</h1>
                    <p class="header-subtitle">Kelola dan pantau semua janji konsultasi Anda dengan mudah</p>
                    <a href="{{ route('daftarprofesional') }}" class="new-consultation-btn">
                        <span>➕</span>
                        Konsultasi Baru
                    </a>
                </div>
            </div>

    {{-- Header --}}
    <div class="client-calendar-header">
        <div>
            <h1 class="client-calendar-title">Jadwal Konsultasi Saya</h1>
            <p class="client-calendar-subtitle">Kelola dan pantau semua janji konsultasi Anda dengan mudah</p>
        </div>

        <div class="client-calendar-nav">
            <button class="client-nav-btn" onclick="previousMonth()">
                {{-- Left arrow --}}
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
            </button>
            <button class="client-today-btn" onclick="goToToday()">Hari ini</button>
            <button class="client-nav-btn" onclick="nextMonth()">
                {{-- Right arrow --}}
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <span style="font-size: 24px;">✅</span>
        <div>
            <strong>Berhasil!</strong>
            <p style="margin: 0;">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Layout --}}
    <div class="client-calendar-layout">
        {{-- Kalender --}}
        <div class="client-calendar-section">
            <h3 class="client-section-title">
                📅 <span id="current-month-year">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
            </h3>
            <div class="client-calendar-grid" id="calendar-grid"></div>
            <div class="client-calendar-legend">
                <div class="client-legend-item"><div class="client-legend-color scheduled"></div><span>Terjadwal</span></div>
                <div class="client-legend-item"><div class="client-legend-color pending"></div><span>Menunggu</span></div>
                <div class="client-legend-item"><div class="client-legend-color completed"></div><span>Selesai</span></div>
                <div class="client-legend-item"><div class="client-legend-color cancelled"></div><span>Dibatalkan</span></div>
            </div>
        </div>

        {{-- Konsultasi --}}
        <div class="client-consultations-section">
            <h3 class="client-section-title">📋 Konsultasi Mendatang</h3>
            <div id="consultations-list"></div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('daftarprofesional') }}" class="client-new-consultation-btn">
                    <span>➕</span> Konsultasi Baru
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="consultationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                <h5 class="modal-title">Detail Konsultasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="consultationDetails"></div>
        </div>
    </div>
</div>

<script>
let currentDate = new Date();
let consultations = @json($konsultasis);

document.addEventListener('DOMContentLoaded', function () {
    renderCalendar();
    renderConsultations();
});

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const today = new Date();

    const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('current-month-year').textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startingDayOfWeek = firstDay.getDay();
    const daysInMonth = lastDay.getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    const dayHeaders = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    let calendarHTML = dayHeaders.map(d => `<div class="client-calendar-header-cell">${d}</div>`).join('');

    for (let i = startingDayOfWeek - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        calendarHTML += `<div class="client-calendar-day other-month"><div class="client-day-number">${day}</div></div>`;
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
        const dayConsults = consultations.filter(c => {
            const d = new Date(c.scheduled_at);
            return d.getFullYear() === year && d.getMonth() === month && d.getDate() === day;
        });

        let eventsHTML = '';
        dayConsults.forEach(consultation => {
            const time = new Date(consultation.scheduled_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            const professionalName = consultation.professional.name.length > 8 ? consultation.professional.name.substring(0, 8) + '...' : consultation.professional.name;
            eventsHTML += `<div class="client-consultation-event ${consultation.status}" onclick="showConsultationDetail(${consultation.id})" title="${consultation.professional.name} - ${consultation.layanan.name} (${time})">${time} ${professionalName}</div>`;
        });

        calendarHTML += `<div class="client-calendar-day ${isToday ? 'today' : ''}"><div class="client-day-number">${day}</div>${eventsHTML}</div>`;
    }

    const totalCells = Math.ceil((startingDayOfWeek + daysInMonth) / 7) * 7;
    for (let i = 1; i <= totalCells - startingDayOfWeek - daysInMonth; i++) {
        calendarHTML += `<div class="client-calendar-day other-month"><div class="client-day-number">${i}</div></div>`;
    }

    document.getElementById('calendar-grid').innerHTML = calendarHTML;
}

function renderConsultations() {
    const now = new Date();
    const upcoming = consultations.filter(c => new Date(c.scheduled_at) >= now).sort((a, b) => new Date(a.scheduled_at) - new Date(b.scheduled_at));

    let html = '';
    if (upcoming.length === 0) {
        html = `<div class="client-empty-state">
            <div class="client-empty-icon">📅</div>
            <h4 class="client-empty-title">Tidak ada konsultasi mendatang</h4>
            <p class="client-empty-description">Mulai konsultasi pertama Anda dengan profesional terpercaya</p>
        </div>`;
    } else {
        upcoming.forEach(c => {
            const d = new Date(c.scheduled_at);
            const dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            const timeStr = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            const statusClass = `client-status-${c.status}`;
            const statusText = { scheduled: 'Terjadwal', pending: 'Menunggu', completed: 'Selesai', cancelled: 'Dibatalkan' }[c.status];

            let actionButtons = '';
            if (c.status === 'scheduled' || c.status === 'pending') {
                 const canModify = c.can_modify;
                actionButtons = `
                    <div class="client-action-buttons">
                        ${c.meeting_link ? `<a href="${c.meeting_link}" target="_blank" class="client-action-btn client-btn-join">🚀 Join</a>` : ''}
                        <a href="/konsultasi/detail/${c.id}" class="client-action-btn client-btn-detail">🔍 Detail</a>
                         ${canModify ? `<a href="/konsultasi/riwayat/edit/${c.id}" class="client-action-btn client-btn-reschedule">📝 Reschedule</a>` : ''}
                        ${canModify ? `<button onclick="cancelConsultation(${c.id})" class="client-action-btn client-btn-cancel">❌ Batal</button>` : ''}
                    </div>
                `;
            } else {
                actionButtons = `
                    <div class="client-action-buttons">
                        <a href="/konsultasi/detail/${c.id}" class="client-action-btn client-btn-detail">🔍 Detail</a>
                    </div>
                `;
            }

            html += `<div class="client-consultation-card" onclick="showConsultationDetail(${c.id})">
                <div class="client-consultation-header">
                    <div>
                        <h5 class="client-consultation-professional">👨‍⚕️ ${c.professional.name}</h5>
                        <p class="client-consultation-service">🏷️ ${c.layanan.name}</p>
                        <p class="client-consultation-time">🕒 ${dateStr}, ${timeStr}</p>
                    </div>
                    <div class="client-consultation-actions">
                        <span class="client-status-badge ${statusClass}">${statusText}</span>
                    </div>
                </div>
                ${actionButtons}
            </div>`;
        });
    }

    document.getElementById('consultations-list').innerHTML = html;
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

function goToToday() {
    currentDate = new Date();
    renderCalendar();
}

function cancelConsultation(id) {
    if (confirm('Apakah Anda yakin ingin membatalkan konsultasi ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/konsultasi/delete/${id}`;
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
