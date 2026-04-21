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
    public function index()
    {
        $userId = auth()->id();

        $data = HasilUji::with(['observasi.lokasi','indikator'])
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
                    ->orderBy('tanggal_pemantauan','DESC')
                    ->get();
        $indikator = IndikatorUji::orderBy('id')->get();

        return view('petugas.hasiluji.create', compact('observasi','indikator'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'observasi_id' => 'required',
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        // Upload file berkas jika ada
        $filePath = null;
        if ($request->hasFile('file_berkas')) {
            $file = $request->file('file_berkas');
            $filePath = $file->store('hasil_uji', 'public');
        }

        $duplikat = HasilUji::where('observasi_id', $request->observasi_id)
                ->whereIn('indikator_id', $request->indikator_id)
                ->exists();

        if ($duplikat) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hasil uji untuk observasi ini sudah pernah diinput. Silakan gunakan fitur Edit untuk mengubah data.');
        }

     $observasi = Observasi::with('lokasi')->findOrFail($request->observasi_id);

$peruntukan = $observasi->lokasi->peruntukan;

foreach ($request->indikator_id as $i => $indikatorId) {

    $nilai = $request->nilai[$i];

    // ambil baku mutu berdasarkan parameter + peruntukan
    $baku = BakuMutuPeruntukan::where('indikator_id', $indikatorId)
        ->whereRaw('LOWER(peruntukan) = ?', [strtolower(trim($peruntukan))])
        ->first();

    $bakuMutu = optional($baku)->baku_mutu;

    // menentukan status
    $status = null;

            if ($bakuMutu !== null) {

                if ($nilai <= $bakuMutu) {
                    $status = 'Memenuhi Baku Mutu';
                } 
                elseif ($nilai <= ($bakuMutu * 2)) {
                    $status = 'Tercemar Ringan';
                } 
                else {
                    $status = 'Tercemar Berat';
                }

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
            ->with('success', 'hasil uji berhasil ditambahkan.');
    }

    public function show($id)
    {
        $userId = auth()->id();
        
        // Ambil salah satu hasil uji
        $hu = HasilUji::with('observasi.lokasi')
            ->whereHas('observasi', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->findOrFail($id);

        // Ambil semua hasil uji dalam observasi yang sama
        $dataHasil = HasilUji::with('indikator')
            ->where('observasi_id', $hu->observasi_id)
            ->orderBy('indikator_id')
            ->get();

        $observasi = $hu->observasi;

        return view('petugas.hasiluji.show', compact('observasi','dataHasil'));
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
                    ->orderBy('tanggal_pemantauan','DESC')
                    ->get();

        $indikator = IndikatorUji::orderBy('id')->get();

        // Ambil nilai hasil uji per indikator
        $dataNilai = HasilUji::where('observasi_id', $observasi_id)
                    ->get()
                    ->keyBy('indikator_id');

        // Ambil salah satu hasil uji untuk file_berkas
        $hu = HasilUji::where('observasi_id', $observasi_id)->first();

        return view('petugas.hasiluji.edit', compact(
            'observasi','observasiSingle','indikator','dataNilai','hu'
        ));
    }

    public function update(Request $request, $observasi_id)
    {
        $userId = auth()->id();

        // Pastikan observasi milik user yang login
        $observasiSingle = Observasi::with('lokasi')
    ->where('id', $observasi_id)
                        ->where('user_id', $userId)
                        ->firstOrFail();

        $request->validate([
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        // Ambil file_berkas yang lama
        $hasilUjiLama = HasilUji::where('observasi_id', $observasi_id)->first();
        $filePath = $hasilUjiLama ? $hasilUjiLama->file_berkas : null;

        // Jika ada file baru diupload
        if ($request->hasFile('file_berkas')) {
            // Hapus file lama
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            
            // Upload file baru
            $file = $request->file('file_berkas');
            $filePath = $file->store('hasil_uji', 'public');
        }

       foreach ($request->indikator_id as $i => $id) {

    $nilai = $request->nilai[$i];

    $peruntukan = $observasiSingle->lokasi->peruntukan;

$baku = BakuMutuPeruntukan::where('indikator_id', $id)
        ->whereRaw('LOWER(peruntukan) = ?', [strtolower(trim($peruntukan))])
        ->first();

    $bakuMutu = $baku ? $baku->baku_mutu : null;

    $status = null;

            if ($bakuMutu !== null) {

                if ($nilai <= $bakuMutu) {
                    $status = 'Memenuhi Baku Mutu';
                } 
                elseif ($nilai <= ($bakuMutu * 2)) {
                    $status = 'Tercemar Ringan';
                } 
                else {
                    $status = 'Tercemar Berat';
                }

            }

    HasilUji::updateOrCreate(
        [
            'observasi_id' => $observasi_id,
            'indikator_id' => $id
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
    'page' => $request->page
])->with('success', 'Hasil uji berhasil diperbarui.');

    }

    public function destroy($id)
    {
        $userId = auth()->id();

        $hu = HasilUji::whereHas('observasi', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->findOrFail($id);

        // Hapus file berkas jika ada
        if ($hu->file_berkas) {
            Storage::disk('public')->delete($hu->file_berkas);
        }

        // Hapus semua 5 data hasil uji
        HasilUji::where('observasi_id', $hu->observasi_id)->delete();

        return redirect()->route('petugas.hasiluji.index')
            ->with('success', 'Semua hasil uji dalam observasi ini telah dihapus.');
    }
}