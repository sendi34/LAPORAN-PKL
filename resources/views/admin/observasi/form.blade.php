<div class="mb-3">
    <label>Petugas</label>
    <select name="user_id" class="form-control" required>
        <option value="">-- Pilih Petugas --</option>
        @foreach($user as $u)
            <option value="{{ $u->id }}" {{ isset($obs) && $obs->user_id == $u->id ? 'selected':'' }}>
                {{ $u->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Lokasi</label>
    <select name="location_id" class="form-control" required>
        <option value="">-- Pilih Lokasi --</option>
        @foreach($lokasi as $l)
            <option value="{{ $l->id }}" {{ isset($obs) && $obs->location_id == $l->id ? 'selected':'' }}>
                {{ $l->nama_lokasi }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Tanggal Pemantauan</label>
    <input type="date" name="tanggal_pemantauan" class="form-control"
        value="{{ $obs->tanggal_pemantauan ?? old('tanggal_pemantauan') }}"
        required>
</div>

<div class="mb-3">
    <label>Periode Pemantauan</label>
    <select name="periode_pemantauan" class="form-control" required>
        <option value="">-- Pilih Periode --</option>
        <option value="1" {{ isset($obs) && $obs->periode_pemantauan == 1 ? 'selected' : '' }}>I (Periode 1)</option>
        <option value="2" {{ isset($obs) && $obs->periode_pemantauan == 2 ? 'selected' : '' }}>II (Periode 2)</option>
    </select>
</div>

<div class="mb-3">
    <label>SHU</label>
    <select name="shu" class="form-control" required>
        <option value="">-- Pilih Status --</option>
        <option value="ADA SHU" {{ (isset($obs) && $obs->shu == 'ADA SHU') ? 'selected':'' }}>ADA SHU</option>
        <option value="TIDAK ADA SHU" {{ (isset($obs) && $obs->shu == 'TIDAK ADA SHU') ? 'selected':'' }}>TIDAK ADA SHU</option>
    </select>
</div>
