@extends('layouts.sbadmin')
@section('title','Tambah Hasil Uji')
@section('content')
<h1 class="h3 mb-4">Tambah Hasil Uji</h1>
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.hasiluji.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.hasiluji.form')
            <button type="submit" class="btn btn-success mt-3">
                <i ></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection