@extends('layouts.sbadmin')
@section('title','Data Lokasi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Data Lokasi</h1>
    <a href="{{ route('admin.lokasi.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Lokasi</a>
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
                    <th>Nama Lokasi</th>
                    <th>Alamat</th>
                    <th>Peruntukan</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lokasi as $l)
                <tr>
                    <td>{{ $l->kode_lokasi }}</td>
                    <td>{{ $l->nama_lokasi }}</td>
                    <td>{{ $l->alamat_lokasi }}</td>
                    <td>{{ $l->peruntukan }}</td>
                    <td>
                        <a href="{{ route('admin.lokasi.show',$l->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.lokasi.edit',$l->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.lokasi.destroy',$l->id) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $lokasi->links() }}
    </div>
</div>

@endsection
