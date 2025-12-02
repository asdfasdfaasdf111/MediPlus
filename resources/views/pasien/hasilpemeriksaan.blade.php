<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeriksaan Pasien</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

@php
    use Carbon\Carbon;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dokter = $dataPemeriksaan->dokter;
    $dataPasien = $dataPemeriksaan->dataPasien;
    $hasilPemeriksaan = $dataPemeriksaan->hasilPemeriksaan;
@endphp

<div>Hasil Pemeriksaan</div>
<div>
    <div>Nama Pasien: {{ $dataPasien->namaLengkap }} </div>
    <div>Dokter Radiologi: {{ $dokter->user->name }}</div>
    <div>Jenis Pemeriksaan: {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</div>
    <div>Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
    <div>Hasil Analisa: {{ $hasilPemeriksaan->hasilPemeriksaan }} </div>
    <div>Unduh Hasil:  
        @foreach(json_decode($hasilPemeriksaan->fileLampiran) as $filePath)
            <a href="{{ Storage::url($filePath) }}" target="_blank">Download</a><br>
        @endforeach
    </div>
</div>

<form action="{{ route('pasien.selesaiPemeriksaan', $dataPemeriksaan) }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-outline-primary">Kembali</button>
</form>