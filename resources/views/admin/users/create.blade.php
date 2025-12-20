@extends('layouts.sbadmin')
@section('title','Tambah User')

@section('content')

<h1 class="h3 mb-4">Tambah User</h1>
<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @include('admin.users.form')
            <button class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">
                Batal
            </a>
        </form>
    </div>
</div>


@endsection
