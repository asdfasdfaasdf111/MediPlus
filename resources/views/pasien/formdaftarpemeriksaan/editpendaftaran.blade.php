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
    use Carbon\Carbon;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $kelompokJenisPemeriksaan = $jenisPemeriksaan->kelompokJenisPemeriksaan;
    $jump = $jenisPemeriksaan->getJump();
@endphp

<script>
  window.rumahSakit = {
    id: {{ $rumahSakit->id }}
  };
  window.dataPemeriksaan = {
    id: {{ $dataPemeriksaan->id }}
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

    <form method="POST" action="{{ route('updateJadwal', ['dataPemeriksaan' => $dataPemeriksaan, 'draft' => "false"]) }}" class="shadow-sm" style="background:#fff;border:1px solid #e9ecef;border-radius:16px;">
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
          </div>
        </div>
      </div>

      <div class="row g-3 px-4 py-3">
        {{-- Kelompok --}}
        <div class="col-12 col-md-6">
          <label class="form-label fw-semibold">Kelompok Jenis Pemeriksaan</label>
          <select id="kelompokJenisPemeriksaan" name="kelompokJenisPemeriksaan" class="form-select rounded-3"  required>
            @foreach($rumahSakit->kelompokJenisPemeriksaan as $kelompok)
              <option value="{{ $kelompok->id }}"
                {{ $kelompok->id == $kelompokJenisPemeriksaan->id ? 'selected' : '' }}>
                {{ $kelompok->namaKelompok }}
              </option>
            @endforeach
          </select>
          <div class="form-text">Pilih kategori pemeriksaan.</div>
        </div>

        {{-- Jenis --}}
        <div class="col-12 col-md-6">
          <label class="form-label fw-semibold">Jenis Pemeriksaan</label>
          <select id="jenisPemeriksaan" name="jenisPemeriksaan" class="form-select rounded-3" required>
            @foreach($rumahSakit->namaJenisPemeriksaan($kelompokJenisPemeriksaan->id) as $jenis)
              <option value="{{ $jenis->id }}"
                {{ $jenis->id == $jenisPemeriksaan->id ? 'selected' : '' }}>
                {{ $jenis->namaJenisPemeriksaan }}
              </option>
            @endforeach
          </select>
          <div class="form-text">Pilih tindakan sesuai rujukan.</div>
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

        {{-- Waktu Kedatangan --}}
        <div class="col-12 col-md-6">
          <div class="h-100 bg-white border rounded-3">

            <div class="border-bottom d-flex align-items-center justify-content-between px-3 py-2">
              <label class="form-label fw-bold mb-0">
                Rentang Waktu Kedatangan
              </label>
              <span id="slotInfo" class="badge text-bg-light rounded-pill">
                1 jam/slot
              </span>
            </div>

            <div class="p-3">
              @php
                $result = $rumahSakit->jamTersedia(
                  $jenisPemeriksaan,
                  $dataPemeriksaan->tanggalPemeriksaan,
                  $dataPemeriksaan
                );
                $timeSlots = $result['listJam'] ?? [];
                $jump = $result['jump'];
              @endphp

              {{-- Slot list --}}
              <div id="rentangWaktuKedatangan"
                  class="row row-cols-1 row-cols-md-2 g-3">

                @forelse ($timeSlots as $slot)
                  <div class="col">
                    <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off"
                          {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i') ? 'checked' : '' }}
                          required>

                    <label class="btn btn-outline-primary rounded-pill w-100 py-2 fw-semibold" for="slot-{{ $loop->index }}">
                      {{ Carbon::parse($slot)->format('H:i') }}
                      –
                      {{ Carbon::parse($slot)->addHour($jump)->format('H:i') }}
                    </label>
                  </div>
                @empty
                  <div class="col-12 text-center text-muted small py-4">
                    <i class="bi bi-calendar-x me-1"></i>
                    Tidak ada slot tersedia pada tanggal ini.
                  </div>
                @endforelse
              </div>

              {{-- Helper text --}}
              <div class="small text-muted mt-2">
                Slot yang tidak tampil berarti sudah tidak tersedia atau kuota penuh.
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="border-top text-center" style="padding:20px;">
        <div class="d-inline-flex flex-wrap justify-content-center" style="gap:.75rem;">
          <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
            Kembali
          </a>
          <button id="submitBtn" type="submit" class="btn btn-primary px-4 px-md-5 rounded-pill">
            Perbarui
          </button>
        </div>
      </div>
    </form>
  </div>
  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>