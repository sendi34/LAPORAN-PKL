@extends('layouts.sbadmin')
@section('title','Edit Observasi')

@section('content')

<h1 class="h3 mb-4">Edit Observasi</h1>

<div class="card shadow">
    <div class="card-body">

        <form action="{{ route('petugas.observasi.update', $obs->id) }}" method="POST">
            @csrf @method('PUT')

            @include('petugas.observasi.form')

            <button class="btn btn-warning"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('petugas.observasi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>

@endsection
