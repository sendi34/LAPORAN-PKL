<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<div class="row">

    <div class="col-md-6">
        <label>Kode Lokasi</label>
        <input type="text" name="kode_lokasi" class="form-control"
            value="{{ old('kode_lokasi', $lokasi->kode_lokasi ?? '') }}">
        @error('kode_lokasi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label>Nama Lokasi</label>
        <input type="text" name="nama_lokasi" class="form-control"
            value="{{ old('nama_lokasi', $lokasi->nama_lokasi ?? '') }}">
        @error('nama_lokasi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
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
        <input type="text" id="latitude" name="latitude" class="form-control"
            value="{{ old('latitude', $lokasi->latitude ?? '') }}">
    </div>

    <div class="col-md-3 mt-3">
        <label>Longitude</label>
        <input type="text" id="longitude" name="longitude" class="form-control"
            value="{{ old('longitude', $lokasi->longitude ?? '') }}">
    </div>

    <div class="col-md-6 mt-3">
        <label>Peruntukan</label>

        <select name="peruntukan" class="form-control">

            <option value="">-- Pilih Peruntukan --</option>

            <option value="Biota Laut"
                {{ old('peruntukan', $lokasi->peruntukan ?? '') == 'Biota Laut' ? 'selected' : '' }}>
                Biota Laut
            </option>

            <option value="Pelabuhan"
                {{ old('peruntukan', $lokasi->peruntukan ?? '') == 'Pelabuhan' ? 'selected' : '' }}>
                Pelabuhan
            </option>

            <option value="Wisata Bahari"
                {{ old('peruntukan', $lokasi->peruntukan ?? '') == 'Wisata Bahari' ? 'selected' : '' }}>
                Wisata Bahari
            </option>

        </select>

    </div>

    <div class="col-md-12 mt-4">
        <label>Pilih Lokasi di Peta</label>
        <div id="map" style="height:400px;"></div>
    </div>

</div>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var lat = document.getElementById('latitude').value || -3.44218;
var lng = document.getElementById('longitude').value || 114.82621;

var map = L.map('map').setView([lat,lng], 10);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'© OpenStreetMap'
}).addTo(map);

var marker = L.marker([lat,lng]).addTo(map);

map.on('click', function(e){

    var latitude = e.latlng.lat;
    var longitude = e.latlng.lng;

    marker.setLatLng([latitude,longitude]);

    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;

});

</script>