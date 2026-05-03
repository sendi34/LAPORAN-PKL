@extends('layouts.sbadmin')
@section('title', 'Dashboard Admin')

@push('head')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Mono&display=swap" rel="stylesheet">
<style>
:root {
    --c-baik:   #10b981;
    --c-ringan: #f59e0b;
    --c-sedang: #f97316;
    --c-berat:  #ef4444;
    --c-gray:   #94a3b8;
}
body, .container-fluid { font-family: 'DM Sans', sans-serif; }

/* ── METRIC CARDS ── */
.metric-card {
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    transition: transform .2s;
}
.metric-card:hover { transform: translateY(-3px); }
.metric-card::after {
    content:'';
    position:absolute;
    top:-20px; right:-20px;
    width:80px; height:80px;
    border-radius:50%;
    background:rgba(255,255,255,0.1);
}
.metric-card .mc-label { font-size:.72rem; font-weight:600; letter-spacing:.06em; text-transform:uppercase; opacity:.8; }
.metric-card .mc-val   { font-size:2rem; font-weight:700; line-height:1.1; }
.metric-card .mc-icon  { font-size:1.6rem; opacity:.3; position:absolute; bottom:12px; right:18px; }
.bg-blue    { background: linear-gradient(135deg,#3b82f6,#1d4ed8); }
.bg-emerald { background: linear-gradient(135deg,#10b981,#047857); }
.bg-amber   { background: linear-gradient(135deg,#f59e0b,#b45309); }
.bg-rose    { background: linear-gradient(135deg,#f43f5e,#be123c); }
.bg-violet  { background: linear-gradient(135deg,#8b5cf6,#6d28d9); }
.bg-cyan    { background: linear-gradient(135deg,#06b6d4,#0e7490); }
.bg-orange  { background: linear-gradient(135deg,#f97316,#c2410c); }
.bg-slate   { background: linear-gradient(135deg,#64748b,#334155); }

/* ── SECTION LABEL ── */
.sec-label {
    font-size:.68rem; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; color:#94a3b8; margin:1.75rem 0 .75rem;
}

/* ── METHOD COMPARISON CARD ── */
.method-compare {
    display:grid; grid-template-columns:1fr 1fr; gap:0;
    border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.08);
}
.method-pane { padding:1.25rem 1.5rem; }
.method-pane.storet { background:#f0f9ff; border-right:2px solid #e2e8f0; }
.method-pane.ip     { background:#fdf4ff; }
.method-pane h6     { font-size:.75rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; margin-bottom:.5rem; }
.method-pane.storet h6 { color:#0369a1; }
.method-pane.ip     h6 { color:#7c3aed; }
.status-pill {
    display:inline-block; padding:2px 10px; border-radius:99px;
    font-size:.72rem; font-weight:600;
}
.pill-baik   { background:#d1fae5; color:#065f46; }
.pill-ringan { background:#fef3c7; color:#92400e; }
.pill-sedang { background:#ffedd5; color:#9a3412; }
.pill-berat  { background:#fee2e2; color:#991b1b; }
.pill-nodata { background:#f1f5f9; color:#64748b; }

/* ── AGREEMENT BADGE ── */
.agree-badge   { font-size:.65rem; font-weight:700; padding:1px 8px; border-radius:99px; }
.agree-yes { background:#d1fae5; color:#065f46; }
.agree-no  { background:#fee2e2; color:#991b1b; }

/* ── INSIGHT BOX ── */
.insight-box {
    background:linear-gradient(135deg,#1e3a5f,#0f2340);
    color:white; border-radius:16px; padding:1.5rem;
    display:flex; align-items:flex-start; gap:1rem;
}
.insight-box .ins-icon { font-size:2rem; flex-shrink:0; }
.insight-box h6 { font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; opacity:.7; margin:0; }
.insight-box p  { margin:4px 0 0; font-size:.95rem; line-height:1.4; }

/* ── TABEL TERBARU ── */
.obs-table td, .obs-table th { font-size:.82rem; padding:.5rem .75rem; }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap" style="gap:12px">
    <div>
        <h4 class="mb-0 font-weight-bold" style="color:#1e3a5f">
            <i class="fas fa-water mr-2" style="color:#3b82f6"></i>Dashboard Kualitas Air Laut
        </h4>
        <small class="text-muted">
            Pemantauan Provinsi Kalimantan Selatan — Tahun {{ $tahun }}
            @if($periode) | Periode {{ $periode == 1 ? 'I' : 'II' }} @endif
        </small>
    </div>
    <form method="GET" class="d-flex align-items-center" style="gap:8px">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            </div>
            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" style="width:90px">
        </div>
        <select name="periode" class="form-control form-control-sm" style="width:130px">
            <option value="">Semua Periode</option>
            <option value="1" {{ $periode == 1 ? 'selected' : '' }}>Periode I</option>
            <option value="2" {{ $periode == 2 ? 'selected' : '' }}>Periode II</option>
        </select>
        <button class="btn btn-primary btn-sm px-3">
            <i class="fas fa-search mr-1"></i> Filter
        </button>
    </form>
</div>

{{-- SECTION: DATA UMUM --}}
<div class="sec-label">Ringkasan Data</div>
<div class="row">
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-blue">
            <div class="mc-label">Total Lokasi</div>
            <div class="mc-val">{{ $totalLokasi }}</div>
            <i class="fas fa-map-marker-alt mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-cyan">
            <div class="mc-label">Total Petugas</div>
            <div class="mc-val">{{ $totalPetugas }}</div>
            <i class="fas fa-users mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-violet">
            <div class="mc-label">Total Parameter</div>
            <div class="mc-val">{{ $totalIndikator }}</div>
            <i class="fas fa-flask mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-slate">
            <div class="mc-label">Total Observasi</div>
            <div class="mc-val">{{ $totalObservasi }}</div>
            <i class="fas fa-clipboard-list mc-icon"></i>
        </div>
    </div>
</div>

{{-- SECTION: STATUS STORET --}}
<div class="sec-label">Status STORET — Tahun {{ $tahun }}</div>
<div class="row">
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-emerald">
            <div class="mc-label">Memenuhi Baku Mutu</div>
            <div class="mc-val">{{ $storet['baik'] }}</div>
            <i class="fas fa-check-circle mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-amber">
            <div class="mc-label">Tercemar Ringan</div>
            <div class="mc-val">{{ $storet['ringan'] }}</div>
            <i class="fas fa-exclamation-circle mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-orange">
            <div class="mc-label">Tercemar Sedang</div>
            <div class="mc-val">{{ $storet['sedang'] }}</div>
            <i class="fas fa-exclamation-triangle mc-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="metric-card bg-rose">
            <div class="mc-label">Tercemar Berat</div>
            <div class="mc-val">{{ $storet['berat'] }}</div>
            <i class="fas fa-times-circle mc-icon"></i>
        </div>
    </div>
</div>

{{-- SECTION: INSIGHT PERBANDINGAN --}}
@php
    $statusLvl = function($s) {
        return match($s) {
            'Memenuhi Baku Mutu' => 0,
            'Tercemar Ringan'    => 1,
            'Tercemar Sedang'    => 2,
            'Tercemar Berat'     => 3,
            default              => -1,
        };
    };

    $totalLok     = $perbandingan->count();
    $sepakatCount = $perbandingan->where('sepakat', true)->count();
    $pctSepakat   = $totalLok > 0 ? round($sepakatCount / $totalLok * 100) : 0;

    $ipLebihBuruk = $perbandingan->filter(fn($r) =>
        $statusLvl($r->status_ip) > $statusLvl($r->status_storet)
    )->count();
@endphp

{{-- helper macro untuk blade --}}
@php
$statusLvl = function($s) {
    return match($s) {
        'Memenuhi Baku Mutu' => 0,
        'Tercemar Ringan'    => 1,
        'Tercemar Sedang'    => 2,
        'Tercemar Berat'     => 3,
        default              => -1,
    };
};
@endphp

<div class="sec-label">Insight Perbandingan Metode</div>
<div class="row mb-3">
    <div class="col-md-4 mb-3">
        <div class="insight-box">
            <div class="ins-icon">🤝</div>
            <div>
                <h6>Tingkat Kesepakatan</h6>
                <p>Kedua metode <strong>sepakat</strong> pada <strong>{{ $pctSepakat }}%</strong>
                ({{ $sepakatCount }}/{{ $totalLok }}) lokasi pemantauan.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="insight-box" style="background:linear-gradient(135deg,#4c1d95,#2e1065)">
            <div class="ins-icon">📊</div>
            <div>
                <h6>IP vs STORET</h6>
                <p>Indeks Pencemaran mendeteksi kondisi <strong>lebih buruk</strong>
                di <strong>{{ $perbandingan->filter(fn($r) => $statusLvl($r->status_ip) > $statusLvl($r->status_storet))->count() }}</strong> lokasi
                dibanding STORET.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="insight-box" style="background:linear-gradient(135deg,#064e3b,#022c22)">
            <div class="ins-icon">✅</div>
            <div>
                <h6>Rekomendasi Metode</h6>
                <p>Gunakan <strong>IP</strong> untuk analisis cepat per lokasi,
                <strong>STORET</strong> untuk penilaian kumulatif multi-parameter.</p>
            </div>
        </div>
    </div>
</div>

{{-- CHART ROW 1: DONUT STORET vs IP --}}
<div class="sec-label">Distribusi Status — STORET vs Indeks Pencemaran</div>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm" style="border-radius:16px;border:none">
            <div class="card-header font-weight-bold" style="border-radius:16px 16px 0 0;background:#eff6ff;color:#1d4ed8;border:none">
                <i class="fas fa-chart-pie mr-1"></i> Metode STORET
                <span class="badge badge-pill badge-primary float-right">Kepmen LH 115/2003</span>
            </div>
            <div class="card-body"><div id="chartStoret"></div></div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm" style="border-radius:16px;border:none">
            <div class="card-header font-weight-bold" style="border-radius:16px 16px 0 0;background:#faf5ff;color:#7c3aed;border:none">
                <i class="fas fa-chart-pie mr-1"></i> Indeks Pencemaran (IP)
                <span class="badge badge-pill" style="background:#7c3aed;color:white" class="float-right">Kepmen LH 115/2003</span>
            </div>
            <div class="card-body"><div id="chartIP"></div></div>
        </div>
    </div>
</div>

{{-- CHART: RADAR PERBANDINGAN --}}
<div class="row">
    <div class="col-md-7 mb-4">
        <div class="card shadow-sm" style="border-radius:16px;border:none">
            <div class="card-header font-weight-bold" style="border-radius:16px 16px 0 0;background:#f8fafc;border:none">
                <i class="fas fa-chart-bar mr-1 text-primary"></i> Observasi per Lokasi (Top 10)
            </div>
            <div class="card-body"><div id="chartLokasi"></div></div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm" style="border-radius:16px;border:none">
            <div class="card-header font-weight-bold" style="border-radius:16px 16px 0 0;background:#f8fafc;border:none">
                <i class="fas fa-vial mr-1 text-warning"></i> Status per Parameter
            </div>
            <div class="card-body"><div id="chartParam"></div></div>
        </div>
    </div>
</div>

{{-- CHART: TREND DUAL AXIS --}}
<div class="sec-label">Tren Kualitas Air — 4 Tahun Terakhir</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body">
        <div id="chartTrend"></div>
        <small class="text-muted">
            <span style="color:#3b82f6">●</span> Skor STORET (makin negatif = makin buruk) &nbsp;
            <span style="color:#8b5cf6">●</span> Nilai IP (makin tinggi = makin tercemar)
        </small>
    </div>
</div>

{{-- TABEL PERBANDINGAN PER LOKASI --}}
<div class="sec-label">Perbandingan Status per Lokasi — STORET vs Indeks Pencemaran</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm obs-table mb-0">
                <thead style="background:#f8fafc">
                    <tr>
                        <th>Lokasi</th>
                        <th class="text-center">Skor STORET</th>
                        <th class="text-center">Status STORET</th>
                        <th class="text-center">Nilai IP</th>
                        <th class="text-center">Status IP</th>
                        <th class="text-center">Kesepakatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perbandingan as $row)
                    <tr>
                        <td><strong>{{ $row->nama_lokasi }}</strong></td>
                        <td class="text-center font-weight-bold" style="font-family:'DM Mono',monospace">
                            {{ $row->skor_storet }}
                        </td>
                        <td class="text-center">
                            @php $s = $row->status_storet; @endphp
                            <span class="status-pill {{ $s=='Memenuhi Baku Mutu' ? 'pill-baik' : ($s=='Tercemar Ringan' ? 'pill-ringan' : ($s=='Tercemar Sedang' ? 'pill-sedang' : 'pill-berat')) }}">
                                {{ $s }}
                            </span>
                        </td>
                        <td class="text-center font-weight-bold" style="font-family:'DM Mono',monospace">
                            {{ $row->nilai_ip }}
                        </td>
                        <td class="text-center">
                            @php $i = $row->status_ip; @endphp
                            <span class="status-pill {{ $i=='Memenuhi Baku Mutu' ? 'pill-baik' : ($i=='Tercemar Ringan' ? 'pill-ringan' : ($i=='Tercemar Sedang' ? 'pill-sedang' : 'pill-berat')) }}">
                                {{ $i }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($row->sepakat)
                                <span class="agree-badge agree-yes">✓ Sepakat</span>
                            @else
                                <span class="agree-badge agree-no">✗ Berbeda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PETA --}}
<div class="sec-label">Peta Sebaran Lokasi</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none;overflow:hidden">
    <div class="card-body p-0">
        <div id="map" style="height:480px"></div>
    </div>
    <div class="card-footer small d-flex flex-wrap" style="gap:16px;background:#f8fafc">
        <span><span style="color:#10b981;font-size:1rem">●</span> Memenuhi Baku Mutu</span>
        <span><span style="color:#f59e0b;font-size:1rem">●</span> Tercemar Ringan</span>
        <span><span style="color:#f97316;font-size:1rem">●</span> Tercemar Sedang</span>
        <span><span style="color:#ef4444;font-size:1rem">●</span> Tercemar Berat</span>
        <span><span style="color:#94a3b8;font-size:1rem">●</span> Belum Ada Data</span>
        <span class="ml-auto text-muted">Lingkaran = STORET | Popup menampilkan kedua metode</span>
    </div>
</div>

{{-- OBSERVASI TERBARU --}}
<div class="sec-label">Observasi Terbaru</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body p-0">
        <table class="table table-sm obs-table mb-0">
            <thead style="background:#f8fafc">
                <tr>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Periode</th>
                    <th>Petugas</th>
                    <th>SHU</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($observasiTerbaru as $obs)
                <tr>
                    <td>
                        <strong>{{ $obs->lokasi->nama_lokasi }}</strong><br>
                        <small class="text-muted">{{ $obs->lokasi->alamat_lokasi }}</small>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($obs->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}</td>
                    <td>Periode {{ $obs->periode_pemantauan == 1 ? 'I' : 'II' }}</td>
                    <td>{{ $obs->user->nama ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $obs->shu == 'ADA SHU' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $obs->shu }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data</td></tr>
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

// ── DONUT STORET ──
new ApexCharts(document.querySelector("#chartStoret"), {
    chart: { type:'donut', height:280 },
    series: [{{ $storet['baik'] }}, {{ $storet['ringan'] }}, {{ $storet['sedang'] }}, {{ $storet['berat'] }}],
    labels: ['Memenuhi','Tercemar Ringan','Tercemar Sedang','Tercemar Berat'],
    colors: [COLORS.baik, COLORS.ringan, COLORS.sedang, COLORS.berat],
    plotOptions: { pie: { donut: { size:'65%', labels:{ show:true, total:{ show:true, label:'Total Lokasi', fontSize:'13px' } } } } },
    legend: { position:'bottom', fontSize:'12px' },
    dataLabels: { enabled: true }
}).render();

// ── DONUT IP ──
new ApexCharts(document.querySelector("#chartIP"), {
    chart: { type:'donut', height:280 },
    series: [{{ $ip['baik'] }}, {{ $ip['ringan'] }}, {{ $ip['sedang'] }}, {{ $ip['berat'] }}],
    labels: ['Memenuhi','Tercemar Ringan','Tercemar Sedang','Tercemar Berat'],
    colors: [COLORS.baik, COLORS.ringan, COLORS.sedang, COLORS.berat],
    plotOptions: { pie: { donut: { size:'65%', labels:{ show:true, total:{ show:true, label:'Total Lokasi', fontSize:'13px' } } } } },
    legend: { position:'bottom', fontSize:'12px' },
    dataLabels: { enabled: true }
}).render();

// ── BAR OBSERVASI ──
new ApexCharts(document.querySelector("#chartLokasi"), {
    chart: { type:'bar', height:300, toolbar:{ show:false } },
    series: [{ name:'Observasi', data: {!! json_encode($obsPerLokasi->pluck('jumlah')) !!} }],
    xaxis:  { categories: {!! json_encode($obsPerLokasi->pluck('nama_lokasi')) !!}, labels:{ rotate:-30, style:{ fontSize:'11px' } } },
    colors: ['#3b82f6'],
    plotOptions: { bar:{ borderRadius:5, columnWidth:'55%' } },
    dataLabels: { enabled:true },
    grid: { borderColor:'#f1f5f9' }
}).render();

// ── BAR STACKED PARAMETER ──
new ApexCharts(document.querySelector("#chartParam"), {
    chart: { type:'bar', height:300, stacked:true, toolbar:{ show:false } },
    series: [
        { name:'Memenuhi',       data: {!! json_encode($statusParam->pluck('memenuhi')) !!} },
        { name:'Tercemar Ringan',data: {!! json_encode($statusParam->pluck('ringan')) !!} },
        { name:'Tercemar Berat', data: {!! json_encode($statusParam->pluck('berat')) !!} },
    ],
    xaxis: { categories: {!! json_encode($statusParam->pluck('parameter')) !!}, labels:{ style:{ fontSize:'11px' } } },
    colors: [COLORS.baik, COLORS.ringan, COLORS.berat],
    legend: { position:'bottom', fontSize:'12px' },
    grid: { borderColor:'#f1f5f9' },
    plotOptions: { bar:{ borderRadius:3 } }
}).render();

// ── LINE TREND DUAL ──
new ApexCharts(document.querySelector("#chartTrend"), {
    chart: { type:'line', height:280, toolbar:{ show:false }, zoom:{ enabled:false } },
    series: [
        { name:'Skor STORET',  data: {!! json_encode($trend->pluck('skor_storet')) !!} },
        { name:'Nilai IP',     data: {!! json_encode($trend->pluck('nilai_ip')) !!} },
    ],
    xaxis: { categories: {!! json_encode($trend->pluck('tahun')) !!} },
    colors: ['#3b82f6','#8b5cf6'],
    stroke: { curve:'smooth', width:[3,3], dashArray:[0,5] },
    markers: { size:6 },
    yaxis: [
        { title:{ text:'Skor STORET', style:{ color:'#3b82f6' } }, reversed:true },
        { opposite:true, title:{ text:'Nilai IP', style:{ color:'#8b5cf6' } } }
    ],
    legend: { position:'top' },
    grid: { borderColor:'#f1f5f9' },
    tooltip: { shared:true, intersect:false }
}).render();

// ── MAP ──
var map = L.map('map').setView([-3.3, 114.6], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution:'© OpenStreetMap' }).addTo(map);

var lokasiData = @json($lokasiMap);
lokasiData.forEach(function(item) {
    if (!item.latitude || !item.longitude) return;

    var colorMap = {
        'Memenuhi Baku Mutu': '#10b981',
        'Tercemar Ringan':    '#f59e0b',
        'Tercemar Sedang':    '#f97316',
        'Tercemar Berat':     '#ef4444',
        'Belum Ada Data':     '#94a3b8',
    };

    var color = colorMap[item.status_storet] || '#94a3b8';

    var pillColor = function(s) {
        return colorMap[s] || '#94a3b8';
    };

    L.circleMarker([item.latitude, item.longitude], {
        color: color, fillColor: color, fillOpacity: 0.85, radius: 10, weight: 2
    })
    .addTo(map)
    .bindPopup(
        '<b style="font-size:13px">' + item.nama_lokasi + '</b><br>' +
        '<small class="text-muted">' + (item.alamat_lokasi || '') + '</small><hr style="margin:6px 0">' +
        '<table style="font-size:12px;width:100%">' +
        '<tr><td><b>STORET</b></td><td><span style="color:' + pillColor(item.status_storet) + ';font-weight:600">' + (item.status_storet || '-') + '</span></td></tr>' +
        '<tr><td><b>IP</b></td><td><span style="color:' + pillColor(item.status_ip) + ';font-weight:600">' + (item.status_ip || '-') + '</span> ' +
        (item.nilai_ip ? '<small>(' + item.nilai_ip + ')</small>' : '') + '</td></tr>' +
        '</table>'
    );
});
</script>
@endpush