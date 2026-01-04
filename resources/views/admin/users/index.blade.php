@extends('layouts.sbadmin')
@section('title', 'Manajemen User')

@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3">Data Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->nama }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if ($u->role == 'admin')
                                    <span class="badge bg-success text-white">Admin</span>
                                @else
                                    <span class="badge bg-info text-white">Petugas</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}

        </div>
    </div>

@endsection
