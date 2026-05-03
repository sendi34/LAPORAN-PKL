<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Lokasi;

class LaporanController extends Controller
{
    /**
     * HALAMAN INDEX LAPORAN
     */
    public function show(Request $request, $jenis)
    {
        $lokasi = null;
        $tahun  = null;

        switch ($jenis) {

            case 'hasil-per-lokasi':
                $lokasi_id = $request->query('lokasi_id');
                $tahun     = $request->query('tahun');
                $periode   = $request->query('periode');
                $data = $this->laporanHasilPerLokasi($lokasi_id, $tahun, $periode);
                $title = "Laporan Hasil Uji per Lokasi";
                $viewCetak = 'admin.laporan.cetak.cetak_hasil_lokasi';
                if ($lokasi_id) {
                    $lokasi = Lokasi::find($lokasi_id);
                }
                break;

            case 'rekap-tahunan':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $data = $this->laporanRekapTahunan($tahun, $periode);
                $title = "Laporan Rekapitulasi Kualitas Air";
                $viewCetak = 'admin.laporan.cetak.cetak_rekap_tahunan';
                $lokasi = null;
                break;

         case 'lokasi-rawan-pencemaran':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $total_pelanggaran = $request->query('total_pelanggaran');
                $lokasi_id = $request->query('lokasi_id'); // TAMBAHKAN INI
                $data = $this->laporanLokasiRawanPencemaran($tahun, $periode, $total_pelanggaran, $lokasi_id);
                $title = "Laporan Lokasi Rawan Pencemaran";
                $viewCetak = 'admin.laporan.cetak.cetak_lokasi_rawan';
                break;

           case 'indikator-melebihi-baku':
                $tahun = $request->query('tahun');
                $lokasi_id = $request->query('lokasi_id');
                $periode = $request->query('periode');
                $indikator_id = $request->query('indikator_id'); // TAMBAHKAN INI
                $data = $this->laporanIndikatorMelebihiBaku($tahun, $lokasi_id, $periode, $indikator_id);
                $title = "Laporan Parameter Melebihi Baku Mutu";
                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }
                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }
                $viewCetak = 'admin.laporan.cetak.cetak_indikator_melebihi';
                break;
            
            case 'status-mutu-air':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');

                $data = $this->laporanStatusMutuAir($tahun, $periode);

                $title = "Laporan Status Mutu Air";
                $viewCetak = 'admin.laporan.cetak.cetak_status_mutu';

                break;

            case 'parameter-dominan':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');

                $data = $this->laporanParameterDominan($tahun, $periode);

                $title = "Laporan Parameter Dominan Tercemar";

                $viewCetak = 'admin.laporan.cetak.cetak_parameter_dominan';
                break;


            case 'perbandingan-peruntukan':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');

                $data = $this->laporanPerbandinganPeruntukan($tahun, $periode);

                $title = "Laporan Perbandingan Peruntukan Air Laut";

                $viewCetak = 'admin.laporan.cetak.cetak_perbandingan_peruntukan';
                break;

            case 'tren-kualitas-air':
                $tahun_awal   = $request->query('tahun_awal');
                $tahun_akhir  = $request->query('tahun_akhir');
                $indikator_id = $request->query('indikator_id');
                $lokasi_id    = $request->query('lokasi_id');
                $data = $this->laporanTrenKualitasAir($tahun_awal, $tahun_akhir, $indikator_id, $lokasi_id);
                $title = "Laporan Tren Kualitas Air";
                $viewCetak = 'admin.laporan.cetak.cetak_tren_kualitas';
                break;

            case 'indeks-pencemaran':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $lokasi_id = $request->query('lokasi_id');

                $data = $this->laporanIndeksPencemaran($tahun, $periode, $lokasi_id);

                $title = "Laporan Indeks Pencemaran";
                $viewCetak = 'admin.laporan.cetak.cetak_indeks_pencemaran';
                break;

            case 'storet':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $lokasi_id = $request->query('lokasi_id');

