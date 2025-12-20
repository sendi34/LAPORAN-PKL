@extends('layouts.sbadmin')
@section('title','Edit Hasil Uji')
@section('content')
<h1 class="h3 mb-4">Edit Hasil Uji</h1>

<div class="card shadow mb-3">
    <div class="card-body">
        <h5>Informasi Observasi</h5>
        <table class="table table-bordered">
            <tr>
                <th width="30%">Lokasi</th>
                <td>{{ $observasiSingle->lokasi->nama_lokasi }}</td>
            </tr>
            <tr>
                <th>Tanggal Pemantauan</th>
                <td>{{ \Carbon\Carbon::parse($observasiSingle->tanggal_pemantauan)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>SHU</th>
                <td>{{ $observasiSingle->shu }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.hasiluji.update', $observasiSingle->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="observasi_id" value="{{ $observasiSingle->id }}">
            
            {{-- ====== 5 INDIKATOR LANGSUNG ====== --}}
            <h5 class="mt-2 mb-3">Input Nilai Indikator</h5>

            @foreach($indikator as $i)
            <div class="card p-3 mb-3">
                <input type="hidden" name="indikator_id[]" value="{{ $i->id }}">
                
                <label><strong>{{ $i->nama_indikator }}</strong> ({{ $i->satuan }})</label>
                
                <input type="number" step="any" name="nilai[]" class="form-control mt-2"
                    value="{{ isset($dataNilai[$i->id]) ? (float) $dataNilai[$i->id]->nilai : '' }}"
                    placeholder="Nilai {{ $i->nama_indikator }}" required>
            </div>
            @endforeach

            <div class="mb-3 mt-3">
                <label>Keterangan (opsional)</label>
                <textarea name="keterangan" class="form-control">{{ (isset($hu) && $hu) ? $hu->keterangan : old('keterangan') }}</textarea>
            </div>

            {{-- FILE BERKAS SURAT HASIL UJI --}}
            <div class="mb-3">
                <label>File Berkas Surat Hasil Uji (opsional)</label>
                <input type="file" name="file_berkas" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                <small class="text-muted">Format: PDF, JPG, PNG, DOC, DOCX (Max: 5MB)</small>
                
                @if(isset($hu) && $hu && $hu->file_berkas)
                    <div class="mt-2">
                        <small class="text-success d-block">
                            <i class="fas fa-file"></i> File saat ini: 
                            <a href="{{ asset('storage/'.$hu->file_berkas) }}" target="_blank" class="text-primary">
                                {{ basename($hu->file_berkas) }}
                            </a>
                        </small>
                        <small class="text-muted d-block">*Upload file baru untuk mengganti file lama</small>
                    </div>
                @endif
            </div>
            
            <button type="submit" class="btn btn-success mt-3">
                Update
            </button>
            <a href="{{ route('admin.hasiluji.index') }}" class="btn btn-secondary mt-3">
                Batal
            </a>
        </form>
    </div>
</div>
@endsection