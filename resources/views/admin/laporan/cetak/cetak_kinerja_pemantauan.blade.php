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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            background: #f0f0f0;
        }

        td,
        th {
            padding: 5px;
        }

        .footer-ttd {
            width: 100%;
            margin-top: 50px;
            text-align: right;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="kop-container">
        <img src="{{ public_path('logo-dlh.png') }}" class="kop-logo" alt="Logo DLH">
        <div class="kop-text">
            <strong>PEMERINTAH PROVINSI KALIMANTAN SELATAN</strong><br>
            <strong>DINAS LINGKUNGAN HIDUP</strong><br>
            Jalan Bangun Praja, Kel. Palam, Kec. Cempaka, Banjarbaru, Kalimantan Selatan 70732 <br>
            Telp/Faks: 0511-6749-241; Laman: www.dlh.kalselprov.go.id; Pos-el : blhdkalsel@gmail.com
        </div>
        <div class="clear"></div>
    </div>

    <h3 style="text-align:center; margin-top:15px;">LAPORAN KINERJA PEMANTAUAN</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Lokasi</th>
                <th>Lokasi</th>
                <th>Tahun</th>
                <th>Target Jadwal</th>
                <th>Realisasi</th>
                <th>Belum Terealisasi</th>
                <th>Capaian (%)</th>
                <th>Tepat Waktu (%)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->kode_lokasi }}</td>
                    <td>{{ $row->lokasi }}</td>
                    <td>{{ $row->tahun }}</td>
                    <td>{{ $row->target_jadwal }}</td>
                    <td>{{ $row->realisasi }}</td>
                    <td>{{ $row->belum_terealisasi }}</td>
                    <td>{{ number_format($row->capaian_persen, 2) }}</td>
                    <td>{{ number_format($row->tepat_waktu_persen, 2) }}</td>
                    <td>{{ $row->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
