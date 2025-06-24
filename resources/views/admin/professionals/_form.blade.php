{{-- Basic User Information --}}
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $professional->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $professional->email ?? '') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Password {{ isset($professional) ? '(kosongkan jika tidak ingin mengubah)' : '' }} 
        @if(!isset($professional)) <span class="text-danger">*</span> @endif
    </label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
           {{ isset($professional) ? '' : 'required' }}>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Professional Information --}}
<hr>
<h5>Informasi Profesional</h5>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Spesialisasi<span class="text-danger">*</span></label>
            <input type="text" name="spesialisasi" class="form-control @error('spesialisasi') is-invalid @enderror" 
                   value="{{ old('spesialisasi', $professional->professional->spesialisasi ?? '') }}" 
                   placeholder="Contoh: Psikolog Klinis, Konselor, dll">
            @error('spesialisasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Pengalaman (Tahun)<span class="text-danger">*</span></label>
            <input type="number" name="pengalaman_tahun" class="form-control @error('pengalaman_tahun') is-invalid @enderror" 
                   value="{{ old('pengalaman_tahun', $professional->professional->pengalaman_tahun ?? '') }}" 
                   min="0" placeholder="0">
            @error('pengalaman_tahun')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Nomor STR (Surat Tanda Registrasi)</label>
    <input type="text" name="str_number" class="form-control @error('str_number') is-invalid @enderror" 
           value="{{ old('str_number', $professional->professional->str_number ?? '') }}" 
           placeholder="Nomor STR profesional">
    @error('str_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Bio/Deskripsi</label>
    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4" 
              placeholder="Deskripsi singkat tentang profesional ini">{{ old('bio', $professional->professional->bio ?? '') }}</textarea>
    @error('bio')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- License Management Section --}}
<hr>
<h5>Lisensi Professional</h5>

