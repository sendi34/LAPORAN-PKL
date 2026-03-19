<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px 20px;
            }
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
            text-align: center;
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
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

        .title {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <!-- KOP -->
    <div class="kop-container">
        <img src="{{ public_path('logo-dlh.png') }}" class="kop-logo">
        <div class="kop-text">
            <strong>PEMERINTAH PROVINSI KALIMANTAN SELATAN</strong><br>
            <strong>DINAS LINGKUNGAN HIDUP</strong><br>
            Jalan Bangun Praja, Kel. Palam, Kec. Cempaka, Banjarbaru<br>
            Telp: 0511-6749-241
        </div>
        <div class="clear"></div>
    </div>

    <!-- JUDUL -->
    <h3 style="text-align:center; margin-top:15px;">
        LAPORAN TREN KUALITAS AIR
    </h3>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Parameter</th>
                <th>Rata Nilai</th>
                <th>Trend</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->tahun }}</td>
                    <td>{{ $row->parameter }}</td>
                    <td>{{ number_format($row->rata_nilai, 4) }}</td>
                    <td>
                        @if($row->trend == 'Naik')
                            Naik
                        @elseif($row->trend == 'Turun')
                            Turun
                        @else
                            Stabil
                        @endif
                    </td>
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