@extends('layouts.sbadmin')
@section('title','Tambah Indikator Uji')

@section('content')

<h1 class="h3 mb-4">Tambah Parameter</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.indikator.store') }}" method="POST">
            @csrf
            @include('admin.indikator.form')
            <button class="btn btn-success mt-3">Simpan</button>
        </form>
    </div>
</div>

@endsection
