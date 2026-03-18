@extends('layouts.sbadmin')
@section('title','Detail Indikator Uji')

@section('content')

<h1 class="h3 mb-4">Detail Parameter Uji</h1>

<div class="card shadow mb-3">
    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th width="200">Kode Parameter</th>
                <td>{{ $i->kode_indikator }}</td>
            </tr>

            <tr>
                <th>Nama Parameter</th>
                <td>{{ $i->nama_indikator }}</td>
            </tr>

            <tr>
                <th>Satuan</th>
                <td>{{ $i->satuan }}</td>
            </tr>
        </table>

    </div>
</div>


<div class="card shadow">
    <div class="card-header">
        <b>Baku Mutu Berdasarkan Peruntukan</b>
    </div>

    <div class="card-body">

        @if($i->bakuMutu && $i->bakuMutu->isNotEmpty())

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Peruntukan</th>
                    <th>Baku Mutu</th>
                </tr>
            </thead>

            <tbody>
                @foreach($i->bakuMutu as $k => $b)
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td>{{ $b->peruntukan }}</td>
                    <td>{{ rtrim(rtrim(number_format($b->baku_mutu,4,'.',''),'0'),'.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else

        <div class="alert alert-info">
            Belum ada data baku mutu untuk parameter ini.
        </div>

        @endif

    </div>
</div>

@endsection