<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));
        $user = auth()->user()->id;

        /*
        |--------------------------------------------------------------------------
        | A. GRAFIK RATA-RATA NILAI UJI PER INDIKATOR
        |--------------------------------------------------------------------------
        */
        $rataIndikator = DB::table('hasil_uji')
            ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
            ->join('observasi', 'observasi.id', '=', 'hasil_uji.observasi_id')
            ->where('observasi.user_id', $user)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'indikator_uji.nama_indikator',
                DB::raw('COALESCE(AVG(hasil_uji.nilai), 0) AS rata_nilai'),
                'indikator_uji.baku_mutu'
            )
            ->groupBy('indikator_uji.nama_indikator', 'indikator_uji.baku_mutu')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | B. GRAFIK JUMLAH OBSERVASI PER LOKASI
        |--------------------------------------------------------------------------
        */
        $observasiLokasi = DB::table('observasi')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->where('observasi.user_id', $user)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'lokasi.alamat_lokasi AS alamat',
                DB::raw('COUNT(observasi.id) as total')
            )
            ->groupBy('lokasi.alamat_lokasi')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | C. PIE CHART — LOKASI ADA SHU vs TIDAK ADA SHU
        | FIX: Kolom shu adalah ENUM('ADA SHU', 'TIDAK ADA SHU'), bukan NULL
        |--------------------------------------------------------------------------
        */
        $shuData = DB::table('observasi')
            ->where('user_id', $user)
            ->where('tahun_pemantauan', $tahun)
            ->select(
                DB::raw("SUM(CASE WHEN shu = 'ADA SHU' THEN 1 ELSE 0 END) AS ada_shu"),
                DB::raw("SUM(CASE WHEN shu = 'TIDAK ADA SHU' THEN 1 ELSE 0 END) AS tidak_shu")
            )
            ->first();

        return view('petugas.dashboard', [
            'tahun'          => $tahun,
            'rataIndikator'  => $rataIndikator,
            'observasiLokasi'=> $observasiLokasi,
            'shuData'        => $shuData,
        ]);
    }
}