@extends('layouts.sbadmin')
@section('title', 'Data Observasi')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-4">Data Observasi Anda</h1>

    <a href="{{ route('petugas.observasi.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Observasi
    </a>
</div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Lokasi</th>
                        <th>Peruntukan</th>
                        <th>Tanggal</th>
                        <th>Periode</th>
                        <th>SHU</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->lokasi->nama_lokasi }}</td>
                            <td>{{ $row->lokasi->peruntukan }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($row->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td>
                                @if ($row->periode_pemantauan == 1)
                                    I
                                @elseif($row->periode_pemantauan == 2)
                                    II
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($row->shu == 'ADA SHU')
                                    <span class="badge bg-success text-white">ADA</span>
                                @else
                                    <span class="badge bg-danger text-white">TIDAK ADA</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('petugas.observasi.show', $row->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>
                                <a href="{{ route('petugas.observasi.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('petugas.observasi.destroy', $row->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $data->links() }}
    </div>

@endsection
