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
            text-align: center;
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
        LAPORAN INDEKS PENCEMARAN
    </h3>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Lokasi</th>
                <th>Alamat Lokasi</th>
                <th>Tahun - Periode</th>
                <th>Rata Ci/Lij</th>
                <th>Max Ci/Lij</th>
                <th>Nilai PI</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->kode_lokasi }}</td>
                    <td style="text-align:left;">{{ $row->alamat_lokasi }}</td>
                    <td>{{ $row->tahun }} - {{ $row->periode == 1 ? 'I' : 'II' }}</td>
                    <td>{{ $row->rata_ci_lij }}</td>
                    <td>{{ $row->max_ci_lij }}</td>
                    <td>{{ $row->nilai_pi }}</td>
                    <td>
                        @if ($row->status == 'Memenuhi Baku Mutu')
                            <span style="color:green;font-weight:bold">Memenuhi Baku Mutu</span>
                        @elseif ($row->status == 'Tercemar Ringan')
                            <span style="color:#856404;font-weight:bold">Tercemar Ringan</span>
                        @elseif ($row->status == 'Tercemar Sedang')
                            <span style="color:#fd7e14;font-weight:bold">Tercemar Sedang</span>
                        @else
                            <span style="color:red;font-weight:bold">Tercemar Berat</span>
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
