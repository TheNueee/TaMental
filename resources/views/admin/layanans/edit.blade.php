@extends('layouts.admin')

@section('title', 'Edit Layanan')

@section('content')
<h3>Edit Layanan</h3>

<form action="{{ route('admin.layanans.update', $layanan) }}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.layanans._form', ['layanan' => $layanan])
    <button type="submit" class="btn btn-success">Perbarui</button>
</form>
@endsection