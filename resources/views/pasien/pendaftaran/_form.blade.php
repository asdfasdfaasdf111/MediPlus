@php
  // $pasien bisa null (create) atau instance (edit)
  $isEdit = isset($pasien);

  // opsi fallback jika tidak dikirim controller
  $hubunganOpts       = $hubunganOpts       ?? ['Orang Tua','Saudara','Pasangan','Anak','Lainnya'];
  $jenisIdentitasOpts = $jenisIdentitasOpts ?? ['KTP','SIM','PASPOR'];
  $jenisKelaminOpts   = $jenisKelaminOpts   ?? ['Laki-laki','Perempuan'];
  $golonganDarahOpts  = $golonganDarahOpts  ?? ['A','B','AB','O','Tidak Tahu'];

  // action & method
  $action = $isEdit
      ? route('pasien.datapasien.update', $pasien)
      : route('pasien.datapasien.store');
@endphp

<form action="{{ $action }}" method="POST" novalidate>
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- Identitas Utama --}}
  <h6 class="text-uppercase text-muted mb-3">Identitas Utama</h6>
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
      <input type="text" name="namaLengkap" maxlength="150" required
             class="form-control @error('namaLengkap') is-invalid @enderror"
             value="{{ old('namaLengkap', $pasien->namaLengkap ?? '') }}"
             placeholder="Nama lengkap pasien">
      @error('namaLengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label">Hubungan Dengan Pasien <span class="text-danger">*</span></label>
      <select name="hubunganKeluarga" class="form-select @error('hubunganKeluarga') is-invalid @enderror" required>
        <option value="" disabled {{ old('hubunganKeluarga', $pasien->hubunganKeluarga ?? '')==='' ? 'selected' : '' }}>Pilih...</option>
        @foreach($hubunganOpts as $opt)
          <option value="{{ $opt }}" @selected(old('hubunganKeluarga', $pasien->hubunganKeluarga ?? '') === $opt)>{{ $opt }}</option>
        @endforeach
      </select>
      @error('hubunganKeluarga') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <hr class="my-4">

  {{-- Identitas Dokumen & Demografi --}}
  <h6 class="text-uppercase text-muted mb-3">Identitas Dokumen & Demografi</h6>
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <label class="form-label">Jenis Identitas <span class="text-danger">*</span></label>
      <select name="jenisIdentitas" class="form-select @error('jenisIdentitas') is-invalid @enderror" required>
        <option value="" disabled {{ old('jenisIdentitas', $pasien->jenisIdentitas ?? '')==='' ? 'selected' : '' }}>Pilih...</option>
        @foreach($jenisIdentitasOpts as $opt)
          <option value="{{ $opt }}" @selected(old('jenisIdentitas', $pasien->jenisIdentitas ?? '') === $opt)>{{ $opt }}</option>
        @endforeach
      </select>
      @error('jenisIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 col-md-6">
      <label class="form-label">No. Identitas <span class="text-danger">*</span></label>
      <input type="text" name="noIdentitas" maxlength="50" required
             class="form-control @error('noIdentitas') is-invalid @enderror"
             value="{{ old('noIdentitas', $pasien->noIdentitas ?? '') }}"
             placeholder="Nomor identitas">
      @error('noIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 col-md-6">
      <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
      <input type="date" name="tanggalLahir" required
             class="form-control @error('tanggalLahir') is-invalid @enderror"
             value="{{ old('tanggalLahir', isset($pasien->tanggalLahir) ? \Illuminate\Support\Carbon::parse($pasien->tanggalLahir)->format('Y-m-d') : '') }}">
      @error('tanggalLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12 col-md-6">
      <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
      <select name="jenisKelamin" class="form-select @error('jenisKelamin') is-invalid @enderror" required>
        <option value="" disabled {{ old('jenisKelamin', $pasien->jenisKelamin ?? '')==='' ? 'selected' : '' }}>Pilih...</option>
        @foreach($jenisKelaminOpts as $opt)
          <option value="{{ $opt }}" @selected(old('jenisKelamin', $pasien->jenisKelamin ?? '') === $opt)>{{ $opt }}</option>
        @endforeach
      </select>
      @error('jenisKelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <hr class="my-4">

  {{-- Kontak & Alamat --}}
  <h6 class="text-uppercase text-muted mb-3">Kontak & Alamat</h6>
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <label class="form-label">No. HP <span class="text-danger">*</span></label>
      <input type="tel" name="noHP" inputmode="numeric" maxlength="30" required
             class="form-control @error('noHP') is-invalid @enderror"
             value="{{ old('noHP', $pasien->noHP ?? '') }}" placeholder="081234567890">
      @error('noHP') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
      <label class="form-label">Alamat Domisili <span class="text-danger">*</span></label>
      <textarea name="alamatDomisili" rows="2" maxlength="255" required
                class="form-control @error('alamatDomisili') is-invalid @enderror"
                placeholder="Nama jalan, nomor, RT/RW, kelurahan, kecamatan, kota/kabupaten">{{ old('alamatDomisili', $pasien->alamatDomisili ?? '') }}</textarea>
      @error('alamatDomisili') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  <hr class="my-4">

  {{-- Kesehatan --}}
  <h6 class="text-uppercase text-muted mb-3">Kesehatan</h6>
  <div class="row g-3">
    <div class="col-12 col-md-6">
      <label class="form-label">Alergi <span class="text-muted">(opsional)</span></label>
      <input type="text" name="alergi" maxlength="255"
             class="form-control @error('alergi') is-invalid @enderror"
             value="{{ old('alergi', $pasien->alergi ?? '') }}"
             placeholder="Misal: obat tertentu / makanan">
      @error('alergi') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label">Golongan Darah <span class="text-danger">*</span></label>
      <select name="golonganDarah" class="form-select @error('golonganDarah') is-invalid @enderror" required>
        <option value="" disabled {{ old('golonganDarah', $pasien->golonganDarah ?? '')==='' ? 'selected' : '' }}>Pilih...</option>
        @foreach($golonganDarahOpts as $opt)
          <option value="{{ $opt }}" @selected(old('golonganDarah', $pasien->golonganDarah ?? '') === $opt)>{{ $opt }}</option>
        @endforeach
      </select>
      @error('golonganDarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>

  {{-- Actions --}}
  <div class="d-flex justify-content-center gap-2 gap-md-3 pt-4">
    <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-outline-primary px-4 px-md-5">Batal</a>
    <button type="submit" class="btn btn-primary px-4 px-md-5">
      {{ $isEdit ? 'Update' : 'Simpan' }}
    </button>
  </div>
</form>
