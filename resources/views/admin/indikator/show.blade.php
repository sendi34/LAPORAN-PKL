@extends('layouts.sbadmin')
@section('title','Detail Indikator Uji')

@section('content')

<h1 class="h3 mb-4">Detail Parameter Uji</h1>

<div class="card shadow">
    <div class="card-body">

        <table class="table table-bordered">
            <tr><th>Kode</th><td>{{ $i->kode_indikator }}</td></tr>
            <tr><th>Nama Parameter</th><td>{{ $i->nama_indikator }}</td></tr>
            <tr><th>Satuan</th><td>{{ $i->satuan }}</td></tr>
            <tr><th>Baku Mutu</th><td>{{ $i->baku_mutu }}</td></tr>
        </table>

    </div>
</div>

@endsection
