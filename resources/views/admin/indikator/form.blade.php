@php
    // aman dipakai di create.blade.php (saat $i belum ada) maupun edit.blade.php
    $biotaLaut    = isset($i) ? $i->bakuMutu->firstWhere('peruntukan', 'Biota Laut') : null;
    $pelabuhan    = isset($i) ? $i->bakuMutu->firstWhere('peruntukan', 'Pelabuhan') : null;
    $wisataBahari = isset($i) ? $i->bakuMutu->firstWhere('peruntukan', 'Wisata Bahari') : null;
@endphp

<div class="row">
    <div class="col-md-6">
        <label>Kode Parameter</label>
        <input type="text" name="kode_indikator" class="form-control"
            value="{{ old('kode_indikator', $i->kode_indikator ?? '') }}">
        @error('kode_indikator')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-6">
        <label>Nama Parameter</label>
        <input type="text" name="nama_indikator" class="form-control"
            value="{{ old('nama_indikator', $i->nama_indikator ?? '') }}">
        @error('nama_indikator')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col-md-4 mt-3">
        <label>Satuan</label>
        <input type="text" name="satuan" class="form-control"
            value="{{ old('satuan', $i->satuan ?? '') }}">
        @error('satuan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<hr>
<h5>Baku Mutu Berdasarkan Peruntukan</h5>
        <div class="row">
            <div class="col-md-4">
            <label>Biota Laut</label>
            <input type="number" step="any" name="biota_laut" class="form-control"
                value="{{ old('biota_laut', $biotaLaut->baku_mutu_formatted ?? '') }}">
        </div>
        <div class="col-md-4">
            <label>Pelabuhan</label>
            <input type="number" step="any" name="pelabuhan" class="form-control"
                value="{{ old('pelabuhan', $pelabuhan->baku_mutu_formatted ?? '') }}">
        </div>
        <div class="col-md-4">
            <label>Wisata Bahari</label>
            <input type="number" step="any" name="wisata_bahari" class="form-control"
                value="{{ old('wisata_bahari', $wisataBahari->baku_mutu_formatted ?? '') }}">
        </div>
</div>