@extends('layouts.sbadmin')
@section('title', 'Detail Observasi')
@section('content')

    <h1 class="h3 mb-4">Detail Observasi</h1>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $obs->lokasi->nama_lokasi }}</td>
                </tr>
                <tr>
                    <th>Petugas</th>
                    <td>{{ $obs->user->nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($obs->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>
                        @if ($obs->periode_pemantauan == 1)
                            I
                        @elseif($obs->periode_pemantauan == 2)
                            II
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status SHU</th>
                    <td>{{ $obs->shu }}</td>
                </tr>
            </table>

        </div>
    </div>

@endsection
