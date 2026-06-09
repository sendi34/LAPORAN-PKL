@extends('layouts.sbadmin')
@section('title', 'Dashboard Petugas')

@push('head')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Mono&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body, .container-fluid { font-family: 'DM Sans', sans-serif; }
.metric-card {
    border-radius: 16px; padding: 1.25rem 1.5rem; color: white;
    position: relative; overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12); transition: transform .2s;
}
.metric-card:hover { transform: translateY(-3px); }
.metric-card::after {
    content:''; position:absolute; top:-20px; right:-20px;
    width:80px; height:80px; border-radius:50%; background:rgba(255,255,255,0.1);
}
.metric-card .mc-label { font-size:.72rem; font-weight:600; letter-spacing:.06em; text-transform:uppercase; opacity:.8; }
.metric-card .mc-val   { font-size:2rem; font-weight:700; line-height:1.1; }
.metric-card .mc-icon  { font-size:1.6rem; opacity:.3; position:absolute; bottom:12px; right:18px; }
.bg-blue    { background: linear-gradient(135deg,#3b82f6,#1d4ed8); }
.bg-emerald { background: linear-gradient(135deg,#10b981,#047857); }
.bg-amber   { background: linear-gradient(135deg,#f59e0b,#b45309); }
.bg-rose    { background: linear-gradient(135deg,#f43f5e,#be123c); }
.sec-label {
    font-size:.68rem; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; color:#94a3b8; margin:1.75rem 0 .75rem;
}
.obs-table td, .obs-table th { font-size:.82rem; padding:.5rem .75rem; }
.status-pill { display:inline-block; padding:2px 10px; border-radius:99px; font-size:.72rem; font-weight:600; }
.pill-baik   { background:#d1fae5; color:#065f46; }
.pill-ringan { background:#fef3c7; color:#92400e; }
.pill-sedang { background:#ffedd5; color:#9a3412; }
.pill-berat  { background:#fee2e2; color:#991b1b; }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap" style="gap:12px">
    <div>
        <h4 class="mb-0 font-weight-bold" style="color:#1e3a5f">
            <i class="fas fa-user mr-2" style="color:#3b82f6"></i>Dashboard Petugas
        </h4>
        <small class="text-muted">
            Selamat datang, <strong>{{ auth()->user()->nama }}</strong> — Tahun {{ $tahun }}
        </small>
    </div>
    <form method="GET" class="d-flex align-items-center" style="gap:8px">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            </div>
            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" style="width:90px">
        </div>
        <button class="btn btn-primary btn-sm px-3">
            <i class="fas fa-search mr-1"></i> Filter
        </button>
    </form>
</div>

{{-- CARDS RINGKASAN --}}
<div class="sec-label">Ringkasan Aktivitas Saya</div>
<div class="row">
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-blue">
            <div class="mc-label">Total Observasi</div>
            <div class="mc-val">{{ $totalObservasi }}</div>
            <i class="fas fa-clipboard-list mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-emerald">
            <div class="mc-label">Lokasi Dipantau</div>
            <div class="mc-val">{{ $totalLokasi }}</div>
            <i class="fas fa-map-marker-alt mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-amber">
            <div class="mc-label">Total Parameter</div>
            <div class="mc-val">{{ $totalParameter }}</div>
            <i class="fas fa-flask mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-rose">
            <div class="mc-label">Parameter Tercemar</div>
            <div class="mc-val">{{ $totalTercemar }}</div>
            <i class="fas fa-exclamation-triangle mc-icon"></i>
        </div>
    </div>
</div>

{{-- STATUS HASIL UJI --}}
<div class="sec-label">Distribusi Status Hasil Uji — {{ $tahun }}</div>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm" style="border-radius:16px;border:none">
            <div class="card-header font-weight-bold" style="border-radius:16px 16px 0 0;background:#f8fafc;border:none">
                <i class="fas fa-chart-pie mr-1 text-primary"></i> Distribusi Status
            </div>
            <div class="card-body"><div id="chartStatus"></div></div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm" style="border-radius:16px;border:none">
            <div class="card-header font-weight-bold" style="border-radius:16px 16px 0 0;background:#f8fafc;border:none">
                <i class="fas fa-chart-bar mr-1 text-warning"></i> Observasi per Lokasi
            </div>
            <div class="card-body"><div id="chartLokasi"></div></div>
        </div>
    </div>
</div>

{{-- STATUS PER PARAMETER --}}
<div class="sec-label">Status per Parameter</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body"><div id="chartParam"></div></div>
</div>

{{-- PARAMETER PALING SERING TERCEMAR --}}
@if($parameterTercemar->count() > 0)
<div class="sec-label">Parameter Paling Sering Melebihi Baku Mutu</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body p-0">
        <table class="table table-sm obs-table mb-0">
            <thead style="background:#f8fafc">
                <tr>
                    <th>No</th>
                    <th>Parameter</th>
                    <th class="text-center">Jumlah Pelanggaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parameterTercemar as $i => $param)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $param->parameter }}</strong></td>
                    <td class="text-center">
                        <span class="badge badge-danger">{{ $param->jumlah }}x</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- PETA LOKASI --}}
<div class="sec-label">Peta Lokasi Observasi Saya</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none;overflow:hidden">
    <div class="card-body p-0">
        <div id="map" style="height:400px"></div>
    </div>
</div>

{{-- OBSERVASI TERBARU --}}
<div class="sec-label">Observasi Terbaru Saya</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body p-0">
        <table class="table table-sm obs-table mb-0">
            <thead style="background:#f8fafc">
                <tr>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Periode</th>
                    <th>SHU</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($observasiTerbaru as $obs)
                <tr>
                    <td>
                        <strong>{{ $obs->lokasi->nama_lokasi }}</strong><br>
                        <small class="text-muted">{{ $obs->lokasi->alamat_lokasi }}</small>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($obs->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>Periode {{ $obs->periode_pemantauan == 1 ? 'I' : 'II' }}</td>
                    <td>
                        <span class="badge {{ $obs->shu == 'ADA SHU' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $obs->shu }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('petugas.observasi.show', $obs->id) }}"
                           class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada observasi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const COLORS = {
    baik:   '#10b981',
    ringan: '#f59e0b',
    sedang: '#f97316',
    berat:  '#ef4444',
};

// ── DONUT STATUS ──
new ApexCharts(document.querySelector("#chartStatus"), {
    chart: { type:'donut', height:280 },
    series: [{{ $statusMemenuhi }}, {{ $statusRingan }}, {{ $statusSedang }}, {{ $statusBerat }}],
    labels: ['Memenuhi','Tercemar Ringan','Tercemar Sedang','Tercemar Berat'],
    colors: [COLORS.baik, COLORS.ringan, COLORS.sedang, COLORS.berat],
    plotOptions: { pie: { donut: { size:'65%', labels:{ show:true, total:{ show:true, label:'Total', fontSize:'13px' } } } } },
    legend: { position:'bottom', fontSize:'12px' },
    dataLabels: { enabled: true }
}).render();

// ── BAR OBSERVASI PER LOKASI ──
new ApexCharts(document.querySelector("#chartLokasi"), {
    chart: { type:'bar', height:280, toolbar:{ show:false } },
    series: [{ name:'Observasi', data: {!! json_encode($observasiLokasi->pluck('total')) !!} }],
    xaxis:  { categories: {!! json_encode($observasiLokasi->pluck('kode_lokasi')) !!}, labels:{ rotate:-30, style:{ fontSize:'11px' } } },
    colors: ['#3b82f6'],
    plotOptions: { bar:{ borderRadius:5, columnWidth:'55%' } },
    dataLabels: { enabled:true },
    grid: { borderColor:'#f1f5f9' }
}).render();

// ── BAR STACKED PARAMETER ──
new ApexCharts(document.querySelector("#chartParam"), {
    chart: { type:'bar', height:300, stacked:true, toolbar:{ show:false } },
    series: [
        { name:'Memenuhi',        data: {!! json_encode($statusParam->pluck('memenuhi')) !!} },
        { name:'Tercemar Ringan', data: {!! json_encode($statusParam->pluck('ringan')) !!} },
        { name:'Tercemar Sedang', data: {!! json_encode($statusParam->pluck('sedang')) !!} },
        { name:'Tercemar Berat',  data: {!! json_encode($statusParam->pluck('berat')) !!} },
    ],
    xaxis: { categories: {!! json_encode($statusParam->pluck('parameter')) !!}, labels:{ style:{ fontSize:'11px' } } },
    colors: [COLORS.baik, COLORS.ringan, COLORS.sedang, COLORS.berat],
    legend: { position:'bottom', fontSize:'12px' },
    grid: { borderColor:'#f1f5f9' },
    plotOptions: { bar:{ borderRadius:3 } }
}).render();

// ── PETA ──
var map = L.map('map').setView([-3.3, 114.6], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution:'© OpenStreetMap' }).addTo(map);
var lokasiData = @json($lokasiMap);
lokasiData.forEach(function(item) {
    if (!item.latitude || !item.longitude) return;
    L.marker([item.latitude, item.longitude])
        .addTo(map)
        .bindPopup('<b>' + item.nama_lokasi + '</b><br>' + item.alamat_lokasi);
});
</script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
@endif
@endpush