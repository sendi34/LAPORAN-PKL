@extends('layouts.sbadmin')
@section('title','Detail Lokasi')
@section('content')

<h1 class="h3 mb-4">Detail Lokasi</h1>

<div class="card shadow">
    <div class="card-body">

        <table class="table table-bordered">
            <tr><th>Kode</th><td>{{ $lokasi->kode_lokasi }}</td></tr>
            <tr><th>Nama Lokasi</th><td>{{ $lokasi->nama_lokasi }}</td></tr>
            <tr><th>Alamat</th><td>{{ $lokasi->alamat_lokasi }}</td></tr>
            <tr><th>Provinsi</th><td>{{ $lokasi->provinsi }}</td></tr>
            <tr><th>Latitude</th><td>{{ $lokasi->latitude }}</td></tr>
            <tr><th>Longtitude</th><td>{{ $lokasi->longtitude }}</td></tr>
            <tr><th>Peruntukan</th><td>{{ $lokasi->peruntukan }}</td></tr>
        </table>


    </div>
</div>

@endsection
