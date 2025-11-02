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
    $allRumahSakit = RumahSakit::all();
    //kalo uda ad draft data, pke nilai dari draft, tpi klo engga, brarti biarin kosong aj
    $draftData = $masterPasien->draftPemeriksaan;
    $draftRumahSakit = $draftData?->rumahSakit;
    $draftJenisPemeriksaan = $draftData?->jenisPemeriksaan;
@endphp

<form method="POST" action="{{ $draftData ? route('updateJadwal', ['dataPemeriksaan' => $draftData, 'draft' => "true"]) : route('pasien.bikinDraft') }}">
    @csrf
    {{-- kalo ad draft brarti edit draftny, kalo engga brarti bikin data baru --}}
    @if ($draftData)
        @method('PUT')
    @endif
    {{-- @dd($draftData) --}}
    <div>Pilih Jadwal Pemeriksaan</div>
    <div>Rumah Sakit</div>
    <select id="rumahSakit" name="rumahSakit" class="form-control" required>
        <option value="-" disabled  {{ $draftRumahSakit ? '' : 'selected' }}>
            -
        </option>
        @foreach($allRumahSakit as $rumahSakit)
            <option value="{{ $rumahSakit->id }}"  {{ $rumahSakit->nama === $draftRumahSakit?->nama ? 'selected' : '' }}>
                {{ $rumahSakit->nama }}
            </option>
        @endforeach
    </select>

    <div>Jenis Pemeriksaan</div>
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
    <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput"
        @if($draftData)
            value="{{ $draftData->tanggalPemeriksaan }}"
        @endif>
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