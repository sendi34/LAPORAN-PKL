<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 13px;
            margin: 20px 40px;
        }

        .kop-container {
            width: 100%;
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
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

        .title {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #f0f0f0;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        .footer-ttd {
            width: 100%;
            margin-top: 50px;
            text-align: right;
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

    <!-- JUDUL -->
    <h3 style="text-align:center;">
        LAPORAN PARAMETER DOMINAN
    </h3>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Parameter</th>
                <th>Jumlah Pelanggaran</th>
                <th>Rata Selisih</th>
                <th>Status Dominan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="text-left">{{ $row->parameter }}</td>
                <td>{{ $row->jumlah_pelanggaran }}</td>
                <td>{{ number_format($row->rata_selisih, 2) }}</td>
                <td>{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TTD -->
    <div class="footer-ttd">
        <p>Banjarbaru, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Kepala Dinas Lingkungan Hidup,</p>
        <br><br><br><br>
        <strong><u>Rahmat Prapto Udoyo, S.Hut, MP</u></strong><br>
        Pembina Utama Muda (IV/c)<br>
        NIP. 19691212 199212 1 004
    </div>

</body>
</html>