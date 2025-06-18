@extends('layouts.admin')
@section('title','Tambah Professional')
@section('content')
<h3>Buat Professional</h3>
<form method="POST" action="{{ route('admin.professionals.store') }}">
@csrf
@include('admin.professionals._form', ['professional'=>null])
<button class="btn btn-primary">Simpan</button>
</form>
@endsection
