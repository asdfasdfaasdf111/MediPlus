@php 
    use Carbon\Carbon; 
@endphp

@extends('layout.staff')

@section('title', 'Homepage Dokter')

@section('content')

@php 
    $aktif = request('status','semua'); 
@endphp

<div class="container-fluid">
    <div class="row">

        @include('layout.sidebardokter')

        <div class="col-md-10 bg-light min-vh-100 px-4 pt-4">

            <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                <form action="{{ route('dokter.homepage') }}" method="GET" class="flex-grow-1">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <div class="input-group">
                        <input id="doctorSearch"
                               class="form-control"
                               type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Telusuri">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <ul class="nav nav-tabs border-0 mb-2">
                @foreach ([
                    'semua' => 'Semua',
                    'berlangsung' => 'Berlangsung',
                    'selesai' => 'Selesai'
                ] as $key => $label)
                    <li class="nav-item">
                        <a class="nav-link {{ $aktif===$key ? 'active' : '' }}"
                           href="{{ route('dokter.homepage', ['status' => $key]) }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>

    {{-- CARD PEMERIKSAAN --}}
    @forelse ($list as $dataPemeriksaan)
        @php
            $dataPasien = $dataPemeriksaan->dataPasien;
            $dataRujukan = $dataPemeriksaan->dataRujukan;
            $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;

            $noReg    = $dataPemeriksaan->noRegistrasi ?? ('REG-'.str_pad($dataPemeriksaan->id, 6, '0', STR_PAD_LEFT));
            $tgl      = $dataPemeriksaan->tanggalPemeriksaan ? Carbon::parse($dataPemeriksaan->tanggalPemeriksaan)->translatedFormat('d F Y') : '-';
            $jamMulai = $dataPemeriksaan->rentangWaktuKedatangan ? Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i') : '-';
            $jamAkhir = $dataPemeriksaan->rentangWaktuKedatangan ? Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->format('H:i') : '-';

            $labelKanan = match (strtolower($dataPemeriksaan->statusDokter ?? '')){
                'dalam antrian'           => 'DALAM ANTRIAN',
                'pemeriksaan berlangsung' => 'PEMERIKSAAN BERLANGSUNG',
                'menunggu laporan'        => 'MENUNGGU LAPORAN',
                'laporan terkirim'        => 'LAPORAN TERKIRIM',
                'selesai'                 => 'SELESAI',
                default => strtoupper($dataPemeriksaan->statusDokter),
            };

            $statusClass = match ($dataPemeriksaan->statusUtama){
                'Berlangsung' => 'text-primary',
                'Selesai'     => 'text-success',
            };
        @endphp

        <div class="card border-0 shadow-sm mb-3 dokter-card">
            <div class="card-body p-0">

                <div class="px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <div class="small">
                        No : <span class="fw-semibold">{{ $noReg }}</span>
                    </div>
                    <div class="small fw-semibold {{ $statusClass }}">
                        {{ $labelKanan }}
                    </div>
                </div>

                <hr class="my-0">

                <div class="row g-3 p-4">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="{{ $statusClass }} fw-bold" style="font-size:1.1rem;">
                            {{ $dataPemeriksaan->statusUtama }}
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="row gy-1">
                            <div class="col-6 text-muted">Nama Lengkap Pasien</div>
                            <div class="col-6 fw-semibold">: {{ $dataPasien->namaLengkap }}</div>

                            <div class="col-6 text-muted">Dokter Perujuk</div>
                            <div class="col-6 fw-semibold">: {{ $dataRujukan->namaDokterPerujuk }}</div>

                            <div class="col-6 text-muted">Dokter Radiologi</div>
                            <div class="col-6 fw-semibold">: {{ $dataPemeriksaan->dokter->user->name }}</div>

                            <div class="col-6 text-muted">Jenis Pemeriksaan</div>
                            <div class="col-6 fw-semibold">
                                : {{ $jenisPemeriksaan->namaJenisPemeriksaan }}
                            </div>

                            <div class="col-6 text-muted">Tanggal Pemeriksaan</div>
                            <div class="col-6 fw-semibold">: {{ $tgl }}</div>

                            <div class="col-6 text-muted">Rentang Waktu Kedatangan</div>
                            <div class="col-6 fw-semibold">: {{ $jamMulai }} - {{ $jamAkhir }}</div>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex flex-column align-items-end justify-content-center gap-2">
                        <a href="{{ route('dokter.detailpemeriksaan', $dataPemeriksaan) }}"
                           class="btn btn-sm {{ $dataPemeriksaan->statusDokter == 'Menunggu Laporan' ? 'btn-primary' : 'btn-outline-primary' }} px-4">
                            {{ $dataPemeriksaan->statusDokter == 'Menunggu Laporan' ? 'Upload File' : 'Lihat Detail' }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-inboxes me-1"></i> Belum ada data.
        </div>
    @endforelse

    {{-- PAGINATION --}}
    @if (method_exists($list, 'links') && $list->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $list->onEachSide(1)->links() }}
        </div>
    @endif

</div>
@endsection