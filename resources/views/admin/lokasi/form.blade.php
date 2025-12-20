<div class="row">

    <div class="col-md-6">
        <label>Kode Lokasi</label>
        <input type="text" name="kode_lokasi" class="form-control"
            value="{{ old('kode_lokasi', $lokasi->kode_lokasi ?? '') }}">
        @error('kode_lokasi') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-6">
        <label>Nama Lokasi</label>
        <input type="text" name="nama_lokasi" class="form-control"
            value="{{ old('nama_lokasi', $lokasi->nama_lokasi ?? '') }}">
        @error('nama_lokasi') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="col-md-12 mt-3">
        <label>Alamat Lokasi</label>
        <textarea name="alamat_lokasi" class="form-control">{{ old('alamat_lokasi', $lokasi->alamat_lokasi ?? '') }}</textarea>
    </div>

    <div class="col-md-6 mt-3">
        <label>Provinsi</label>
        <input type="text" name="provinsi" class="form-control"
            value="{{ old('provinsi', $lokasi->provinsi ?? '') }}">
    </div>

    <div class="col-md-3 mt-3">
        <label>Latitude</label>
        <input type="text" name="latitude" class="form-control"
            value="{{ old('latitude', $lokasi->latitude ?? '') }}">
    </div>

    <div class="col-md-3 mt-3">
        <label>Longtitude</label>
        <input type="text" name="longtitude" class="form-control"
            value="{{ old('longtitude', $lokasi->longtitude ?? '') }}">
    </div>

    <div class="col-md-6 mt-3">
        <label>Peruntukan</label>
        <input type="text" name="peruntukan" class="form-control"
            value="{{ old('peruntukan', $lokasi->peruntukan ?? '') }}">
    </div>

</div>
