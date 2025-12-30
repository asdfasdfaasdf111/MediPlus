{{-- <!DOCTYPE html>
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
</form> --}}



@extends('layout.app')

@section('title', 'Hasil Pemeriksaan Pasien')

@section('content')

@php
use Carbon\Carbon;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dokter = $dataPemeriksaan->dokter;
    $dataPasien = $dataPemeriksaan->dataPasien;
    $hasilPemeriksaan = $dataPemeriksaan->hasilPemeriksaan;
@endphp

<body class="bg-light text-dark">
  <div class="container-fluid py-3 py-md-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 d-flex flex-column">

        <div class="mb-3">
            <h4 class="mb-1" style="color:#173B7A;">Hasil Pemeriksaan</h4>
            <div class="text-muted small">
                Berikut hasil analisa pemeriksaan radiologi yang telah dilakukan.
            </div>
        </div>


        <div class="row g-3">
            <div class="col-12">
                <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    <i class="bi bi-clipboard2-pulse me-2"></i> Informasi Pemeriksaan
                </div>
                <div class="card-body">
                    <div class="row g-3">
                    <div class="col-md-6">
                        <div class="small text-muted">Nama Pasien</div>
                        <div class="fw-semibold">{{ $dataPasien->namaLengkap }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="small text-muted">Dokter Radiologi</div>
                        <div class="fw-semibold">{{ $dokter->user->name }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="small text-muted">Jenis Pemeriksaan</div>
                        <div class="fw-semibold">
                        {{ $jenisPemeriksaan->namaJenisPemeriksaan }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="small text-muted">Tanggal Pemeriksaan</div>
                        <div class="fw-semibold">{{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
                    </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    <i class="bi bi-journal-medical me-2"></i> Hasil Analisa
                </div>
                
                <div class="card-body">
                    <div class="fw-semibold text-break">
                        {{ $hasilPemeriksaan->hasilPemeriksaan }}
                    </div>

                    <hr>

                   <div class="vstack gap-2">
                        @foreach (json_decode($hasilPemeriksaan->fileLampiran) as $index => $filePath)
                            <div>
                                <a href="{{ Storage::url($filePath) }}"
                                target="_blank"
                                class="link-primary text-decoration-none">
                                    <i class="bi bi-file-earmark-arrow-down me-1"></i>
                                    File Lampiran {{ $index + 1 }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div> 

        {{-- BUTTON KEMBALI --}}
        <div class="mt-4 d-flex justify-content-center">
            <form action="{{ route('pasien.selesaiPemeriksaan', $dataPemeriksaan) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-outline-primary px-5 rounded-pill">
                Kembali
                </button>
            </form>
        </div>

        </div>
    </div>

  </div>
@endsection
