@extends('layouts.sbadmin')
@section('title','Detail User')

@section('content')

<h1 class="h3 mb-4">Detail User</h1>

<div class="card shadow">
    <div class="card-body">

        <table class="table table-bordered">
            <tr><th>Nama</th><td>{{ $user->nama }}</td></tr>
            <tr><th>Email</th><td>{{ $user->email }}</td></tr>
            <tr><th>Role</th><td>{{ ucfirst($user->role) }}</td></tr>
            <tr><th>Dibuat</th><td>{{ $user->created_at }}</td></tr>
        </table>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>

    </div>
</div>

@endsection
