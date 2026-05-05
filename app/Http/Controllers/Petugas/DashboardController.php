<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\HasilUji;
use App\Models\Observasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun  = $request->query('tahun', date('Y'));
        $userId = auth()->id();

        // ── CARDS RINGKASAN ──
        $totalObservasi = Observasi::where('user_id', $userId)
            ->where('tahun_pemantauan', $tahun)
            ->count();

        $totalLokasi = Observasi::where('user_id', $userId)
            ->where('tahun_pemantauan', $tahun)
            ->distinct('location_id')
            ->count('location_id');

        $totalParameter = DB::table('hasil_uji')
            ->join('observasi', 'observasi.id', '=', 'hasil_uji.observasi_id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->count();

        $totalTercemar = DB::table('hasil_uji')
            ->join('observasi', 'observasi.id', '=', 'hasil_uji.observasi_id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->where('hasil_uji.status', '!=', 'Memenuhi Baku Mutu')
            ->whereNotNull('hasil_uji.status')
            ->count();

        // ── STATUS HASIL UJI ──
        $statusCount = DB::table('hasil_uji')
            ->join('observasi', 'observasi.id', '=', 'hasil_uji.observasi_id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select('hasil_uji.status', DB::raw('COUNT(*) as total'))
            ->groupBy('hasil_uji.status')
            ->get()
            ->keyBy('status');

        $statusMemenuhi = $statusCount['Memenuhi Baku Mutu']->total ?? 0;
        $statusRingan   = $statusCount['Tercemar Ringan']->total ?? 0;
        $statusSedang   = $statusCount['Tercemar Sedang']->total ?? 0;
        $statusBerat    = $statusCount['Tercemar Berat']->total ?? 0;

        // ── GRAFIK OBSERVASI PER LOKASI ──
        $observasiLokasi = DB::table('observasi')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'lokasi.kode_lokasi',
                DB::raw('COUNT(observasi.id) as total')
            )
            ->groupBy('lokasi.kode_lokasi')
            ->orderBy('total', 'desc')
            ->get();

        // ── GRAFIK STATUS PER PARAMETER ──
        $statusParam = DB::table('hasil_uji')
            ->join('observasi',     'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('indikator_uji', 'indikator_uji.id',       '=', 'hasil_uji.indikator_id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'indikator_uji.nama_indikator as parameter',
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Memenuhi Baku Mutu' THEN 1 END) as memenuhi"),
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Tercemar Ringan' THEN 1 END) as ringan"),
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Tercemar Sedang' THEN 1 END) as sedang"),
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Tercemar Berat' THEN 1 END) as berat"),
            )
            ->groupBy('indikator_uji.id', 'indikator_uji.nama_indikator')
            ->get();

        // ── PETA LOKASI ──
        $lokasiMap = DB::table('lokasi')
            ->join('observasi', 'observasi.location_id', '=', 'lokasi.id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->select(
                'lokasi.nama_lokasi',
                'lokasi.alamat_lokasi',
                'lokasi.latitude',
                'lokasi.longitude'
            )
            ->distinct()
            ->get();

        // ── OBSERVASI TERBARU ──
        $observasiTerbaru = Observasi::with(['lokasi', 'user'])
            ->where('user_id', $userId)
            ->orderBy('tanggal_pemantauan', 'desc')
            ->limit(5)
            ->get();

        // ── PARAMETER PALING SERING TERCEMAR ──
        $parameterTercemar = DB::table('hasil_uji')
            ->join('observasi',     'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('indikator_uji', 'indikator_uji.id',       '=', 'hasil_uji.indikator_id')
            ->where('observasi.user_id', $userId)
            ->where('observasi.tahun_pemantauan', $tahun)
            ->where('hasil_uji.status', '!=', 'Memenuhi Baku Mutu')
            ->whereNotNull('hasil_uji.status')
            ->select(
                'indikator_uji.nama_indikator as parameter',
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('indikator_uji.id', 'indikator_uji.nama_indikator')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact(
            'tahun',
            'totalObservasi',
            'totalLokasi',
            'totalParameter',
            'totalTercemar',
            'statusMemenuhi',
            'statusRingan',
            'statusSedang',
            'statusBerat',
            'observasiLokasi',
            'statusParam',
            'lokasiMap',
            'observasiTerbaru',
            'parameterTercemar',
        ));
    }
}