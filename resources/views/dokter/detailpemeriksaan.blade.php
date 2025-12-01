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
    $hasilPemeriksaan = $dataPemeriksaan->hasilPemeriksaan;
@endphp

<div class="container mt-5">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-primary">Ringkasan Pemeriksaan</h4>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4" style="max-width: 700px; margin: 0 auto;">
        <h5 class="fw-bold text-primary">Jadwal Pemeriksaan</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label mt-1">Rumah Sakit</label>
                <p class="fw-bold">{{ $rumahSakit->nama }}</p>

                <label class="form-label mt-1">Jenis Pemeriksaan</label>
                <p class="fw-bold">{{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</p>

                @if ($dataPemeriksaan->statusUtama != 'Dibatalkan')
                    <label class="form-label mt-1">Dokter Radiologi</label>
                    <p class="fw-bold">{{ $dokter->user->name }}</p>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label mt-1">Tanggal Pemeriksaan</label>
                <p class="fw-bold">{{ $dataPemeriksaan->tanggalPemeriksaan }}</p>

                <label class="form-label mt-1">Rentang Waktu Kedatangan</label>
                <p class="fw-bold">{{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}</p>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 mt-3" style="max-width: 700px; margin: 0 auto;">
        <h5 class="fw-bold text-primary mb-3">Data Pasien</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label mb-1">Nama Lengkap</label>
                <p class="fw-bold mb-3">{{ $dataPasien->namaLengkap }}</p>

                <label class="form-label mb-1">Jenis Kelamin</label>
                <p class="fw-bold">{{ $dataPemeriksaan->riwayatJenisKelamin }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label mb-1">Tanggal Lahir</label>
                <p class="fw-bold mb-3">{{ $dataPemeriksaan->riwayatTanggalLahir }}</p>

                <label class="form-label mb-1">Deskripsi Alergi</label>
                @if (!empty($dataPemeriksaan->riwayatAlergi))
                    <p class="fw-bold">{{ $dataPemeriksaan->riwayatAlergi }}</p>
                @else
                    <p class="text-secondary">-</p>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 mt-3" style="max-width: 700px; margin: 0 auto;">
        <h5 class="fw-bold text-primary mb-3">Data Rujukan</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label mb-1">Nama Fasilitias Kesehatan</label>
                <p class="fw-bold mb-3">{{ $dataRujukan->namaFaskes }}</p>

                <label class="form-label mb-1">Nama Dokter Perujuk</label>
                <p class="fw-bold">{{ $dataRujukan->namaDokterPerujuk }}</p>

                <label class="form-label mb-1">Tanggal Pemeriksaan di Klinik</label>
                <p class="fw-bold">{{ $dataRujukan->tanggalPemeriksaanFaskes }}</p>

                <label class="form-label mb-1">Diagnosa Kerja</label>
                <p class="fw-bold">{{ $dataRujukan->diagnosaKerja }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label mb-1">Alasan Rujukan</label>
                <p class="fw-bold mb-3">{{ $dataRujukan->alasanRujukan }}</p>

                <label class="form-label mb-1">Permintaan Pemeriksaan</label>
                <p class="fw-bold mb-3">{{ $dataRujukan->permintaanPemeriksaan }}</p>

                <label class="form-label mb-1">Formulir Rujukan</label>
                <p class="fw-bold mb-3">{{ $dataRujukan->formulirRujukan }}</p>
            </div>
        </div>
    </div>

    @if($dataPemeriksaan->statusDokter == 'Menunggu Laporan')
        <form action="POST" action="{{ route('file.store') }}" class=""></form>
        <div class="container mt-5">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-primary">Unggah Hasil</h4>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 p-4 mb-5" style="max-width: 700px; margin: 0 auto;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Mitra Radiologi</label>
                <input type="file" class="form-control" name="file" id="hasilPemeriksaan" accept="application/pdf" @if(empty($hasilPemeriksaan->file)) required @endif>
                <span id="fileLampiran">
                    @if (!empty($hasilPemeriksaan->file))
                        {{ $hasilPemeriksaan->fileLampiran }}
                    @else
                        Tidak ada file
                    @endif
                </span>

                <script>
                    const input = document.getElementById('file');
                    const fileLampiran = document.getElementById('file');

                    input.addEventListener('change', () => {
                        if(input.files.length > 0) {
                            fileLampiran.textContent = input.files[0].name;
                        } else {
                            fileLampiran.textcontent = 'Tidak ada file';
                        }
                    });
                </script>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-lanel fw-semibold">Deskripsi Hasil Analisa</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control" placeholder="Deskripsi Hasil Analisa"></textarea>
            </div>

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-primary fw-semibold px-4">
                    Unggah Draft
                </button>
            </div>

            <div class="d-flex justify-content-center gap-4 mt-4">
                <a href="{{ route('dokter.homepage') }}" class="btn btn-outline-primary fw-semibold px-5" style="border-radius: 25px;">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary fw-semibold px-5" style="border-radius: 25px;">
                    Kirim
                </button>
            </div>

        </div>
    @endif


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

{{-- @if($dataPemeriksaan->statusDokter == 'Menunggu Laporan')
    <div class="container mt-5">
    {{-- Judul --}}
    {{-- <div class="text-center mb-4">
        <h4 class="fw-bold text-primary">Unggah Hasil</h4>
    </div> --}}

    {{-- Kartu Form --}}
    {{-- <div class="card shadow-sm border-0 rounded-4 p-4" style="max-width: 700px; margin: 0 auto;">
        <form id="form-hasil" action="{{ route('dokter.hasilpemeriksaan', $dataPemeriksaan) }}"
              method="POST" enctype="multipart/form-data">
            @csrf --}}

            {{-- Mitra Radiologi --}}
            {{-- <div class="mb-3">
                <label class="form-label fw-semibold">Mitra Radiologi</label>
                <div class="d-flex align-items-center gap-3">
                    <label class="btn btn-light border d-flex align-items-center px-4">
                        <i class="bi bi-upload me-2"></i> Unggah
                        <input type="file" name="file" hidden onchange="showFileName(event)">
                    </label>
                    <span id="file-name" class="text-secondary">Belum ada file</span>
                </div>
            </div> --}}

            {{-- Deskripsi Hasil Analisa --}}
            {{-- <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi Hasil Analisa</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control"
                          placeholder="Deskripsi Hasil Analisa" rows="4"></textarea>
            </div> --}}

            {{-- Tombol Unggah Draft --}}
            {{-- <div class="text-end mb-3">
                <button type="submit" class="btn btn-primary fw-semibold px-4">
                    Unggah Draft
                </button>
            </div> --}}

            {{-- Tombol Bawah (Kembali & Kirim) --}}
            {{-- <div class="d-flex justify-content-center gap-4 mt-4">
                <a href="{{ route('dokter.homepage') }}"
                class="btn btn-outline-primary fw-semibold px-4"
                style="border-radius: 25px;">
                    Kembali
                </a>
                <button type="submit"
                        class="btn btn-primary fw-semibold px-5"
                        style="border-radius: 25px;">
                    Kirim
                </button>
            </div>
        </form>
    </div> --}}
</div>

{{-- Script untuk menampilkan nama file --}}
{{-- <script>
function showFileName(event) {
    const input = event.target;
    const fileName = input.files.length ? input.files[0].name : 'Belum ada file';
    document.getElementById('file-name').textContent = fileName;
}
</script> --}}
</body>
</html>
