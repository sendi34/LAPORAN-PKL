<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Observasi;
use App\Models\IndikatorUji;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));

        // NILAI UJI BERDASARKAN PERUNTUKAN
        $nilaiPerIndikator = DB::table('hasil_uji')
            ->join('indikator_uji','hasil_uji.indikator_id','=','indikator_uji.id')
            ->join('observasi','hasil_uji.observasi_id','=','observasi.id')
            ->join('lokasi','observasi.location_id','=','lokasi.id')
            ->select(
                'indikator_uji.nama_indikator',
                'hasil_uji.nilai',
                'lokasi.peruntukan'
            )
            ->whereYear('observasi.tanggal_pemantauan',$tahun)
            ->get();

        // OBSERVASI PER LOKASI
        $obsPerLokasi = Observasi::select(
                'lokasi.nama_lokasi',
                DB::raw('COUNT(*) AS jumlah')
            )
            ->join('lokasi','observasi.location_id','=','lokasi.id')
            ->whereYear('observasi.tanggal_pemantauan', $tahun)
            ->groupBy('observasi.location_id','lokasi.nama_lokasi')
            ->get();

        // DATA LOKASI UNTUK PETA
        $lokasiMap = Lokasi::select(
                'id',
                'nama_lokasi',
                'alamat_lokasi',
                'latitude',
                'longitude'
            )->get();

        // CARD SUMMARY
        $totalLokasi = Lokasi::count();
        $totalPetugas = User::where('role','petugas')->count();
        $totalIndikator = IndikatorUji::count();
        $totalObservasi = Observasi::count();

        return view('admin.dashboard', compact(
            'tahun',
            'nilaiPerIndikator',
            'obsPerLokasi',
            'lokasiMap',
            'totalLokasi',
            'totalPetugas',
            'totalIndikator',
            'totalObservasi'
        ));
    }
}