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
.bg-violet  { background: linear-gradient(135deg,#8b5cf6,#6d28d9); }
.bg-cyan    { background: linear-gradient(135deg,#06b6d4,#0e7490); }
.bg-orange  { background: linear-gradient(135deg,#f97316,#c2410c); }
.bg-slate   { background: linear-gradient(135deg,#64748b,#334155); }
.sec-label {
    font-size:.68rem; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; color:#94a3b8; margin:1.75rem 0 .75rem;
}
.status-pill { display:inline-block; padding:2px 10px; border-radius:99px; font-size:.72rem; font-weight:600; }
.pill-baik   { background:#d1fae5; color:#065f46; }
.pill-ringan { background:#fef3c7; color:#92400e; }
.pill-sedang { background:#ffedd5; color:#9a3412; }
.pill-berat  { background:#fee2e2; color:#991b1b; }
.agree-badge { font-size:.65rem; font-weight:700; padding:1px 8px; border-radius:99px; }
.agree-yes   { background:#d1fae5; color:#065f46; }
.agree-no    { background:#fee2e2; color:#991b1b; }
.insight-box {
    background:linear-gradient(135deg,#1e3a5f,#0f2340);
    color:white; border-radius:16px; padding:1.5rem;
    display:flex; align-items:flex-start; gap:1rem;
}
.insight-box .ins-icon { font-size:2rem; flex-shrink:0; }
.insight-box h6 { font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; opacity:.7; margin:0; }
.insight-box p  { margin:4px 0 0; font-size:.95rem; line-height:1.4; }
.obs-table td, .obs-table th { font-size:.82rem; padding:.5rem .75rem; }
.ai-card {
    border-radius: 16px; border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    transition: transform .2s, box-shadow .2s; height: 100%;
}
.ai-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.12); }
.ai-card .card-header {
    border-radius: 16px 16px 0 0 !important; border: none;
    font-weight: 700; font-size: .82rem; letter-spacing: .04em; padding: 1rem 1.25rem;
}
.ai-card .card-body { padding: 1.25rem; display: flex; flex-direction: column; gap: .75rem; }
.btn-ai {
    border-radius: 10px; font-weight: 600; font-size: .82rem; padding: .5rem 1rem;
    border: none; display: flex; align-items: center; gap: 6px;
    justify-content: center; transition: opacity .15s, transform .1s; margin-top: auto;
}
.btn-ai:hover  { opacity: .88; }
.btn-ai:active { transform: scale(.97); }
.btn-ai:disabled { opacity: .5; cursor: not-allowed; }
.btn-forecast    { background: linear-gradient(135deg, #0ea5e9, #0369a1); color: white; }
.btn-correlation { background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white; }
.btn-recommend   { background: linear-gradient(135deg, #f43f5e, #be123c); color: white; }
.ai-loading {
    display: none; align-items: center; justify-content: center;
    gap: 8px; padding: .75rem 0; font-size: .8rem; color: #64748b;
}
.ai-modal .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.ai-modal .modal-header  { border-radius: 16px 16px 0 0; border-bottom: 1px solid #f1f5f9; padding: 1.25rem 1.5rem; }
.ai-modal .modal-body    { padding: 1.5rem; max-height: 70vh; overflow-y: auto; }
.ai-modal .modal-title   { font-weight: 700; font-size: 1rem; display: flex; align-items: center; gap: 8px; }
.ai-result-card { border-radius: 12px; padding: .9rem 1rem; margin-bottom: .75rem; border-left: 4px solid transparent; }
.ai-result-card.urgensi-kritis  { border-left-color: #ef4444; background: #fff1f2; }
.ai-result-card.urgensi-tinggi  { border-left-color: #f59e0b; background: #fffbeb; }
.ai-result-card.urgensi-sedang  { border-left-color: #3b82f6; background: #eff6ff; }
.ai-result-card.korelasi-positif { border-left-color: #ef4444; background: #fff1f2; }
.ai-result-card.korelasi-negatif { border-left-color: #10b981; background: #ecfdf5; }
.ai-result-card.program-card     { border-left-color: #10b981; background: #f0fdf4; }
.ai-result-card.penyebab-card    { border-left-color: #f59e0b; background: #fffbeb; }
.ai-result-card.indikator-card   { border-left-color: #8b5cf6; background: #f5f3ff; }
.ai-result-card .rc-title  { font-weight: 700; font-size: .85rem; color: #1e293b; margin-bottom: 4px; }
.ai-result-card .rc-sub    { font-size: .78rem; color: #475569; line-height: 1.5; }
.ai-result-card .rc-action { font-size: .78rem; color: #0f172a; margin-top: 6px; }
.ai-result-card .rc-meta   { font-size: .72rem; color: #94a3b8; margin-top: 4px; }
.badge-ai      { padding: 3px 10px; border-radius: 99px; font-size: .68rem; font-weight: 700; }
.badge-kritis  { background: #fee2e2; color: #991b1b; }
.badge-tinggi  { background: #fef3c7; color: #92400e; }
.badge-sedang  { background: #dbeafe; color: #1e40af; }
.badge-baik    { background: #d1fae5; color: #065f46; }
.badge-buruk   { background: #fee2e2; color: #991b1b; }
.badge-conf    { background: #f3f4f6; color: #374151; }
.tren-badge    { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 99px; font-size: .75rem; font-weight: 700; }
.tren-membaik    { background: #d1fae5; color: #065f46; }
.tren-memburuk   { background: #fee2e2; color: #991b1b; }
.tren-stabil     { background: #dbeafe; color: #1e40af; }
.tren-fluktuatif { background: #fef3c7; color: #92400e; }
.ai-summary-box {
    background: linear-gradient(135deg, #1e3a5f, #0f2340); color: white;
    border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.25rem;
    font-size: .88rem; line-height: 1.6;
}
.ai-summary-box .sum-label { font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; opacity: .6; margin-bottom: 4px; }
.param-chip { display: inline-block; padding: 3px 10px; border-radius: 99px; background: #f1f5f9; color: #334155; font-size: .72rem; font-weight: 600; margin: 2px; }
.param-chip.chip-warning { background: #fef3c7; color: #92400e; }
.param-chip.chip-danger  { background: #fee2e2; color: #991b1b; }
.modal-section-title {
    font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: #94a3b8; margin: 1.25rem 0 .6rem; display: flex; align-items: center; gap: 8px;
}
.modal-section-title::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }
.ai-error {
    background: #fff1f2; border: 1px solid #fecdd3; border-radius: 10px;
    padding: .75rem 1rem; font-size: .82rem; color: #9f1239; display: flex; align-items: center; gap: 8px;
}
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

{{-- SECTION: AI --}}
<div class="sec-label">
    <i class="fas fa-robot mr-1" style="color:#8b5cf6"></i>
    Analisis Kecerdasan Buatan (Llama 3.1)
</div>

<div class="row mb-4">
    {{-- CARD 1: FORECASTING --}}
    <div class="col-md-4 mb-3">
        <div class="card ai-card">
            <div class="card-header" style="background:#e0f2fe;color:#0369a1;">
                <i class="fas fa-chart-line mr-1"></i> Prediksi Tren
                <span class="badge badge-pill badge-primary float-right" style="font-size:.65rem;font-weight:600">Time-Series</span>
            </div>
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:.8rem">
                    AI memprediksi kualitas air 2 periode ke depan berdasarkan data historis.
                </p>
                <select id="ai-forecast-lokasi" class="form-control form-control-sm">
                    <option value="">— Semua Lokasi —</option>
                    @foreach($daftarLokasi as $lok)
                        <option value="{{ $lok->id }}">{{ $lok->kode_lokasi }} — {{ Str::limit($lok->alamat_lokasi, 30) }}</option>
                    @endforeach
                </select>
                <select id="ai-forecast-param" class="form-control form-control-sm">
                    <option value="">— Semua Parameter —</option>
                    @foreach($daftarIndikator as $ind)
                        <option value="{{ $ind->nama_indikator }}">{{ $ind->nama_indikator }}</option>
                    @endforeach
                </select>
                <div class="ai-loading" id="loading-forecast">
                    <div class="spinner-border spinner-border-sm text-info"></div>
                    <span>Menganalisis tren data...</span>
                </div>
                <button class="btn-ai btn-forecast" id="btn-forecast" onclick="runForecast()">
                    <i class="fas fa-magic"></i> Jalankan Prediksi
                </button>
            </div>
        </div>
    </div>

    {{-- CARD 2: CORRELATION --}}
    <div class="col-md-4 mb-3">
        <div class="card ai-card">
            <div class="card-header" style="background:#ede9fe;color:#6d28d9;">
                <i class="fas fa-project-diagram mr-1"></i> Analisis Korelasi
                <span class="badge badge-pill float-right" style="background:#7c3aed;color:white;font-size:.65rem;font-weight:600">Causality</span>
            </div>
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:.8rem">
                    Temukan korelasi antar parameter dan identifikasi penyebab utama pencemaran.
                </p>
                <select id="ai-corr-periode" class="form-control form-control-sm">
                    <option value="">— Semua Periode —</option>
                    <option value="1" {{ $periode == 1 ? 'selected' : '' }}>Periode I</option>
                    <option value="2" {{ $periode == 2 ? 'selected' : '' }}>Periode II</option>
                </select>
                <select id="ai-corr-lokasi" class="form-control form-control-sm">
                    <option value="">— Semua Lokasi —</option>
                    @foreach($daftarLokasi as $lok)
                        <option value="{{ $lok->id }}">{{ $lok->kode_lokasi }} — {{ Str::limit($lok->alamat_lokasi, 30) }}</option>
                    @endforeach
                </select>
                <div class="ai-loading" id="loading-correlation">
                    <div class="spinner-border spinner-border-sm" style="color:#7c3aed"></div>
                    <span>Menganalisis korelasi...</span>
                </div>
                <button class="btn-ai btn-correlation" id="btn-correlation" onclick="runCorrelation()">
                    <i class="fas fa-search-plus"></i> Analisis Korelasi
                </button>
            </div>
        </div>
    </div>

    {{-- CARD 3: RECOMMENDATION --}}
    <div class="col-md-4 mb-3">
        <div class="card ai-card">
            <div class="card-header" style="background:#fce7f3;color:#9d174d;">
                <i class="fas fa-lightbulb mr-1"></i> Rekomendasi Tindakan
                <span class="badge badge-pill float-right" style="background:#be185d;color:white;font-size:.65rem;font-weight:600">Prescriptive</span>
            </div>
            <div class="card-body">
                <p class="text-muted mb-1" style="font-size:.8rem">
                    Rencana aksi prioritas konkret berbasis kondisi aktual seluruh lokasi.
                </p>
                <select id="ai-rec-periode" class="form-control form-control-sm">
                    <option value="">— Semua Periode —</option>
                    <option value="1" {{ $periode == 1 ? 'selected' : '' }}>Periode I</option>
                    <option value="2" {{ $periode == 2 ? 'selected' : '' }}>Periode II</option>
                </select>
                <select id="ai-rec-lokasi" class="form-control form-control-sm">
                    <option value="">— Semua Lokasi —</option>
                    @foreach($daftarLokasi as $lok)
                        <option value="{{ $lok->id }}">{{ $lok->kode_lokasi }} — {{ Str::limit($lok->alamat_lokasi, 30) }}</option>
                    @endforeach
                </select>
                <div class="ai-loading" id="loading-recommend">
                    <div class="spinner-border spinner-border-sm text-danger"></div>
                    <span>Menyusun rekomendasi...</span>
                </div>
                <button class="btn-ai btn-recommend" id="btn-recommend" onclick="runRecommend()">
                    <i class="fas fa-clipboard-check"></i> Generate Rekomendasi
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL AI --}}
<div class="modal fade ai-modal" id="aiResultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aiModalTitle">Hasil Analisis AI</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" id="aiModalBody"></div>
            <div class="modal-footer" style="border-top:1px solid #f1f5f9;">
                <small class="text-muted mr-auto">
                    <i class="fas fa-robot mr-1" style="color:#8b5cf6"></i>
                    Dianalisis oleh Groq AI (LLaMA 3.1)
                </small>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Tutup</button>
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
                <span class="badge badge-pill float-right" style="background:#7c3aed;color:white">Kepmen LH 115/2003</span>
            </div>
            <div class="card-body"><div id="chartIP"></div></div>
        </div>
    </div>
</div>

{{-- CHART ROW 2 --}}
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

{{-- CHART: TREND --}}
<div class="sec-label">Tren Kualitas Air — 4 Tahun Terakhir</div>
<div class="card shadow-sm mb-4" style="border-radius:16px;border:none">
    <div class="card-body">
        <div id="chartTrend"></div>
        <small class="text-muted">
            <span style="color:#3b82f6">●</span> Skor STORET (makin tinggi = makin buruk) &nbsp;
            <span style="color:#8b5cf6">●</span> Nilai IP (makin tinggi = makin tercemar)
        </small>
    </div>
</div>

{{-- TABEL PERBANDINGAN --}}
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
                        <td class="text-center font-weight-bold" style="font-family:'DM Mono',monospace">{{ $row->skor_storet }}</td>
                        <td class="text-center">
                            @php $s = $row->status_storet; @endphp
                            <span class="status-pill {{ $s=='Memenuhi Baku Mutu' ? 'pill-baik' : ($s=='Tercemar Ringan' ? 'pill-ringan' : ($s=='Tercemar Sedang' ? 'pill-sedang' : 'pill-berat')) }}">{{ $s }}</span>
                        </td>
                        <td class="text-center font-weight-bold" style="font-family:'DM Mono',monospace">{{ $row->nilai_ip }}</td>
                        <td class="text-center">
                            @php $i = $row->status_ip; @endphp
                            <span class="status-pill {{ $i=='Memenuhi Baku Mutu' ? 'pill-baik' : ($i=='Tercemar Ringan' ? 'pill-ringan' : ($i=='Tercemar Sedang' ? 'pill-sedang' : 'pill-berat')) }}">{{ $i }}</span>
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
                    <th>Lokasi</th><th>Tanggal</th><th>Periode</th><th>Petugas</th><th>SHU</th>
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
const COLORS = { baik:'#10b981', ringan:'#f59e0b', sedang:'#f97316', berat:'#ef4444' };
const AI_TAHUN   = {{ $tahun }};
const AI_PERIODE = {{ $periode ?? 'null' }};
const AI_BASE    = '/admin/ai';

function setLoading(id, show) {
    const el  = document.getElementById('loading-' + id);
    const btn = document.getElementById('btn-' + id);
    if (!el || !btn) return;
    el.style.display = show ? 'flex' : 'none';
    btn.disabled     = show;
}
function showModal(title, bodyHtml) {
    document.getElementById('aiModalTitle').innerHTML = title;
    document.getElementById('aiModalBody').innerHTML  = bodyHtml;
    $('#aiResultModal').modal('show');
}
function renderError(msg) {
    return `<div class="ai-error"><i class="fas fa-exclamation-circle"></i>${msg}</div>`;
}
function urgensiBadge(lvl) {
    const map = { Kritis:'badge-kritis', Tinggi:'badge-tinggi', Sedang:'badge-sedang' };
    return `<span class="badge-ai ${map[lvl]||'badge-conf'}">${lvl||'-'}</span>`;
}
function statusBadge(s) {
    if (!s) return '<span class="badge-ai badge-conf">-</span>';
    const map = { 'Memenuhi Baku Mutu':'badge-baik','Tercemar Ringan':'badge-tinggi','Tercemar Sedang':'badge-kritis','Tercemar Berat':'badge-kritis' };
    return `<span class="badge-ai ${map[s]||'badge-conf'}">${s}</span>`;
}
function trenBadge(tren) {
    const map = { Membaik:['tren-membaik','↗ Membaik'], Memburuk:['tren-memburuk','↘ Memburuk'], Stabil:['tren-stabil','→ Stabil'], Fluktuatif:['tren-fluktuatif','↕ Fluktuatif'] };
    const [cls, label] = map[tren] || ['tren-stabil', tren||'-'];
    return `<span class="tren-badge ${cls}">${label}</span>`;
}
function chips(arr, cls='') {
    if (!arr||!arr.length) return '<span class="text-muted small">-</span>';
    return arr.map(v=>`<span class="param-chip ${cls}">${v}</span>`).join('');
}

function runForecast() {
    const lokasi_id = document.getElementById('ai-forecast-lokasi').value;
    const parameter = document.getElementById('ai-forecast-param').value;
    setLoading('forecast', true);
    const params = new URLSearchParams({ tahun: AI_TAHUN, ...(lokasi_id&&{lokasi_id}), ...(parameter&&{parameter}) });
    fetch(`${AI_BASE}/forecast?${params}`)
        .then(r=>r.json())
        .then(data=>{
            setLoading('forecast', false);
            if (data.error) { showModal('<i class="fas fa-chart-line text-info mr-2"></i>Prediksi Tren', renderError(data.error)); return; }
            const predRows = (data.prediksi||[]).map(p=>`
                <tr>
                    <td class="font-weight-bold">Periode ${p.periode} / ${p.tahun}</td>
                    <td>${p.parameter||'-'}</td>
                    <td class="text-center" style="font-family:'DM Mono',monospace;font-weight:700">${parseFloat(p.prediksi_nilai||0).toFixed(4)} <small class="text-muted">${p.satuan||''}</small></td>
                    <td class="text-center" style="font-family:'DM Mono',monospace">${parseFloat(p.baku_mutu||0).toFixed(4)}</td>
                    <td class="text-center">${statusBadge(p.prediksi_status)}</td>
                </tr>`).join('')||'<tr><td colspan="5" class="text-center text-muted">Tidak ada data prediksi</td></tr>';
            const faktors = (data.faktor_risiko||[]).map(f=>`<li style="font-size:.82rem;margin-bottom:4px">${f}</li>`).join('');
            showModal('<i class="fas fa-chart-line text-info mr-2"></i>Prediksi Tren Kualitas Air', `
                <div class="ai-summary-box"><div class="sum-label">Ringkasan Tren</div><div>${data.ringkasan||'-'}</div></div>
                <div class="d-flex align-items-center mb-3 flex-wrap" style="gap:8px">
                    <span class="text-muted small mr-1">Tren:</span>${trenBadge(data.tren)}
                    <span class="text-muted small ml-3 mr-1">Confidence:</span>
                    <span class="badge-ai badge-conf">${data.confidence||'-'}</span>
                </div>
                <div class="modal-section-title">Tabel Prediksi</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" style="font-size:.82rem">
                        <thead style="background:#f8fafc"><tr><th>Periode</th><th>Parameter</th><th class="text-center">Nilai Prediksi</th><th class="text-center">Baku Mutu</th><th class="text-center">Status</th></tr></thead>
                        <tbody>${predRows}</tbody>
                    </table>
                </div>
                <div class="modal-section-title">Faktor Risiko</div>
                <ul style="padding-left:1.2rem">${faktors}</ul>
                <div style="background:#f8fafc;border-radius:10px;padding:.75rem 1rem;font-size:.78rem;color:#64748b">
                    <i class="fas fa-info-circle mr-1"></i><strong>Alasan confidence:</strong> ${data.alasan_confidence||'-'}
                </div>`);
        })
        .catch(err=>{ setLoading('forecast',false); showModal('<i class="fas fa-chart-line text-info mr-2"></i>Prediksi Tren', renderError('Kesalahan koneksi: '+err.message)); });
}

function runCorrelation() {
    const periode   = document.getElementById('ai-corr-periode').value;
    const lokasi_id = document.getElementById('ai-corr-lokasi').value;
    setLoading('correlation', true);
    const params = new URLSearchParams({ tahun: AI_TAHUN, ...(periode&&{periode}), ...(lokasi_id&&{lokasi_id}) });
    fetch(`${AI_BASE}/correlation?${params}`)
        .then(r=>r.json())
        .then(data=>{
            setLoading('correlation', false);
            if (data.error) { showModal('<i class="fas fa-project-diagram mr-2" style="color:#7c3aed"></i>Analisis Korelasi', renderError(data.error)); return; }
            const korelasiCards = (data.korelasi_kuat||[]).map(k=>`
                <div class="ai-result-card korelasi-${k.arah==='positif'?'positif':'negatif'}">
                    <div class="rc-title">${k.param_a||'-'} ↔ ${k.param_b||'-'}
                        <span class="badge-ai ${k.arah==='positif'?'badge-buruk':'badge-baik'} ml-1">${k.arah||'-'}</span>
                        <span class="badge-ai badge-conf ml-1">${k.kekuatan||'-'}</span>
                    </div>
                    <div class="rc-sub">${k.penjelasan||'-'}</div>
                </div>`).join('')||'<p class="text-muted small">Tidak ada korelasi teridentifikasi</p>';
            const indCards = (data.indikator_awal||[]).map(i=>`
                <div class="ai-result-card indikator-card">
                    <div class="rc-title"><i class="fas fa-exclamation-triangle mr-1" style="color:#f59e0b"></i>${i.parameter||'-'}</div>
                    <div class="rc-sub">${i.alasan||'-'}</div>
                    <div class="rc-meta">Berdampak ke: ${chips(i.parameter_yang_terpengaruh,'chip-warning')}</div>
                </div>`).join('')||'<p class="text-muted small">Tidak ada indikator awal</p>';
            const penyebabCards = (data.penyebab_dominan||[]).map(p=>`
                <div class="ai-result-card penyebab-card">
                    <div class="rc-title">${p.penyebab||'-'} <span class="badge-ai badge-conf ml-1">kepastian: ${p.tingkat_kepastian||'-'}</span></div>
                    <div class="rc-meta">Parameter terdampak: ${chips(p.parameter_terdampak,'chip-danger')}</div>
                    <div class="rc-action"><i class="fas fa-search mr-1 text-primary"></i><strong>Investigasi:</strong> ${p.rekomendasi_investigasi||'-'}</div>
                </div>`).join('')||'<p class="text-muted small">Tidak ada penyebab teridentifikasi</p>';
            showModal('<i class="fas fa-project-diagram mr-2" style="color:#7c3aed"></i>Analisis Korelasi & Penyebab', `
                <div class="ai-summary-box"><div class="sum-label">Kondisi Keseluruhan</div><div>${data.ringkasan||'-'}</div></div>
                <div class="modal-section-title">Parameter Kritis</div>
                <div class="mb-3">${chips(data.parameter_kritis,'chip-danger')}</div>
                <div class="modal-section-title">Korelasi Antar Parameter</div>${korelasiCards}
                <div class="modal-section-title">Indikator Awal (Early Warning)</div>${indCards}
                <div class="modal-section-title">Penyebab Dominan</div>${penyebabCards}`);
        })
        .catch(err=>{ setLoading('correlation',false); showModal('<i class="fas fa-project-diagram mr-2" style="color:#7c3aed"></i>Analisis Korelasi', renderError('Kesalahan koneksi: '+err.message)); });
}

function runRecommend() {
    const periode   = document.getElementById('ai-rec-periode').value;
    const lokasi_id = document.getElementById('ai-rec-lokasi').value;
    setLoading('recommend', true);
    const params = new URLSearchParams({ tahun: AI_TAHUN, ...(periode&&{periode}), ...(lokasi_id&&{lokasi_id}) });
    fetch(`${AI_BASE}/recommend?${params}`)
        .then(r=>r.json())
        .then(data=>{
            setLoading('recommend', false);
            if (data.error) { showModal('<i class="fas fa-lightbulb text-danger mr-2"></i>Rekomendasi Tindakan', renderError(data.error)); return; }
            const daruratCards = (data.prioritas_darurat||[]).map(d=>{
                const cls = {Kritis:'urgensi-kritis',Tinggi:'urgensi-tinggi',Sedang:'urgensi-sedang'}[d.tingkat_urgensi]||'urgensi-sedang';
                return `<div class="ai-result-card ${cls}">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="rc-title">${d.lokasi||'-'}</div>${urgensiBadge(d.tingkat_urgensi)}
                    </div>
                    <div class="rc-sub">${d.masalah_utama||'-'}</div>
                    <div class="rc-action"><i class="fas fa-arrow-right mr-1"></i><strong>Tindakan:</strong> ${d.tindakan_segera||'-'}</div>
                    <div class="rc-meta"><i class="fas fa-clock mr-1"></i> Target: ${d.target_waktu||'-'} &nbsp;·&nbsp; <i class="fas fa-building mr-1"></i>${Array.isArray(d.instansi_terkait)?d.instansi_terkait.join(', '):(d.instansi_terkait||'-')}</div>
                </div>`;
            }).join('')||'<p class="text-muted small">Tidak ada prioritas darurat</p>';
            const jangkaCards = (data.rekomendasi_jangka_panjang||[]).map(j=>`
                <div class="ai-result-card program-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="rc-title">${j.program||'-'}</div>
                        <span class="badge-ai badge-conf">${j.estimasi_durasi||'-'}</span>
                    </div>
                    <div class="rc-sub">${j.deskripsi||'-'}</div>
                    <div class="rc-meta">Lokasi: ${chips(j.lokasi_sasaran)}</div>
                    <div class="rc-action" style="color:#059669"><i class="fas fa-check-circle mr-1"></i><strong>Indikator:</strong> ${j.indikator_keberhasilan||'-'}</div>
                </div>`).join('')||'<p class="text-muted small">Tidak ada program jangka panjang</p>';
            showModal('<i class="fas fa-lightbulb text-danger mr-2"></i>Rekomendasi Tindakan AI', `
                <div class="ai-summary-box"><div class="sum-label">Ringkasan Eksekutif</div><div>${data.ringkasan_eksekutif||'-'}</div></div>
                <div class="modal-section-title"><span style="color:#ef4444">●</span> Prioritas Darurat</div>${daruratCards}
                <div class="modal-section-title"><span style="color:#10b981">●</span> Program Jangka Panjang</div>${jangkaCards}
                <div class="modal-section-title">Parameter Prioritas Monitoring</div>
                <div class="mb-2">${chips(data.parameter_prioritas_monitoring,'chip-warning')}</div>
                <div class="modal-section-title">Lokasi Perlu Perhatian Khusus</div>
                <div>${chips(data.lokasi_perlu_perhatian_khusus,'chip-danger')}</div>`);
        })
        .catch(err=>{ setLoading('recommend',false); showModal('<i class="fas fa-lightbulb text-danger mr-2"></i>Rekomendasi Tindakan', renderError('Kesalahan koneksi: '+err.message)); });
}

new ApexCharts(document.querySelector("#chartStoret"), {
    chart:{type:'donut',height:280},
    series:[{{ $storet['baik'] }},{{ $storet['ringan'] }},{{ $storet['sedang'] }},{{ $storet['berat'] }}],
    labels:['Memenuhi','Tercemar Ringan','Tercemar Sedang','Tercemar Berat'],
    colors:[COLORS.baik,COLORS.ringan,COLORS.sedang,COLORS.berat],
    plotOptions:{pie:{donut:{size:'65%',labels:{show:true,total:{show:true,label:'Total Lokasi',fontSize:'13px'}}}}},
    legend:{position:'bottom',fontSize:'12px'},dataLabels:{enabled:true}
}).render();

new ApexCharts(document.querySelector("#chartIP"), {
    chart:{type:'donut',height:280},
    series:[{{ $ip['baik'] }},{{ $ip['ringan'] }},{{ $ip['sedang'] }},{{ $ip['berat'] }}],
    labels:['Memenuhi','Tercemar Ringan','Tercemar Sedang','Tercemar Berat'],
    colors:[COLORS.baik,COLORS.ringan,COLORS.sedang,COLORS.berat],
    plotOptions:{pie:{donut:{size:'65%',labels:{show:true,total:{show:true,label:'Total Lokasi',fontSize:'13px'}}}}},
    legend:{position:'bottom',fontSize:'12px'},dataLabels:{enabled:true}
}).render();

new ApexCharts(document.querySelector("#chartLokasi"), {
    chart:{type:'bar',height:300,toolbar:{show:false}},
    series:[{name:'Observasi',data:{!! json_encode($obsPerLokasi->pluck('jumlah')) !!}}],
    xaxis:{categories:{!! json_encode($obsPerLokasi->pluck('nama_lokasi')) !!},labels:{rotate:-30,style:{fontSize:'11px'}}},
    colors:['#3b82f6'],plotOptions:{bar:{borderRadius:5,columnWidth:'55%'}},
    dataLabels:{enabled:true},grid:{borderColor:'#f1f5f9'}
}).render();

new ApexCharts(document.querySelector("#chartParam"), {
    chart:{type:'bar',height:300,stacked:true,toolbar:{show:false}},
    series:[
        {name:'Memenuhi',data:{!! json_encode($statusParam->pluck('memenuhi')) !!}},
        {name:'Tercemar Ringan',data:{!! json_encode($statusParam->pluck('ringan')) !!}},
        {name:'Tercemar Berat',data:{!! json_encode($statusParam->pluck('berat')) !!}},
    ],
    xaxis:{categories:{!! json_encode($statusParam->pluck('parameter')) !!},labels:{style:{fontSize:'11px'}}},
    colors:[COLORS.baik,COLORS.ringan,COLORS.berat],
    legend:{position:'bottom',fontSize:'12px'},grid:{borderColor:'#f1f5f9'},plotOptions:{bar:{borderRadius:3}}
}).render();

new ApexCharts(document.querySelector("#chartTrend"), {
    chart:{type:'line',height:280,toolbar:{show:false},zoom:{enabled:false}},
    series:[
        {name:'Skor STORET',data:{!! json_encode($trend->pluck('skor_storet')) !!}},
        {name:'Nilai IP',data:{!! json_encode($trend->pluck('nilai_ip')) !!}},
    ],
    xaxis:{categories:{!! json_encode($trend->pluck('tahun')) !!}},
    colors:['#3b82f6','#8b5cf6'],
    stroke:{curve:'smooth',width:[3,3],dashArray:[0,5]},
    markers:{size:6},
    yaxis:[
        {title:{text:'Skor STORET',style:{color:'#3b82f6'}},reversed:true},
        {opposite:true,title:{text:'Nilai IP',style:{color:'#8b5cf6'}}}
    ],
    legend:{position:'top'},grid:{borderColor:'#f1f5f9'},tooltip:{shared:true,intersect:false}
}).render();

var map = L.map('map').setView([-3.3, 114.6], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution:'© OpenStreetMap'}).addTo(map);
var lokasiData = @json($lokasiMap);
lokasiData.forEach(function(item) {
    if (!item.latitude || !item.longitude) return;
    var colorMap = {
        'Memenuhi Baku Mutu':'#10b981','Tercemar Ringan':'#f59e0b',
        'Tercemar Sedang':'#f97316','Tercemar Berat':'#ef4444','Belum Ada Data':'#94a3b8'
    };
    var color = colorMap[item.status_storet] || '#94a3b8';
    L.circleMarker([item.latitude, item.longitude], {color:color,fillColor:color,fillOpacity:0.85,radius:10,weight:2})
    .addTo(map)
    .bindPopup(
        '<b style="font-size:13px">'+item.nama_lokasi+'</b><br>'+
        '<small class="text-muted">'+(item.alamat_lokasi||'')+'</small><hr style="margin:6px 0">'+
        '<table style="font-size:12px;width:100%">'+
        '<tr><td><b>STORET</b></td><td><span style="color:'+(colorMap[item.status_storet]||'#94a3b8')+';font-weight:600">'+(item.status_storet||'-')+'</span></td></tr>'+
        '<tr><td><b>IP</b></td><td><span style="color:'+(colorMap[item.status_ip]||'#94a3b8')+';font-weight:600">'+(item.status_ip||'-')+'</span>'+(item.nilai_ip?'<small>('+item.nilai_ip+')</small>':'')+'</td></tr>'+
        '</table>'
    );
});
</script>
@endpush