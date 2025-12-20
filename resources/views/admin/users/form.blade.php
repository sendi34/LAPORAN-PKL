<div class="form-group">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama ?? '') }}" required>
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="form-group">
    <label>Role</label>
    <select name="role" class="form-control" required>
        <option value="admin" {{ isset($user) && $user->role=='admin' ? 'selected' : '' }}>Admin</option>
        <option value="petugas" {{ isset($user) && $user->role=='petugas' ? 'selected' : '' }}>Petugas</option>
    </select>
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control">
    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
</div>
