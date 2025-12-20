<div class="row">

    <div class="col-md-6">
        <label>Kode Parameter</label>
        <input type="text" name="kode_indikator" class="form-control"
            value="{{ old('kode_indikator', $i->kode_indikator ?? '') }}">
        @error('kode_indikator') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label>Nama Parameter</label>
        <input type="text" name="nama_indikator" class="form-control"
            value="{{ old('nama_indikator', $i->nama_indikator ?? '') }}">
        @error('nama_indikator') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-4 mt-3">
        <label>Satuan</label>
        <input type="text" name="satuan" class="form-control"
            value="{{ old('satuan', $i->satuan ?? '') }}">
        @error('satuan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-4 mt-3">
        <label>Baku Mutu</label>
        <input type="number" step="any" name="baku_mutu" class="form-control"
            value="{{ old('baku_mutu', $i->baku_mutu ?? '') }}">
        @error('baku_mutu') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

</div>
