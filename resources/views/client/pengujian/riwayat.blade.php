@extends('layouts.app')

@section('title', 'Riwayat Pengujian Saya')

@section('content')
<h1>@yield('title')</h1>

<p>
    <a href="{{ route('disclaimer') }}" class="btn btn-success">Lakukan Pengujian Baru</a>
</p>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal Pengujian</th>
            <th>Kategori Depresi</th>
            <th>Kategori Kecemasan</th>
            <th>Kategori Stres</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengujian as $index => $pengujian)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pengujian->created_at->format('d M Y, H:i') }}</td>
            <td>{{ $pengujian->kategori_depresi }}</td>
            <td>{{ $pengujian->kategori_kecemasan }}</td>
            <td>{{ $pengujian->kategori_stres }}</td>
            <td>
                <a href="{{ route('client.pengujian.lihat', $pengujian->id) }}" title="Lihat Detail">🔍</a>
                <form action="{{ route('client.pengujian.hapus', $pengujian->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" style="border:none; background:none;" title="Hapus">🗑️</button>
</form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
