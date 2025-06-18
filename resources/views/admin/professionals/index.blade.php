@extends('layouts.admin')
@section('title','Daftar Professional')
@section('content')
<h3>Daftar Professional</h3>
<a href="{{ route('admin.professionals.create') }}" class="btn btn-primary mb-3">+ Buat Professional</a>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<table class="table table-bordered">
<thead><tr><th>Name</th><th>Email</th><th>Aksi</th></tr></thead>
<tbody>
@foreach($professionals as $pro)
<tr>
<td>{{ $pro->name }}</td>
<td>{{ $pro->email }}</td>
<td>
<a href="{{ route('admin.professionals.edit',$pro) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('admin.professionals.destroy',$pro) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
@csrf @method('DELETE')
<button class="btn btn-sm btn-danger">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
