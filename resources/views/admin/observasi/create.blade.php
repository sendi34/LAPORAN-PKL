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
            <a href="{{ route('admin.observasi.index') }}" class="btn btn-secondary mt-3">
                Batal
            </a>
        </form>
    </div>
</div>

@endsection
