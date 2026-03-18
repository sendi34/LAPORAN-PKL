@extends('layouts.sbadmin')
@section('title', 'Detail Hasil Uji')
@section('content')
    <h1 class="h3 mb-4">Detail Hasil Uji</h1>
    <div class="card shadow">
        <div class="card-body">
            <h5 class="mb-3">Informasi Observasi</h5>
            <table class="table table-bordered mb-4">
                <tr>
                    <th width="30%">Lokasi</th>
                    <td>{{ $observasi->lokasi->nama_lokasi }}</td>
                </tr>
                <tr>
                    <th width="">Peruntukan</th>
                    <td>{{ $observasi->lokasi->peruntukan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Observasi</th>
                    <td>{{ \Carbon\Carbon::parse($observasi->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <th>SHU</th>
                    <td>{{ $observasi->shu }}</td>
                </tr>
                <tr>
                    <th>File Berkas Surat Hasil Uji</th>
                    <td>
                        @if ($dataHasil->first() && $dataHasil->first()->file_berkas)
                            <a href="{{ asset('storage/' . $dataHasil->first()->file_berkas) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download File
                            </a>
                            <small class="text-muted d-block mt-1">
                                {{ basename($dataHasil->first()->file_berkas) }}
                            </small>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                </tr>
            </table>

            <h5 class="mb-3">Hasil Uji</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Parameter</th>
                        <th>Satuan</th>
                        <th>Nilai</th>
                        <th>Baku Mutu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataHasil as $hasil)
                        <tr>
                            <td>{{ $hasil->indikator->nama_indikator }}</td>
                            <td>{{ $hasil->indikator->satuan }}</td>
                            <td>{{ (float) $hasil->nilai }}</td>
                            <td>{{ (float) $hasil->baku_mutu }}</td>
                            <td>
                                @if ($hasil->status == 'Memenuhi Baku Mutu')
                                    <span class="badge bg-success text-white">Memenuhi</span>
                                @elseif ($hasil->status == 'Tercemar Ringan')
                                    <span class="badge bg-warning text-dark">Tercemar Ringan</span>
                                @elseif ($hasil->status == 'Tercemar Berat')
                                    <span class="badge bg-danger text-white">Tercemar Berat</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="mt-4">Keterangan</h5>
            <div class="border rounded p-3 bg-light">
                {{ $dataHasil->first()->keterangan ?? '-' }}
            </div>
        </div>
    </div>
@endsection