                $data = $this->laporanStoret($tahun, $periode, $lokasi_id);

                $title = "Laporan Metode STORET";
                $viewCetak = 'admin.laporan.cetak.cetak_storet';
                break;

            default:
                abort(404);
        }

        return view('admin.laporan.index', [
            'data'      => $data,
            'title'     => $title,
            'jenis'     => $jenis,
            'lokasi'    => $lokasi,
            'tahun'     => $tahun,
            
        ]);
    }

    /**
     * CETAK PDF
     */
    public function cetak(Request $request, $jenis)
    {
        $lokasi = null;
        $tahun  = null;
        $status_shu = null; 
        switch ($jenis) {

            case 'hasil-per-lokasi':
                $lokasi_id = $request->query('lokasi_id');
                $tahun     = $request->query('tahun');
                $periode   = $request->query('periode');
                $data = $this->laporanHasilPerLokasi($lokasi_id, $tahun, $periode);
                $title = "Laporan Hasil Uji per Lokasi (Tahunan)";
                $view  = 'admin.laporan.cetak.cetak_hasil_lokasi';
                if ($lokasi_id) {
                    $lokasi = Lokasi::find($lokasi_id);
                }
                break;

            case 'rekap-tahunan':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $data = $this->laporanRekapTahunan($tahun, $periode);
                $title = "Laporan Rekapitulasi Tahunan Kualitas Air";
                $view  = 'admin.laporan.cetak.cetak_rekap_tahunan';
                break;

         case 'lokasi-rawan-pencemaran':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $total_pelanggaran = $request->query('total_pelanggaran');
                $lokasi_id = $request->query('lokasi_id'); // TAMBAHKAN INI
                $data = $this->laporanLokasiRawanPencemaran($tahun, $periode, $total_pelanggaran, $lokasi_id);
                $title = "Laporan Lokasi Rawan Pencemaran";
                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }
                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }
                if ($total_pelanggaran) {
                    $title .= " - Total Pelanggaran: " . $total_pelanggaran;
                }
                $view  = 'admin.laporan.cetak.cetak_lokasi_rawan';
                break;

           case 'indikator-melebihi-baku':
                $tahun = $request->query('tahun');
                $lokasi_id = $request->query('lokasi_id');
                $periode = $request->query('periode');
                $indikator_id = $request->query('indikator_id'); // TAMBAHKAN INI
                $data = $this->laporanIndikatorMelebihiBaku($tahun, $lokasi_id, $periode, $indikator_id);
                $title = "Laporan Indikator Melebihi Baku Mutu";
                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }
                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }
                $view  = 'admin.laporan.cetak.cetak_indikator_melebihi';
                break;
            
            case 'status-mutu-air':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');

                $data = $this->laporanStatusMutuAir($tahun, $periode);

                $title = "Laporan Status Mutu Air";

                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }

                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }

                $view  = 'admin.laporan.cetak.cetak_status_mutu';
                break;

            case 'parameter-dominan':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');

                $data = $this->laporanParameterDominan($tahun, $periode);

                $title = "Laporan Parameter Dominan Tercemar";

                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }

                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }

                $view = 'admin.laporan.cetak.cetak_parameter_dominan';
                break;

            case 'perbandingan-peruntukan':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');

                $data = $this->laporanPerbandinganPeruntukan($tahun, $periode);

                $title = "Laporan Perbandingan Peruntukan Air Laut";

                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }

                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }

                $view = 'admin.laporan.cetak.cetak_perbandingan_peruntukan';
                break;

            case 'tren-kualitas-air':
                $tahun_awal   = $request->query('tahun_awal');
                $tahun_akhir  = $request->query('tahun_akhir');
                $indikator_id = $request->query('indikator_id');
                $lokasi_id    = $request->query('lokasi_id');
                $data = $this->laporanTrenKualitasAir($tahun_awal, $tahun_akhir, $indikator_id, $lokasi_id);
                $title = "Laporan Tren Kualitas Air";
                $view = 'admin.laporan.cetak.cetak_tren_kualitas';
                break;

            case 'indeks-pencemaran':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $lokasi_id = $request->query('lokasi_id');

                $data = $this->laporanIndeksPencemaran($tahun, $periode, $lokasi_id);

                $title = "Laporan Indeks Pencemaran";

                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }

                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }

                $view = 'admin.laporan.cetak.cetak_indeks_pencemaran';
                break;

            case 'storet':
                $tahun = $request->query('tahun');
                $periode = $request->query('periode');
                $lokasi_id = $request->query('lokasi_id');

                $data = $this->laporanStoret($tahun, $periode, $lokasi_id);

                $title = "Laporan Metode STORET";

                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }

                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }

                $view = 'admin.laporan.cetak.cetak_storet';
                break;

            default:
                abort(404);
        }

        $pdf = Pdf::loadView($view, [
            'data'      => $data,
            'title'     => $title,
            'lokasi'    => $lokasi,
            'tahun'     => $tahun,
            'periode'   => $periode ?? null,
            'status_shu' => $status_shu 
        ]);

       return $pdf->download($title . '.pdf');
    }

    // ============================================================
    // 1. LAPORAN HASIL UJI PER LOKASI 
    // ============================================================
    private function laporanHasilPerLokasi($lokasi_id = null, $tahun = null, $periode = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'lokasi.kode_lokasi',
            'lokasi.alamat_lokasi as alamat',
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',
            'indikator_uji.nama_indikator as parameter_uji',
            DB::raw('ROUND(hasil_uji.nilai, 2) as nilai'),
            'indikator_uji.satuan',
            DB::raw('ROUND(hasil_uji.baku_mutu, 2) as baku_mutu'),

            // ✅ Ambil langsung dari kolom status yang sudah tersimpan
            'hasil_uji.status',
        );

    if ($lokasi_id) {
        $q->where('observasi.location_id', $lokasi_id);
    }

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    return $q->orderBy('lokasi.kode_lokasi')->get();
}

    // ============================================================
    // 2. LAPORAN REKAPITULASI TAHUNAN KUALITAS AIR
    // ============================================================
    private function laporanRekapTahunan($tahun = null, $periode = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',
            'indikator_uji.nama_indikator as parameter',
            DB::raw('ROUND(AVG(hasil_uji.nilai), 2) as rata_nilai'),
        );

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    return $q->groupBy('tahun', 'periode', 'parameter')
             ->orderBy('tahun')
             ->orderBy('periode')
             ->orderBy('parameter')
             ->get();
}

    // ============================================================
    // 3. LAPORAN LOKASI PENCEMARAN
    // ============================================================
   private function laporanLokasiRawanPencemaran($tahun = null, $periode = null, $total_pelanggaran = null, $lokasi_id = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'lokasi.kode_lokasi',
            'lokasi.alamat_lokasi',
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',
            DB::raw('COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) AS total_pelanggaran'),
            DB::raw('COUNT(DISTINCT hasil_uji.indikator_id) AS jumlah_parameter'),
            DB::raw('ROUND(AVG(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN (hasil_uji.nilai - hasil_uji.baku_mutu) END), 2) AS rata_selisih'),
            DB::raw('ROUND(MAX(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN hasil_uji.nilai END), 2) AS nilai_tertinggi'),
            DB::raw('ROUND((COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) * 100.0 / COUNT(hasil_uji.id)), 2) AS persentase_pelanggaran'),
            DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN indikator_uji.nama_indikator END ORDER BY indikator_uji.nama_indikator SEPARATOR ", ") AS parameter_bermasalah')
        );

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    if ($lokasi_id) {
        $q->where('observasi.location_id', $lokasi_id);
    }

    $q->groupBy('lokasi.id', 'lokasi.kode_lokasi', 'lokasi.alamat_lokasi', 'observasi.tahun_pemantauan', 'observasi.periode_pemantauan');
    
    if ($total_pelanggaran !== null && $total_pelanggaran !== '') {
        $q->having('total_pelanggaran', '=', $total_pelanggaran);
    }
    
    $q->orderBy('total_pelanggaran', 'desc')
      ->orderBy('persentase_pelanggaran', 'desc');

    return $q->get();
}

    // ============================================================
    // 4. LAPORAN INDIKATOR MELEBIHI BAKU MUTU
    // ============================================================
    private function laporanIndikatorMelebihiBaku($tahun = null, $lokasi_id = null, $periode = null, $indikator_id = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'observasi.tahun_pemantauan AS tahun',
            'observasi.periode_pemantauan AS periode',
            'lokasi.alamat_lokasi',
            'indikator_uji.nama_indikator AS nama_parameter',
            'hasil_uji.nilai',
            'hasil_uji.baku_mutu',
            DB::raw('(hasil_uji.nilai - hasil_uji.baku_mutu) AS selisih'),
        )
        ->whereRaw('hasil_uji.nilai > hasil_uji.baku_mutu');

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($lokasi_id) {
        $q->where('observasi.location_id', $lokasi_id);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    // TAMBAHAN BARU: Filter Parameter/Indikator
    if ($indikator_id) {
        $q->where('hasil_uji.indikator_id', $indikator_id);
    }

    return $q->orderBy('observasi.tahun_pemantauan')
             ->orderBy('observasi.periode_pemantauan')
             ->orderBy('lokasi.alamat_lokasi')
             ->get();
}

