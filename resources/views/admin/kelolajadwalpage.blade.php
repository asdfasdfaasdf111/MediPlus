<a href="{{ route('admin.homepage')}}">
    Homepage
</a>

<a href="{{ route('admin.keloladokterpage')}}">
    Kelola Dokter
</a>

<a href="{{ route('admin.kelolapetugaspage')}}">
    Kelola Petugas
</a>

<a href="{{ route('admin.kelolajadwalpage')}}">
    Kelola Jadwal
</a>

<a href="{{ route('admin.logaktivitaspage')}}">
    Log Aktivitas
</a>

<form action="{{ route('admin.updateJadwal')}}" method ="POST">
    @csrf
    <div>
        <label for='jamBuka'>Jam Buka</label>
        <input type='time' name='jamBuka' id='jamBuka' value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamBuka)->format('H:i') }}"   required>
    </div>

    <div>
        <label for='jamTutup'>Jam Tutup</label>
        <input type='time' name='jamTutup' id='jamTutup' value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamTutup)->format('H:i') }}"   required>
        @error('jamTutup')
            <div style="color: red;">{{ "Jam tutup harus diatas jam buka" }}</div>
        @enderror
    </div>

    <button type='submit'>Update Jadwal</button>
</form>

<form action="{{ route('admin.updateJumlahPasien')}}" method ="POST">
    @csrf
    <div>
        <label for='jumlahPasien'>Jumlah Pasien / 1 jam</label>
        <input type='number' name='jumlahPasien' id='jumlahPasien' value="{{ $admin->rumahSakit->jumlahPasien }}"   required>
        @error('jumlahPasien')
            <div style="color: red;">{{ "Jumlah Pasien harus positif" }}</div>
        @enderror
    </div>

    <button type='submit'>Update Jumlah Pasien</button>
</form>

