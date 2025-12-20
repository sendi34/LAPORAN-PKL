<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndikatorUji;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index()
    {
        $data = IndikatorUji::orderBy('nama_indikator')->paginate(10);
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
            'satuan'         => 'required',
            'baku_mutu'      => 'required|numeric'
        ]);

        IndikatorUji::create($request->all());

        return redirect()->route('admin.indikator.index')
            ->with('success', 'Indikator uji berhasil ditambahkan.');
    }

    public function show($id)
    {
        $i = IndikatorUji::findOrFail($id);
        return view('admin.indikator.show', compact('i'));
    }

    public function edit($id)
    {
        $i = IndikatorUji::findOrFail($id);
        return view('admin.indikator.edit', compact('i'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_indikator' => "required|unique:indikator_uji,kode_indikator,$id",
            'nama_indikator' => 'required',
            'satuan'         => 'required',
            'baku_mutu'      => 'required|numeric'
        ]);

        $i = IndikatorUji::findOrFail($id);
        $i->update($request->all());

        return redirect()->route('admin.indikator.index')
            ->with('success', 'Indikator uji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        IndikatorUji::destroy($id);

        return redirect()->route('admin.indikator.index')
            ->with('success', 'Indikator uji berhasil dihapus.');
    }
}
