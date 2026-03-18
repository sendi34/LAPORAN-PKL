@extends('layouts.sbadmin')
@section('title','Detail Lokasi')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<h1 class="h3 mb-4">Detail Lokasi</h1>

<div class="card shadow">
    <div class="card-body">

        <table class="table table-bordered">
            <tr><th width="200">Kode</th><td>{{ $lokasi->kode_lokasi }}</td></tr>
            <tr><th>Nama Lokasi</th><td>{{ $lokasi->nama_lokasi }}</td></tr>
            <tr><th>Alamat</th><td>{{ $lokasi->alamat_lokasi }}</td></tr>
            <tr><th>Provinsi</th><td>{{ $lokasi->provinsi }}</td></tr>
            <tr><th>Latitude</th><td>{{ $lokasi->latitude }}</td></tr>
            <tr><th>Longtitude</th><td>{{ $lokasi->longtitude }}</td></tr>
            <tr><th>Peruntukan</th><td>{{ $lokasi->peruntukan }}</td></tr>
        </table>

        <div class="mt-4">
            <h5>Lokasi pada Peta</h5>
            <div id="map" style="height:400px;"></div>
        </div>

    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var latitude = {{ $lokasi->latitude ?? 0 }};
var longitude = {{ $lokasi->longtitude ?? 0 }};

var map = L.map('map').setView([latitude, longitude], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'© OpenStreetMap'
}).addTo(map);

var marker = L.marker([latitude, longitude]).addTo(map);

marker.bindPopup(
    "<b>{{ $lokasi->nama_lokasi }}</b><br>{{ $lokasi->peruntukan }}"
).openPopup();

</script>

@endsection