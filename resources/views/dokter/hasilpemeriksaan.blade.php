<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homepage Dokter</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
@php
    use Carbon\Carbon;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dokter = $dataPemeriksaan->dokter;
    $dataPasien = $dataPemeriksaan->dataPasien;
    $dataRujukan = $dataPemeriksaan->dataRujukan;
@endphp

<div>Ringkasan Pemeriksaan</div>
<div>
    <div>Jadwal Pemeriksaan</div>
    <div>Rumah Sakit: {{ $rumahSakit->nama }}</div>
    <div>Jenis Pemeriksaan: {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</div>
    @if ($dataPemeriksaan->statusUtama != 'Dibatalkan')
        <div>Dokter Radiologi: {{ $dokter->user->name }}</div>
    @endif
    <div>Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
    <div>Rentang Waktu Kedatangan: {{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}</div>
</div>
==========================================================
{{-- <div>
    <div>Tipe Pasien</div> --}}
    {{-- yang di comment itu antara uda ga diperlukan(kayanya, bahas dlu), atau datanya ga disimpan --}}
    {{-- <div>Tipe Pasien: </div>
    <div>Nomor Rekam Medis: </div>
    <div>Pendaftaran dilakukan untuk: </div>
    <div>Hubungan dengan Pasien: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div> --}}
    {{-- <div>
        Nama Pendamping:
        @if (!empty($dataPemeriksaan->namaPendamping))
            {{$dataPemeriksaan->namaPendamping}}
        @else
            -
        @endif
    </div>
    <div>
        Nomor Telepon Pendamping:
        @if (!empty($dataPemeriksaan->nomorPendamping))
            {{$dataPemeriksaan->nomorPendamping}}
        @else
            -
        @endif
    </div>
    <div>
        Catatan:
        @if (!empty($dataPemeriksaan->catatanPetugas))
            {{$dataPemeriksaan->catatanPetugas}}
        @else
            -
        @endif
    </div>
</div>
========================================================== --}}
<div>
    <div>Data Pasien</div>
    <div>Nama Lengkap: {{ $dataPasien->namaLengkap }}</div>
    <div>Jenis Kelamin: {{ $dataPemeriksaan->riwayatJenisKelamin }}</div>
    <div>Tanggal Lahir: {{ $dataPemeriksaan->riwayatTanggalLahir }}</div>
    <div>
        Deskripsi Alergi:
        @if (!empty($dataPemeriksaan->riwayatAlergi))
            {{ $dataPemeriksaan->riwayatAlergi }}
        @else
            -
        @endif
    </div>
</div>
==========================================================
<div>
    <div>Data Rujukan</div>
    <div>Nama Fasilitas Kesehatan: {{ $dataRujukan->namaFaskes }}</div>
    <div>Nama Dokter Perujuk: {{ $dataRujukan->namaDokterPerujuk }}</div>
    <div>Tanggal Pemeriksaan di Klinik: {{ $dataRujukan->tanggalPemeriksaanFaskes }}</div>
    <div>Diagnosa Kerja: {{ $dataRujukan->diagnosaKerja }}</div>
    <div>Alasan Rujukan: {{ $dataRujukan->alasanRujukan }}</div>
    <div>Permintaan Pemeriksaan: {{ $dataRujukan->permintaanPemeriksaan }}</div>
    {{-- bikin jadi bnrn bisa pencet file ntr idk --}}
    <div>Formulir Rujukan: {{ $dataRujukan->formulirRujukan }}</div>
</div>

<div class="">
    <h3 class="">Unggah Hasil</h3>

    <div class="">
        <form action="{{ route('dokter.hasilpemeriksaan') }}" method="POST" enctype="multipart/form-date" class="">
            @csrf

            <div class="">
                <label for="" class="">Mitra Radiologi</label>
                <div class="">
                    <label for="" class="">
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </label>
                </div>
                <div class="">
                    <button class="btn btn-success" type="submit">
                        <i class="bi bi-upload"></i> Unggah
                    </button>
                </div>
            </div>

            <div class="">
                <label for="" class="">Deskripsi Hasil Analisa</label>
                <div class="">
                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi Hasil Analisa"></textarea>
                    <button class="btn btn-primary" type="submit"> Unggah Draft </button>
                </div>
                @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </form>
    </div>
</div>

<a href="{{ route('dokter.homepage') }}"> Kembali </a>
</body>
