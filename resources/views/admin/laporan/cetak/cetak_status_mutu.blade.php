<!DOCTYPE html>
<html>
<head>
    <style>
        @page { size: A4 landscape; margin: 15mm; }

        body {
            font-family:"Times New Roman", serif;
            font-size:13px;
            margin:20px 40px;
        }

        .kop-container {
            width:100%;
            text-align:center;
            border-bottom:3px solid black;
            padding-bottom:10px;
            margin-bottom:20px;
        }

        .kop-logo { float:left; width:70px; }

        .kop-text { font-size:14px; line-height:1.3; }

        .clear { clear:both; }

        table {
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
            font-size:12px;
        }

        table, th, td { border:1px solid black; }

        th { background:#f0f0f0; }

        th, td { padding:5px; text-align:center; }

        .footer-ttd {
            margin-top:50px;
            text-align:right;
        }
    </style>
</head>

<body>

 <!-- KOP SURAT -->
    <div class="kop-container">
        <img src="{{ public_path('logo-dlh.png') }}" class="kop-logo" alt="Logo DLH">
        <div class="kop-text">
            <strong>PEMERINTAH PROVINSI KALIMANTAN SELATAN</strong><br>
            <strong>DINAS LINGKUNGAN HIDUP</strong><br>
            Jalan Bangun Praja, Kel. Palam, Kec. Cempaka, Banjarbaru, Kalimantan Selatan 70732 <br> (Kawasan Perkantoran
            Pemerintah Provinsi Kalimantan Selatan) <br>
            Telp/Faks: 0511-6749-241; Laman: www.dlh.kalselprov.go.id; Pos-el : blhdkalsel@gmail.com
        </div>
        <div class="clear"></div>
    </div>

<h3 style="text-align:center;">LAPORAN STATUS MUTU AIR</h3>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Kode Lokasi</th>
    <th>Alamat</th>
    <th>Tahun - Periode</th>
    <th>Jumlah Parameter</th>
    <th>Jumlah Melampaui</th>
    <th>% Pelanggaran</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
@foreach($data as $i => $row)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $row->kode_lokasi }}</td>
    <td>{{ $row->alamat_lokasi }}</td>
    <td>{{ $row->tahun }} - {{ $row->periode == 1 ? 'I' : 'II' }}</td>
    <td>{{ $row->jumlah_parameter }}</td>
    <td>{{ $row->jumlah_melampaui }}</td>
    <td>{{ number_format($row->persen_pelanggaran,2) }}%</td>
    <td><strong>{{ $row->status }}</strong></td>
</tr>
@endforeach
</tbody>
</table>

<div class="footer-ttd">
    <p>Banjarbaru, {{ now()->translatedFormat('d F Y') }}</p>
    <p>Kepala Dinas Lingkungan Hidup</p>

    <br><br><br><br>

    <strong><u>Rahmat Prapto Udoyo, S.Hut, MP</u></strong>
</div>

</body>
</html>