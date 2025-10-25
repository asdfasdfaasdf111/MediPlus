<div class="col-md-10 p-4 bg-light">
    <div class="card shadow-sm">
        <h4 class="text-center mb-4 pt-5">Tambah Modalitas</h4>
        <div class="card-body px-5">
        <form method="POST" action="{{ route('petugas.tambahModalitas') }}">
            @csrf

            <div class="mb-3">
                <label for="namaModalitas" class="form-label">Nama Modalitas</label>
                <input type="text" class="form-control" 
                    name="namaModalitas" id="namaModalitas" placeholder="Nama Modalitas" value="{{ old('namaModalitas') }}" required>
            </div>

            <div class="mb-3">
                <label for="jenisModalitas" class="form-label">Jenis Modalitas</label>
                <input type="text" class="form-control" 
                    name="jenisModalitas" id="jenisModalitas" placeholder="Jenis Modalitas" value="{{ old('jenisModalitas') }}" required>
            </div>

            <div class="mb-3">
                <label for="kodeRuang" class="form-label">Kode Ruang</label>
                <input type="text" class="form-control" 
                    name="kodeRuang" id="kodeRuang" placeholder="Kode Ruang" value="{{ old('kodeRuang') }}" required>
            </div>

            <div class="d-flex justify-content-center gap-3 pt-3">
                <a href="{{ route('petugas.kelolamodalitas') }}" 
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