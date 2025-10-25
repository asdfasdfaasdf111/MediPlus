@extends('layout.app')
@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid">
  <div class="row">
    {{-- Sidebar --}}
    <div class="col-md-2 min-vh-100 p-2 mt-3">
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="{{ route('profile.edit') }}"
             class="nav-link {{ request()->routeIs('profile.edit') ? 'text-primary fw-bold' : 'text-dark' }}">
            <i class="bi bi-person-circle me-2"></i> Edit Profile
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="{{ route('profile.password.edit') }}"
             class="nav-link {{ request()->routeIs('profile.password.*') ? 'text-primary fw-bold' : 'text-dark' }}">
            <i class="bi bi-shield-lock me-2"></i> Change Password
          </a>
        </li>
      </ul>
    </div>

    {{-- Content --}}
    <div class="col-md-10 p-4 bg-light">

      <div class="card shadow-sm">
        <h4 class="text-center mb-1 pt-5">Edit Profile</h4>
        <p class="text-center text-muted mb-4">Perbarui data akun dan informasi pasien</p>

        <div class="card-body px-5">
          <form action="{{ route('profile.update') }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            {{-- ================== AKUN ================== --}}
            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-person-badge me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Akun</h6>
              </div>
              <div class="mt-3 row g-3">
                <div class="col-12">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" id="name" name="name" maxlength="100" required
                         class="form-control @error('name') is-invalid @enderror"
                         placeholder="Nama lengkap"
                         value="{{ old('name', $user->name) }}">
                  @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" id="email" name="email" required
                         class="form-control @error('email') is-invalid @enderror"
                         placeholder="email@domain.com"
                         value="{{ old('email', $user->email) }}">
                  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            <hr class="my-4">

            {{-- ================== IDENTITAS ================== --}}
            @php
              $jenisIdentitasOptions = ['KTP','SIM','PASPOR'];
              $jenisIdentitasVal = old('jenisIdentitas', $pasien->jenisIdentitas ?? '');
              $jkVal = old('jenisKelamin', $pasien->jenisKelamin ?? '');
            @endphp
            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-card-text me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Identitas</h6>
              </div>
              <div class="mt-3 row g-3">
                <div class="col-md-6">
                  <label for="jenisIdentitas" class="form-label">Jenis Identitas</label>
                  <select id="jenisIdentitas" name="jenisIdentitas" required
                          class="form-select @error('jenisIdentitas') is-invalid @enderror">
                    <option value="" disabled {{ $jenisIdentitasVal==='' ? 'selected' : '' }}>Pilih...</option>
                    @foreach ($jenisIdentitasOptions as $opt)
                      <option value="{{ $opt }}" {{ $jenisIdentitasVal===$opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                  </select>
                  @error('jenisIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label for="noIdentitas" class="form-label">No. Identitas</label>
                  <input type="text" id="noIdentitas" name="noIdentitas" maxlength="50" required
                         class="form-control @error('noIdentitas') is-invalid @enderror"
                         placeholder="Nomor identitas"
                         value="{{ old('noIdentitas', $pasien->noIdentitas ?? '') }}">
                  @error('noIdentitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" id="tanggalLahir" name="tanggalLahir" required
                         class="form-control @error('tanggalLahir') is-invalid @enderror"
                         value="{{ old('tanggalLahir', isset($pasien->tanggalLahir) ? \Illuminate\Support\Carbon::parse($pasien->tanggalLahir)->format('Y-m-d') : '') }}">
                  @error('tanggalLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                  <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                  <select id="jenisKelamin" name="jenisKelamin" required
                          class="form-select @error('jenisKelamin') is-invalid @enderror">
                    <option value="" disabled {{ $jkVal==='' ? 'selected' : '' }}>Pilih...</option>
                    <option value="Laki-laki" {{ $jkVal==='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $jkVal==='Perempuan' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                  @error('jenisKelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            <hr class="my-4">

            {{-- ================== KONTAK ================== --}}
            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-telephone me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Kontak</h6>
              </div>
              <div class="mt-3 row g-3">
                <div class="col-md-6">
                <label for="noHP" class="form-label">No. HP</label>
                <input type="tel" id="noHP" name="noHP"
                    class="form-control @error('noHP') is-invalid @enderror"
                    placeholder="081234567890"
                    inputmode="numeric"
                    pattern="^08[0-9]{8,11}$"
                    value="{{ old('noHP', $pasien->noHP ?? '') }}" required>
                @error('noHP') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

              </div>
            </div>

            <hr class="my-4">

            {{-- ================== ALAMAT ================== --}}
            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-geo-alt me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Alamat</h6>
              </div>
              <div class="mt-3 row g-3">
                <div class="col-12">
                  <label for="alamatDomisili" class="form-label">Alamat Domisili</label>
                  <textarea id="alamatDomisili" name="alamatDomisili" rows="2" maxlength="255" required
                            class="form-control @error('alamatDomisili') is-invalid @enderror"
                            placeholder="Nama jalan, nomor, RT/RW, kelurahan, kecamatan, kota/kabupaten">{{ old('alamatDomisili', $pasien->alamatDomisili ?? '') }}</textarea>
                  @error('alamatDomisili') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            <hr class="my-4">

            {{-- ================== KESEHATAN ================== --}}
            @php
              $golOptions = ['A','B','AB','O'];
              $golVal = old('golonganDarah', $pasien->golonganDarah ?? '');
            @endphp
            <div class="mb-2">
              <div class="d-flex align-items-center">
                <i class="bi bi-heart-pulse me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Kesehatan</h6>
              </div>
              <div class="mt-3 row g-3">
                <div class="col-md-6">
                  <label for="alergi" class="form-label">Alergi (opsional)</label>
                  <input type="text" id="alergi" name="alergi" maxlength="255"
                         class="form-control @error('alergi') is-invalid @enderror"
                         placeholder="Misal: obat tertentu / makanan"
                         value="{{ old('alergi', $pasien->alergi ?? '') }}">
                  @error('alergi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                  <label for="golonganDarah" class="form-label">Golongan Darah (opsional)</label>
                  <select id="golonganDarah" name="golonganDarah"
                          class="form-select @error('golonganDarah') is-invalid @enderror">
                    <option value="" {{ $golVal==='' ? 'selected' : '' }}>Pilih...</option>
                    @foreach ($golOptions as $g)
                      <option value="{{ $g }}" {{ $golVal===$g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                  </select>
                  @error('golonganDarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-center gap-3 pt-4">
              <a href="{{ url()->previous() }}" class="btn btn-outline-primary px-5 rounded-pill">Kembali</a>
              <button type="submit" class="btn btn-primary px-5 rounded-pill">Simpan</button>
            </div>
          </form>
        </div>
      </div>

      

    </div>
  </div>
</div>
@endsection
