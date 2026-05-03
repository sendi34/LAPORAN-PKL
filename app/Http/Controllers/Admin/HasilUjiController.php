<?php

namespace App\Http\Controllers\Admin;

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
        $data = HasilUji::with(['observasi.lokasi', 'observasi.user', 'indikator'])
            ->orderBy('observasi_id', 'DESC')
            ->paginate(20);

        return view('admin.hasiluji.index', compact('data'));
    }

    public function create()
    {
        $observasi = Observasi::with('lokasi')
            ->orderBy('tanggal_pemantauan', 'DESC')
            ->get();

        $indikator = IndikatorUji::orderBy('id')->get();

        return view('admin.hasiluji.create', compact('observasi', 'indikator'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'observasi_id' => 'required',
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $observasi  = Observasi::with('lokasi')->findOrFail($request->observasi_id);
        $peruntukan = $observasi->lokasi->peruntukan;

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

        foreach ($request->indikator_id as $i => $id) {
            $baku     = BakuMutuPeruntukan::where('indikator_id', $id)
                ->where('peruntukan', $peruntukan)
                ->first();
            $bakuMutu = $baku ? $baku->baku_mutu : null;
            $nilai    = (float) $request->nilai[$i];

            $indikator = IndikatorUji::find($id);
            $status    = null;

            if ($bakuMutu !== null && $bakuMutu > 0) {
                $status = $this->hitungStatus($nilai, $bakuMutu, $indikator->nama_indikator ?? '');
            }

            HasilUji::create([
                'observasi_id' => $request->observasi_id,
                'indikator_id' => $id,
                'nilai'        => $nilai,
                'baku_mutu'    => $bakuMutu,
                'status'       => $status,
                'keterangan'   => $request->keterangan,
                'file_berkas'  => $filePath,
            ]);
        }

        return redirect()->route('admin.hasiluji.index')
            ->with('success', 'Hasil uji berhasil ditambahkan');
    }

    public function show($id)
    {
        $hu = HasilUji::with('observasi.lokasi')->findOrFail($id);

        $dataHasil = HasilUji::with('indikator')
            ->where('observasi_id', $hu->observasi_id)
            ->orderBy('indikator_id')
            ->get();

        $observasi = $hu->observasi;

        return view('admin.hasiluji.show', compact('observasi', 'dataHasil'));
    }

    public function edit($observasi_id)
    {
        $observasiSingle = Observasi::with('lokasi')->findOrFail($observasi_id);

        $observasi = Observasi::with('lokasi')
            ->orderBy('tanggal_pemantauan', 'DESC')
            ->get();

        $indikator = IndikatorUji::orderBy('id')->get();

        $dataNilai = HasilUji::where('observasi_id', $observasi_id)
            ->get()
            ->keyBy('indikator_id');

        $hu = HasilUji::where('observasi_id', $observasi_id)->first();

        return view('admin.hasiluji.edit', compact(
            'observasi',
            'observasiSingle',
            'indikator',
            'dataNilai',
            'hu'
        ));
    }

    public function update(Request $request, $observasi_id)
    {
        $request->validate([
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $observasi  = Observasi::with('lokasi')->findOrFail($observasi_id);
        $peruntukan = $observasi->lokasi->peruntukan;

        $hasilUjiLama = HasilUji::where('observasi_id', $observasi_id)->first();
        $filePath     = $hasilUjiLama ? $hasilUjiLama->file_berkas : null;

        if ($request->hasFile('file_berkas')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file_berkas')->store('hasil_uji', 'public');
        }

        foreach ($request->indikator_id as $i => $id) {
            $baku     = BakuMutuPeruntukan::where('indikator_id', $id)
                ->whereRaw('LOWER(peruntukan) = ?', [strtolower($peruntukan)])
                ->first();
            $bakuMutu = $baku ? $baku->baku_mutu : null;
            $nilai    = (float) $request->nilai[$i];

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

        return redirect()->route('admin.hasiluji.index')
            ->with('success', 'Hasil uji berhasil diperbarui');
    }

    public function destroy($id)
    {
        $hu = HasilUji::findOrFail($id);

        if ($hu->file_berkas) {
            Storage::disk('public')->delete($hu->file_berkas);
        }

        HasilUji::where('observasi_id', $hu->observasi_id)->delete();

        return redirect()->route('admin.hasiluji.index')
            ->with('success', 'Semua hasil uji dalam observasi ini telah dihapus');
    }
}