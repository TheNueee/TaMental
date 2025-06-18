@extends('layouts.app')

@section('title', 'Daftar Profesional')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary">Daftar sebelum membuat janji</h4>
    <div class="row">
        @foreach($professionals as $pro)
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <img src="https://via.placeholder.com/100x100.png?text=Foto" class="rounded-circle mb-3" alt="Foto">
                    <h5 class="card-title">{{ $pro->name }}</h5>
                    <p class="mb-1">{{ $pro->gelar ?? 'Profesional' }}</p>
                    <a href="#" class="d-block mb-3">Selengkapnya</a>

                    @if(auth()->guest() || auth()->user()->isClient())
                        <a href="{{ auth()->guest() ? route('login.form') : route('booking.page', ['professional' => $pro->id]) }}"
                           class="btn btn-warning">
                            Buat Janji
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
