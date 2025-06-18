@extends('layouts.app')

@section('title', 'Janji Konsultasi Saya')

@section('content')



<div class="container">
    <h2>Riwayat Janji Konsultasi</h2>

    <p>
        <a href="{{ route('daftarprofesional') }}" class="btn btn-success">Lakukan Konsultasi Baru</a>
    </p>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <table class="table">
        <thead><tr><th>Layanan</th><th>Dengan</th><th>Waktu</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($konsultasis as $a)
            <tr>
                <td>{{ $a->layanan->name }}</td>
                <td>{{ $a->professional->name }}</td>
                <td>{{ $a->scheduled_at->format('d M Y H:i') }}</td>
                <td>
                    {{ ucfirst($a->status) }}<br>
                    @if($a->status === 'scheduled')
                    <a href="{{ $a->meeting_link }}" target="_blank">Join</a><br>
                    <a href="{{ route('client.konsultasi.edit', $a) }}" class="btn btn-sm btn-warning mt-1">Reschedule</a>
                    <form action="{{ route('client.konsultasi.destroy', $a) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Yakin batalkan?')">Batalkan</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
