@extends('layouts.app')

@section('title', 'Booking Konsultasi')

@section('content')
<div class="container">
    <h2>Booking Konsultasi dengan {{ $professional->name }}</h2>
    <form action="{{ route('booking.store') }}" method="POST">
    @csrf
    <input type="hidden" name="professional_id" value="{{ $professional->id }}">

    <div class="mb-3">
        <label>Pilih Layanan:</label>
        <select name="layanan_id" class="form-control" required>
            @foreach($layanans as $s)
            <option value="{{ $s->id }}">{{ $s->name }} - {{ $s->duration_minutes }} menit - Rp{{ $s->price }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Pilih Tanggal & Waktu:</label>
        <input type="datetime-local" name="scheduled_at" class="form-control" required>
        @error('scheduled_at')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Catatan untuk Profesional (Opsional):</label>
        <textarea name="notes" class="form-control" rows="4" placeholder="Silahkan isi jika anda memiliki catatan tambahan untuk profesional"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Buat Janji</button>
</form>

</div>
@endsection
