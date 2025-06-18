@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Saya')

@section('content')
<div class="container">
    <h2>Jadwal Konsultasi</h2>
    <table class="table">
        <thead><tr><th>Klien</th><th>Layanan</th><th>Waktu</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($konsultasis as $a)
            <tr>
                <td>{{ $a->client->name }}</td>
                <td>{{ $a->layanan->name }}</td>
                <td>{{ $a->scheduled_at->format('d M Y H:i') }}</td>
                <td>
                    {{ ucfirst($a->status) }}<br>
                    @if($a->status === 'scheduled' && $a->meeting_link)
                    <a href="{{ $a->meeting_link }}" target="_blank">Join Meeting</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
