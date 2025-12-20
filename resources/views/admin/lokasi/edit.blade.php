@extends('layouts.sbadmin')
@section('title','Edit Lokasi')
@section('content')

<h1 class="h3 mb-4">Edit Lokasi</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.lokasi.update',$lokasi->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.lokasi.form')
            <button class="btn btn-success mt-3">Update</button>
            <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary mt-3">
                Batal
            </a>
        </form>
    </div>
</div>

@endsection
