<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\HasilUji;
use App\Models\Observasi;
use App\Models\IndikatorUji;
use App\Models\BakuMutuPeruntukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HasilUjiController extends Controller
{
    // ── DAFTAR PARAMETER MINIMUM (nilai harus >= baku mutu) ──
    private array $parameterMinimum = [
        'dissolved oxygen',
        'oksigen terlarut',
        'do',
    ];

    // ── HELPER: hitung status berdasarkan nilai vs baku mutu ──
    private function hitungStatus(float $nilai, float $bakuMutu, string $namaIndikator): string
    {
        $nama      = strtolower($namaIndikator);
        $isMinimum = collect($this->parameterMinimum)
            ->contains(fn($k) => str_contains($nama, $k));

        if ($isMinimum) {
            // DO: semakin tinggi semakin baik, baku mutu adalah nilai minimum
            if ($nilai >= $bakuMutu)
                return 'Memenuhi Baku Mutu';
            elseif ($nilai >= $bakuMutu * 0.75)
                return 'Tercemar Ringan';
            elseif ($nilai >= $bakuMutu * 0.50)
                return 'Tercemar Sedang';
            else
                return 'Tercemar Berat';
        } else {
            // Parameter maksimum: semakin rendah semakin baik
            $rasio = $nilai / $bakuMutu;
            if ($rasio <= 1.0)
                return 'Memenuhi Baku Mutu';
            elseif ($rasio <= 2.0)
                return 'Tercemar Ringan';
            elseif ($rasio <= 5.0)
                return 'Tercemar Sedang';
            else
                return 'Tercemar Berat';
        }
    }

    public function index()
    {
        $userId = auth()->id();

        $data = HasilUji::with(['observasi.lokasi', 'indikator'])
            ->whereHas('observasi', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('observasi_id', 'DESC')
            ->paginate(20);

        return view('petugas.hasiluji.index', compact('data'));
    }

    public function create()
    {
        $userId = auth()->id();

        $observasi = Observasi::with('lokasi')
            ->where('user_id', $userId)
            ->orderBy('tanggal_pemantauan', 'DESC')
            ->get();

        $indikator = IndikatorUji::orderBy('id')->get();

        return view('petugas.hasiluji.create', compact('observasi', 'indikator'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'observasi_id' => 'required',
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $duplikat = HasilUji::where('observasi_id', $request->observasi_id)
            ->whereIn('indikator_id', $request->indikator_id)
            ->exists();

        if ($duplikat) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hasil uji untuk observasi ini sudah pernah diinput. Silakan gunakan fitur Edit untuk mengubah data.');
        }

        $filePath = null;
        if ($request->hasFile('file_berkas')) {
            $filePath = $request->file('file_berkas')->store('hasil_uji', 'public');
        }

        $observasi  = Observasi::with('lokasi')->findOrFail($request->observasi_id);
        $peruntukan = $observasi->lokasi->peruntukan;

        foreach ($request->indikator_id as $i => $indikatorId) {
            $nilai = (float) $request->nilai[$i];

            $baku     = BakuMutuPeruntukan::where('indikator_id', $indikatorId)
                ->whereRaw('LOWER(peruntukan) = ?', [strtolower(trim($peruntukan))])
                ->first();
            $bakuMutu = optional($baku)->baku_mutu;

            $indikator = IndikatorUji::find($indikatorId);
            $status    = null;

            if ($bakuMutu !== null && $bakuMutu > 0) {
                $status = $this->hitungStatus($nilai, $bakuMutu, $indikator->nama_indikator ?? '');
            }

            HasilUji::create([
                'observasi_id' => $observasi->id,
                'indikator_id' => $indikatorId,
                'nilai'        => $nilai,
                'baku_mutu'    => $bakuMutu,
                'status'       => $status,
                'keterangan'   => $request->keterangan,
                'file_berkas'  => $filePath,
            ]);
        }

        return redirect()->route('petugas.hasiluji.index')
            ->with('success', 'Hasil uji berhasil ditambahkan.');
    }

    public function show($id)
    {
        $userId = auth()->id();

        $hu = HasilUji::with('observasi.lokasi')
            ->whereHas('observasi', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->findOrFail($id);

        $dataHasil = HasilUji::with('indikator')
            ->where('observasi_id', $hu->observasi_id)
            ->orderBy('indikator_id')
            ->get();

        $observasi = $hu->observasi;

        return view('petugas.hasiluji.show', compact('observasi', 'dataHasil'));
    }

    public function edit($observasi_id)
    {
        $userId = auth()->id();

        $observasiSingle = Observasi::with('lokasi')
            ->where('id', $observasi_id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $observasi = Observasi::with('lokasi')
            ->where('user_id', $userId)
            ->orderBy('tanggal_pemantauan', 'DESC')
            ->get();

        $indikator = IndikatorUji::orderBy('id')->get();

        $dataNilai = HasilUji::where('observasi_id', $observasi_id)
            ->get()
            ->keyBy('indikator_id');

        $hu = HasilUji::where('observasi_id', $observasi_id)->first();

        return view('petugas.hasiluji.edit', compact(
            'observasi',
            'observasiSingle',
            'indikator',
            'dataNilai',
            'hu'
        ));
    }

    public function update(Request $request, $observasi_id)
    {
        $userId = auth()->id();

        $observasiSingle = Observasi::with('lokasi')
            ->where('id', $observasi_id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $request->validate([
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $hasilUjiLama = HasilUji::where('observasi_id', $observasi_id)->first();
        $filePath     = $hasilUjiLama ? $hasilUjiLama->file_berkas : null;

        if ($request->hasFile('file_berkas')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file_berkas')->store('hasil_uji', 'public');
        }

        $peruntukan = $observasiSingle->lokasi->peruntukan;

        foreach ($request->indikator_id as $i => $id) {
            $nilai = (float) $request->nilai[$i];

            $baku     = BakuMutuPeruntukan::where('indikator_id', $id)
                ->whereRaw('LOWER(peruntukan) = ?', [strtolower(trim($peruntukan))])
                ->first();
            $bakuMutu = $baku ? $baku->baku_mutu : null;

            $indikator = IndikatorUji::find($id);
            $status    = null;

            if ($bakuMutu !== null && $bakuMutu > 0) {
                $status = $this->hitungStatus($nilai, $bakuMutu, $indikator->nama_indikator ?? '');
            }

            HasilUji::updateOrCreate(
                [
                    'observasi_id' => $observasi_id,
                    'indikator_id' => $id,
                ],
                [
                    'nilai'       => $nilai,
                    'baku_mutu'   => $bakuMutu,
                    'status'      => $status,
                    'keterangan'  => $request->keterangan,
                    'file_berkas' => $filePath,
                ]
            );
        }

        return redirect()->route('petugas.hasiluji.index', [
            'page' => $request->page,
        ])->with('success', 'Hasil uji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userId = auth()->id();

        $hu = HasilUji::whereHas('observasi', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->findOrFail($id);

        if ($hu->file_berkas) {
            Storage::disk('public')->delete($hu->file_berkas);
        }

        HasilUji::where('observasi_id', $hu->observasi_id)->delete();

        return redirect()->route('petugas.hasiluji.index')
            ->with('success', 'Semua hasil uji dalam observasi ini telah dihapus.');
    }
}