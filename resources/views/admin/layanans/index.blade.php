@extends('layouts.admin')

@section('title', 'Daftar Layanan')

@section('content')
<h3 class="mb-4">Daftar Layanan</h3>

<a href="{{ route('admin.layanans.create') }}" class="btn btn-primary mb-3">+ Tambah Layanan</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@forelse($groupedlayanans as $professionalName => $layanans)
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white fw-bold">
            {{ $professionalName }}
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Durasi (menit)</th>
                        <th>Harga</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($layanans as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->duration_minutes }}</td>
                            <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.layanans.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.layanans.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <p class="text-muted">Belum ada layanan yang ditambahkan.</p>
@endforelse
@endsection
