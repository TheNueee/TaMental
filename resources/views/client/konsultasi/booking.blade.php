@extends('layouts.app')
@section('title', 'Booking Konsultasi')
@section('content')
<div class="booking-container">
    <div class="booking-header">
        <h1 class="booking-title">Buat Janji Konsultasi</h1>
        <p class="booking-subtitle">Pilih layanan dan waktu yang sesuai untuk konsultasi Anda</p>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-error">
            <div class="alert-content">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="booking-content">
        <div class="booking-form-card">
            <!-- Professional Info -->
            <div class="professional-info">
                {{-- <img src="{{ $professional->profile_picture ? asset('storage/' . $professional->profile_picture) : asset('images/default-avatar.png') }}" 
                     alt="{{ $professional->name }}" 
                     class="professional-avatar"> --}}
                <div class="professional-details">
                    <h3>{{ $professional->name }}</h3>
                    <p>{{ $professional->specialization ?? 'Psikolog Klinis' }}</p>
                </div>
            </div>

            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="professional_id" value="{{ $professional->id }}">
                <input type="hidden" name="selected_service" id="selectedService">
                <input type="hidden" name="selected_price" id="selectedPrice">
                
                <!-- Service Selection -->
                <div class="form-section">
                    <label class="form-label">Pilih Layanan Konsultasi</label>
                    <div class="services-list">
                        @foreach($layanans as $layanan)
                        <div class="service-option" data-service-id="{{ $layanan->id }}" data-price="{{ $layanan->price }}">
                            <input type="radio" name="layanan_id" value="{{ $layanan->id }}" id="service_{{ $layanan->id }}" required>
                            <div class="service-info">
                                <h4>{{ $layanan->name }}</h4>
                                <p>{{ $layanan->duration_minutes }} menit</p>
                            </div>
                            <div class="service-price">Rp {{ number_format($layanan->price, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>
                    @error('layanan_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date & Time Selection -->
                <div class="form-section">
                    <label class="form-label">Pilih Tanggal & Waktu</label>
                    <div class="datetime-section">
                        <div>
                            <input type="date" name="booking_date" class="form-input" id="bookingDate" required min="{{ date('Y-m-d') }}">
                            @error('booking_date')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <select name="booking_time" class="form-select" id="bookingTime" required>
                                <option value="">Pilih Waktu</option>
                                <!-- Time slots will be populated by JavaScript -->
                            </select>
                            @error('booking_time')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="time-info">
                        <small><i class="fas fa-info-circle"></i> Booking hanya dapat dilakukan minimal 6 jam sebelum waktu konsultasi</small>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="form-section">
                    <label class="form-label">Ceritakan singkat latar belakang dan kesibukan anda serta kondisi fisik dan psikis yang anda rasakan</label>
                    <textarea name="notes" class="form-textarea" placeholder="Silahkan isi sebagai catatan tambahan untuk profesional"></textarea>
                </div>
            </form>
        </div>

        <!-- Booking Summary -->
        <div class="booking-summary">
            <h3 class="summary-title">Ringkasan Pemesanan</h3>
            
            <div class="summary-item">
                <span class="summary-label">Profesional:</span>
                <span class="summary-value">{{ $professional->name }}</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Layanan:</span>
                <span class="summary-value" id="summaryService">-</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Durasi:</span>
                <span class="summary-value" id="summaryDuration">-</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Tanggal:</span>
                <span class="summary-value" id="summaryDate">-</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Waktu:</span>
                <span class="summary-value" id="summaryTime">-</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Total Biaya:</span>
                <span class="summary-value summary-total" id="summaryTotal">Rp 0</span>
            </div>

            <button type="submit" form="bookingForm" class="btn-book" id="bookButton" disabled>
                <i class="fas fa-calendar-check"></i>
                Buat Janji
            </button>
        </div>
    </div>
</div>

<style>
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 500;
}

.alert-error {
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.alert-success {
    background-color: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #16a34a;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 8px;
}

.time-info {
    margin-top: 8px;
    color: #6b7280;
}

.time-info i {
    margin-right: 4px;
}

.disabled {
    opacity: 0.5;
    pointer-events: none;
    background-color: #f3f4f6 !important;
    color: #9ca3af !important;
}

.service-option.disabled {
    opacity: 0.5;
    pointer-events: none;
    background-color: #f9fafb;
}

.form-select option:disabled {
    color: #9ca3af;
    background-color: #f9fafb;
}

.loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #f3f4f6;
    border-top: 2px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceOptions = document.querySelectorAll('.service-option');
    const bookingDate = document.getElementById('bookingDate');
    const bookingTime = document.getElementById('bookingTime');
    const bookButton = document.getElementById('bookButton');
    
    // Summary elements
    const summaryService = document.getElementById('summaryService');
    const summaryDuration = document.getElementById('summaryDuration');
    const summaryDate = document.getElementById('summaryDate');
    const summaryTime = document.getElementById('summaryTime');
    const summaryTotal = document.getElementById('summaryTotal');
    
    let selectedServiceData = null;
    let existingBookings = [];

    // Service selection
    serviceOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove previous selection
            serviceOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selection to clicked option
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Store service data
            selectedServiceData = {
                id: this.dataset.serviceId,
                name: this.querySelector('h4').textContent,
                duration: this.querySelector('p').textContent,
                price: parseInt(this.dataset.price)
            };
            
            // Update summary
            summaryService.textContent = selectedServiceData.name;
            summaryDuration.textContent = selectedServiceData.duration;
            summaryTotal.textContent = 'Rp ' + selectedServiceData.price.toLocaleString('id-ID');
            
            // Set hidden fields
            document.getElementById('selectedService').value = selectedServiceData.name;
            document.getElementById('selectedPrice').value = selectedServiceData.price;
            
            checkFormCompletion();
        });
    });

    // Date selection
    bookingDate.addEventListener('change', function() {
        const selectedDate = this.value;
        summaryDate.textContent = formatDate(selectedDate);
        
        // Reset time selection
        bookingTime.value = '';
        summaryTime.textContent = '-';
        
        // Load available time slots
        loadAvailableTimeSlots(selectedDate);
        checkFormCompletion();
    });

    // Time selection
    bookingTime.addEventListener('change', function() {
        summaryTime.textContent = this.value || '-';
        checkFormCompletion();
    });

    // Load available time slots with validation
    function loadAvailableTimeSlots(selectedDate) {
        if (!selectedDate) return;

        // Show loading
        bookingTime.innerHTML = '<option value="">Loading...</option>';
        bookingTime.disabled = true;

        // Fetch existing bookings for the date
        fetch(`/api/bookings/available-slots?professional_id={{ $professional->id }}&date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                populateTimeSlots(selectedDate, data.bookedSlots || []);
                bookingTime.disabled = false;
            })
            .catch(error => {
                console.error('Error loading time slots:', error);
                populateTimeSlots(selectedDate, []);
                bookingTime.disabled = false;
            });
    }

    // Generate time slots with validation
    function populateTimeSlots(selectedDate, bookedSlots = []) {
        bookingTime.innerHTML = '<option value="">Pilih Waktu</option>';
        
        const startHour = 9;
        const endHour = 17;
        const currentDate = new Date();
        const selectedDateTime = new Date(selectedDate);
        const isToday = selectedDateTime.toDateString() === currentDate.toDateString();
        
        for (let hour = startHour; hour < endHour; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                const timeString = String(hour).padStart(2, '0') + ':' + String(minute).padStart(2, '0');
                
                // Create datetime for this slot
                const slotDateTime = new Date(selectedDate + ' ' + timeString);
                
                // Check if slot is valid
                const isSlotValid = isSlotAvailable(slotDateTime, bookedSlots, isToday);
                
                const option = document.createElement('option');
                option.value = timeString;
                option.textContent = timeString;
                
                if (!isSlotValid.available) {
                    option.disabled = true;
                    option.textContent += ` (${isSlotValid.reason})`;
                    option.style.color = '#9ca3af';
                }
                
                bookingTime.appendChild(option);
            }
        }
    }

    // Check if time slot is available
    function isSlotAvailable(slotDateTime, bookedSlots, isToday) {
        const currentTime = new Date();
        const minimumBookingTime = new Date(currentTime.getTime() + (6 * 60 * 60 * 1000)); // 6 hours from now
        
        // Check if slot is in the past or less than 6 hours from now
        if (slotDateTime <= minimumBookingTime) {
            return {
                available: false,
                reason: isToday ? 'Mohon Pilih Waktu Lain' : 'Sudah lewat'
            };
        }
        
        // Check if slot is already booked
        const timeString = slotDateTime.toTimeString().slice(0, 5);
        if (bookedSlots.includes(timeString)) {
            return {
                available: false,
                reason: 'Sudah dipesan'
            };
        }
        
        return { available: true };
    }

    // Format date for display
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Check form completion
    function checkFormCompletion() {
        const serviceSelected = document.querySelector('input[name="layanan_id"]:checked');
        const dateSelected = bookingDate.value;
        const timeSelected = bookingTime.value;
        
        if (serviceSelected && dateSelected && timeSelected) {
            bookButton.disabled = false;
            bookButton.style.opacity = '1';
        } else {
            bookButton.disabled = true;
            bookButton.style.opacity = '0.6';
        }
    }

    // Form submission with validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!selectedServiceData || !bookingDate.value || !bookingTime.value) {
            showAlert('Mohon lengkapi semua field yang diperlukan', 'error');
            return;
        }
        
        // Validate time slot again before submission
        const selectedDateTime = new Date(bookingDate.value + ' ' + bookingTime.value);
        const currentTime = new Date();
        const minimumBookingTime = new Date(currentTime.getTime() + (6 * 60 * 60 * 1000));
        
        if (selectedDateTime <= minimumBookingTime) {
            showAlert('Waktu booking harus minimal 6 jam dari sekarang', 'error');
            return;
        }
        
        // Disable submit button to prevent double submission
        bookButton.disabled = true;
        bookButton.innerHTML = '<span class="loading-spinner"></span> Memproses...';
        
        // Combine date and time for scheduled_at
        const scheduledAt = bookingDate.value + ' ' + bookingTime.value + ':00';
        
        // Create hidden input for scheduled_at
        const scheduledInput = document.createElement('input');
        scheduledInput.type = 'hidden';
        scheduledInput.name = 'scheduled_at';
        scheduledInput.value = scheduledAt;
        this.appendChild(scheduledInput);
        
        // Submit the form
        this.submit();
    });

    // Show alert function
    function showAlert(message, type = 'error') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <div class="alert-content">
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Insert alert at the top of booking container
        const bookingContainer = document.querySelector('.booking-container');
        bookingContainer.insertBefore(alert, bookingContainer.children[1]);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    bookingDate.setAttribute('min', today);

    // Initialize time slots if date is already selected
    if (bookingDate.value) {
        loadAvailableTimeSlots(bookingDate.value);
    }
});
</script>
@endsection