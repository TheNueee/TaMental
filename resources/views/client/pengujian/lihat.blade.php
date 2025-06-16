@extends('layouts.app')

@section('title', 'Detail Pengujian')

@section('content')
<h1>@yield('title')</h1>

<p><strong>Tanggal Pengujian:</strong> {{ $pengujian->created_at->format('d M Y, H:i') }}</p>
<p><strong>Hasil Depresi:</strong> {{ $kategoriDepresi }} ({{ $pengujian->skor_depresi }})</p>
<p><strong>Hasil Kecemasan:</strong> {{ $kategoriKecemasan }} ({{ $pengujian->skor_kecemasan }})</p>
<p><strong>Hasil Stres:</strong> {{ $kategoriStres }} ({{ $pengujian->skor_stres }})</p>

<p>
    <form action="{{ route('client.pengujian.hapus', $pengujian->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" style="border:none; background:none;" title="Hapus">🗑️</button>
</form>

</p>
@endsection
