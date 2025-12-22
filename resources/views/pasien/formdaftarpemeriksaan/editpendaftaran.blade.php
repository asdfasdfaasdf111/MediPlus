<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Jadwal Pemeriksaan</title>

  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  @vite(['resources/js/calendar.js'])
  @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
  use App\Models\RumahSakit;
  use Carbon\Carbon;

  $rumahSakit       = $dataPemeriksaan->rumahSakit;
  $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
@endphp

<script>
  window.rumahSakit = { 
    id: {{ $rumahSakit->id }} 
    };
  window.jenisPemeriksaan = { 
    id: {{ $jenisPemeriksaan->id }} 
    };
</script>

<body class="bg-light text-dark" style="min-height:100vh;">

  <div class="container py-4">

    <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
      <div>
        <h4 class="mb-1 fw-bold" style="color:#173B7A;">Edit Pendaftaran</h4>
        <div class="text-muted small">
          Perbarui jadwal kedatangan sesuai ketersediaan.
        </div>
      </div>
    </div>

    <form method="POST" action="{{ route('pasien.updateTanggal', ['dataPemeriksaan' => $dataPemeriksaan]) }}" class="shadow-sm" style="background:#fff;border:1px solid #e9ecef;border-radius:16px;">
      @csrf
      @method('PUT')

      {{-- Info Sekilas--}}
      <div class="border-bottom" style="padding:16px 20px;">
        <div class="d-flex align-items-center" style="gap:.75rem;">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-calendar-check fs-5 text-primary"></i>
          </div>
          <div class="flex-grow-1">
            <div style="font-weight:600;">
              Rumah Sakit {{ $rumahSakit->nama }}
            </div>
            <div class="small text-muted">
              {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}
            </div>
          </div>
        </div>
      </div>

      {{-- Kalender & Slot Waktu --}}
      <div class="row g-3" style="padding:16px 20px;">

        <div class="col-12 col-md-6">
          <div class="h-100" style="background:#fff;border:1px solid #e9ecef;border-radius:12px;">
            <div class="border-bottom" style="padding:12px 16px;">
              <label for="tanggalPemeriksaan" class="form-label fw-bold" style="margin:0;">
                Tanggal Pemeriksaan
              </label>
            </div>

            <div style="padding:16px;">
              <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput"
                     value="{{ $dataPemeriksaan->tanggalPemeriksaan }}">

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

        {{-- Slot waktu --}}
        <div class="col-12 col-md-6">
          <div class="h-100" style="background:#fff;border:1px solid #e9ecef;border-radius:12px;">
            <div class="border-bottom d-flex align-items-center justify-content-between" style="padding:12px 16px;">
              <label class="form-label fw-bold" style="margin:0;">Rentang Waktu Kedatangan</label>
              <span class="badge text-bg-light" style="border-radius:999px;">1 jam/slot</span>
            </div>
            <div style="padding:16px;">
              @php
                $result = $rumahSakit->jamTersedia($jenisPemeriksaan, $dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan);
                $timeSlots = $result['listJam'] ?? [];
            @endphp

              <div id="rentangWaktuKedatangan" class="d-grid" style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap:.9rem;">
                
                {{-- Copy punya petugas --}}
                  @foreach ($timeSlots as $slot)
                      <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off" {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i') ? 'checked' : '' }} required>
                      <label class="btn btn-outline-secondary" for="slot-{{ $loop->index }}">
                          {{ Carbon::parse($slot)->format('H:i') }} - {{ Carbon::parse($slot)->addHour($jump)->format('H:i') }}
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
      <div class="border-top text-center" style="padding:20px;">
        <div class="d-inline-flex flex-wrap justify-content-center" style="gap:.75rem;">
          <a href="{{ route('pasien.pendaftaran') }}"
             class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
            Kembali
          </a>
          <button id="submitBtn" type="submit"
                  class="btn btn-primary px-4 px-md-5 rounded-pill">
            Perbarui
          </button>
        </div>
      </div>
    </form>
  </div>
  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>