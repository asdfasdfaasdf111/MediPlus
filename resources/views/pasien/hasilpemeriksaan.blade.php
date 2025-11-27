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

{{-- Harusny ud benar tpi blm pernah di run, ntr klo yg dokter ud slsai, cek ulang --}}

<div>Hasil Pemeriksaan</div>
<div>
    <div>Nama Pasien: {{ $dataPasien->namaLengkap }} </div>
    <div>Dokter Radiologi: {{ $dokter->user->name }}</div>
    <div>Jenis Pemeriksaan: {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</div>
    <div>Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
    <div>Hasil Analisa: {{ $hasilPemeriksaan->hasilPemeriksaan }} </div>
    <div>Unduh Hasil:  
        <a href="{{ asset('storage/' . $hasilPemeriksaan->fileLampiran) }}" target="_blank">
            Download
        </a>
    </div>
</div>

<a href="{{ route('pasien.selesaiPemeriksaan') }}"> Kembali </a>