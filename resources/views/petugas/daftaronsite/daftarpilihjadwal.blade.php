@extends('layout.staff')

@section('title', 'Petugas | Daftar Pilih Jadwal Onsite')

@vite(['resources/js/calendar.js'])
@vite(['resources/js/jadwal-dinamis-petugas.js'])

@section('content')

@php
    use App\Models\RumahSakit;
    use App\Models\User;
    use Carbon\Carbon;

    $masterPasien = User::findOrFail($user)->masterPasien;
    $rumahSakit = $petugas->rumahSakit;
    // //kalo uda ad draft data, pke nilai dari draft, tpi klo engga, brarti biarin kosong aj
    $draftData = $masterPasien->draftPemeriksaan;
    $draftJenisPemeriksaan = $draftData?->jenisPemeriksaan;
    $draftKelompokJenisPemeriksaan = $draftJenisPemeriksaan?->kelompokJenisPemeriksaan; -> tambah ini
@endphp

<script>
    window.rumahSakit = { id: {{ $rumahSakit->id }} };
</script>

<div class="container-fluid">
  <div class="row">

    @include('layout.sidebarpetugas')

    <div class="col-md-10 p-4 bg-light" style="min-height:100vh;">


      <form method="POST"
            action="{{ $draftData
              ? route('petugas.updateJadwalOnsite', ['dataPemeriksaan' => $draftData])
              : route('petugas.bikinDraftOnsite', ['masterPasienId' => $masterPasien->id]) }}"
            class="shadow-sm"
            style="background:#fff;border:1px solid #e9ecef;border-radius:16px;">

        @csrf
        @if ($draftData)
            @method('PUT')
        @endif

        {{-- Header Card --}}
        <div class="border-bottom" style="padding:16px 20px;">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-hospital fs-5 text-primary"></i>
            <div style="font-weight:600;">
              Langkah 1 : Pilih Jadwal
            </div>
          </div>
        </div>

        {{-- Jenis Pemeriksaan --}}
        <div class="row g-3" style="padding:16px 20px;">
          <div class="col-12 col-md-6">
            <label for="kelompokJenisPemeriksaan" style="font-weight:600;">Kelompok Jenis Pemeriksaan</label>
            <select id="kelompokJenisPemeriksaan" name="kelompokJenisPemeriksaan" class="form-select" style="border-radius:12px;" required>
              <option value="-" disabled selected>-</option>
              @foreach($rumahSakit->kelompokJenisPemeriksaan as $kelompokJenisPemeriksaan)
                <option value="{{ $kelompokJenisPemeriksaan->id }}" {{ $draftKelompokJenisPemeriksaan?->id === $kelompokJenisPemeriksaan->id ? 'selected' : '' }}>
                    {{ $kelompokJenisPemeriksaan->namaKelompok }}
                </option>
              @endforeach
            </select>
            <div class="form-text">
              Pilih kategori pemeriksaan.
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" style="font-weight:600;">Jenis Pemeriksaan</label>
            <select id="jenisPemeriksaan" name="jenisPemeriksaan" class="form-select" style="border-radius:12px;" required>
              @if ($draftData)
                <option value="-" disabled>-</option>
                @foreach($rumahSakit->namaJenisPemeriksaan($draftKelompokJenisPemeriksaan->id) as $jenisPemeriksaan)
                  <option value="{{ $jenisPemeriksaan->id }}" {{ $jenisPemeriksaan->id == $draftJenisPemeriksaan->id ? 'selected' : '' }}>
                    {{ $jenisPemeriksaan->namaJenisPemeriksaan }}
                  </option>
                @endforeach
              @endif
            </select>
            <div class="form-text">
              Pilih tindakan spesifik sesuai kebutuhan.
            </div>
          </div>
        </div>

        {{-- Kalender & Slot Waktu --}}
        <div class="row g-3" style="padding:16px 20px;">

          <div class="col-12 col-md-6">
            <div class="h-100" style="background:#fff;border:1px solid #e9ecef;border-radius:12px;">
              <div class="border-bottom" style="padding:12px 16px;">
                <label class="form-label fw-bold mb-0">Tanggal Pemeriksaan</label>
              </div>

              <div style="padding:16px;">
                <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput" @if($draftData) value="{{ $draftData->tanggalPemeriksaan }}" @endif>

                @if ($draftData)
                  <x-calendar
                    :disabled-dates="$rumahSakit->jadwalPenuhPetugas($draftJenisPemeriksaan)"
                    :default-date="$draftData->tanggalPemeriksaan"
                    id="tanggalPemeriksaan"
                    name="tanggalPemeriksaan"
                    required/>
                @else
                  <x-calendar
                    id="tanggalPemeriksaan"
                    name="tanggalPemeriksaan"
                    required/>
                @endif

                <div class="small text-muted mt-2">
                  <i class="bi bi-info-circle me-1"></i>
                  Pilih tanggal yang tersedia.
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="h-100" style="background:#fff;border:1px solid #e9ecef;border-radius:12px;">
              <div class="border-bottom d-flex align-items-center justify-content-between" style="padding:12px 16px;">
                <label class="form-label fw-bold mb-0">Rentang Waktu Kedatangan</label>
                <span class="badge text-bg-light rounded-pill">1 jam/slot</span>
              </div>

              <div style="padding:16px;">
                <div id="rentangWaktuKedatangan" class="d-grid" style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap:.9rem;">
                        @if ($draftData)
                            @php
                              $result = $rumahSakit->jamTersediaPetugas(
                                  $draftJenisPemeriksaan,
                                  $draftData->tanggalPemeriksaan,
                                  $draftData
                              );
                              $timeSlots = $result['listJam'] ?? [];
                              $jump = $result['jump'];
                            @endphp

                            @foreach ($timeSlots as $slot)
                                <div class="col">
                                  <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off"
                                         {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($draftData->rentangWaktuKedatangan)->format('H:i') ? 'checked' : '' }}
                                        required>

                                  <label class="btn btn-outline-primary rounded-pill w-100 py-2 fw-semibold" for="slot-{{ $loop->index }}">
                                      {{ Carbon::parse($slot)->format('H:i') }}
                                      –
                                      {{ Carbon::parse($slot)->addHour($jump)->format('H:i') }}
                                  </label>
                                </div>
                            @endforeach
                        @endif
                </div>

                <div class="small text-muted mt-2">
                  Slot yang tidak tampil berarti sudah tidak tersedia pada tanggal tersebut.
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="border-top text-center" style="padding:20px;">
          <div class="d-inline-flex gap-2">
            <a href="{{ route('petugas.tambahpendaftaranbaru') }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
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

@endsection
