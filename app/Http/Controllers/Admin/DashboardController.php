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
        $tahun   = $request->query('tahun', date('Y'));
        $periode = $request->query('periode');

        // ── STORET ──
        $dataStoret = $this->hitungStoret($tahun, $periode);
        $storet = [
            'baik'   => $dataStoret->where('status', 'Memenuhi Baku Mutu')->count(),
            'ringan' => $dataStoret->where('status', 'Tercemar Ringan')->count(),
            'sedang' => $dataStoret->where('status', 'Tercemar Sedang')->count(),
            'berat'  => $dataStoret->where('status', 'Tercemar Berat')->count(),
        ];

        // ── INDEKS PENCEMARAN ──
        $dataIP = $this->hitungIndeksPencemaran($tahun, $periode);
        $ip = [
            'baik'   => $dataIP->where('status', 'Memenuhi Baku Mutu')->count(),
            'ringan' => $dataIP->where('status', 'Tercemar Ringan')->count(),
            'sedang' => $dataIP->where('status', 'Tercemar Sedang')->count(),
            'berat'  => $dataIP->where('status', 'Tercemar Berat')->count(),
        ];

        // ── PERBANDINGAN PER LOKASI ──
        $perbandingan = $this->hitungPerbandingan($dataStoret, $dataIP);

        // ── OBS PER LOKASI ──
        $obsPerLokasi = Observasi::select('lokasi.nama_lokasi', DB::raw('COUNT(*) AS jumlah'))
            ->join('lokasi', 'observasi.location_id', '=', 'lokasi.id')
            ->whereYear('observasi.tanggal_pemantauan', $tahun)
            ->when($periode, fn($q) => $q->where('observasi.periode_pemantauan', $periode))
            ->groupBy('observasi.location_id', 'lokasi.nama_lokasi')
            ->orderBy('jumlah', 'desc')
            ->limit(10)->get();

        // ── MAP + STATUS GABUNGAN ──
        $lokasiMap = Lokasi::all();
        foreach ($lokasiMap as $lok) {
            $s = $dataStoret->firstWhere('lokasi_id', $lok->id);
            $i = $dataIP->firstWhere('lokasi_id', $lok->id);
            $lok->status_storet = $s->status ?? 'Belum Ada Data';
            $lok->status_ip     = $i->status ?? 'Belum Ada Data';
            $lok->nilai_ip      = $i->nilai_ip ?? null;
            $lok->skor_storet   = $s->skor_storet ?? null;
        }

        // ── TREND 4 TAHUN ──
        $trend = collect();
        for ($t = $tahun - 3; $t <= $tahun; $t++) {
            $s   = $this->hitungStoret($t);
            $i   = $this->hitungIndeksPencemaran($t);
            $trend->push([
                'tahun'       => $t,
                'skor_storet' => round($s->avg('skor_storet') ?? 0, 2),
                'nilai_ip'    => round($i->avg('nilai_ip') ?? 0, 3),
            ]);
        }

        // ── STATUS PER PARAMETER ──
        $statusParam = DB::table('hasil_uji')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
            ->select(
                'indikator_uji.nama_indikator as parameter',
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Memenuhi Baku Mutu' THEN 1 END) as memenuhi"),
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Tercemar Ringan' THEN 1 END) as ringan"),
                DB::raw("COUNT(CASE WHEN hasil_uji.status = 'Tercemar Berat' THEN 1 END) as berat")
            )
            ->where('observasi.tahun_pemantauan', $tahun)
            ->when($periode, fn($q) => $q->where('observasi.periode_pemantauan', $periode))
            ->groupBy('indikator_uji.id', 'indikator_uji.nama_indikator')
            ->get();

        // ── CARDS ──
        $totalLokasi    = Lokasi::count();
        $totalPetugas   = User::where('role', 'petugas')->count();
        $totalIndikator = IndikatorUji::count();
        $totalObservasi = Observasi::count();
        $jumlahBaik     = $dataStoret->where('status', 'Memenuhi Baku Mutu')->count();
        $jumlahTercemar = $dataStoret->where('status', '!=', 'Memenuhi Baku Mutu')->count();

        // ── OBSERVASI TERBARU ──
        $observasiTerbaru = Observasi::with(['lokasi', 'user'])
            ->orderBy('tanggal_pemantauan', 'desc')
            ->limit(5)->get();

        return view('admin.dashboard', compact(
            'tahun', 'periode',
            'obsPerLokasi', 'lokasiMap',
            'totalLokasi', 'totalPetugas', 'totalIndikator', 'totalObservasi',
            'jumlahTercemar', 'jumlahBaik',
            'storet', 'ip', 'perbandingan',
            'trend', 'statusParam',
            'observasiTerbaru'
        ));
    }

    // ── STORET ──
    private function hitungStoret($tahun = null, $periode = null)
    {
        $data = DB::table('hasil_uji')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('lokasi', 'observasi.location_id', '=', 'lokasi.id')
            ->select('lokasi.id as lokasi_id', 'lokasi.nama_lokasi',
                     'observasi.tahun_pemantauan as tahun',
                     'observasi.periode_pemantauan as periode',
                     'hasil_uji.nilai', 'hasil_uji.baku_mutu')
            ->when($tahun, fn($q) => $q->where('observasi.tahun_pemantauan', $tahun))
            ->when($periode, fn($q) => $q->where('observasi.periode_pemantauan', $periode))
            ->whereNotNull('hasil_uji.baku_mutu')
            ->where('hasil_uji.baku_mutu', '>', 0)
            ->get();

        $grouped = $data->groupBy(fn($i) => $i->lokasi_id . '-' . $i->tahun . '-' . $i->periode);
        $result  = [];

        foreach ($grouped as $rows) {
            $first = $rows->first();
            $skor  = 0;
            foreach ($rows as $r) {
                if ($r->nilai > $r->baku_mutu) $skor -= 2;
            }
            if ($skor == 0)       $status = 'Memenuhi Baku Mutu';
            elseif ($skor >= -10) $status = 'Tercemar Ringan';
            elseif ($skor >= -30) $status = 'Tercemar Sedang';
            else                  $status = 'Tercemar Berat';

            $result[] = (object)[
                'lokasi_id'   => $first->lokasi_id,
                'nama_lokasi' => $first->nama_lokasi,
                'skor_storet' => $skor,
                'status'      => $status,
            ];
        }
        return collect($result);
    }

    // ── INDEKS PENCEMARAN ──
    private function hitungIndeksPencemaran($tahun = null, $periode = null)
    {
        $data = DB::table('hasil_uji')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->select('lokasi.id as lokasi_id', 'lokasi.nama_lokasi',
                     'observasi.tahun_pemantauan as tahun',
                     'observasi.periode_pemantauan as periode',
                     'hasil_uji.nilai', 'hasil_uji.baku_mutu')
            ->when($tahun, fn($q) => $q->where('observasi.tahun_pemantauan', $tahun))
            ->when($periode, fn($q) => $q->where('observasi.periode_pemantauan', $periode))
            ->whereNotNull('hasil_uji.baku_mutu')
            ->where('hasil_uji.baku_mutu', '>', 0)
            ->get();

        $grouped = $data->groupBy(fn($i) => $i->lokasi_id . '-' . $i->tahun . '-' . $i->periode);
        $result  = [];

        foreach ($grouped as $rows) {
            $first   = $rows->first();
            $rasio   = $rows->map(fn($r) => $r->nilai / $r->baku_mutu);
            $rata    = $rasio->avg();
            $maks    = $rasio->max();
            $ip      = round(sqrt(($rata * $rata + $maks * $maks) / 2), 3);

            if ($ip <= 1.0)      $status = 'Memenuhi Baku Mutu';
            elseif ($ip <= 5.0)  $status = 'Tercemar Ringan';
            elseif ($ip <= 10.0) $status = 'Tercemar Sedang';
            else                 $status = 'Tercemar Berat';

            $result[] = (object)[
                'lokasi_id'   => $first->lokasi_id,
                'nama_lokasi' => $first->nama_lokasi,
                'nilai_ip'    => $ip,
                'status'      => $status,
            ];
        }
        return collect($result);
    }

    // ── PERBANDINGAN STORET vs IP ──
    private function hitungPerbandingan($dataStoret, $dataIP)
    {
        $result = [];
        foreach ($dataStoret as $s) {
            $i = $dataIP->firstWhere('lokasi_id', $s->lokasi_id);
            if (!$i) continue;

            // Agreement: apakah kedua metode sepakat?
            $sepakat = ($s->status === $i->status);

            $result[] = (object)[
                'nama_lokasi'    => $s->nama_lokasi,
                'status_storet'  => $s->status,
                'status_ip'      => $i->status,
                'skor_storet'    => $s->skor_storet,
                'nilai_ip'       => $i->nilai_ip,
                'sepakat'        => $sepakat,
            ];
        }
        return collect($result);
    }
}