<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::orderByRaw("
    CASE 
        WHEN nama_lokasi REGEXP '[0-9]' 
        THEN CAST(REGEXP_REPLACE(nama_lokasi, '[^0-9]', '') AS UNSIGNED)
        ELSE 99999
    END
")->paginate(10);

        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_lokasi' => 'required|string|max:50|unique:lokasi,kode_lokasi',
            'nama_lokasi' => 'required|string|max:150',
            'peruntukan' => 'required',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        return view('admin.lokasi.show', compact('lokasi'));
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $request->validate([
            'kode_lokasi' => "required|string|max:50|unique:lokasi,kode_lokasi,$id",
            'nama_lokasi' => 'required|string|max:150',
            'peruntukan' => 'required',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Lokasi::destroy($id);

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