// ============================================================
    // 5. LAPORAN INDIKATOR MELEBIHI BAKU MUTU
    // ============================================================
private function laporanStatusMutuAir($tahun = null, $periode = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        ->select(
            'lokasi.kode_lokasi',
            'lokasi.alamat_lokasi',
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',

            DB::raw('COUNT(hasil_uji.id) as jumlah_parameter'),

            DB::raw('COUNT(CASE 
                WHEN hasil_uji.nilai > hasil_uji.baku_mutu 
                THEN 1 END) as jumlah_melampaui'),

            DB::raw('ROUND(
                (COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) * 100.0 
                / COUNT(hasil_uji.id)), 2
            ) as persen_pelanggaran')
        );

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    $data = $q->groupBy(
            'lokasi.id',
            'lokasi.kode_lokasi',
            'lokasi.alamat_lokasi',
            'observasi.tahun_pemantauan',
            'observasi.periode_pemantauan'
        )
        ->orderBy('persen_pelanggaran', 'desc')
        ->get();

    // 🔥 TAMBAH STATUS
    foreach ($data as $row) {
        if ($row->persen_pelanggaran == 0) {
            $row->status = 'Baik';
        } elseif ($row->persen_pelanggaran <= 25) {
            $row->status = 'Tercemar Ringan';
        } elseif ($row->persen_pelanggaran <= 50) {
            $row->status = 'Tercemar Sedang';
        } else {
            $row->status = 'Tercemar Berat';
        }
    }

    return $data;
}

