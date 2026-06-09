<div class="mb-4">
    <label class="font-weight-bold">Observasi</label>
    <select name="observasi_id"
            class="form-control"
            required
            {{ isset($observasiSingle) ? 'disabled' : '' }}>
        <option value="">-- Pilih Observasi --</option>

        @foreach($observasi as $o)
            <option value="{{ $o->id }}"
                {{ (isset($observasiSingle) && $observasiSingle->id == $o->id) ? 'selected' : '' }}
                {{ (isset($hu) && $hu && $hu->observasi_id == $o->id) ? 'selected' : '' }}>
                {{ $o->lokasi->nama_lokasi }}
                | {{ $o->periode_pemantauan }}
                | {{ $o->tanggal_pemantauan }}
                | {{ $o->shu }}
            </option>
        @endforeach
    </select>

    @if(isset($observasiSingle))
        <input type="hidden" name="observasi_id" value="{{ $observasiSingle->id }}">
        <small class="text-muted">
            Observasi tidak dapat diubah saat edit
        </small>
    @endif
</div>

<hr>

<h6 class="mb-1">
    <label class="font-weight-bold">Input Nilai Parameter</label>
</h6>

<div class="row">

    @foreach($indikator as $i)
    <div class="col-md-6">

        <input type="hidden"
               name="indikator_id[]"
               value="{{ $i->id }}">

        <div class="form-group">
            <label>
                <strong>{{ $i->nama_indikator }}</strong>
            </label>

            <div class="input-group">

                <input type="number"
                       step="any"
                       name="nilai[]"
                       class="form-control"
                       value="{{ isset($dataNilai[$i->id]) ? $dataNilai[$i->id]->nilai : '' }}"
                       placeholder="Masukkan nilai {{ $i->nama_indikator }}"
                       required>

                <div class="input-group-append">
                    <span class="input-group-text">
                        {{ $i->satuan }}
                    </span>
                </div>

            </div>
        </div>

    </div>
    @endforeach

</div>

<hr>

<div class="form-group">
    <label class="font-weight-bold">
        Keterangan
    </label>

    <textarea name="keterangan"
              rows="3"
              class="form-control">{{ (isset($hu) && $hu) ? $hu->keterangan : old('keterangan') }}</textarea>
</div>

<div class="form-group">
    <label class="font-weight-bold">
        File Berkas Surat Hasil Uji
    </label>

    <input type="file"
           name="file_berkas"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">

    <small class="text-muted">
        Format file: PDF, JPG, PNG, DOC, DOCX (Maksimal 5 MB)
    </small>

    @if(isset($hu) && $hu && $hu->file_berkas)
        <div class="mt-2">
            <a href="{{ asset('storage/'.$hu->file_berkas) }}"
               target="_blank"
               class="text-success">

                <i class="fas fa-file-alt"></i>
                {{ basename($hu->file_berkas) }}

            </a>

            <br>

            <small class="text-muted">
                Upload file baru untuk mengganti file lama
            </small>
        </div>
    @endif
</div>
