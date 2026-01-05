@extends('layouts.sbadmin')
@section('title','Data Indikator Uji')

@section('content')

<div class="d-flex justify-content-between mb-4">
    <h1 class="h3">Data Parameter</h1>
    <a href="{{ route('admin.indikator.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Parameter</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Kode</th>
                    <th>Nama Parameter</th>
                    <th>Satuan</th>
                    <th>Baku Mutu</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i)
                <tr>
                    <td>{{ $i->kode_indikator }}</td>
                    <td>{{ $i->nama_indikator }}</td>
                    <td>{{ $i->satuan }}</td>
                    <td>{{ (float) $i->baku_mutu }}</td>
                    <td>
                        <a href="{{ route('admin.indikator.show',$i->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.indikator.edit',$i->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.indikator.destroy',$i->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Hapus indikator ini?')">
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
