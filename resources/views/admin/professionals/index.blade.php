@extends('layouts.admin')
@section('title','Daftar Professional')
@section('content')
    <h3>Daftar Professional</h3>
    <a href="{{ route('admin.professionals.create') }}" class="btn btn-primary mb-3">+ Buat Professional</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Spesialisasi</th>
                    <th>Pengalaman</th>
                    <th>STR Number</th>
                    <th>Lisensi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($professionals as $pro)
                    <tr>
                        <td>{{ $pro->name }}</td>
                        <td>{{ $pro->email }}</td>
                        <td>{{ $pro->professional->spesialisasi ?? '-' }}</td>
                        <td>{{ $pro->professional ? $pro->professional->pengalaman_tahun . ' tahun' : '-' }}</td>
                        <td>{{ $pro->professional->str_number ?? '-' }}</td>
                        <td>
                            @if($pro->professional && $pro->professional->licenses->count() > 0)
                                @foreach($pro->professional->licenses as $license)
                                    <span class="badge bg-info me-1">{{ $license->nama }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.professionals.edit', $pro) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.professionals.destroy', $pro) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus? Semua data professional dan lisensi akan dihapus.')">
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
@endsection