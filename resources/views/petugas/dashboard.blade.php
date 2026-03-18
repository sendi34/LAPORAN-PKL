@extends('layouts.sbadmin')
@section('title','Dashboard Petugas')

@section('content')

<h1 class="h3 mb-4">Dashboard Petugas</h1>

{{-- FILTER TAHUN --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" class="form-inline">
            <label class="mr-2">Filter Tahun:</label>
            <input type="number" name="tahun" class="form-control mr-2" value="{{ $tahun }}">
            <button class="btn btn-primary">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>
    </div>
</div>



{{-- GRAFIK OBSERVASI PER LOKASI --}}
<div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
        Jumlah Observasi per Lokasi
    </div>
    <div class="card-body">
        <div id="chartLokasi"></div>
    </div>
</div>


{{-- PETA LOKASI --}}
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        Peta Lokasi Observasi
    </div>
    <div class="card-body">
        <div id="map" style="height:500px;"></div>
    </div>
</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

/* -----------------------------
GRAFIK OBSERVASI LOKASI
----------------------------- */

var lokasiOptions = {
    chart:{ type:'bar', height:350 },
    series:[{
        name:'Observasi',
        data:{!! json_encode($observasiLokasi->pluck('total')) !!}
    }],
    xaxis:{
        categories:{!! json_encode($observasiLokasi->pluck('alamat')) !!}
    }
};

new ApexCharts(document.querySelector("#chartLokasi"), lokasiOptions).render();


</script>


{{-- LEAFLET MAP --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var map = L.map('map').setView([-3.3,114.6],7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'OpenStreetMap'
}).addTo(map);

var lokasi = @json($lokasiMap);

lokasi.forEach(function(item){

    if(item.latitude && item.longitude){

        L.marker([item.latitude,item.longitude])
        .addTo(map)
        .bindPopup(
            "<b>"+item.nama_lokasi+"</b><br>"+item.alamat_lokasi
        );

    }

});

</script>

@endpush