<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BakuMutuPeruntukan;
use App\Models\IndikatorUji;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index()
    {
        $data = IndikatorUji::with('bakuMutu')
            ->orderBy('nama_indikator')
            ->paginate(10);

        return view('admin.indikator.index', compact('data'));
    }

    public function create()
    {
        return view('admin.indikator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_indikator' => 'required|unique:indikator_uji,kode_indikator',
            'nama_indikator' => 'required',
            'satuan' => 'required',
        ]);

        $indikator = IndikatorUji::create([
            'kode_indikator' => $request->kode_indikator,
            'nama_indikator' => $request->nama_indikator,
            'satuan' => $request->satuan,
        ]);

        // simpan baku mutu peruntukan
        BakuMutuPeruntukan::create([
            'indikator_id' => $indikator->id,
            'peruntukan' => 'Biota Laut',
            'baku_mutu' => $request->biota_laut,
        ]);

        BakuMutuPeruntukan::create([
            'indikator_id' => $indikator->id,
            'peruntukan' => 'Pelabuhan',
            'baku_mutu' => $request->pelabuhan,
        ]);

        BakuMutuPeruntukan::create([
            'indikator_id' => $indikator->id,
            'peruntukan' => 'Wisata Bahari',
            'baku_mutu' => $request->wisata_bahari,
        ]);

        return redirect()->route('admin.indikator.index')
            ->with('success', 'Parameter berhasil ditambahkan');
    }

    public function show($id)
    {
        $i = IndikatorUji::with('bakuMutu')->findOrFail($id);

        return view('admin.indikator.show', compact('i'));
    }

    public function edit($id)
    {
        $i = IndikatorUji::with('bakuMutu')->findOrFail($id);

        return view('admin.indikator.edit', compact('i'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_indikator' => "required|unique:indikator_uji,kode_indikator,$id",
            'nama_indikator' => 'required',
            'satuan' => 'required',
        ]);

        $i = IndikatorUji::findOrFail($id);

        $i->update([
            'kode_indikator' => $request->kode_indikator,
            'nama_indikator' => $request->nama_indikator,
            'satuan' => $request->satuan,
        ]);

        // update baku mutu
        foreach ($i->bakuMutu as $b) {

            if ($b->peruntukan == 'Biota Laut') {
                $b->update(['baku_mutu' => $request->biota_laut]);
            }

            if ($b->peruntukan == 'Pelabuhan') {
                $b->update(['baku_mutu' => $request->pelabuhan]);
            }

            if ($b->peruntukan == 'Wisata Bahari') {
                $b->update(['baku_mutu' => $request->wisata_bahari]);
            }
        }

        return redirect()->route('admin.indikator.index')
            ->with('success', 'Parameter berhasil diperbarui');
    }

    public function destroy($id)
    {
        $indikator = IndikatorUji::findOrFail($id);

        // hapus baku mutu
        BakuMutuPeruntukan::where('indikator_id', $indikator->id)->delete();

        $indikator->delete();

        return redirect()->route('admin.indikator.index')
            ->with('success', 'Parameter berhasil dihapus');
    }
}
