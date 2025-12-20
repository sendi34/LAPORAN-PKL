<!DOCTYPE html>
<html>

<head>
    <style>
        /* Pengaturan orientasi landscape untuk cetak */
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
            text-align: center;
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
            font-weight: bold;
            padding: 8px 5px;
        }

        td {
            padding: 6px 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }

        .badge-warning {
            background: #ffc107;
            color: #000;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }

        .footer-ttd {
            width: 100%;
            margin-top: 30px;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .info-box p {
            margin: 3px 0;
            font-size: 11px;
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
            Jalan Bangun Praja, Kel. Palam, Kec. Cempaka, Banjarbaru, Kalimantan Selatan 70732 <br>
            (Kawasan Perkantoran Pemerintah Provinsi Kalimantan Selatan) <br>
            Telp/Faks: 0511-6749-241; Laman: www.dlh.kalselprov.go.id; Pos-el : blhdkalsel@gmail.com
        </div>
        <div class="clear"></div>
    </div>

    <!-- JUDUL -->
    <h3 style="text-align:center; margin-top:15px; margin-bottom: 5px;">
        LAPORAN LOKASI RAWAN PENCEMARAN
    </h3>


    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 8%;">Kode Lokasi</th>
                <th style="width: 18%;">Alamat Lokasi</th>
                <th style="width: 5%;">Tahun - Periode</th>
                <th style="width: 7%;">Total Pelanggaran</th>
                <th style="width: 7%;">% Pelanggaran</th>
                <th style="width: 7%;">Jumlah Parameter</th>
                <th style="width: 8%;">Rata Selisih</th>
                <th style="width: 31%;">Parameter Bermasalah</th>
            </tr>
        </thead>

        <tbody>
            @if ($data->count() > 0)
                @php $no = 1; @endphp
                @foreach ($data as $row)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center"><strong>{{ $row->kode_lokasi }}</strong></td>
                        <td>{{ $row->alamat_lokasi }}</td>
                        <td>{{ $row->tahun }} - {{ $row->periode == 1 ? 'I' : 'II' }}</td>
                        <td class="text-center">{{ $row->total_pelanggaran }}</td>
                        <td class="text-center">
                            <strong>{{ number_format($row->persentase_pelanggaran, 1) }}%</strong>
                        </td>
                        <td class="text-center">{{ $row->jumlah_parameter }}</td>
                        <td class="text-right">{{ number_format($row->rata_selisih, 2) }}</td>
                        <td style="font-size: 10px;">{{ $row->parameter_bermasalah }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center" style="padding: 20px;">
                        <em>Tidak ada lokasi rawan pencemaran dalam periode ini</em>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($data->count() > 0)
    @endif
    <!-- TANDA TANGAN -->
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
