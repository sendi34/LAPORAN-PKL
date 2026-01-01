@extends('layouts.sbadmin')
@section('title','Edit Observasi')
@section('content')

<h1 class="h3 mb-4">Edit Observasi</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.observasi.update',$obs->id) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.observasi.form')
            <button class="btn btn-success mt-3">Update</button>
        </form>
    </div>
</div>

@endsection
