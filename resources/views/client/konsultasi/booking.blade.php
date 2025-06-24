@extends('layouts.app')
@section('title', 'Booking Konsultasi')
@section('content')
<div class="booking-container">
    <div class="booking-header">
        <h1 class="booking-title">Buat Janji Konsultasi</h1>
        <p class="booking-subtitle">Pilih layanan dan waktu yang sesuai untuk konsultasi Anda</p>
    </div>

    <div class="booking-content">
        <div class="booking-form-card">
            <!-- Professional Info -->
            <div class="professional-info">
                <img src="{{ $professional->profile_picture ? asset('storage/' . $professional->profile_picture) : asset('images/default-avatar.png') }}" 
                     alt="{{ $professional->name }}" 
                     class="professional-avatar">
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
                </div>

                <!-- Notes Section -->
                <div class="form-section">
                    <label class="form-label">Ceritakan kesibukan dan kondisi yang anda rasakan</label>
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
        populateTimeSlots();
        checkFormCompletion();
    });

    // Time selection
    bookingTime.addEventListener('change', function() {
        summaryTime.textContent = this.value || '-';
        checkFormCompletion();
    });

    // Generate time slots
    function populateTimeSlots() {
        bookingTime.innerHTML = '<option value="">Pilih Waktu</option>';
        
        // Generate time slots from 9 AM to 5 PM
        const startHour = 9;
        const endHour = 17;
        
        for (let hour = startHour; hour < endHour; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                const timeString = String(hour).padStart(2, '0') + ':' + String(minute).padStart(2, '0');
                const option = document.createElement('option');
                option.value = timeString;
                option.textContent = timeString;
                bookingTime.appendChild(option);
            }
        }
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

    // Form submission
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!selectedServiceData || !bookingDate.value || !bookingTime.value) {
            alert('Mohon lengkapi semua field yang diperlukan');
            return;
        }
        
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

    // Initialize time slots
    if (bookingDate.value) {
        populateTimeSlots();
    }
});
</script>
@endsection