@extends('layouts.sbadmin')

@section('title', $title)

@section('content')

    <h4 class="mb-4">{{ $title }}</h4>

    {{-- FILTER KHUSUS LAPORAN HASIL PER LOKASI --}}
    @if ($jenis == 'hasil-per-lokasi')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }} - {{ $l->alamat_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Periode Pemantauan</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>II</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Tahun Pemantauan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN REKAP TAHUNAN --}}
    @if ($jenis == 'rekap-tahunan')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Tahun Pemantauan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Periode Pemantauan</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>II</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN LOKASI RAWAN PENCEMARAN --}}
    @if ($jenis == 'lokasi-rawan-pencemaran')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }} - {{ $l->alamat_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>
                        <div class="col-md-2">
                            <label>Periode</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua --</option>
                                <option value="1" {{ request('periode') == '1' ? 'selected' : '' }}>I</option>
                                <option value="2" {{ request('periode') == '2' ? 'selected' : '' }}>II</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Total Pelanggaran</label>
                            <input type="number" name="total_pelanggaran" class="form-control"
                                value="{{ request('total_pelanggaran') }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN INDIKATOR MELEBIHI BAKU MUTU --}}
    @if ($jenis == 'indikator-melebihi-baku')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }} - {{ $l->alamat_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Periode</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == '1' ? 'selected' : '' }}>Periode I
                                </option>
                                <option value="2" {{ request('periode') == '2' ? 'selected' : '' }}>Periode II
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Parameter Uji</label>
                            <select name="indikator_id" class="form-control">
                                <option value="">-- Semua Parameter --</option>
                                @foreach (\App\Models\IndikatorUji::orderBy('nama_indikator')->get() as $ind)
                                    <option value="{{ $ind->id }}"
                                        {{ request('indikator_id') == $ind->id ? 'selected' : '' }}>
                                        {{ $ind->nama_indikator }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN STATUS MUTU AIR --}}
    @if ($jenis == 'status-mutu-air')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Tahun Pemantauan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Periode Pemantauan</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>Periode I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>Periode II</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN PARAMETER DOMINAN --}}
    @if ($jenis == 'parameter-dominan')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">

                        <div class="col-md-3">
                            <label>Tahun Pemantauan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Periode Pemantauan</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>Periode I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>Periode II</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">
                                Tampilkan
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN PERBANDINGAN PERUNTUKAN --}}
    @if ($jenis == 'perbandingan-peruntukan')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">

                        <div class="col-md-3">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Periode</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>II</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN TRN KUALITAS AIR --}}
    @if ($jenis == 'tren-kualitas-air')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">

                        {{-- TAHUN AWAL --}}
                        <div class="col-md-3">
                            <label>Tahun Awal</label>
                            <input type="number" name="tahun_awal" class="form-control"
                                value="{{ request('tahun_awal') }}">
                        </div>

                        {{-- TAHUN AKHIR --}}
                        <div class="col-md-3">
                            <label>Tahun Akhir</label>
                            <input type="number" name="tahun_akhir" class="form-control"
                                value="{{ request('tahun_akhir') }}">
                        </div>

                        {{-- PARAMETER --}}
                        <div class="col-md-3">
                            <label>Parameter</label>
                            <select name="indikator_id" class="form-control">
                                <option value="">-- Semua Parameter --</option>
                                @foreach (\App\Models\IndikatorUji::orderBy('nama_indikator')->get() as $ind)
                                    <option value="{{ $ind->id }}"
                                        {{ request('indikator_id') == $ind->id ? 'selected' : '' }}>
                                        {{ $ind->nama_indikator }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- LOKASI --}}
                        <div class="col-md-3">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- BUTTON --}}
                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN KINERJA PEMANTAUAN --}}
    @if ($jenis == 'kinerja-pemantauan')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}">
                        </div>
                        <div class="col-md-3">
                            <label>Periode</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>II</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- FILTER KHUSUS LAPORAN INDEKS PENCEMARAN --}}
    @if ($jenis == 'indeks-pencemaran')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">

                        <div class="col-md-3">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Tahun Pemantauan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Periode Pemantauan</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>Periode I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>Periode II</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif
    {{-- FILTER KHUSUS LAPORAN STORET --}}
    @if ($jenis == 'storet')
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET">
                    <div class="row">

                        <div class="col-md-3">
                            <label>Lokasi</label>
                            <select name="lokasi_id" class="form-control">
                                <option value="">-- Semua Lokasi --</option>
                                @foreach (\App\Models\Lokasi::orderBy('kode_lokasi')->get() as $l)
                                    <option value="{{ $l->id }}"
                                        {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->kode_lokasi }} - {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Tahun Pemantauan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Periode Pemantauan</label>
                            <select name="periode" class="form-control">
                                <option value="">-- Semua Periode --</option>
                                <option value="1" {{ request('periode') == 1 ? 'selected' : '' }}>Periode I</option>
                                <option value="2" {{ request('periode') == 2 ? 'selected' : '' }}>Periode II</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-primary">Tampilkan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- TOMBOL CETAK - CARA SEDERHANA DENGAN LINK LANGSUNG --}}
    <a href="{{ route('admin.laporan.cetak', $jenis) }}?{{ http_build_query(request()->query()) }}"
        class="btn btn-danger mb-3"
        onclick="notifCetak(event, this)">
        <i class="fas fa-file-pdf"></i> Cetak PDF
    </a>

    @if ($jenis == 'tren-kualitas-air' && count($data) > 0)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="font-weight-bold mb-3">Grafik Time-Series Kualitas Air</h6>
                <div style="height: 380px;">
                    <canvas id="trenKualitasChart"></canvas>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if (count($data) > 0)
                {{-- TABEL DINAMIS SESUAI DATA --}}
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            @foreach (array_keys((array) $data[0]) as $col)
                                <th>{{ ucfirst(str_replace('_', ' ', $col)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                @foreach ((array) $row as $key => $val)
                                    @if (in_array($key, ['nilai', 'baku_mutu']))
                                        <td>{{ (float) $val }}</td>
                                    @elseif($key === 'selisih')
                                        <td>{{ number_format($val, 2) }}</td>
                                    @else
                                        <td>{{ $val }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Tidak ada data untuk ditampilkan.</div>
            @endif
        </div>
    </div>
<script>
function notifCetak(e, el) {
    e.preventDefault();
    Swal.fire({
        icon: 'info',
        title: 'Mengunduh PDF...',
        text: 'File laporan sedang diunduh ke perangkat Anda.',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    }).then(() => {
        window.location.href = el.href;
    });
}
</script>

@if ($jenis == 'tren-kualitas-air' && count($data) > 0)
    @php
        $rows = collect($data);
        $labels = $rows
            ->map(fn($r) => $r->tahun . '-P' . $r->periode)
            ->unique()
            ->sort()
            ->values()
            ->all();

        $groups = $rows->groupBy(fn($r) => $r->lokasi . ' | ' . $r->parameter);
        $datasets = [];
        foreach ($groups as $seriesName => $seriesRows) {
            $seriesMap = [];
            foreach ($seriesRows as $seriesRow) {
                $seriesMap[$seriesRow->tahun . '-P' . $seriesRow->periode] = (float) $seriesRow->rata_nilai;
            }

            $datasets[] = [
                'label' => $seriesName,
                'data' => array_map(fn($label) => $seriesMap[$label] ?? null, $labels),
            ];
        }
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function() {
            const labels = @json($labels);
            const datasets = @json($datasets).map((set, idx) => {
                const colorPalette = [
                    '#1d4ed8', '#16a34a', '#dc2626', '#9333ea',
                    '#0f766e', '#ea580c', '#7c3aed', '#475569'
                ];
                const color = colorPalette[idx % colorPalette.length];

                return {
                    label: set.label,
                    data: set.data,
                    borderColor: color,
                    backgroundColor: color,
                    tension: 0.25,
                    spanGaps: true,
                    fill: false,
                };
            });

            new Chart(document.getElementById('trenKualitasChart'), {
                type: 'line',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Rata-rata Nilai' } },
                        x: { title: { display: true, text: 'Periode Waktu' } }
                    }
                }
            });
        })();
    </script>
@endif
@endsection
