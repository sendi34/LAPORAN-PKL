@extends('layouts.sbadmin')
@section('title','Tambah Observasi')

@section('content')

<h1 class="h3 mb-4">Tambah Observasi</h1>

<div class="card shadow">
    <div class="card-body">

        <form action="{{ route('petugas.observasi.store') }}" method="POST">
            @csrf

            @include('petugas.observasi.form')

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('petugas.observasi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>

@endsection
