<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }

        /* KOP SURAT */
        .kop-container {
            width: 100%;
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .kop-logo {
            float: left;
            width: 70px;
        }

        .kop-text {
            font-size: 14px;
            line-height: 1.3;
        }

        .clear {
            clear: both;
        }

        /* JUDUL */
        .title {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        /* TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #f0f0f0;
        }

        th, td {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>

<body>

<div class="kop-container">
    <img src="{{ public_path('logo-dlh.png') }}" class="kop-logo">

    <div class="kop-text">
        <strong>PEMERINTAH PROVINSI KALIMANTAN SELATAN</strong><br>
        <strong>DINAS LINGKUNGAN HIDUP</strong><br>
        Jalan Bangun Praja, Kel. Palam, Kec. Cempaka, Banjarbaru, Kalimantan Selatan 70732 <br>
        (Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan) <br>
        Telp/Faks: 0511-6749-241 <br>
        Laman: www.dlh.kalselprov.go.id <br>
        Email: blhdkalsel@gmail.com
    </div>

    <div class="clear"></div>
</div>

<h3 class="title">
    LAPORAN STATUS MUTU AIR
</h3>

<!-- (OPSIONAL TAPI BAGUS) INFO FILTER -->
<p>
    Tahun: {{ $tahun ?? 'Semua' }} <br>
    Periode: 
    @if($periode == 1)
        I
    @elseif($periode == 2)
        II
    @else
        Semua
    @endif
</p>

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
            <th>Status Mutu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $row)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td class="text-center">{{ $row->kode_lokasi }}</td>
            <td>{{ $row->alamat_lokasi }}</td>
            <td class="text-center">
                {{ $row->tahun }} - {{ $row->periode == 1 ? 'I' : 'II' }}
            </td>
            <td class="text-center">{{ $row->jumlah_parameter }}</td>
            <td class="text-center">{{ $row->jumlah_melampaui }}</td>
            <td class="text-center">{{ number_format($row->persen_pelanggaran,2) }}%</td>
            <td class="text-center"><strong>{{ $row->status }}</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Banjarbaru, {{ now()->translatedFormat('d F Y') }}</p>
    <p>Kepala Dinas Lingkungan Hidup,</p>

    <br><br><br>

    <strong><u>Rahmat Prapto Udoyo, S.Hut, MP</u></strong><br>
    Pembina Utama Muda (IV/c)<br>
    NIP. 19691212 199212 1 004
</div>

</body>
</html>