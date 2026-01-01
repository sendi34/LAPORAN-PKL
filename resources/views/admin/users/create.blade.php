@extends('layouts.sbadmin')
@section('title', 'Tambah User')

@section('content')

    <h1 class="h3 mb-4">Tambah Pengguna</h1>
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                @include('admin.users.form')
                <button class="btn btn-success mt-3">Simpan</button>
            </form>
        </div>
    </div>


@endsection
