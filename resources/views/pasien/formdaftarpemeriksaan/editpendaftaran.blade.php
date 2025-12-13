<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemeriksaan Pasien Baru</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
    use App\Models\RumahSakit;
    use Carbon\Carbon;

    $rumahSakit = $dataPemeriksaan->rumahSakit;
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

<form method="POST" action="{{ route('pasien.updateTanggal', ['dataPemeriksaan' => $dataPemeriksaan]) }}">
    @csrf
    @method('PUT')
    <div>Pilih Jadwal Pemeriksaan</div>
    <div>Tanggal Pemeriksaan</div>
    <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput"
            value="{{ $dataPemeriksaan->tanggalPemeriksaan }}">
    <x-calendar 
        :disabled-dates="$rumahSakit->jadwalPenuh($jenisPemeriksaan)" 
        :default-date="$dataPemeriksaan->tanggalPemeriksaan" 
        id="tanggalPemeriksaan" 
        name="tanggalPemeriksaan"
        required/>

    <label class="form-label fw-bold">Rentang Waktu Kedatangan</label>
    <div id="rentangWaktuKedatangan" class="d-flex flex-wrap gap-2">
        @php
            $timeSlots = $rumahSakit->jamTersedia($jenisPemeriksaan, $dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan);
        @endphp

        @foreach ($timeSlots as $slot)
            <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off" {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i') ? 'checked' : '' }} required>
            <label class="btn btn-outline-secondary" for="slot-{{ $loop->index }}">
                {{ Carbon::parse($slot)->format('H:i') }} - {{ Carbon::parse($slot)->addHour()->format('H:i') }}
            </label>
        @endforeach
    </div>

    <div class="d-flex justify-content-center gap-3 pt-3">
        <a href="{{ route('pasien.pendaftaran') }}" 
           class="btn btn-outline-primary px-5 rounded-pill">
           Kembali
        </a>
        <button id="submitBtn" type="submit" class="btn btn-primary px-5 rounded-pill">
            Perbarui
        </button>
    </div>
</form>