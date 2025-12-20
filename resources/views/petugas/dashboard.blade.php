@extends('layouts.sbadmin')
@section('title', 'Dashboard Petugas')
@section('content')
<h1 class="h3 mb-4">Dashboard Petugas</h1>

{{-- FORM FILTER TAHUN --}}
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="GET" class="form-inline">
            <label class="mr-2">Filter Tahun:</label>
            <input type="number" name="tahun" class="form-control mr-2" value="{{ $tahun }}" placeholder="Tahun" style="width: 150px;">
            <button class="btn btn-primary">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>
    </div>
</div>

{{-- GRAFIK 1 - DENGAN TRANSFORMASI SQRT --}}
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <i class=""></i> Grafik Rata-rata Nilai Uji per Indikator (Tahun {{ $tahun }})
    </div>
    <div class="card-body">
        <div id="chartRataIndikator"></div>
    </div>
</div>

{{-- GRAFIK 2 --}}
<div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
        Jumlah Observasi per Lokasi (Tahun {{ $tahun }})
    </div>
    <div class="card-body">
        <div id="chartObservasiLokasi"></div>
    </div>
</div>

{{-- GRAFIK 3 --}}
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        Diagram SHU vs Tidak SHU ({{ $tahun }})
    </div>
    <div class="card-body">
        <div id="chartSHU"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
/* ----------------------------------------------------
    GRAFIK 1: Dengan Square Root Transformation
---------------------------------------------------- */
var indikatorLabels = @json($rataIndikator->pluck('nama_indikator'));
var indikatorNilai = @json($rataIndikator->pluck('rata_nilai'));
var indikatorBaku = @json($rataIndikator->pluck('baku_mutu'));

// Transformasi: sqrt untuk visualisasi, simpan nilai asli
var transformedData = indikatorNilai.map((nilai, index) => {
    var original = parseFloat(nilai);
    return {
        x: indikatorLabels[index],
        y: Math.sqrt(original),  // Transform dengan sqrt
        original: original,       // Simpan nilai asli
        bakuMutu: parseFloat(indikatorBaku[index])
    };
});

var avgOptions = {
    chart: { 
        type: 'bar', 
        height: 450,
        toolbar: { show: true }
    },
    series: [{
        name: 'Rata-rata',
        data: transformedData
    }],
    xaxis: {
        type: 'category',
        labels: {
            style: {
                fontSize: '11px'
            }
        }
    },
    yaxis: {
        min: 0,                    // MULAI DARI 0 - tidak mengambang!
        forceNiceScale: true,
        title: {
            text: 'mg/L',
            style: {
                fontSize: '12px',
                fontWeight: 600
            }
        },
        labels: {
            formatter: function(val) {
                // Konversi balik ke nilai asli untuk label Y
                var original = val * val;
                if (original < 0.01) return original.toFixed(4);
                if (original < 1) return original.toFixed(3);
                if (original < 10) return original.toFixed(2);
                return original.toFixed(1);
            }
        }
    },
    plotOptions: {
        bar: {
            columnWidth: '65%',
            borderRadius: 4,
            dataLabels: {
                position: 'top'
            }
        }
    },
    dataLabels: {
        enabled: true,
        offsetY: -20,
        formatter: function(val, opts) {
            // Tampilkan nilai ASLI di label
            var original = opts.w.config.series[0].data[opts.dataPointIndex].original;
            if (original < 0.01) return original.toFixed(4);
            if (original < 1) return original.toFixed(3);
            if (original < 10) return original.toFixed(2);
            return original.toFixed(1);
        },
        style: {
            fontSize: '12px',
            fontWeight: 'bold',
            colors: ['#304758']
        },
        background: {
            enabled: true,
            foreColor: '#fff',
            padding: 4,
            borderRadius: 2,
            borderWidth: 1,
            borderColor: '#1E90FF',
            opacity: 0.95
        }
    },
    colors: ['#1E90FF'],
    grid: {
        borderColor: '#e7e7e7',
        strokeDashArray: 3
    },
    tooltip: {
        custom: function({series, seriesIndex, dataPointIndex, w}) {
            var data = w.config.series[seriesIndex].data[dataPointIndex];
            return '<div class="p-2" style="background: #304758; color: white; border-radius: 4px;">' +
                   '<strong>' + data.x + '</strong><br>' +
                   'Nilai: <strong>' + data.original.toFixed(4) + ' mg/L</strong><br>' +
                   '</div>';
        }
    }
};
new ApexCharts(document.querySelector("#chartRataIndikator"), avgOptions).render();

/* ----------------------------------------------------
    GRAFIK 2: Observasi per Lokasi
---------------------------------------------------- */
var lokasiOptions = {
    chart: { type: 'bar', height: 350 },
    series: [{
        name: 'Jumlah Observasi',
        data: @json($observasiLokasi->pluck('total'))
    }],
    xaxis: {
        categories: @json($observasiLokasi->pluck('alamat'))
    },
    dataLabels: { enabled: true },
    colors: ['#FF8C00']
};
new ApexCharts(document.querySelector("#chartObservasiLokasi"), lokasiOptions).render();

/* ----------------------------------------------------
    GRAFIK 3: SHU vs Tidak SHU
---------------------------------------------------- */
var shuOptions = {
    chart: { type: 'pie', height: 350 },
    labels: ['ADA SHU', 'TIDAK ADA SHU'],
    series: [{{ $shuData->ada_shu }}, {{ $shuData->tidak_shu }}],
    colors: ['#28A745', '#DC3545']
};
new ApexCharts(document.querySelector("#chartSHU"), shuOptions).render();
</script>
@endpush