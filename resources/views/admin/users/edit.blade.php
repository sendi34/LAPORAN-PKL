@extends('layouts.sbadmin')
@section('title','Edit User')

@section('content')

    <h1 class="h3 mb-4">Edit Pengguna</h1>
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                @include('admin.users.form')
                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>
    </div>

@endsection