@extends('layouts.admin')
@section('title','Edit Professional')
@section('content')
<h3>Edit Professional</h3>
<form method="POST" action="{{ route('admin.professionals.update',$professional) }}">
@csrf @method('PUT')
@include('admin.professionals._form', ['professional'=>$professional])
<button class="btn btn-success">Update</button>
</form>
@endsection
