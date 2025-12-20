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

           case 'aktivitas-petugas':
                $tahun = $request->query('tahun');
                $petugas_id = $request->query('petugas_id');
                $periode = $request->query('periode');
                $data = $this->laporanAktivitasPetugas($tahun, $petugas_id, $periode);
                $title = "Laporan Aktivitas Petugas";
                $viewCetak = 'admin.laporan.cetak.cetak_aktivitas_petugas';
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
                $title = "Laporan Indikator Melebihi Baku Mutu";
                if ($tahun) {
                    $title .= " Tahun " . $tahun;
                }
                if ($periode) {
                    $title .= " Periode " . ($periode == 1 ? 'I' : 'II');
                }
                $viewCetak = 'admin.laporan.cetak.cetak_indikator_melebihi';
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

            case 'aktivitas-petugas':
                $tahun = $request->query('tahun');
                $petugas_id = $request->query('petugas_id');
                $periode = $request->query('periode');
                $data = $this->laporanAktivitasPetugas($tahun, $petugas_id, $periode);
                $title = "Laporan Aktivitas Petugas per Tahun";
                $view  = 'admin.laporan.cetak.cetak_aktivitas_petugas';
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
            'hasil_uji.nilai',
            'indikator_uji.satuan',
            'indikator_uji.baku_mutu',
            DB::raw("IF(hasil_uji.nilai > indikator_uji.baku_mutu, 'Melebihi Baku Mutu', 'Sesuai') AS status")
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
    // 3. LAPORAN AKTIVITAS PETUGAS PER TAHUN
    // ============================================================
   private function laporanAktivitasPetugas($tahun = null, $petugas_id = null, $periode = null)
{
    $q = DB::table('observasi')
        ->join('users', 'users.id', '=', 'observasi.user_id')
        ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
        
        // JOIN dengan hasil_uji untuk memastikan hanya yang sudah ada hasil ujinya
        ->leftJoin('hasil_uji', 'hasil_uji.observasi_id', '=', 'observasi.id')
        
        ->select(
            'users.nama',
            'observasi.tahun_pemantauan as tahun',
            'observasi.periode_pemantauan as periode',
            
            // Total observasi (termasuk yang belum ada hasil uji)
            DB::raw('COUNT(DISTINCT observasi.id) AS jumlah_observasi'),
            
            // Hanya lokasi yang SUDAH ADA hasil ujinya
            DB::raw('COUNT(DISTINCT CASE WHEN hasil_uji.id IS NOT NULL THEN lokasi.id END) AS jumlah_lokasi_sudah_diuji')
        );

    if ($tahun) {
        $q->where('observasi.tahun_pemantauan', $tahun);
    }

    if ($petugas_id) {
        $q->where('users.id', $petugas_id);
    }

    if ($periode) {
        $q->where('observasi.periode_pemantauan', $periode);
    }

    return $q->groupBy('users.id', 'observasi.tahun_pemantauan', 'observasi.periode_pemantauan')
             ->orderBy('users.nama')
             ->orderBy('observasi.tahun_pemantauan', 'desc')
             ->orderBy('observasi.periode_pemantauan')
             ->get();
}

    // ============================================================
    // 4. LAPORAN LOKASI BERDASARKAN SHU (FIXED!)
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
            DB::raw('COUNT(CASE WHEN hasil_uji.nilai > indikator_uji.baku_mutu THEN 1 END) AS total_pelanggaran'),
            DB::raw('COUNT(DISTINCT hasil_uji.indikator_id) AS jumlah_parameter'),
            DB::raw('ROUND(AVG(CASE WHEN hasil_uji.nilai > indikator_uji.baku_mutu THEN (hasil_uji.nilai - indikator_uji.baku_mutu) END), 2) AS rata_selisih'),
            DB::raw('ROUND(MAX(CASE WHEN hasil_uji.nilai > indikator_uji.baku_mutu THEN hasil_uji.nilai END), 2) AS nilai_tertinggi'),
            DB::raw('ROUND((COUNT(CASE WHEN hasil_uji.nilai > indikator_uji.baku_mutu THEN 1 END) * 100.0 / COUNT(hasil_uji.id)), 2) AS persentase_pelanggaran'),
            DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN hasil_uji.nilai > indikator_uji.baku_mutu THEN indikator_uji.nama_indikator END ORDER BY indikator_uji.nama_indikator SEPARATOR ", ") AS parameter_bermasalah')
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
    // 5. LAPORAN INDIKATOR MELEBIHI BAKU MUTU
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
            'indikator_uji.baku_mutu',
            DB::raw('(hasil_uji.nilai - indikator_uji.baku_mutu) AS selisih'),
        )
        ->whereRaw('hasil_uji.nilai > indikator_uji.baku_mutu');

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
}