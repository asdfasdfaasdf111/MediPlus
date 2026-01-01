{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemeriksaan Pasien Baru</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
    @vite(['resources/js/switch-datapendaming.js'])
</head> --}}

@extends('layout.app')

@section('title', 'Step 2 Daftar Tipe Pasien')

@section('content')

@php
    use Carbon\Carbon;
    // Ambil masterPasien dari user yang login
    $masterPasien = auth()->user()->masterPasien;
    $draftData    = $masterPasien->draftPemeriksaan;
    $draftPasien  = $draftData->dataPasien;
    $punyaPendamping = !empty($draftData->namaPendamping)
        || !empty($draftData->nomorPendamping)
        || !empty($draftData->hubunganPendamping);
@endphp

<div class="bg-light text-dark">

  <div class="container-fluid py-3 py-md-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 min-vh-100 d-flex flex-column">

        {{-- Header halaman --}}
        <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
          <div>
            <h4 class="mb-1" style="color:#173B7A;">Pilih Tipe Pasien</h4>
            <div class="text-muted small">
              Pilih pasien yang akan diperiksa dan isi data pendamping bila diperlukan.
            </div>
          </div>

        </div>

        {{-- FORM  --}}
        <form method="POST" action="{{ route('pasien.updateTipePasien', $draftData) }}" class="bg-white border rounded-4 shadow-sm flex-grow-0" novalidate>
            @csrf
            @method('PUT')

            <div class="border-bottom px-4 py-3">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people fs-5 text-primary"></i>
                <div>
                  <div class="fw-semibold">Tipe Pasien</div>
                </div>
              </div>
            </div>

            <div class="row g-3 px-4 py-3">
              {{-- Pilih Pasien --}}
              <div class="col-12">
                <label for="pilihPasien" class="form-label fw-semibold">Pilih Pasien</label>
                <select id="pilihPasien" name="pilihPasien" class="form-select rounded-3" required>
                    <option value="-" disabled {{ $draftPasien ? '' : 'selected' }}>
                        -
                    </option>
                    @foreach($masterPasien->dataPasien as $pasien)
                        <option value="{{ $pasien->id }}"
                                {{ $pasien->id === $draftPasien?->id ? 'selected' : '' }}>
                            {{ $pasien->namaLengkap }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Pilih pasien yang akan melakukan pemeriksaan.</div>
              </div>

            {{-- Garis pembatas buat yg data pendamping --}}
            <input type="hidden" name="pakaiPendamping" id="pakaiPendamping" value="{{ $punyaPendamping ? 1 : 0 }}">

              <div class="col-12">
                <hr class="my-3 border-top border-secondary-subtle">
              </div>

              <div class="col-12 d-flex justify-content-between align-items-center">
                <h6 class="text-uppercase text-muted mb-0 small">
                    Data Pendamping
                </h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch"  id="togglePendamping" {{ $punyaPendamping ? 'checked' : '' }}>
                    <label class="form-check-label small" for="togglePendamping">
                      Isi jika ada
                    </label>
                  </div>
                </div>


              <div class="col-12 col-md-6">
                <label for="namaPendamping" class="form-label fw-semibold">Nama Pendamping</label>
                    <input type="text" class="form-control js-pendamping-field @error('namaPendamping') is-invalid @enderror" name="namaPendamping" id="namaPendamping" placeholder="Nama Pendamping" @if(!$punyaPendamping) disabled @endif value="{{ old('namaPendamping', $draftData->namaPendamping) }}">
                        @error('namaPendamping')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
              </div>

              <div class="col-12 col-md-6">
                <label for="nomorPendamping" class="form-label fw-semibold">Kontak Pendamping</label>
                    <input type="text" class="form-control js-pendamping-field @error('nomorPendamping') is-invalid @enderror" name="nomorPendamping" id="nomorPendamping" placeholder="Nomor Handphone" @if(!$punyaPendamping) disabled @endif value="{{ old('nomorPendamping', $draftData->nomorPendamping) }}">
                        @error('nomorPendamping')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
              </div>

              <div class="col-12 col-md-6">
                <label for="hubunganPendamping" class="form-label fw-semibold">Pasien Merupakan</label>
                <select id="hubunganPendamping" name="hubunganPendamping" class="form-select rounded-3 js-pendamping-field @error('hubunganPendamping') is-invalid @enderror"  @if(!$punyaPendamping) disabled @endif>
                    <option value="">Pilih Hubungan</option>
                    @foreach (['Orang Tua', 'Saudara', 'Pasangan', 'Anak', 'Lainnya'] as $option)
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

            <div class="border-top text-center px-4 py-3">
              <div class="d-inline-flex gap-2">
                <a href="{{ route('pasien.daftarpilihjadwal') }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
                   Kembali
                </a>
                <button id="submitBtn" type="submit" class="btn btn-primary px-4 px-md-5 rounded-pill">
                    Berikutnya
                </button>
              </div>
            </div>
        </form>

      </div>
    </div>
  </div>

  {{-- <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>

</div>
</html> --}}

@endsection

@push('page-scripts')
  @vite(['resources/js/switch-datapendaming.js'])
@endpush
