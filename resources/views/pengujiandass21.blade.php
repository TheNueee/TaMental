@extends('layouts.app')

@section('title', 'Pengujian DASS-21')

@section('content')
<h1>@yield('title')</h1>

<p>Silakan isi kuesioner di bawah ini sesuai dengan apa yang Anda rasakan selama seminggu terakhir.</p>

<form method="POST" action="{{ route('pengujiandass21') }}">
    @csrf
    @foreach ($pertanyaan as $index => $teks)
        <div class="form-group mb-4">
            <label class="fw-bold">{{ $index + 1 }}. {{ $teks }}</label><br>
            @foreach ([0 => 'Tidak pernah sama sekali', 1 => 'Kadang-kadang', 2 => 'Sering', 3 => 'Sangat sering'] as $value => $label)
                <div class="form-check">
                    <input type="radio" name="jawaban[{{ $index }}]" value="{{ $value }}" class="form-check-input">
                    <label class="form-check-label">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg">Lihat Hasil</button>
    </div>
</form>
@endsection
