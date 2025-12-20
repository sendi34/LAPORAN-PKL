@extends('layouts.sbadmin')
@section('title','Edit User')

@section('content')

<h1 class="h3 mb-4">Edit User</h1>
<div class="card shadow">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.users.update',$user->id) }}">
            @csrf @method('PUT')
            @include('admin.users.form')
            <button class="btn btn-success mt-3">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">
                Batal
            </a>
        </form>

    </div>
</div>

@endsection
