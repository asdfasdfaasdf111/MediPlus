<div class="col-md-10 p-4 bg-light">
    <div class="card shadow-sm">
        <h4 class="text-center mb-4 pt-5">Tambah Jenis Pemeriksaan</h4>
        <div class="card-body px-5">
        <form method="POST" action="{{ route('petugas.tambahJenisPemeriksaan') }}">
            @csrf

            <label for="modalitasId" class="form-label">Modalitas</label>
            <select name="modalitasId" class="form-control">
                @foreach($petugas->rumahSakit->modalitas as $modalitas)
                    <option value="{{ $modalitas->id }}">
                        {{ $modalitas->namaModalitas }}
                    </option>
                @endforeach
            </select>

            <div class="mb-3">
                <label for="namaJenisPemeriksaan" class="form-label">Nama Jenis Pemeriksaan</label>
                <input type="text" class="form-control" 
                    name="namaJenisPemeriksaan" id="namaJenisPemeriksaan" placeholder="Nama Jenis Pemeriksaan" value="{{ old('namaJenisPemeriksaan') }}" required>
            </div>

            <div class="mb-3">
                <label for="namaPemeriksaanSpesifik" class="form-label">Nama Pemeriksaan Spesifik</label>
                <input type="text" class="form-control" 
                    name="namaPemeriksaanSpesifik" id="namaPemeriksaanSpesifik" placeholder="Nama Pemeriksaan Spesifik" value="{{ old('namaPemeriksaanSpesifik') }}" required>
            </div>

            <div class="mb-3">
                <label for="kelompokJenisPemeriksaan" class="form-label">Kelompok Jenis Pemeriksaan</label>
                <input type="text" class="form-control" 
                    name="kelompokJenisPemeriksaan" id="kelompokJenisPemeriksaan" placeholder="Kelompok Jenis Pemeriksaan" value="{{ old('kelompokJenisPemeriksaan') }}" required>
            </div>

            <div class="mb-3">
                <label for="pemakaianKontras" class="form-label">Memakai Kontras</label>
                <input type="hidden" name="pemakaianKontras" value="0">
                <input type="checkbox" name="pemakaianKontras" value="1" {{ old('pemakaianKontras') == 1 ? 'checked' : '' }}>
            </div>

            <div class="mb-3">
                <label for="lamaPemeriksaan" class="form-label">Lama Pemeriksaan</label>
                <input type="number" name="lamaPemeriksaan" min="1" class="w-16 border p-1 text-center" value="{{ old('lamaPemeriksaan') }}" required>
                <label for="lamaPemeriksaan" class="form-label">Menit</label>
            </div>

            <div class="mb-3">
                <label for="diDampingiDokter" class="form-label">Perlu Didampingi Dokter</label>
                <input type="hidden" name="diDampingiDokter" value="0">
                <input type="checkbox" name="diDampingiDokter" value="1" {{ old('diDampingiDokter') == 1 ? 'checked' : '' }}>
            </div>
            

            <div class="d-flex justify-content-center gap-3 pt-3">
                <a href="{{ route('petugas.kelolajenispemeriksaan') }}" 
                   class="btn btn-outline-primary px-5 rounded-pill">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary px-5 rounded-pill">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>