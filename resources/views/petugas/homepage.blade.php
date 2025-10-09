<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Petugas</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

@php
    use Carbon\Carbon;
@endphp

<a href="{{ route('petugas.kelolajenispemeriksaan') }}"> Dashboard </a>

@foreach ($petugas->dataPemeriksaan as $dataPemeriksaan)
    @php
        $dataPasien = $dataPemeriksaan->dataPasien;
        $dataRujukan = $dataPemeriksaan->dataRujukan;
        $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    @endphp
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="bg-white shadow-sm rounded p-3">
            {{ $dataPemeriksaan->id }} {{ $dataPemeriksaan->statusPetugas }}
            <div class="d-flex align-items-center mb-2">
                {{ $dataPemeriksaan->statusUtama }}
                <div>
                    <h6 class="mb-0 fw-bold">Nama Lengkap Pasien: {{ $dataPasien->namaLengkap }}</h6>
                    @if ($dataPemeriksaan->statusUtama == 'Pending')
                        <small class="text-muted">Dokter Perujuk: {{ $dataRujukan->namaDokterPerujuk }}</small><br>
                    @elseif ($dataPemeriksaan->statusUtama != 'Dibatalkan')
                        <small class="text-muted">Dokter Radiologi: {{ $dataPemeriksaan->dokter->user->name }}</small><br>
                    @endif
                    
                    <small class="text-muted">Jenis Pemeriksaan:  {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</small><br>
                    <small class="text-muted">Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</small><br>
                    <small class="text-muted">Rentang Waktu Kedatangan: {{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}</small><br>
                </div>
            </div>
            @if ($dataPemeriksaan->statusUtama == 'Pending')
                <div class="col-md-2">
                    <a href="{{ route('petugas.pratinjaupemeriksaan', $dataPemeriksaan) }}" class="btn btn-primary w-100">
                        Pratinjau
                    </a>
                </div>
            @else
                <div class="col-md-2">
                    <a href="{{ route('petugas.detailpemeriksaan', $dataPemeriksaan) }}" class="btn btn-primary w-100">
                        Lihat Detail
                    </a>
                </div>
            @endif
            
        </div>
    </div>
@endforeach