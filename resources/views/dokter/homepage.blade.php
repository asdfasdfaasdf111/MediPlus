@php use Carbon\Carbon;@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Homepage Dokter</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    @include('layout.navbar2')
    
    <div class="row-md-10 p-4">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <form action="" class="flex-grow-1" method="GET">
                <div class="input-group">
                    <input class="form-control form-control-sm w-auto" type="text" name="search" placeholder="Telusuri" style="font-family: 'Open Sans', sans-serif;">
                    <button class="btn btn-outline-secondary" type="submit" style="background-color: #ffff">
                        <i class="bi bi-search" style="background-color: #ffff"></i>
                    </button>
                </div>
            </form>

            <div class="col-md-2 p-4">
                <form action="{{ route('dokter.listdaftar') }}" method="GET">
                    <button type="submit" class="btn btn-primary w-100 fw-bold px-3">+ Tambah RS Baru</button>
                </form>
            </div>
        </div>
    </div>

    @php $aktif = request('status','semua'); @endphp
        <ul class="nav nav-tabs border-0 ms-4 me-4">
          @foreach ([
            'semua' => 'Semua',
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai'
          ] as $key => $label)
            <li class="nav-item">
              <a class="nav-link {{ $aktif===$key ? 'active' : '' }}"
                href="{{ route('dokter.homepage', ['status' => $key]) }}">
                {{ $label }}</a>
            </li>
          @endforeach
        </ul>

    @php
        $query = $dokter->dataPemeriksaan()->where('statusDokter', '!=', 'Menunggu Registrasi Ulang');

        if ($aktif !== 'semua') {
            $query->whereRaw('LOWER(statusUtama) = ?', [strtolower($aktif)]);
        }

        $list = $query->get();
    @endphp

    @forelse ($list as $dataPemeriksaan)
        @php
            $dataPasien = $dataPemeriksaan->dataPasien;
            $dataRujukan = $dataPemeriksaan->dataRujukan;
            $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;

            $noReg    = $dataPemeriksaan->noRegistrasi ?? ('REG-'.str_pad($dataPemeriksaan->id, 6, '0', STR_PAD_LEFT));
            $tgl      = $dataPemeriksaan->tanggalPemeriksaan ? Carbon::parse($dataPemeriksaan->tanggalPemeriksaan)->translatedFormat('d F Y') : '-';
            $jamMulai = $dataPemeriksaan->rentangWaktuKedatangan ? Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H : i') : '-';
            $jamAkhir = $dataPemeriksaan->rentangWaktuKedatangan ? Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->format('H : i') : '-';

            // Status Kanan Atas
            $labelKanan = match (strtolower($dataPemeriksaan->statusDokter ?? '')){
                'dalam antrian'           => 'DALAM ANTRIAN',
                'pemeriksaan berlangsung' => 'PEMERIKSAAN BERLANGSUNG',
                'menunggu laporan'        => 'MENUNGGU LAPORAN',
                'selesai'                 => 'SELESAI'
            };

            $statusClass = match ($dataPemeriksaan->statusUtama){
                'Berlangsung' => 'text-primary',
                'Selesai'     => 'text-success'
            }
        @endphp

        <div class="card border-0 shadow-sm mb-4 ms-4 me-4 mt-2" style="background:#F5F8FF;">
            <div class="card-body p-0">
                <div class="px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <div class="small">
                        No : <span class="fw-semibold">{{ $noReg }}</span>
                    </div>
                    <div class="small fw-semibold {{ $statusClass }}"> {{ $labelKanan }}</div>
                </div>

                <hr class="my-0">

                <div class="row g-3 p-4 align-items-center">
                     <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <div class="{{ $statusClass }} fw-bold" style="font-size:1.1rem;">
                            {{ $dataPemeriksaan->statusUtama }}
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row gy-1">
                            <div class="col-5 text-muted">Nama Lengkap Pasien</div>
                            <div class="col-5 fw-semibold">: {{ $dataPasien->namaLengkap }}</div>

                            <div class="col-5 text-muted">Dokter Perujuk</div>
                            <div class="col-5 fw-semibold">: {{ $dataRujukan->namaDokterPerujuk }}</div>

                            <div class="col-5 text-muted">Dokter Radiologi</div>
                            <div class="col-5 fw-semibold">: {{ $dataPemeriksaan->dokter->user->name }}</div>

                            <div class="col-5 text-muted">Jenis Pemeriksaan</div>
                            <div class="col-5 fw-semibold">: {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }} </div>

                            <div class="col-5 text-muted">Tanggal Pemeriksaan</div>
                            <div class="col-5 fw-semibold">: {{ $tgl }}</div>

                            <div class="col-5 text-muted">Rentang Waktu Kedatangan</div>
                            <div class="col-5 fw-semibold">: {{ $jamMulai }} - {{ $jamAkhir }}</div>
                        </div>

                        @if($dataPemeriksaan->statusDokter ==  'Menunggu Laporan')
                                <div class="col-md-2">
                                    <a href="{{ route('dokter.detailpemeriksaan', $dataPemeriksaan) }}">
                                        <button class="bi bi-upload">Upload File</button>
                                    </a>
                                </div>
                            @else
                                <div class="col-md-2">
                                    <a href="{{ route('dokter.detailpemeriksaan', $dataPemeriksaan) }}">
                                        <button class="bi bi-primary">Lihat Detail</button>
                                    </a>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-inboxes me-1"></i> Belum ada data.
            </div>
    @endforelse
</body>
</html>


{{-- <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="bg-white shadow-sm rounded p-3">
                {{ $dataPemeriksaan->id }} {{ $dataPemeriksaan->statusDokter }}
                <div class="d-flex align-items-center mb-2">
                    {{ $dataPemeriksaan->statusUtama }}
                    <div>
                        <h6 class="mb-0 fw-bold">Nama Lengkap Pasien: {{ $dataPasien->namaLengkap }}</h6>
                        <small class="text-muted">Dokter Radiologi: {{ $dataPemeriksaan->dokter->user->name }}</small><br>
                        <small class="text-muted">Jenis Pemeriksaan:  {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</small><br>
                        <small class="text-muted">Tanggal Pemeriksaan: {{ $dataPemeriksaan->tanggalPemeriksaan }}</small><br>
                        <small class="text-muted">Rentang Waktu Kedatangan: {{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}</small><br>
                    </div>
                </div>
                @if($dataPemeriksaan->statusDokter ==  'Menunggu Laporan')
                    <div class="col-md-2">
                        <a href="{{ route('dokter.detailpemeriksaan', $dataPemeriksaan) }}">
                            <button class="bi bi-upload">Upload File</button>
                        </a>
                    </div>
                @else
                    <div class="col-md-2">
                        <a href="{{ route('dokter.detailpemeriksaan', $dataPemeriksaan) }}">
                            <button class="bi bi-primary">Lihat Detail</button>
                        </a>
                    </div>
                @endif
            </div>
        </div> --}}
