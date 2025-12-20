<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Observasi;
use App\Models\HasilUji;
use App\Models\IndikatorUji;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // UBAH INI - Gunakan 'tahun' sama seperti petugas
        $tahun = $request->query('tahun', date('Y'));
        
        // 1) RATA-RATA NILAI PER INDIKATOR
        $avgPerIndikator = HasilUji::select(
                'indikator_uji.nama_indikator',
                DB::raw('COALESCE(AVG(hasil_uji.nilai), 0) AS rata'),
                'indikator_uji.baku_mutu'
            )
            ->join('indikator_uji', 'hasil_uji.indikator_id', '=', 'indikator_uji.id')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->whereYear('observasi.tanggal_pemantauan', $tahun) // Ubah $year jadi $tahun
            ->groupBy('hasil_uji.indikator_id', 'indikator_uji.nama_indikator', 'indikator_uji.baku_mutu')
            ->get()
            ->map(function ($row) {
                $row->rata = floatval($row->rata);
                return $row;
            });

        // 2) JUMLAH OBSERVASI PER LOKASI
        $obsPerLokasi = Observasi::select(
                'lokasi.nama_lokasi',
                DB::raw('COUNT(*) AS jumlah')
            )
            ->join('lokasi','observasi.location_id','=','lokasi.id')
            ->whereYear('observasi.tanggal_pemantauan', $tahun) // Ubah $year jadi $tahun
            ->groupBy('observasi.location_id','lokasi.nama_lokasi')
            ->get();

        // 3) SHU vs Tidak SHU
        $shuData = Observasi::select('shu', DB::raw('COUNT(*) AS jumlah'))
            ->whereYear('tanggal_pemantauan', $tahun) // Ubah $year jadi $tahun
            ->groupBy('shu')
            ->get();

        // CARD SUMMARY
        $totalLokasi = Lokasi::count();
        $totalPetugas = User::where('role','petugas')->count();
        $totalIndikator = IndikatorUji::count();
        $totalObservasi = Observasi::count();

        return view('admin.dashboard', compact(
            'tahun', // Ubah 'year' jadi 'tahun'
            'avgPerIndikator',
            'obsPerLokasi',
            'shuData',
            'totalLokasi',
            'totalPetugas',
            'totalIndikator',
            'totalObservasi'
        ));
    }
}