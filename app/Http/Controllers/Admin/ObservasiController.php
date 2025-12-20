<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Observasi;
use App\Models\User;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class ObservasiController extends Controller
{
    public function index()
    {
        $data = Observasi::with(['lokasi','user'])
                ->latest()
                ->paginate(10);

        return view('admin.observasi.index', compact('data'));
    }

    public function create()
    {
        $lokasi = Lokasi::orderBy('nama_lokasi')->get();
        $user = User::where('role','petugas')->orderBy('nama')->get();

        return view('admin.observasi.create', compact('lokasi','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id'        => 'required',
            'user_id'            => 'required',
            'tanggal_pemantauan' => 'required|date',
            'periode_pemantauan' => 'required|string',
            'shu'                => 'required|string'
        ]);

        Observasi::create([
            'location_id'        => $request->location_id,
            'user_id'            => $request->user_id,
            'tanggal_pemantauan' => $request->tanggal_pemantauan,
            'tahun_pemantauan'   => date('Y', strtotime($request->tanggal_pemantauan)),
            'periode_pemantauan' => $request->periode_pemantauan,
            'shu'                => $request->shu
        ]);

        return redirect()->route('admin.observasi.index')
            ->with('success', 'Observasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $obs = Observasi::with(['lokasi','user','hasilUji.indikator'])->findOrFail($id);
        return view('admin.observasi.show', compact('obs'));
    }

    public function edit($id)
    {
        $obs = Observasi::findOrFail($id);
        $lokasi = Lokasi::orderBy('nama_lokasi')->get();
        $user = User::where('role','petugas')->orderBy('nama')->get();

        return view('admin.observasi.edit', compact('obs','lokasi','user'));
    }

    public function update(Request $request, $id)
    {
        $obs = Observasi::findOrFail($id);

        $request->validate([
            'location_id'        => 'required',
            'user_id'            => 'required',
            'tanggal_pemantauan' => 'required|date',
            'periode_pemantauan' => 'required|string',
            'shu'                => 'required|string'
        ]);

        $obs->update([
            'location_id'        => $request->location_id,
            'user_id'            => $request->user_id,
            'tanggal_pemantauan' => $request->tanggal_pemantauan,
            'tahun_pemantauan'   => date('Y', strtotime($request->tanggal_pemantauan)),
            'periode_pemantauan' => $request->periode_pemantauan,
            'shu'                => $request->shu
        ]);

        return redirect()->route('admin.observasi.index')
            ->with('success', 'Observasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Observasi::destroy($id);

        return redirect()->route('admin.observasi.index')
            ->with('success', 'Observasi berhasil dihapus.');
    }
}
