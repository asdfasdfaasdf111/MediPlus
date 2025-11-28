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

<form method="POST" action="{{ route('pasien.updateTipePasien', $draftData) }}">
    @csrf
    @method('PUT')
    <div>Tipe Pasien</div>
    <div>Pilih Pasien</div>
    <select id="pilihPasien" name="pilihPasien" class="form-control" required>
        <option value="-" disabled  {{ $draftPasien ? '' : 'selected' }}>
            -
        </option>
        @foreach($masterPasien->dataPasien as $pasien)
            <option value="{{ $pasien->id }}"  {{ $pasien->id === $draftPasien?->id ? 'selected' : '' }}>
                {{ $pasien->namaLengkap }}
            </option>
        @endforeach
    </select>

    <div>Data Pendamping (Isi jika ada)</div>
    <div>Nama Pendamping </div>
    <input type="text"  class="form-control"
                        name="namaPendamping" id="namaPendamping"
                        placeholder="Nama Pendamping"
                        @if(!empty($draftData->namaPendamping))
                            value="{{ $draftData->namaPendamping }}"
                        @endif>

    <div>Kontak Pendamping </div>
    <input type="text"  class="form-control"
                        name="nomorPendamping" id="nomorPendamping"
                        placeholder="Nomor Handphone"
                        @if(!empty($draftData->nomorPendamping))
                            value="{{ $draftData->nomorPendamping }}"
                        @endif>

    <div>Hubungan dengan Pasien</div>
    <select id="hubunganPendamping" name="hubunganPendamping" class="form-control">
        <option value="">Pilih Hubungan</option>
        @foreach (['Orang Tua', 'Saudara', 'Pasangan', 'Anak', 'Lainnya'] as $option)
            <option value="{{ $option }}"
                {{ $draftData->hubunganPendamping === $option ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>

    <div class="d-flex justify-content-center gap-3 pt-3">
        <a href="{{ route('pasien.daftarpilihjadwal') }}" 
           class="btn btn-outline-primary px-5 rounded-pill">
           Kembali
        </a>
        <button id="submitBtn" type="submit" class="btn btn-primary px-5 rounded-pill">
            Berikutnya
        </button>
    </div>
</form>