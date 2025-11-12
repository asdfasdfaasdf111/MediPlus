<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Petugas | Edit Pendaftaran</title>

  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  @vite(['resources/js/calendar.js'])
  @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
  use Carbon\Carbon;
  $rumahSakit       = $dataPemeriksaan->rumahSakit;
  $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
@endphp

<script>
  window.rumahSakit = { id: {{ $rumahSakit->id }} };
  window.dataPemeriksaan = { id: {{ $dataPemeriksaan->id }} };
</script>

<body class="bg-white text-dark">

  {{-- NAVBAR --}}
  @include('layout.navbar2')

  <div class="container-fluid">
    <div class="row">

      {{-- SIDEBAR --}}
      <div class="col-md-2 min-vh-100 p-3 border-end">
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}"
               class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolajenispemeriksaan') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolajenispemeriksaan') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-clipboard2-check me-2"></i> Jenis Pemeriksaan
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolamodalitas') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolamodalitas') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-hdd-rack me-2"></i> Modalitas
            </a>
          </li>
        </ul>
      </div>

      {{-- CONTENT --}}
      <div class="col-md-10 p-4 bg-light" style="min-height:100vh;">

        {{-- Header sederhana (tanpa breadcrumb) --}}
        <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
          <div>
            <h4 class="mb-1" style="color:#173B7A;">Edit Pendaftaran</h4>
          </div>
          <span class="badge text-bg-light d-none d-md-inline" style="border-radius:999px;padding:.5rem .75rem;">
            <i class="bi bi-shield-check me-1"></i> Petugas Panel
          </span>
        </div>

        {{-- Card Form --}}
        <form method="POST" action="{{ route('petugas.updateJadwal', $dataPemeriksaan) }}"
              class="shadow-sm"
              style="background:#fff;border:1px solid #e9ecef;border-radius:16px;">

          @csrf
          @method('PUT')

          {{-- Ringkasan RS --}}
          <div class="border-bottom" style="padding:16px 20px;">
            <div class="d-flex align-items-center" style="gap:.5rem;">
              <i class="bi bi-building fs-5 text-primary"></i>
              <div>
                <div style="font-weight:600;">Rumah Sakit {{ $rumahSakit->nama }}</div>
              </div>
            </div>
          </div>

          {{-- Pilihan Jenis & Spesifik --}}
          <div class="row g-3" style="padding:16px 20px;">
            <div class="col-12 col-md-6">
              <label for="jenisPemeriksaan" class="form-label" style="font-weight:600;">Jenis Pemeriksaan</label>
              <select id="jenisPemeriksaan" name="jenisPemeriksaan" class="form-select" required
                      style="border-radius:12px;">
                @foreach($rumahSakit->jenisPemeriksaan->pluck('namaJenisPemeriksaan')->unique() as $namaJenisPemeriksaan)
                  <option value="{{ $namaJenisPemeriksaan }}"
                          {{ $namaJenisPemeriksaan == $jenisPemeriksaan->namaJenisPemeriksaan ? 'selected' : '' }}>
                    {{ $namaJenisPemeriksaan }}
                  </option>
                @endforeach
              </select>
              <div class="form-text">Pilih kategori umum pemeriksaan.</div>
            </div>

            <div class="col-12 col-md-6">
              <label for="jenisPemeriksaanSpesifik" class="form-label" style="font-weight:600;">Pemeriksaan Spesifik</label>
              <select id="jenisPemeriksaanSpesifik" name="jenisPemeriksaanSpesifik" class="form-select" required
                      style="border-radius:12px;">
                <option value="-" disabled>-</option>
                @foreach($rumahSakit->jenisPemeriksaanSpesifik($jenisPemeriksaan->namaJenisPemeriksaan)->get() as $pemeriksaanSpesifik)
                  <option value="{{ $pemeriksaanSpesifik->id }}"
                          {{ $pemeriksaanSpesifik->id == $jenisPemeriksaan->id ? 'selected' : '' }}>
                    {{ $pemeriksaanSpesifik->namaPemeriksaanSpesifik }}
                  </option>
                @endforeach
              </select>
              <div class="form-text">Pilih tindakan spesifik sesuai rujukan.</div>
            </div>
          </div>

 {{-- Kalender & Slot Waktu --}}