// ============================================================
    // 6. LAPORAN PARAMETER DOMINAN TERCEMAR
    // ============================================================
private function laporanParameterDominan($tahun = null, $periode = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'indikator_uji.nama_indikator as parameter',

            DB::raw('COUNT(CASE 
                WHEN hasil_uji.nilai > hasil_uji.baku_mutu 
                THEN 1 END) as jumlah_pelanggaran'),

            DB::raw('ROUND(AVG(
                CASE 
                    WHEN hasil_uji.nilai > hasil_uji.baku_mutu 
                    THEN (hasil_uji.nilai - hasil_uji.baku_mutu) 
                END
            ), 2) as rata_selisih')
        );

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    $data = $q->groupBy('indikator_uji.id', 'indikator_uji.nama_indikator')
        ->orderBy('jumlah_pelanggaran', 'desc')
        ->get();

    // 🔥 TAMBAH STATUS DOMINAN
    foreach ($data as $row) {
        if ($row->jumlah_pelanggaran >= 10) {
            $row->status = 'Dominan';
        } elseif ($row->jumlah_pelanggaran >= 5) {
            $row->status = 'Tinggi';
        } elseif ($row->jumlah_pelanggaran >= 1) {
            $row->status = 'Rendah';
        } else {
            $row->status = 'Tidak Ada';
        }
    }

    return $data;
}

