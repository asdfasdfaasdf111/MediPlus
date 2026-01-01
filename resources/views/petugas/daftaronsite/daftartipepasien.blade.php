@extends('layout.staff')

@section('title', 'Petugas | Detail Pemeriksaan')

@vite(['resources/js/switch-datapendaming.js'])

@section('content')

@php
    use Carbon\Carbon;

    $draftData   = $masterPasien->draftPemeriksaan;
    $draftPasien = $draftData->dataPasien;
    $punyaPendamping = old(
      'pakaiPendamping',
      !empty($draftData->namaPendamping)
      || !empty($draftData->nomorPendamping)
      || !empty($draftData->hubunganPendamping)
    );
@endphp

<div class="container-fluid">
  <div class="row">

    @include('layout.sidebarpetugas')

    <div class="col-md-10 p-4 bg-light" style="min-height:100vh;">


      <form method="POST" action="{{ route('petugas.updateTipePasien', $draftData) }}" novalidate class="shadow-sm" style="background:#fff;border:1px solid #e9ecef;border-radius:16px;">
        @csrf
        @method('PUT')

        <div class="border-bottom" style="padding:16px 20px;">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people fs-5 text-primary"></i>
            <div style="font-weight:600;">
              Langkah 2 : Pilih Tipe Pasien
            </div>
          </div>
        </div>

        <div class="row g-3" style="padding:16px 20px;">

          {{-- Pilih Pasien --}}
          <div class="col-12">
            <label for="pilihPasien" class="form-label" style="font-weight:600;">
              Pilih Pasien
            </label>
            <select id="pilihPasien"  name="pilihPasien" class="form-select" style="border-radius:12px;" required>
              <option value="-" disabled {{ $draftPasien ? '' : 'selected' }}>
                -
              </option>

              @foreach($masterPasien->dataPasien as $pasien)
                <option value="{{ $pasien->id }}"
                        {{ $pasien->id === $draftPasien?->id ? 'selected' : '' }}>
                  {{ $pasien->namaLengkap }}
                </option>
              @endforeach

              <option value="__tambah_pasien__">
                + Tambah Pasien Baru
              </option>
            </select>

            <div class="form-text">
              Pilih pasien yang akan melakukan pemeriksaan.
            </div>
          </div>

          <input type="hidden" name="pakaiPendamping" id="pakaiPendamping" value="{{ $punyaPendamping ? 1 : 0 }}">
          

          <div class="col-12">
            <hr class="my-3 border-secondary-subtle">
          </div>

          <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-0 text-uppercase text-muted small">
                Data Pendamping
              </h6>
              <div class="small text-muted">
                Opsional, diisi jika pasien didampingi
              </div>
            </div>

            <div class="form-check form-switch">
              <input class="form-check-input"
                    type="checkbox"
                    role="switch"
                    id="togglePendamping"
                    {{ $punyaPendamping ? 'checked' : '' }}>
              <label class="form-check-label small" for="togglePendamping">
                Aktifkan
              </label>
            </div>
          </div>


<div class="col-12 col-md-6">
  <label for="namaPendamping" class="form-label fw-semibold">
    Nama Pendamping
  </label>
  <input type="text"
         class="form-control js-pendamping-field @error('namaPendamping') is-invalid @enderror"
         name="namaPendamping"
         id="namaPendamping"
         placeholder="Nama Pendamping"
         value="{{ old('namaPendamping', $draftData->namaPendamping) }}"
         @if(!$punyaPendamping) disabled @endif>

  @error('namaPendamping')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>


<div class="col-12 col-md-6">
  <label for="nomorPendamping" class="form-label fw-semibold">
    Kontak Pendamping
  </label>
  <input type="text"
         class="form-control js-pendamping-field @error('nomorPendamping') is-invalid @enderror"
         name="nomorPendamping"
         id="nomorPendamping"
         placeholder="Nomor Handphone"
         value="{{ old('nomorPendamping', $draftData->nomorPendamping) }}"
         @if(!$punyaPendamping) disabled @endif>

  @error('nomorPendamping')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>



<div class="col-12 col-md-6">
  <label for="hubunganPendamping" class="form-label fw-semibold">
    Pasien Merupakan
  </label>

  <select id="hubunganPendamping"
          name="hubunganPendamping"
          class="form-select js-pendamping-field @error('hubunganPendamping') is-invalid @enderror"
          @if(!$punyaPendamping) disabled @endif>

    <option value="">Pilih Hubungan</option>

    @foreach (['Orang Tua','Saudara','Pasangan','Anak','Lainnya'] as $option)
      <option value="{{ $option }}"
        {{ old('hubunganPendamping', $draftData->hubunganPendamping) === $option ? 'selected' : '' }}>
        {{ $option }}
      </option>
    @endforeach
  </select>

  @error('hubunganPendamping')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>


        </div>

        <div class="border-top text-center" style="padding:20px;">
          <div class="d-inline-flex gap-2">
            <a href="{{ route('petugas.daftarpilihjadwal', $masterPasien->user) }}"
               class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
              Kembali
            </a>
            <button type="submit" id="submitBtn" class="btn btn-primary px-4 px-md-5 rounded-pill">
              Berikutnya
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('pilihPasien').addEventListener('change', function () {
  if (this.value === '__tambah_pasien__') {
    window.location.href = "{{ route('petugas.daftartambahdatapasien', $masterPasien->id) }}";
  }
});
</script>

@push('page-scripts')
  @vite(['resources/js/switch-datapendaming.js'])
@endpush

@endsection