{{-- Current Professional's Licenses (Read-only display + hidden inputs) --}}
@if(isset($professional) && $professional->professional && $professional->professional->licenses->count() > 0)
    <div class="mb-4">
        <label class="form-label">Lisensi Saat Ini</label>
        <div class="row">
            @foreach($professional->professional->licenses as $license)
                {{-- Hidden input to preserve existing licenses --}}
                <input type="hidden" name="existing_licenses[]" value="{{ $license->id }}">
                
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="card-title">{{ $license->nama }}</h6>
                                    <small class="text-muted">
                                        <strong>No:</strong> {{ $license->nomor }}<br>
                                        <strong>Berlaku:</strong> {{ $license->tanggal_terbit->format('d/m/Y') }} - {{ $license->tanggal_expired->format('d/m/Y') }}<br>
                                        @if($license->tanggal_expired->isPast())
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($license->tanggal_expired->diffInDays(now()) <= 30)
                                            <span class="badge bg-warning">Akan Expired</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </small>
                                    @if($license->deskripsi)
                                        <small class="text-muted d-block mt-1">{{ Str::limit($license->deskripsi, 100) }}</small>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-license-btn" 
                                        data-license-id="{{ $license->id }}" title="Hapus lisensi ini">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="alert alert-info small">
            <i class="bi bi-info-circle"></i> 
            <strong>Catatan:</strong> Lisensi di atas akan tetap dipertahankan saat update. 
            Klik tombol <i class="bi bi-x text-danger"></i> untuk menghapus lisensi yang tidak diperlukan.
        </div>
    </div>
@else
    <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle"></i> Belum ada lisensi yang terdaftar untuk professional ini.
    </div>
@endif

{{-- Global Licenses Selection (Only for Create, not Update) --}}
@if(!isset($professional) && $licenses->count() > 0)
    <div class="mb-4">
        <label class="form-label">Pilih dari Lisensi yang Tersedia (Opsional)</label>
        <div class="row">
            @foreach($licenses as $license)
                @php
                    $isSelected = old('licenses') ? in_array($license->id, old('licenses', [])) : false;
                @endphp
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card {{ $isSelected ? 'border-success' : 'border-light' }}">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="licenses[]" 
                                       value="{{ $license->id }}" id="license_{{ $license->id }}"
                                       {{ $isSelected ? 'checked' : '' }}>
                                <label class="form-check-label" for="license_{{ $license->id }}">
                                    <strong>{{ $license->nama }}</strong>
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <strong>No:</strong> {{ $license->nomor }}<br>
                                <strong>Berlaku:</strong> {{ $license->tanggal_terbit->format('d/m/Y') }} - {{ $license->tanggal_expired->format('d/m/Y') }}<br>
                                @if($license->tanggal_expired->isPast())
                                    <span class="badge bg-danger">Expired</span>
                                @elseif($license->tanggal_expired->diffInDays(now()) <= 30)
                                    <span class="badge bg-warning">Akan Expired</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </small>
                            @if($license->deskripsi)
                                <small class="text-muted d-block mt-1">{{ Str::limit($license->deskripsi, 100) }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @error('licenses')
            {{-- <div class="text-danger small">{{ $message }}</div> --}}
        @enderror
    </div>
@endif

{{-- Add New License Section --}}
<div class="card border-primary">
    <div class="card-header bg-light">
        <h6 class="mb-0">
            <button class="btn btn-link text-decoration-none p-0" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#newLicenseForm" aria-expanded="false" aria-controls="newLicenseForm">
                <i class="bi bi-plus-circle"></i> Tambah Lisensi Baru
            </button>
        </h6>
    </div>
    <div class="collapse" id="newLicenseForm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lisensi</label>
                        <input type="text" name="new_license_nama" class="form-control @error('new_license_nama') is-invalid @enderror" 
                               value="{{ old('new_license_nama') }}" placeholder="Contoh: Lisensi Psikolog Klinis">
                        @error('new_license_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nomor Lisensi</label>
                        <input type="text" name="new_license_nomor" class="form-control @error('new_license_nomor') is-invalid @enderror" 
                               value="{{ old('new_license_nomor') }}" placeholder="Contoh: PSI-001-2024">
                        @error('new_license_nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Terbit</label>
                        <input type="date" name="new_license_tanggal_terbit" class="form-control @error('new_license_tanggal_terbit') is-invalid @enderror" 
                               value="{{ old('new_license_tanggal_terbit') }}">
                        @error('new_license_tanggal_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Expired</label>
                        <input type="date" name="new_license_tanggal_expired" class="form-control @error('new_license_tanggal_expired') is-invalid @enderror" 
                               value="{{ old('new_license_tanggal_expired') }}">
                        @error('new_license_tanggal_expired')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi Lisensi (Opsional)</label>
                <textarea name="new_license_deskripsi" class="form-control @error('new_license_deskripsi') is-invalid @enderror" 
                          rows="3" placeholder="Deskripsi tentang lisensi ini">{{ old('new_license_deskripsi') }}</textarea>
                @error('new_license_deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="alert alert-info small">
                <i class="bi bi-info-circle"></i> Lisensi baru akan otomatis ditambahkan ke sistem dan diterapkan ke professional ini.
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle checkbox visual feedback (only for create form)
    const checkboxes = document.querySelectorAll('input[name="licenses[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.card');
            if (this.checked) {
                card.classList.remove('border-light');
                card.classList.add('border-success');
            } else {
                card.classList.remove('border-success');
                card.classList.add('border-light');
            }
        });
    });

    // Handle remove license functionality
    const removeBtns = document.querySelectorAll('.remove-license-btn');
    removeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const licenseId = this.dataset.licenseId;
            const card = this.closest('.col-md-6, .col-lg-4');
            const hiddenInput = document.querySelector(`input[name="existing_licenses[]"][value="${licenseId}"]`);
            
            if (confirm('Yakin ingin menghapus lisensi ini dari professional?')) {
                // Remove the card from display
                card.style.transition = 'opacity 0.3s';
                card.style.opacity = '0';
                setTimeout(() => {
                    card.remove();
                }, 300);
                
                // Remove the hidden input so it won't be preserved
                if (hiddenInput) {
                    hiddenInput.remove();
                }
            }
        });
    });
});
</script>