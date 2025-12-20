@extends('layouts.sbadmin')
@section('title','Tambah Hasil Uji')

@section('content')

<h1 class="h3 mb-4">Tambah Hasil Uji</h1>

<div class="card shadow">
    <div class="card-body">

        <form action="{{ route('petugas.hasiluji.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('petugas.hasiluji.form')

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <a href="{{ route('petugas.hasiluji.index') }}" class="btn btn-secondary">
               Kembali
            </a>
        </form>

    </div>
</div>

@endsection