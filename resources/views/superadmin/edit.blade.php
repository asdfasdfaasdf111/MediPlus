<form action="{{ route('superadmin.submitdata', $rumahSakit->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <h2 class="">Data Rumah Sakit</h2>
        <label>Nama Rumah Sakit</label>
        <input type="text" name="nama_rs" value="{{ $rumahSakit->nama }}">
    </div>
    <div class="form-group">
        <label>Alamat Rumah Sakit</label>
        <input type="text" name="alamat" value="{{ $rumahSakit->alamat }}">
    </div>
    <div class="form-group">
        <label>No. Telepon Rumah Sakit</label>
        <input type="text" name="noTelepon" value="{{ $rumahSakit->noTelepon }}">
    </div>
    <div class="form-group">
        <h2 class="">Data Admin Rumah Sakit</h2>
        <label>Nama Lengkap</label>
        <input type="text" name="nama_admin" value="{{ $rumahSakit->admin->user->name }}">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $rumahSakit->admin->user->email }}">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
    </div>
    <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('superadmin.homepage') }}" class="btn btn-secondary">Kembali</a>
</form>
