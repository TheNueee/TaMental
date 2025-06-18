@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')
<h3>Tambah Layanan Baru</h3>

<form action="{{ route('admin.layanans.store') }}" method="POST">
    @csrf
    @include('admin.layanans._form', ['layanan' => null])
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
