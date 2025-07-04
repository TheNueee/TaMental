@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Saya')

@section('content')
<style>
/* Professional Action Buttons Styles */
.professional-action-buttons {
    display: flex;
    gap: 8px;
    margin-top: 12px;
    flex-wrap: wrap;
}

.professional-action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.professional-btn-join {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.professional-btn-join:hover {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    transform: translateY(-1px);
}

.professional-btn-detail {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.professional-btn-detail:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    transform: translateY(-1px);
}

.professional-btn-reschedule {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.professional-btn-reschedule:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
    color: white;
    transform: translateY(-1px);
}

.professional-btn-cancel {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.professional-btn-cancel:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    transform: translateY(-1px);
}

/* Disabled state for action buttons */
.professional-action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

/* Professional consultation card improvements */
.professional-consultation-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
    cursor: default; /* Remove pointer cursor since we have action buttons */
}

.professional-consultation-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.professional-consultation-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}

.professional-consultation-client {
    color: #1f2937;
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 4px 0;
}

.professional-consultation-service {
    color: #6b7280;
    font-size: 14px;
    margin: 0 0 4px 0;
}

.professional-consultation-time {
    color: #374151;
    font-size: 14px;
    margin: 0;
}

.professional-status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: white;
}

.professional-status-scheduled { background: #10b981; }
.professional-status-pending { background: #f59e0b; }
.professional-status-completed { background: #6b7280; }
.professional-status-cancelled { background: #ef4444; }

/* Empty state styling */
.professional-empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.professional-empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.professional-empty-title {
    color: #1f2937;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.professional-empty-description {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 0;
}
</style>
<div class="bg-professional"></div>
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
    
    // Previous month days
    for (let i = startingDayOfWeek - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        calendarHTML += `<div class="professional-calendar-day other-month">
            <div class="professional-day-number">${day}</div>
        </div>`;
    }
    
    // Current month days
    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
        
        // PERBAIKAN: Cara lebih aman untuk handle tanggal
        const dayConsults = consultations.filter(c => {
            const d = new Date(c.scheduled_at);
            // Koreksi timezone dengan mengurangi offset
            const correctedDate = new Date(d.getTime() - (7 * 60 * 60 * 1000));
            return correctedDate.getFullYear() === year && correctedDate.getMonth() === month && correctedDate.getDate() === day;
        });
        
        let eventsHTML = '';
        dayConsults.forEach(consultation => {
            // PERBAIKAN: Format waktu dengan koreksi timezone
            const originalDate = new Date(consultation.scheduled_at);
            const correctedTime = new Date(originalDate.getTime() - (7 * 60 * 60 * 1000));
            const time = String(correctedTime.getHours()).padStart(2, '0') + ':' + String(correctedTime.getMinutes()).padStart(2, '0');
            
            const clientName = consultation.client.name.length > 8 ? consultation.client.name.substring(0, 8) + '...' : consultation.client.name;
            eventsHTML += `<div class="professional-consultation-event ${consultation.status}" onclick="showConsultationDetail(${consultation.id})" title="${consultation.client.name} - ${consultation.layanan.name} (${time})">${time} ${clientName}</div>`;
        });
        
        calendarHTML += `<div class="professional-calendar-day ${isToday ? 'today' : ''}">
            <div class="professional-day-number">${day}</div>${eventsHTML}
        </div>`;
    }
    
    // Next month days to fill grid
    const totalCells = Math.ceil((startingDayOfWeek + daysInMonth) / 7) * 7;
    for (let i = 1; i <= totalCells - startingDayOfWeek - daysInMonth; i++) {
        calendarHTML += `<div class="professional-calendar-day other-month"><div class="professional-day-number">${i}</div></div>`;
    }
    
    document.getElementById('calendar-grid').innerHTML = calendarHTML;
}

function renderConsultations() {
    const now = new Date();
    
    // PERBAIKAN: Cara lebih aman untuk handle waktu
    const upcoming = consultations.filter(c => {
        const originalDate = new Date(c.scheduled_at);
        const correctedDate = new Date(originalDate.getTime() - (7 * 60 * 60 * 1000));
        return correctedDate >= now;
    }).sort((a, b) => {
        const dateA = new Date(a.scheduled_at);
        const dateB = new Date(b.scheduled_at);
        const correctedA = new Date(dateA.getTime() - (7 * 60 * 60 * 1000));
        const correctedB = new Date(dateB.getTime() - (7 * 60 * 60 * 1000));
        return correctedA - correctedB;
    });
    
    let html = '';
    
    if (upcoming.length === 0) {
        html = `<div class="professional-empty-state">
            <div class="professional-empty-icon">📅</div>
            <h4 class="professional-empty-title">Tidak ada konsultasi mendatang</h4>
            <p class="professional-empty-description">Konsultasi baru akan muncul di sini setelah klien melakukan booking.</p>
        </div>`;
    } else {
        upcoming.forEach(c => {
            // PERBAIKAN: Format tanggal dan waktu dengan manual formatting
            const originalDate = new Date(c.scheduled_at);
            const d = new Date(originalDate.getTime() - (7 * 60 * 60 * 1000));
            
            // Format tanggal manual
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dateStr = `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
            
            // Format waktu manual
            const timeStr = String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
            
            const statusClass = `professional-status-${c.status}`;
            const statusText = { 
                scheduled: 'Terjadwal', 
                pending: 'Menunggu', 
                completed: 'Selesai', 
                cancelled: 'Dibatalkan' 
            }[c.status];
            
            let actionButtons = '';
            if (c.status === 'scheduled' || c.status === 'pending') {
                const canModify = c.can_modify;
                actionButtons = `
                    <div class="professional-action-buttons">
                        ${c.meeting_link ? `<a href="${c.meeting_link}" target="_blank" class="professional-action-btn professional-btn-join">🚀 Join</a>` : ''}
                        <a href="${window.location.origin}/professional/konsultasi/${c.id}" class="professional-action-btn professional-btn-detail">🔍 Detail</a>
                        ${canModify ? `<a href="${window.location.origin}/professional/konsultasi/${c.id}/edit" class="professional-action-btn professional-btn-reschedule">📝 Reschedule</a>` : ''}
                        ${canModify ? `<button onclick="cancelConsultation(${c.id})" class="professional-action-btn professional-btn-cancel">❌ Batal</button>` : ''}
                    </div>
                `;
            } else {
                actionButtons = `
                    <div class="professional-action-buttons">
                        <a href="${window.location.origin}/professional/konsultasi/${c.id}" class="professional-action-btn professional-btn-detail">🔍 Detail</a>
                    </div>
                `;
            }
            
            html += `<div class="professional-consultation-card">
                <div class="professional-consultation-header">
                    <div>
                        <h5 class="professional-consultation-client">👤 ${c.client.name}</h5>
                        <p class="professional-consultation-service">🏷️ ${c.layanan.name}</p>
                        <p class="professional-consultation-time">🕒 ${dateStr}, ${timeStr}</p>
                    </div>
                    <div class="professional-consultation-actions">
                        <span class="professional-status-badge ${statusClass}">${statusText}</span>
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

function showConsultationDetail(id) {
    const c = consultations.find(x => x.id === id);
    if (!c) return;
    
    // PERBAIKAN: Format waktu dengan koreksi timezone untuk modal
    const originalDate = new Date(c.scheduled_at);
    const correctedDate = new Date(originalDate.getTime() - (7 * 60 * 60 * 1000));
    
    // Format manual untuk modal
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    const dayName = days[correctedDate.getDay()];
    const date = correctedDate.getDate();
    const monthName = months[correctedDate.getMonth()];
    const year = correctedDate.getFullYear();
    const time = String(correctedDate.getHours()).padStart(2, '0') + ':' + String(correctedDate.getMinutes()).padStart(2, '0');
    
    const formatted = `${dayName}, ${date} ${monthName} ${year}, ${time}`;
    
    const statusColor = { 
        scheduled: '#10b981', 
        pending: '#f59e0b', 
        completed: '#6b7280', 
        cancelled: '#ef4444' 
    }[c.status];
    
    const statusText = { 
        scheduled: 'Terjadwal', 
        pending: 'Menunggu', 
        completed: 'Selesai', 
        cancelled: 'Dibatalkan' 
    }[c.status];
    
    const badge = `<span class="badge" style="background: ${statusColor}; color: white; padding: 6px 12px; border-radius: 6px;">${statusText}</span>`;
    const note = c.notes ? `<p><strong>📝 Catatan:</strong> ${c.notes}</p>` : '';
    const join = c.status === 'scheduled' && c.meeting_link ? 
        `<a href="${c.meeting_link}" target="_blank" class="btn btn-primary mt-3">🚀 Join Meeting</a>` : '';
    
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

function cancelConsultation(id) {
    if (confirm('Apakah Anda yakin ingin membatalkan konsultasi ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/professional/konsultasi') }}/${id}`;
        
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