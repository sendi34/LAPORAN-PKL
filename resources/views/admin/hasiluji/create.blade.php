@extends('layouts.sbadmin')
@section('title','Tambah Hasil Uji')
@section('content')
<h1 class="h3 mb-4">Tambah Hasil Uji</h1>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-1"></i>
    {!! session('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.hasiluji.store') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf
            @include('admin.hasiluji.form')
            <button type="submit" class="btn btn-success mt-3">
                <i></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection