@extends('layouts.sbadmin')
@section('title', 'Data Hasil Uji')

@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Hasil Uji Anda</h1>
        <a href="{{ route('petugas.hasiluji.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Hasil Uji
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: #5a5c69; color: white;">
                        <tr>
                            <th width="20%">Observasi</th>
                            <th width="35%">Parameter & Nilai</th>
                            <th width="15%">Keterangan</th>
                            <th width="15%">File Berkas SHU</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // GROUP hasil_uji berdasarkan observasi_id
                            $grouped = $data->groupBy('observasi_id');
                        @endphp

                        @forelse ($grouped as $observasi_id => $items)
                            @php
                                $obs = $items->first()->observasi;
                                $firstItem = $items->first();
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $obs->lokasi->nama_lokasi }}</strong><br>
                                    <span class="text-muted">
                                        Peruntukan : {{ $obs->lokasi->peruntukan }}
                                    </span><br>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $obs->lokasi->alamat_lokasi }}
                                    </small><br>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($obs->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}
                                    </small><br>
                                    @if ($obs->periode_pemantauan)
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> {{ $obs->periode_pemantauan }}
                                        </small><br>
                                    @endif
                                    <span class="badge bg-info mt-1 text-white">{{ $obs->shu }}</span>
                                </td>
                                <td>
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Nilai</th>
                                                <th>Baku Mutu</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $hu)
                                                <tr>
                                                    <td>{{ $hu->indikator->nama_indikator }}</td>
                                                    <td>{{ (float) $hu->nilai }}</td>
                                                    <td>{{ (float) $hu->baku_mutu }}</td>
                                                    <td>
                                                        @if ($hu->status == 'Memenuhi Baku Mutu')
                                                            <span class="badge bg-success text-white">Memenuhi</span>
                                                        @elseif ($hu->status == 'Tercemar Ringan')
                                                            <span class="badge bg-warning text-dark">Tercemar Ringan</span>
                                                        @elseif ($hu->status == 'Tercemar Sedang')
                                                            <span class="badge bg-orange text-white" style="background-color:#f97316!important">Tercemar Sedang</span>
                                                        @elseif ($hu->status == 'Tercemar Berat')
                                                            <span class="badge bg-danger text-white">Tercemar Berat</span>
                                                        @else
                                                            <span class="badge bg-secondary text-white">Tidak Ada Baku Mutu</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <small>{{ Str::limit($firstItem->keterangan ?? '-', 50) }}</small>
                                </td>
                                <td class="text-center">
                                    @if ($firstItem->file_berkas)
                                        <a href="{{ asset('storage/' . $firstItem->file_berkas) }}" target="_blank"
                                            class="btn btn-sm btn-success mb-1" title="Download File">
                                            <i class="fas fa-file-pdf"></i> Download
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            {{ Str::limit(basename($firstItem->file_berkas), 20) }}
                                        </small>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus-circle"></i><br>
                                            Tidak ada file
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('petugas.hasiluji.show', $firstItem->id) }}?page={{ request('page') }}"
                                        class="btn btn-info btn-sm mb-1">
                                        Detail
                                    </a>

                                    <a href="{{ route('petugas.hasiluji.edit', $firstItem->observasi_id) }}?page={{ request('page') }}"
                                        class="btn btn-warning btn-sm mb-1" title="Edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('petugas.hasiluji.destroy', $firstItem->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus semua hasil uji observasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data hasil uji</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>

@endsection
