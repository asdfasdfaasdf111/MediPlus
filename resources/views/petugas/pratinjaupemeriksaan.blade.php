<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeriksaan Petugas</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

@php
    use Carbon\Carbon;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dataPasien = $dataPemeriksaan->dataPasien;
    $dataRujukan = $dataPemeriksaan->dataRujukan;
@endphp

<div>Ringkasan Pemeriksaan</div>
<div>
    <div>Pilih Jadwal</div>
    <div>Rumah Sakit: {{ $rumahSakit->nama }}</div>
    <div>Jenis Pemeriksaan: {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</div>
    <div>Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
    <div>Rentang Waktu Kedatangan: {{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}</div>
    <a href = "{{ route('petugas.kelolajenispemeriksaan') }}"> Ubah Jadwal </a>
</div>
==========================================================
<div>
    <div>Tipe Pasien</div>
    {{-- yang di comment itu antara uda ga diperlukan(kayanya, bahas dlu), atau datanya ga disimpan --}}
    {{-- <div>Tipe Pasien: </div>
    <div>Nomor Rekam Medis: </div>
    <div>Pendaftaran dilakukan untuk: </div>
    <div>Hubungan dengan Pasien: {{ $dataPemeriksaan->tanggalPemeriksaan }}</div> --}}
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
    <div>
        Catatan: 
        @if (!empty($dataPemeriksaan->catatanPetugas))
            {{$dataPemeriksaan->catatanPetugas}}
        @else
            -
        @endif
    </div>
</div>
==========================================================
<div>
    <div>Formulir Data Diri</div>
    <div>Nama Lengkap: {{ $dataPasien->namaLengkap }}</div>
    <div>Jenis Kelamin: {{ $dataPemeriksaan->riwayatJenisKelamin }}</div>
    <div>Tanggal Lahir: {{ $dataPemeriksaan->riwayatTanggalLahir }}</div>
    <div>Golongan Darah: {{ $dataPemeriksaan->riwayatGolonganDarah }}</div>
    <div>Jenis Kartu Identitas: {{ $dataPasien->jenisIdentitas }}</div>
    <div>
        Nomor Identitas: 
        @php
            $start = substr($dataPasien->noIdentitas, 0, 4);
            for ($i = 0; $i < strlen($dataPasien->noIdentitas) - 4; $i++){
                $start .= 'X';
            }
        @endphp
        {{ $start }}
    </div>
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
    {{-- bikin jadi bnrn bisa pencet file ntr idk --}}
    <div>Formulir Rujukan: {{ $dataRujukan->formulirRujukan }}</div>
</div>

<form method="POST" action="{{ route('petugas.updatePendaftaran', $dataPemeriksaan) }}">
    @csrf
    @method('PUT')
    Jadwalkan Dokter
    <div>Dokter Radiologi </div>
    <select name="dokterId" class="form-control edit-field">
        @foreach($rumahSakit->dokter as $dokter)
            <option 
                value="{{ $dokter->id }}" 
                @if($jenisPemeriksaan->diDampingiDokter && !$dokter->available($dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan->rentangWaktuKedatangan, $jenisPemeriksaan->lamaPemeriksaan)) disabled @endif
            >
                {{ $dokter->user->name }}
                @if($jenisPemeriksaan->diDampingiDokter && !$dokter->available($dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan->rentangWaktuKedatangan, $jenisPemeriksaan->lamaPemeriksaan)) (Not available) @endif
            </option>
        @endforeach
    </select>
    <div class="d-flex justify-content-center gap-3 pt-3">
        <a href="{{ route('petugas.homepage') }}" 
           class="btn btn-outline-primary px-5 rounded-pill">
            Kembali
        </a>
        <button type="submit" name="status" value="rejected" class="btn btn-sm btn-danger">
            Tolak
        </button>
        <button type="submit" name="status" value="accepted" class="btn btn-primary px-5 rounded-pill">
            Terima
        </button>
    </div>
</form>