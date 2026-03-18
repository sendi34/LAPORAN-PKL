@extends('layouts.sbadmin')
@section('title', 'Data Indikator Uji')

@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Data Parameter</h1>

        <a href="{{ route('admin.indikator.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Parameter
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="120">Kode</th>
                        <th>Nama Parameter</th>
                        <th width="120">Satuan</th>
                        <th width="200">Baku Mutu (Peruntukan)</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i)
                        <tr>

                            <td>{{ $i->kode_indikator }}</td>

                            <td>{{ $i->nama_indikator }}</td>

                            <td>{{ $i->satuan }}</td>

                            <td>

                                @if ($i->bakuMutu && $i->bakuMutu->isNotEmpty())
                                    @foreach ($i->bakuMutu as $b)
                                        <div>
                                            <b>{{ $b->peruntukan }}</b> :
                                            {{ rtrim(rtrim(number_format($b->baku_mutu,4,'.',''),'0'),'.') }}
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted">
                                        Belum ada baku mutu
                                    </span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.indikator.show', $i->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('admin.indikator.edit', $i->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.indikator.destroy', $i->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Hapus parameter ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data parameter</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="mt-3">
                {{ $data->links() }}
            </div>

        </div>
    </div>

@endsection
