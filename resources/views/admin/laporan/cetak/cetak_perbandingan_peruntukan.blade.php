<!DOCTYPE html>
<html>
<head>
    <style>
        @page { size: A4 landscape; margin: 15mm; }

        body { font-family: "Times New Roman"; font-size: 12px; }

        .kop { text-align:center; border-bottom:3px solid black; margin-bottom:10px; }
        .title { text-align:center; margin:10px 0; font-size:16px; }

        table { width:100%; border-collapse: collapse; }
        table, th, td { border:1px solid black; }
        th { background:#eee; }
        th, td { padding:6px; text-align:center; }

        .ttd { margin-top:40px; text-align:right; }
    </style>
</head>
<body>

<div class="kop">
    <strong>PEMERINTAH PROVINSI KALIMANTAN SELATAN</strong><br>
    <strong>DINAS LINGKUNGAN HIDUP</strong>
</div>

<div class="title">
    {{ strtoupper($title) }}
</div>

<p>
Tahun: {{ $tahun ?? 'Semua' }} <br>
Periode:
{{ $periode == 1 ? 'I' : ($periode == 2 ? 'II' : 'Semua') }}
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Peruntukan</th>
            <th>Jumlah Data</th>
            <th>Rata Nilai</th>
            <th>Jumlah Melampaui</th>
            <th>% Pelanggaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row->peruntukan }}</td>
            <td>{{ $row->jumlah_data }}</td>
            <td>{{ number_format($row->rata_nilai,2) }}</td>
            <td>{{ $row->jumlah_melampaui }}</td>
            <td>{{ $row->persen_pelanggaran }} %</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="ttd">
    <p>Banjarbaru, {{ now()->translatedFormat('d F Y') }}</p>
    <p>Kepala Dinas</p>
    <br><br><br>
    <strong><u>Rahmat Prapto Udoyo</u></strong>
</div>

</body>
</html>