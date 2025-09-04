<div class="col-md-10 p-4 bg-light">
    <div class="card shadow-sm">
        <h4 class="text-center mb-4 pt-5">Tambah DICOM</h4>
        <div class="card-body px-5">
        <form method="POST" action="{{ route('petugas.tambahDicom') }}">
            @csrf

            <label for="modalitasId" class="form-label">Alamat IP</label>
            <select name="modalitasId" class="form-control">
                @foreach($petugas->rumahSakit->modalitas as $modalitas)
                    <option value="{{ $modalitas->id }}">
                        {{ $modalitas->alamatIP }}
                    </option>
                @endforeach
            </select>

            <div class="mb-3">
                <label for="netMask" class="form-label">Net Mask</label>
                <input type="text" class="form-control" 
                    name="netMask" id="netMask" placeholder="Net Mask" value="{{ old('netMask') }}" required>
            </div>

            <div class="mb-3">
                <label for="layananDicom" class="form-label">Layanan DICOM</label>
                <input type="text" class="form-control" 
                    name="layananDicom" id="layananDicom" placeholder="Layanan DICOM" value="{{ old('layananDicom') }}" required>
            </div>

            <div class="mb-3">
                <label for="peran" class="form-label">Peran</label>
                <input type="text" class="form-control" 
                    name="peran" id="peran" placeholder="Peran" value="{{ old('peran') }}" required>
            </div>

            <div class="mb-3">
                <label for="AET" class="form-label">AET</label>
                <input type="text" class="form-control" 
                    name="AET" id="AET" placeholder="AET" value="{{ old('AET') }}" required>
            </div>

            <div class="mb-3">
                <label for="port" class="form-label">Port</label>
                <input type="text" class="form-control" 
                    name="port" id="port" placeholder="Port" value="{{ old('port') }}" required>
            </div>
            

            <div class="d-flex justify-content-center gap-3 pt-3">
                <a href="{{ route('petugas.keloladicom') }}" 
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