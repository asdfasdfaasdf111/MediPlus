<form action="{{ route('superadmin.submit') }}" method="POST">
    @csrf

    <div class="form-group">
        <h2 class="">Data Rumah Sakit</h2>
        <label>Nama Rumah Sakit</label>
        <input type="text" class="form-control" name="nama_rs" placeholder="Nama Rumah Sakit">
    </div>
    <div class="form-group">
        <label>Alamat Rumah Sakit</label>
        <input type="text" class="form-control" name="alamat" placeholder="Alamat Rumah Sakit">
    </div>
    <div class="form-group">
        <label>No. Telepon Rumah Sakit</label>
        <input type="text" class="form-control" name="noTelepon" placeholder="No. Telepon Rumah Sakit">
    </div>
    <div class="form-group">
        <h2 class="">Data Admin Rumah Sakit</h2>
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" name="nama_admin" placeholder="Nama Lengkap">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" name="email" placeholder="Email">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('superadmin.homepage') }}" class="btn btn-secondary">Kembali</a>
</form>
