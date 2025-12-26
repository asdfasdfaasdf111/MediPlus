<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petugas | Tambah Data Pasien</title>

  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  @vite(['resources/js/calendar.js'])
  @vite(['resources/js/switch-datapendaming.js'])
</head>

<body class="bg-light">

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">

      {{-- CARD --}}
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

          {{-- HEADER --}}
          <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
              <h4 class="fw-bold mb-1">Tambah Data Pasien</h4>
              <small class="text-muted">
                Isi data pasien yang akan didaftarkan secara onsite
              </small>
            </div>
            <a href="{{ route('petugas.daftartipepasien', $masterPasien) }}"
               class="btn btn-light btn-sm rounded-pill">
              <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
          </div>

          @php
            $isEdit = isset($pasien);

            $hubunganOpts       = $hubunganOpts       ?? ['Diri Sendiri','Orang Tua','Saudara','Pasangan','Anak','Lainnya'];
            $jenisIdentitasOpts = $jenisIdentitasOpts ?? ['KTP','SIM','PASPOR'];
            $jenisKelaminOpts   = $jenisKelaminOpts   ?? ['Laki-laki','Perempuan'];
            $golonganDarahOpts  = $golonganDarahOpts  ?? ['A','B','AB','O','Tidak Tahu'];
          @endphp

          <form action="{{ route('petugas.bikindatapasienbaru', $masterPasien) }}"
                method="POST" novalidate>
            @csrf
            @if($isEdit) @method('PUT') @endif

            {{-- Identitas Utama --}}
            <h6 class="text-uppercase text-muted mb-3">Identitas Utama</h6>
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label">
                  Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text" name="namaLengkap" maxlength="150" required
                       class="form-control @error('namaLengkap') is-invalid @enderror"
                       value="{{ old('namaLengkap', $pasien->namaLengkap ?? '') }}"
                       placeholder="Nama lengkap pasien">
                @error('namaLengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label">
                  Pasien Merupakan <span class="text-danger">*</span>
                </label>
                <select name="hubunganKeluarga"
                        class="form-select @error('hubunganKeluarga') is-invalid @enderror"
                        required>
                  <option value="" disabled {{ old('hubunganKeluarga', $pasien->hubunganKeluarga ?? '')==='' ? 'selected' : '' }}>
                    Pilih Opsi
                  </option>
                  @foreach($hubunganOpts as $opt)
                    <option value="{{ $opt }}"
                      @selected(old('hubunganKeluarga', $pasien->hubunganKeluarga ?? '') === $opt)>
                      {{ $opt }}
                    </option>
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
                <label class="form-label">
                  Jenis Identitas <span class="text-danger">*</span>
                </label>
                <select name="jenisIdentitas"
                        class="form-select @error('jenisIdentitas') is-invalid @enderror"
                        required>
                  <option value="" disabled {{ old('jenisIdentitas', $pasien->jenisIdentitas ?? '')==='' ? 'selected' : '' }}>
                    Pilih Opsi
                  </option>
                  @foreach($jenisIdentitasOpts as $opt)
                    <option value="{{ $opt }}"
                      @selected(old('jenisIdentitas', $pasien->jenisIdentitas ?? '') === $opt)>
                      {{ $opt }}
                    </option>
                  @endforeach
                </select>
                @error('jenisIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label">
                  No. Identitas <span class="text-danger">*</span>
                </label>
                <input type="text" name="noIdentitas" maxlength="50" required
                       class="form-control @error('noIdentitas') is-invalid @enderror"
                       value="{{ old('noIdentitas', $pasien->noIdentitas ?? '') }}"
                       placeholder="Nomor identitas">
                @error('noIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label">
                  Tanggal Lahir <span class="text-danger">*</span>
                </label>
                <input type="date" name="tanggalLahir" required
                       class="form-control @error('tanggalLahir') is-invalid @enderror"
                       value="{{ old('tanggalLahir', isset($pasien->tanggalLahir)
                        ? \Illuminate\Support\Carbon::parse($pasien->tanggalLahir)->format('Y-m-d') : '') }}">
                @error('tanggalLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label">
                  Jenis Kelamin <span class="text-danger">*</span>
                </label>
                <select name="jenisKelamin"
                        class="form-select @error('jenisKelamin') is-invalid @enderror"
                        required>
                  <option value="" disabled {{ old('jenisKelamin', $pasien->jenisKelamin ?? '')==='' ? 'selected' : '' }}>
                    Pilih Opsi
                  </option>
                  @foreach($jenisKelaminOpts as $opt)
                    <option value="{{ $opt }}"
                      @selected(old('jenisKelamin', $pasien->jenisKelamin ?? '') === $opt)>
                      {{ $opt }}
                    </option>
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
                <label class="form-label">
                  No. HP <span class="text-danger">*</span>
                </label>
                <input type="tel" name="noHP" inputmode="numeric" maxlength="30" required
                       class="form-control @error('noHP') is-invalid @enderror"
                       value="{{ old('noHP', $pasien->noHP ?? '') }}"
                       placeholder="081234567890">
                @error('noHP') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12">
                <label class="form-label">
                  Alamat Domisili <span class="text-danger">*</span>
                </label>
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
                <label class="form-label">
                  Alergi <span class="text-muted">(opsional)</span>
                </label>
                <input type="text" name="alergi" maxlength="255"
                       class="form-control @error('alergi') is-invalid @enderror"
                       value="{{ old('alergi', $pasien->alergi ?? '') }}"
                       placeholder="Misal: obat tertentu / makanan">
                @error('alergi') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label">
                  Golongan Darah <span class="text-danger">*</span>
                </label>
                <select name="golonganDarah"
                        class="form-select @error('golonganDarah') is-invalid @enderror"
                        required>
                  <option value="" disabled {{ old('golonganDarah', $pasien->golonganDarah ?? '')==='' ? 'selected' : '' }}>
                    Pilih Opsi
                  </option>
                  @foreach($golonganDarahOpts as $opt)
                    <option value="{{ $opt }}"
                      @selected(old('golonganDarah', $pasien->golonganDarah ?? '') === $opt)>
                      {{ $opt }}
                    </option>
                  @endforeach
                </select>
                @error('golonganDarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-center gap-3 pt-4">
              <a href="{{ route('petugas.daftartipepasien', $masterPasien) }}"
                 class="btn btn-outline-primary rounded-pill px-5">
                Batal
              </a>
              <button type="submit"
                      class="btn btn-primary rounded-pill px-5">
                Simpan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
