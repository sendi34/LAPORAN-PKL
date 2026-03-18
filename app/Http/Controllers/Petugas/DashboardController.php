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
        | A. NILAI UJI BERDASARKAN PERUNTUKAN
        |--------------------------------------------------------------------------
        */
        $nilaiIndikator = DB::table('hasil_uji')
            ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
            ->join('observasi', 'observasi.id', '=', 'hasil_uji.observasi_id')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->where('observasi.user_id', $user)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'indikator_uji.nama_indikator',
                'hasil_uji.nilai',
                'lokasi.peruntukan'
            )
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
        | C. DATA LOKASI UNTUK PETA
        |--------------------------------------------------------------------------
        */
        $lokasiMap = DB::table('lokasi')
            ->join('observasi', 'observasi.location_id', '=', 'lokasi.id')
            ->where('observasi.user_id', $user)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'lokasi.nama_lokasi',
                'lokasi.alamat_lokasi',
                'lokasi.latitude',
                'lokasi.longitude'
            )
            ->distinct()
            ->get();


        return view('petugas.dashboard', [
            'tahun'           => $tahun,
            'nilaiIndikator'  => $nilaiIndikator,
            'observasiLokasi' => $observasiLokasi,
            'lokasiMap'       => $lokasiMap
        ]);
    }
}