// ============================================================
    // 7. LAPORAN PERBANDINGAN PERUNTUKAN
    // ============================================================
private function laporanPerbandinganPeruntukan($tahun = null, $periode = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'observasi.location_id', '=', 'lokasi.id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'lokasi.peruntukan',

            DB::raw('COUNT(hasil_uji.id) as jumlah_data'),

            DB::raw('ROUND(AVG(hasil_uji.nilai), 2) as rata_nilai'),

            DB::raw('COUNT(CASE 
                WHEN hasil_uji.nilai > hasil_uji.baku_mutu 
                THEN 1 END) as jumlah_melampaui'),

            DB::raw('ROUND(
                (COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) * 100.0 
                / COUNT(hasil_uji.id)), 2
            ) as persen_pelanggaran')
        );

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    return $q->groupBy('lokasi.peruntukan')
        ->orderBy('persen_pelanggaran', 'desc')
        ->get();
}

// ============================================================
    // 8. LAPORAN TREN KUALITAS AIR
    // ============================================================
private function laporanTrenKualitasAir(
    $tahun_awal = null, 
    $tahun_akhir = null, 
    $indikator_id = null, 
    $lokasi_id = null
) {
    $data = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id') // tambah join lokasi
        ->select(
            'observasi.tahun_pemantauan as tahun',
            'indikator_uji.nama_indikator as parameter',
            DB::raw('ROUND(AVG(hasil_uji.nilai), 4) as rata_nilai')
        )
        ->when($tahun_awal, fn($q) => $q->where('observasi.tahun_pemantauan', '>=', $tahun_awal))
        ->when($tahun_akhir, fn($q) => $q->where('observasi.tahun_pemantauan', '<=', $tahun_akhir))
        ->when($indikator_id, fn($q) => $q->where('hasil_uji.indikator_id', $indikator_id))
        ->when($lokasi_id, fn($q) => $q->where('observasi.location_id', $lokasi_id))
        ->groupBy('tahun', 'parameter')
        ->orderBy('parameter')
        ->orderBy('tahun')
        ->get();

    $result = [];
    $last = [];

    foreach ($data as $row) {
        $param = $row->parameter;

        if (!isset($last[$param])) {
            $row->trend = '-';
        } else {
            if ($row->rata_nilai > $last[$param]) {
                $row->trend = 'Naik';
            } elseif ($row->rata_nilai < $last[$param]) {
                $row->trend = 'Turun';
            } else {
                $row->trend = 'Stabil';
            }
        }

        $last[$param] = $row->rata_nilai;
        $result[] = $row;
    }

    return $result;
}

// ============================================================
    // 9. LAPORAN METODE INDEKS PENCEMARAN
    // ============================================================
