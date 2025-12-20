@extends('layouts.auth')

@section('title', 'Register')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-5">

                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Buat Akun</h1>
                </div>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Pilih Role</label>
                        <select name="role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100">Daftar</button>

                    <hr>

                    <div class="text-center">
                        <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
