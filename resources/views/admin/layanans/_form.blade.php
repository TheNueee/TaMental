<div class="mb-3">
    <label for="name" class="form-label">Nama Layanan</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name', $layanan->name ?? '') }}">
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" required>{{ old('description', $layanan->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="duration_minutes" class="form-label">Durasi (menit)</label>
    <input type="number" name="duration_minutes" class="form-control" required value="{{ old('duration_minutes', $layanan->duration_minutes ?? '') }}">
</div>

<div class="mb-3">
    <label for="price" class="form-label">Harga (Rp)</label>
    <input type="number" name="price" class="form-control" required value="{{ old('price', $layanan->price ?? '') }}">
</div>

<div class="mb-3">
    <label for="professional_id" class="form-label">Professional</label>
    <select name="professional_id" class="form-control" required>
        <option value="">-- Pilih Professional --</option>
        @foreach($professionals as $pro)
            <option value="{{ $pro->id }}" {{ (old('professional_id', $layanan->professional_id ?? '') == $pro->id) ? 'selected' : '' }}>
                {{ $pro->name }} ({{ $pro->email }})
            </option>
        @endforeach
    </select>
</div>
