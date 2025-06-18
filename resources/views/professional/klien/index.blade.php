@extends('layouts.app')

@section('title', 'Daftar Klien')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Daftar Klien</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($klien as $k)
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $k->name }}</h5>
                    <p class="card-text mb-1"><strong>Email:</strong> {{ $k->email }}</p>
                    <p class="card-text mb-3"><strong>Telepon:</strong> {{ $k->telepon ?? '-' }}</p>
                    <a href="{{ route('professional.klien.detail', $k->id) }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
