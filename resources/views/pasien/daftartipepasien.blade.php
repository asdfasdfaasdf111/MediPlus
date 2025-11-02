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
    use Carbon\Carbon;
    $draftData = $masterPasien->draftPemeriksaan;
    $masterPasien = auth()->user()->masterPasien;
    $draftPasien = $draftData->dataPasien;
@endphp

<form method="POST" action="{{ route('belumdibikin') }}">
    @csrf
    @method('PUT')
    <div>Tipe Pasien</div>
    <div>Pilih Pasien</div>
    <select id="pilihPasien" name="pilihPasien" class="form-control" required>
        <option value="-" disabled  {{ $draftRumahSakit ? '' : 'selected' }}>
            -
        </option>
        @foreach($masterPasien->dataPasien as $pasien)
            <option value="{{ $pasien->id }}"  {{ $pasien->id === $draftPasien?->id ? 'selected' : '' }}>
                {{ $pasien->namaLengkap }}
            </option>
        @endforeach
    </select>

    <div>Data Pendamping (Isi jika ada)</div>
    <select id="jenisPemeriksaan" name="jenisPemeriksaan" class="form-control" required>
        @if ($draftData)
            @foreach($draftRumahSakit->namaJenisPemeriksaan() as $namaJenisPemeriksaan)
                <option value="{{ $namaJenisPemeriksaan }}" {{ $namaJenisPemeriksaan == $draftJenisPemeriksaan->namaJenisPemeriksaan ? 'selected' : '' }}>
                    {{ $namaJenisPemeriksaan }}
                </option>
            @endforeach
        @endif
    </select>

    <div>Pemeriksaan Spesifik</div>
    <select id="jenisPemeriksaanSpesifik" name="jenisPemeriksaanSpesifik" class="form-control" required>
        @if ($draftData)
            <option value="-" disabled>
                -
            </option>
            @foreach($draftRumahSakit->jenisPemeriksaanSpesifik($draftJenisPemeriksaan->namaJenisPemeriksaan)->get() as $pemeriksaanSpesifik)
                <option value="{{ $pemeriksaanSpesifik->id }}" {{ $pemeriksaanSpesifik->id == $draftJenisPemeriksaan->id ? 'selected' : '' }}>
                    {{ $pemeriksaanSpesifik->namaPemeriksaanSpesifik }}
                </option>
            @endforeach
        @endif
    </select>

    <div>Tanggal Pemeriksaan</div>
    <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput">
    

    @if ($draftData)
        <x-calendar 
            :disabled-dates="$draftRumahSakit->jadwalPenuh($draftJenisPemeriksaan)" 
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


    <label class="form-label fw-bold">Rentang Waktu Kedatangan</label>
    <div id="rentangWaktuKedatangan" class="d-flex flex-wrap gap-2">
        @if ($draftData)
            @php
                $timeSlots = $draftRumahSakit->jamTersedia($draftJenisPemeriksaan, $draftData->tanggalPemeriksaan, $draftData);
            @endphp

            @foreach ($timeSlots as $slot)
                <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off" {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($draftData->rentangWaktuKedatangan)->format('H:i') ? 'checked' : '' }} required>
                <label class="btn btn-outline-secondary" for="slot-{{ $loop->index }}">
                    {{ Carbon::parse($slot)->format('H:i') }} - {{ Carbon::parse($slot)->addHour()->format('H:i') }}
                </label>
            @endforeach
        @endif
    </div>

    <div class="d-flex justify-content-center gap-3 pt-3">
        <a href="{{ route('pasien.pendaftaran') }}" 
           class="btn btn-outline-primary px-5 rounded-pill">
           Kembali
        </a>
        <button id="submitBtn" type="submit" class="btn btn-primary px-5 rounded-pill">
            Berikutnya
        </button>
    </div>
</form>