
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
    $dataPemeriksaan = $masterPasien->draftPemeriksaan;
    $dataRujukan = $dataPemeriksaan->dataRujukan;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dataPasien = $dataPemeriksaan->dataPasien;
@endphp

<div>Ringkasan Pendaftaran</div>
<div>Berikut adalah pratinjau pendaftaran pemeriksaan Anda</div>
<div>
    <div>Pilih Jadwal</div>
    <div>Rumah Sakit: {{ $rumahSakit->nama }}</div>
    <div>Jenis Pemeriksaan: {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</div>
    <div>Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
    <div>Rentang Waktu Kedatangan: {{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}</div>
    <a href="{{ route('pasien.daftarpilihjadwal') }}"> Ubah Jadwal </a>
</div>
==========================================================
<div>
    <div>Tipe Pasien</div>
    <div>Nama Pasien: {{ $dataPasien->namaLengkap }}</div>
    <div>Hubungan dengan Pasien: {{ $dataPemeriksaan->hubunganPendamping }}</div>
    <div>
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
    <a href="{{ route('pasien.daftartipepasien') }}"> Ubah Tipe Pasien </a>
</div>
==========================================================
<div>
    <div>Formulir Data Diri</div>
    <div>Nama Lengkap: {{ $dataPasien->namaLengkap }}</div>
    <div>Jenis Kelamin: {{ $dataPemeriksaan->riwayatJenisKelamin }}</div>
    <div>Tanggal Lahir: {{ $dataPemeriksaan->riwayatTanggalLahir }}</div>
    <div>Golongan Darah: {{ $dataPemeriksaan->riwayatGolonganDarah }}</div>
    <div>Jenis Kartu Identitas: {{ $dataPasien->jenisIdentitas }}</div>
    <div>Nomor Identitas: {{ $dataPasien->noIdentitas }}</div>
    <div>Alamat Domisili: {{ $dataPemeriksaan->riwayatAlamatDomisili }}</div>
    <div>Nomor Telepon Aktif: {{ $dataPemeriksaan->riwayatNoHP }}</div>
    <div>
        Apakah Pasien memiliki Alergi: 
        @if (!empty($dataPemeriksaan->riwayatAlergi))
            Ya
        @else
            Tidak
        @endif
    </div>
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
    <a href="{{ asset('storage/' . $dataRujukan->formulirRujukan) }}" target="_blank">
        {{ $dataRujukan->namaFile }}
    </a>
    <div></div>
    <a href="{{ route('pasien.daftardatarujukan') }}"> Ubah Data Rujukan </a>
</div>

<form method="POST" action="{{ route('pasien.finalisasiDraft', $dataPemeriksaan) }}">
    @csrf
    @method('PUT')

    <div class="d-flex justify-content-center gap-3 pt-3">
        <a href="{{ route('pasien.daftardatarujukan') }}" 
           class="btn btn-outline-primary px-5 rounded-pill">
           Kembali
        </a>
        <button id="submitBtn" type="submit" class="btn btn-primary px-5 rounded-pill">
            Berikutnya
        </button>
    </div>
</form>
