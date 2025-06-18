@extends('layouts.app')

@section('title', 'Ubah Jadwal Konsultasi')

@section('content')
<div class="container">
    <h2>Reschedule Konsultasi</h2>
    <form action="{{ route('client.konsultasi.update', $konsultasi) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Jadwal Lama:</label>
            <strong>{{ $konsultasi->scheduled_at->format('d M Y H:i') }}</strong>
        </div>
        <div class="mb-3">
            <label>Jadwal Baru:</label>
            <input type="datetime-local" name="scheduled_at" class="form-control" required>
            @error('scheduled_at')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