private function laporanIndeksPencemaran($tahun = null, $periode = null, $lokasi_id = null)
{
    $data = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        ->select(
            'lokasi.id as lokasi_id',
            'lokasi.kode_lokasi',
            'lokasi.alamat_lokasi',
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',
            'hasil_uji.baku_mutu', 
            DB::raw('(hasil_uji.nilai / hasil_uji.baku_mutu) as ci_lij')
        );

    if ($tahun) {
        $data->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($periode) {
        $data->where('observasi.periode_pemantauan', $periode);
    }

    if ($lokasi_id) {
    $data->where('observasi.location_id', $lokasi_id);
    }

    $data = $data->get();

    // GROUP PER LOKASI
   $grouped = $data->groupBy(function ($item) {
    return $item->lokasi_id . '-' . $item->tahun . '-' . $item->periode;
});

    $result = [];

    foreach ($grouped as $lokasi_id => $rows) {

        $ci_values = [];

        foreach ($rows as $row) {
            if ($row->baku_mutu > 0) {
                $ci_values[] = $row->ci_lij;
            }
        }

        if (count($ci_values) == 0) continue;

        $rata = array_sum($ci_values) / count($ci_values);
        $max  = max($ci_values);

        // RUMUS PI
        $pi = sqrt((pow($max, 2) + pow($rata, 2)) / 2);

        // STATUS
        if ($pi <= 1) {
            $status = 'Memenuhi Baku Mutu';
        } elseif ($pi <= 5) {
            $status = 'Tercemar Ringan';
        } elseif ($pi <= 10) {
            $status = 'Tercemar Sedang';
        } else {
            $status = 'Tercemar Berat';
        }

        $first = $rows->first();

        $result[] = (object)[
            'kode_lokasi' => $first->kode_lokasi,
            'alamat_lokasi' => $first->alamat_lokasi,
            'tahun' => $first->tahun,
            'periode' => $first->periode,
            'rata_ci_lij' => round($rata, 3),
            'max_ci_lij' => round($max, 3),
            'nilai_pi' => round($pi, 3),
            'status' => $status
        ];
    }

    return collect($result)->sortByDesc('nilai_pi')->values();
}
// ============================================================
    // 10. LAPORAN METODE STORET
    // ============================================================
private function laporanStoret($tahun = null, $periode = null, $lokasi_id = null)
{
    $q = DB::table('hasil_uji')
        ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
        ->select(
            'lokasi.id as lokasi_id',
            'lokasi.kode_lokasi',
            'lokasi.alamat_lokasi',
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',
            'hasil_uji.nilai',
            'hasil_uji.baku_mutu',
            'indikator_uji.nama_indikator as parameter'
        )
        ->whereNotNull('hasil_uji.baku_mutu')
        ->where('hasil_uji.baku_mutu', '>', 0);

    if ($tahun)     $q->where('observasi.tahun_pemantauan', $tahun);
    if ($periode)   $q->where('observasi.periode_pemantauan', $periode);
    if ($lokasi_id) $q->where('observasi.location_id', $lokasi_id);

    $rawData = $q->orderBy('lokasi.kode_lokasi')->get();

    $grouped = $rawData->groupBy(function ($item) {
        return $item->lokasi_id . '-' . $item->tahun . '-' . $item->periode;
    });

    $result = [];

    foreach ($grouped as $key => $rows) {
        $first            = $rows->first();
        $skor             = 0;
        $jumlah_melanggar = 0;
        $jumlah_data      = $rows->count();

        foreach ($rows as $row) {
            if ($row->nilai > $row->baku_mutu) {
                // Kimia, Kepmen LH 115/2003
                $skor -= ($jumlah_data < 10) ? 2 : 4;
                $jumlah_melanggar++;
            }
        }

        if ($skor == 0)        { $kelas = 'A'; $status = 'Memenuhi Baku Mutu'; }
        elseif ($skor >= -10)  { $kelas = 'B'; $status = 'Tercemar Ringan'; }
        elseif ($skor >= -30)  { $kelas = 'C'; $status = 'Tercemar Sedang'; }
        else                   { $kelas = 'D'; $status = 'Tercemar Berat'; }

        $result[] = (object)[
            'kode_lokasi'      => $first->kode_lokasi,
            'alamat_lokasi'    => $first->alamat_lokasi,
            'tahun'            => $first->tahun,
            'periode'          => $first->periode,
            'jumlah_parameter' => $rows->count(),
            'jumlah_melanggar' => $jumlah_melanggar,
            'skor_storet'      => $skor,
            'kelas'            => $kelas,
            'status'           => $status,
        ];
    }

    return collect($result)->sortBy('skor_storet')->values();
}
}