<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilUji;
use App\Models\Observasi;
use App\Models\IndikatorUji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HasilUjiController extends Controller
{
    public function index()
    {
        $data = HasilUji::with(['observasi.lokasi', 'observasi.user', 'indikator'])
                ->orderBy('observasi_id', 'DESC')
                ->paginate(20);

        return view('admin.hasiluji.index', compact('data'));
    }

    public function create()
    {
        $observasi = Observasi::with('lokasi')->orderBy('tanggal_pemantauan','DESC')->get();
        $indikator = IndikatorUji::orderBy('id')->get();

        return view('admin.hasiluji.create', compact('observasi','indikator'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'observasi_id' => 'required',
            'indikator_id' => 'required|array',
            'nilai'        => 'required|array',
            'file_berkas'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // max 5MB
        ]);

        // Upload file berkas jika ada
        $filePath = null;
        if ($request->hasFile('file_berkas')) {
            $file = $request->file('file_berkas');
            $filePath = $file->store('hasil_uji', 'public');
        }

        // Simpan data untuk setiap indikator dengan file_berkas yang sama
        foreach ($request->indikator_id as $i => $id) {
            HasilUji::create([
                'observasi_id' => $request->observasi_id,
                'indikator_id' => $id,
                'nilai'        => $request->nilai[$i],
                'keterangan'   => $request->keterangan,
                'file_berkas'  => $filePath, // File berkas sama untuk semua indikator
            ]);
        }

        return redirect()->route('admin.hasiluji.index')
            ->with('success', 'hasil uji berhasil ditambahkan.');
    }

    public function show($id)
    {
        $hu = HasilUji::with('observasi.lokasi')->findOrFail($id);

        $dataHasil = HasilUji::with('indikator')
            ->where('observasi_id', $hu->observasi_id)
            ->orderBy('indikator_id')
            ->get();

        $observasi = $hu->observasi;

        return view('admin.hasiluji.show', compact('observasi','dataHasil'));
    }

    public function edit($observasi_id)
    {
        $observasiSingle = Observasi::with('lokasi')->findOrFail($observasi_id);
        $observasi = Observasi::with('lokasi')->orderBy('tanggal_pemantauan','DESC')->get();
        $indikator = IndikatorUji::orderBy('id')->get();

        // Ambil nilai hasil uji per indikator
        $dataNilai = HasilUji::where('observasi_id', $observasi_id)
                    ->get()
                    ->keyBy('indikator_id');

        // Ambil salah satu hasil uji untuk mendapatkan file_berkas dan keterangan
        $hu = HasilUji::where('observasi_id', $observasi_id)->first();

        return view('admin.hasiluji.edit', compact(
            'observasi','observasiSingle','indikator','dataNilai','hu'
        ));
    }

    public function update(Request $request, $observasi_id)
    {
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
            // Hapus file lama jika ada
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            
            // Upload file baru
            $file = $request->file('file_berkas');
            $filePath = $file->store('hasil_uji', 'public');
        }

        // Update semua indikator dengan file_berkas yang sama
        foreach ($request->indikator_id as $i => $id) {
            HasilUji::updateOrCreate(
                [
                    'observasi_id' => $observasi_id,
                    'indikator_id' => $id
                ],
                [
                    'nilai'       => $request->nilai[$i],
                    'keterangan'  => $request->keterangan,
                    'file_berkas' => $filePath, // File berkas sama untuk semua
                ]
            );
        }

        return redirect()->route('admin.hasiluji.index')
            ->with('success', 'Hasil uji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hu = HasilUji::findOrFail($id);

        // Hapus file berkas jika ada (cukup sekali karena file sama untuk semua indikator)
        if ($hu->file_berkas) {
            Storage::disk('public')->delete($hu->file_berkas);
        }

        // Hapus semua 5 data hasil uji berdasarkan observasi_id
        HasilUji::where('observasi_id', $hu->observasi_id)->delete();

        return redirect()->route('admin.hasiluji.index')
            ->with('success', 'Semua hasil uji dalam observasi ini telah dihapus.');
    }
}