@extends('layouts.app')
@section('title', 'Jadwal Konsultasi Saya')
@section('content')
<div class="professional-calendar-consultation-container">
    <!-- Header -->
    <div class="professional-calendar-header">
        <div>
            <h1 class="professional-calendar-title">Jadwal Konsultasi</h1>
            <p class="professional-calendar-subtitle">Pantau semua konsultasi yang dijadwalkan bersama klien Anda</p>
        </div>
        
        <div class="professional-calendar-nav">
            <button class="professional-nav-btn" onclick="previousMonth()">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
            </button>
            <button class="professional-today-btn" onclick="goToToday()">Hari ini</button>
            <button class="professional-nav-btn" onclick="nextMonth()">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Calendar Layout -->
    <div class="professional-calendar-layout">
        <!-- Calendar Section -->
        <div class="professional-calendar-section">
            <h3 class="professional-section-title">
                📅 <span id="current-month-year">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
            </h3>
            <div class="professional-calendar-grid" id="calendar-grid"></div>

            <div class="professional-calendar-legend">
                <div class="professional-legend-item">
                    <div class="professional-legend-color scheduled"></div>
                    <span>Terjadwal</span>
                </div>
                <div class="professional-legend-item">
                    <div class="professional-legend-color pending"></div>
                    <span>Menunggu</span>
                </div>
                <div class="professional-legend-item">
                    <div class="professional-legend-color completed"></div>
                    <span>Selesai</span>
                </div>
                <div class="professional-legend-item">
                    <div class="professional-legend-color cancelled"></div>
                    <span>Dibatalkan</span>
                </div>
            </div>
        </div>

        <!-- Consultations Section -->
        <div class="professional-consultations-section">
            <h3 class="professional-section-title">📋 Konsultasi Mendatang</h3>
            <div id="consultations-list"></div>
        </div>
    </div>
</div>

<!-- Modal -->
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
    let calendarHTML = dayHeaders.map(d => `<div class="professional-calendar-header-cell">${d}</div>`).join('');

    for (let i = startingDayOfWeek - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        calendarHTML += `<div class="professional-calendar-day other-month">
            <div class="professional-day-number">${day}</div>
        </div>`;
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
            const clientName = consultation.client.name.length > 8 ? consultation.client.name.substring(0, 8) + '...' : consultation.client.name;

            eventsHTML += `<div class="professional-consultation-event ${consultation.status}" onclick="showConsultationDetail(${consultation.id})" title="${consultation.client.name} - ${consultation.layanan.name} (${time})">${time} ${clientName}</div>`;
        });

        calendarHTML += `<div class="professional-calendar-day ${isToday ? 'today' : ''}">
            <div class="professional-day-number">${day}</div>${eventsHTML}
        </div>`;
    }

    const totalCells = Math.ceil((startingDayOfWeek + daysInMonth) / 7) * 7;
    for (let i = 1; i <= totalCells - startingDayOfWeek - daysInMonth; i++) {
        calendarHTML += `<div class="professional-calendar-day other-month"><div class="professional-day-number">${i}</div></div>`;
    }

    document.getElementById('calendar-grid').innerHTML = calendarHTML;
}

function renderConsultations() {
    const now = new Date();
    const upcoming = consultations.filter(c => new Date(c.scheduled_at) >= now).sort((a, b) => new Date(a.scheduled_at) - new Date(b.scheduled_at));
    let html = '';

    if (upcoming.length === 0) {
        html = `<div class="professional-empty-state">
            <div class="professional-empty-icon">📅</div>
            <h4 class="professional-empty-title">Tidak ada konsultasi mendatang</h4>
            <p class="professional-empty-description">Konsultasi baru akan muncul di sini setelah klien melakukan booking.</p>
        </div>`;
    } else {
        upcoming.forEach(c => {
            const d = new Date(c.scheduled_at);
            const dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            const timeStr = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            const statusClass = `professional-status-${c.status}`;
            const statusText = { scheduled: 'Terjadwal', pending: 'Menunggu', completed: 'Selesai', cancelled: 'Dibatalkan' }[c.status];

            const joinBtn = c.status === 'scheduled' && c.meeting_link ?
                `<a href="${c.meeting_link}" target="_blank" class="professional-join-meeting-btn">🚀 Join Meeting</a>` : '';

            html += `<div class="professional-consultation-card" onclick="showConsultationDetail(${c.id})">
                <div class="professional-consultation-header">
                    <div>
                        <h5 class="professional-consultation-client">👤 ${c.client.name}</h5>
                        <p class="professional-consultation-service">🏷️ ${c.layanan.name}</p>
                        <p class="professional-consultation-time">🕒 ${dateStr}, ${timeStr}</p>
                    </div>
                    <div class="professional-consultation-actions">
                        <span class="professional-status-badge ${statusClass}">${statusText}</span>
                        ${joinBtn}
                    </div>
                </div>
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

function showConsultationDetail(id) {
    const c = consultations.find(x => x.id === id);
    if (!c) return;

    const d = new Date(c.scheduled_at);
    const formatted = d.toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    const statusColor = { scheduled: '#10b981', pending: '#f59e0b', completed: '#6b7280', cancelled: '#ef4444' }[c.status];
    const statusText = { scheduled: 'Terjadwal', pending: 'Menunggu', completed: 'Selesai', cancelled: 'Dibatalkan' }[c.status];

    const badge = `<span class="badge" style="background: ${statusColor}; color: white; padding: 6px 12px; border-radius: 6px;">${statusText}</span>`;
    const note = c.notes ? `<p><strong>📝 Catatan:</strong> ${c.notes}</p>` : '';
    const join = c.status === 'scheduled' && c.meeting_link ? `<a href="${c.meeting_link}" target="_blank" class="btn btn-primary mt-3">🚀 Join Meeting</a>` : '';

    document.getElementById('consultationDetails').innerHTML = `
        <div style="padding: 10px;">
            <h6><strong>👤 Klien:</strong> ${c.client.name}</h6>
            <p><strong>📧 Email:</strong> ${c.client.email || 'Tidak tersedia'}</p>
            <p><strong>🏷️ Layanan:</strong> ${c.layanan.name}</p>
            <p><strong>🕒 Waktu:</strong> ${formatted}</p>
            <p><strong>📊 Status:</strong> ${badge}</p>
            ${note}
            ${join}
        </div>
    `;
    new bootstrap.Modal(document.getElementById('consultationModal')).show();
}
</script>
@endsection
