@extends('layouts.sbadmin')
@section('title','Dashboard Admin')

@section('content')
<h1 class="h3 mb-4">Dashboard Admin</h1>

{{-- CARD --}}
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-primary p-3">
            <h6>Total Lokasi</h6>
            <h3>{{ $totalLokasi }}</h3>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-success p-3">
            <h6>Total Petugas</h6>
            <h3>{{ $totalPetugas }}</h3>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-warning p-3">
            <h6>Total Parameter</h6>
            <h3>{{ $totalIndikator }}</h3>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-left-danger p-3">
            <h6>Total Observasi</h6>
            <h3>{{ $totalObservasi }}</h3>
        </div>
    </div>
</div>


{{-- FILTER TAHUN --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" class="form-inline">
            <label class="mr-2">Filter Tahun:</label>

            <input type="number"
                   name="tahun"
                   class="form-control mr-2"
                   value="{{ $tahun }}"
                   placeholder="Tahun"
                   style="width:150px;">

            <button class="btn btn-primary">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>
    </div>
</div>

{{-- GRAFIK 2 --}}
<div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
        <i class="fas fa-map-marker-alt"></i>
        Jumlah Observasi per Lokasi (Tahun {{ $tahun }})
    </div>

    <div class="card-body">
        <div id="chartLokasi"></div>
    </div>
</div>


{{-- PETA SEBARAN LOKASI --}}
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        <i class="fas fa-map"></i>
        Peta Sebaran Lokasi Pemantauan
    </div>

    <div class="card-body">
        <div id="map" style="height:500px;"></div>
    </div>
</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

/* ===============================
   GRAFIK 2
================================ */

var lokasiOptions = {

    chart:{ type:'bar', height:350 },

    series:[{
        name:'Jumlah Observasi',
        data:{!! json_encode($obsPerLokasi->pluck('jumlah')) !!}
    }],

    xaxis:{
        categories:{!! json_encode($obsPerLokasi->pluck('nama_lokasi')) !!}
    },

    dataLabels:{ enabled:true },

    colors:['#FF8C00']

};

new ApexCharts(document.querySelector("#chartLokasi"), lokasiOptions).render();



/* ===============================
   PETA LOKASI
================================ */

var map = L.map('map').setView([-3.3,114.6],7);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'OpenStreetMap'
}
).addTo(map);


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