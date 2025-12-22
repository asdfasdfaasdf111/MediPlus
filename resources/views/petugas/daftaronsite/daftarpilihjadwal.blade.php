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
    $draftData = $masterPasien->draftPemeriksaan;
    $draftJenisPemeriksaan = $draftData?->jenisPemeriksaan;
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
            <label class="form-label" style="font-weight:600;">Jenis Pemeriksaan</label>
            <select id="jenisPemeriksaan" name="jenisPemeriksaan" class="form-select" style="border-radius:12px;" required>
              <option value="-" disabled selected>-</option>
              @foreach($rumahSakit->namaJenisPemeriksaan() as $namaJenisPemeriksaan)
                <option value="{{ $namaJenisPemeriksaan }}"
                  {{ $draftJenisPemeriksaan?->namaJenisPemeriksaan === $namaJenisPemeriksaan ? 'selected' : '' }}>
                  {{ $namaJenisPemeriksaan }}
                </option>
              @endforeach
            </select>
            <div class="form-text">
              Pilih kategori umum pemeriksaan.
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" style="font-weight:600;">Pemeriksaan Spesifik</label>
            <select id="jenisPemeriksaanSpesifik" name="jenisPemeriksaanSpesifik" class="form-select" style="border-radius:12px;" required>
              @if ($draftData)
                <option value="-" disabled>-</option>
                @foreach($rumahSakit->jenisPemeriksaanSpesifik($draftJenisPemeriksaan->namaJenisPemeriksaan)->get() as $pemeriksaanSpesifik)
                  <option value="{{ $pemeriksaanSpesifik->id }}"
                    {{ $pemeriksaanSpesifik->id == $draftJenisPemeriksaan->id ? 'selected' : '' }}>
                    {{ $pemeriksaanSpesifik->namaPemeriksaanSpesifik }}
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
                  <x-calendar :default-date="$draftData->tanggalPemeriksaan" id="tanggalPemeriksaan" name="tanggalPemeriksaan" required/>
                @else
                  <x-calendar id="tanggalPemeriksaan" name="tanggalPemeriksaan" required/>
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
                      $result = $rumahSakit->jamTersediaPetugas(  $draftJenisPemeriksaan, $draftData->tanggalPemeriksaan, $draftData );
                    @endphp

                    @foreach ($result['listJam'] as $slot)
                      <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}"
                             {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($draftData->rentangWaktuKedatangan)->format('H:i')  ? 'checked' : '' }}
                             required>

                      <label class="btn btn-outline-primary" for="slot-{{ $loop->index }}" style="border-radius:999px;padding:.6rem 0;text-align:center;">
                        {{ Carbon::parse($slot)->format('H:i') }} – {{ Carbon::parse($slot)->addHour($result['jump'])->format('H:i') }}
                      </label>
                    @endforeach
                  @endif

                </div>

                <div class="small text-muted mt-2">
                  Slot yang tidak tampil berarti tidak tersedia.
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="border-top text-center" style="padding:20px;">
          <div class="d-inline-flex gap-2">
            <a href="{{ route('petugas.tambahpendaftaranbaru') }}"
               class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
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
