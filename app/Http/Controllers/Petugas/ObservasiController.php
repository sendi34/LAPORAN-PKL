<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Observasi;
use Illuminate\Http\Request;

class ObservasiController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

        // DATA HANYA YG DIBUAT PETUGAS LOGIN
        $data = Observasi::with('lokasi')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->paginate(10);

        return view('petugas.observasi.index', compact('data'));
    }

    public function create()
    {
        $lokasi = Lokasi::orderBy('nama_lokasi')->get();

        return view('petugas.observasi.create', compact('lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required',
            'tanggal_pemantauan' => 'required|date',
            'periode_pemantauan' => 'required',
            'shu' => 'required|in:ADA SHU,TIDAK ADA SHU',
        ]);

        Observasi::create([
            'location_id' => $request->location_id,
            'user_id' => auth()->user()->id, // AUTO PETUGAS LOGIN
            'tanggal_pemantauan' => $request->tanggal_pemantauan,
            'tahun_pemantauan' => date('Y', strtotime($request->tanggal_pemantauan)),
            'periode_pemantauan' => $request->periode_pemantauan,
            'shu' => $request->shu,
        ]);

        return redirect()->route('petugas.observasi.index')
            ->with('success', 'Observasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $obs = Observasi::with(['lokasi', 'user', 'hasilUji.indikator'])
            ->where('id', $id)
            ->where('user_id', auth()->user()->id) // SECURITY
            ->firstOrFail();

        return view('petugas.observasi.show', compact('obs'));
    }

    public function edit($id)
    {
        $obs = Observasi::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $lokasi = Lokasi::orderBy('nama_lokasi')->get();

        return view('petugas.observasi.edit', compact('obs', 'lokasi'));
    }

    public function update(Request $request, $id)
    {
        $obs = Observasi::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $request->validate([
            'location_id' => 'required',
            'tanggal_pemantauan' => 'required|date',
            'periode_pemantauan' => 'required',
            'shu' => 'required|in:ADA SHU,TIDAK ADA SHU',
        ]);

        $obs->update([
            'location_id' => $request->location_id,
            'tanggal_pemantauan' => $request->tanggal_pemantauan,
            'tahun_pemantauan' => date('Y', strtotime($request->tanggal_pemantauan)),
            'periode_pemantauan' => $request->periode_pemantauan,
            'shu' => $request->shu,
        ]);

        return redirect()->route('petugas.observasi.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $obs = Observasi::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $obs->delete();

        return redirect()->route('petugas.observasi.index')
            ->with('success', 'Data observasi berhasil dihapus.');
    }
}