<div class="row g-3" style="padding:16px 20px;">

  <div class="col-12 col-md-6">
    <div class="h-100" style="background:#fff;border:1px solid #e9ecef;border-radius:12px;">
      <div class="border-bottom" style="padding:12px 16px;">
        <label for="tanggalPemeriksaan" class="form-label fw-bold" style="margin:0;">Tanggal Pemeriksaan</label>
      </div>

      <div style="padding:16px;">
        <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput"
               value="{{ $dataPemeriksaan->tanggalPemeriksaan }}">

        {{-- kalender langsung, tanpa box abu/dashed --}}
        <div style="background:#fff;border-radius:12px;">
          <x-calendar
            :disabled-dates="$rumahSakit->jadwalPenuh($jenisPemeriksaan)"
            :default-date="$dataPemeriksaan->tanggalPemeriksaan"
            id="tanggalPemeriksaan"
            name="tanggalPemeriksaan"
            required/>
        </div>

        <div class="small text-muted mt-2">
          <i class="bi bi-info-circle me-1"></i>
          Pilih tanggal yang tersedia. Tanggal abu-abu menandakan jadwal penuh.
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-6">
    <div class="h-100" style="background:#fff;border:1px solid #e9ecef;border-radius:12px;">
      <div class="border-bottom d-flex align-items-center justify-content-between" style="padding:12px 16px;">
        <label class="form-label fw-bold" style="margin:0;">Rentang Waktu Kedatangan</label>
        <span class="badge text-bg-light" style="border-radius:999px;">1 jam/slot</span>
      </div>

      <div style="padding:16px;">
        @php
          $timeSlots = $rumahSakit->jamTersedia($jenisPemeriksaan, $dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan);
        @endphp

        {{-- Grid responsif: 140px–1fr, rapi, tidak berantakan --}}
        <div id="rentangWaktuKedatangan"
             class="d-grid"
             style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap:.6rem;">
          @foreach ($timeSlots as $slot)
            @php
              $isChecked = \Carbon\Carbon::parse($slot)->format('H:i') ==
                           \Carbon\Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i');
            @endphp
            <input type="radio" class="btn-check" name="rentangWaktuKedatangan"
                   id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off"
                   {{ $isChecked ? 'checked' : '' }} required>
            <label class="btn btn-outline-secondary"
                   for="slot-{{ $loop->index }}"
                   style="display:block;width:100%;text-align:center;border-radius:999px;padding:.6rem 0;">
              {{ \Carbon\Carbon::parse($slot)->format('H:i') }} – {{ \Carbon\Carbon::parse($slot)->addHour()->format('H:i') }}
            </label>
          @endforeach
        </div>

        <div class="small text-muted mt-2">
          Slot yang tidak tampil berarti tidak tersedia untuk tanggal tersebut.
        </div>
      </div>
    </div>
  </div>

</div>






          {{-- Actions --}}
          <div class="border-top text-center" style="padding:20px;">
            <div class="d-inline-flex" style="gap:.75rem;">
              <a href="{{ route('petugas.pratinjaupemeriksaan', $dataPemeriksaan) }}"
                 class="btn btn-outline-primary rounded-pill px-4">
                Kembali
              </a>
              <button id="submitBtn" type="submit"
                      class="btn btn-primary rounded-pill px-4">
                Simpan
              </button>
            </div>
          </div>
        </form>

        {{-- Footnote --}}
        <div class="text-center small mt-3" style="color:#98a2b3;">
          © {{ date('Y') }} MediPlus — Petugas Panel
        </div>

      </div>{{-- /CONTENT --}}
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
