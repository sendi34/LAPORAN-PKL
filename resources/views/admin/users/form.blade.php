@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
           value="{{ old('nama', $user->nama ?? '') }}" required>
    @error('nama')
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
           value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Role</label>
    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
        <option value="">Pilih Role</option>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
    </select>
    @error('role')
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
    @error('password')
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>