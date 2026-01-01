@extends('layouts.sbadmin')
@section('title','Edit Indikator Uji')

@section('content')

<h1 class="h3 mb-4">Edit Indikator Uji</h1>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.indikator.update',$i->id) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.indikator.form')
            <button class="btn btn-success mt-3">Update</button>
        </form>
    </div>
</div>

@endsection
