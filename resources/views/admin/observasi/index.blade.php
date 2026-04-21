@extends('layouts.sbadmin')
@section('title', 'Data Observasi')

@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Data Observasi</h1>
        <a href="{{ route('admin.observasi.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Observasi</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Lokasi</th>
                        <th>Peruntukan</th>
                        <th>Petugas</th>
                        <th>Tanggal</th>
                        <th>Periode</th>
                        <th>SHU</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $o)
                        <tr>
                            <td>{{ $o->lokasi->nama_lokasi }}</td>
                            <td>{{ $o->lokasi->peruntukan }}</td>
                            <td>{{ $o->user->nama }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($o->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td>
                                @if ($o->periode_pemantauan == 1)
                                    I
                                @elseif($o->periode_pemantauan == 2)
                                    II
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if ($o->shu == 'ADA SHU')
                                    <span class="badge bg-success text-white">Ada SHU</span>
                                @else
                                    <span class="badge bg-danger text-white">Tidak Ada SHU</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.observasi.show', $o->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('admin.observasi.edit', $o->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.observasi.destroy', $o->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data ini?')" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $data->links() }}
        </div>
    </div>

@endsection
