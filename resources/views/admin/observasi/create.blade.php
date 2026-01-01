@extends('layouts.sbadmin')
@section('title','Tambah Observasi')
@section('content')

<h1 class="h3 mb-4">Tambah Observasi</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.observasi.store') }}" method="POST">
            @csrf
            @include('admin.observasi.form')
            <button class="btn btn-success mt-3">Simpan</button>
        </form>
    </div>
</div>

@endsection
