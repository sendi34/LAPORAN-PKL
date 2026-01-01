@extends('layouts.sbadmin')
@section('title','Tambah Lokasi')
@section('content')

<h1 class="h3 mb-4">Tambah Lokasi</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.lokasi.store') }}" method="POST">
            @csrf
            @include('admin.lokasi.form')
            <button class="btn btn-success mt-3">Simpan</button>
        </form>
    </div>
</div>

@endsection
