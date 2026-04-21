{{-- Tambahkan enctype di tag form pembuka --}}
{{-- <form action="..." method="POST" enctype="multipart/form-data"> --}}

<div class="mb-3">
    <label>Observasi</label>
    <select name="observasi_id" class="form-control" required {{ isset($observasiSingle) ? 'disabled' : '' }}>
        <option value="">-- Pilih Observasi --</option>
        @foreach($observasi as $o)
            <option value="{{ $o->id }}" 
                {{ (isset($observasiSingle) && $observasiSingle->id == $o->id) ? 'selected' : '' }}
                {{ (isset($hu) && $hu && $hu->observasi_id == $o->id) ? 'selected' : '' }}>
                {{ $o->lokasi->nama_lokasi }} | {{ $o->lokasi->peruntukan }} | {{ $o->tanggal_pemantauan }} | {{ $o->periode_pemantauan }} | {{ $o->shu }}
            </option>
        @endforeach
    </select>
    @if(isset($observasiSingle))
        <input type="hidden" name="observasi_id" value="{{ $observasiSingle->id }}">
        <small class="text-muted">Observasi tidak dapat diubah saat edit</small>
    @endif
</div>

{{-- ====== 5 INDIKATOR LANGSUNG (TANPA DROPDOWN) ====== --}}
<h5 class="mt-4">Input Nilai Parameter</h5>

@foreach($indikator as $i)
<div class="card p-3 mb-3">

    <!-- kirim id indikator -->
    <input type="hidden" name="indikator_id[]" value="{{ $i->id }}">

    <label><strong>{{ $i->nama_indikator }}</strong> ({{ $i->satuan }})</label>

    <input type="number" step="any" name="nilai[]" class="form-control mt-2"
        value="{{ isset($dataNilai[$i->id]) ? $dataNilai[$i->id]->nilai : '' }}"
        placeholder="Nilai {{ $i->nama_indikator }}" required>

</div>
@endforeach
{{-- ======================================== --}}

<div class="mb-3 mt-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control">{{ (isset($hu) && $hu) ? $hu->keterangan : old('keterangan') }}</textarea>
</div>

{{-- FILE BERKAS SURAT HASIL UJI --}}
<div class="mb-3">
    <label>File Berkas Surat Hasil Uji</label>
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