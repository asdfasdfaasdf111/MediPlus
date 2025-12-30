@extends('layout.staff')

@section('title', 'Homepage Petugas')

@section('content')

@php
    use Carbon\Carbon;
    $aktif  = $aktif ?? request('status', 'semua');
    $search = $search ?? request('search');
@endphp

  <div class="container-fluid ">
    <div class="row">
      @include('layout.sidebarpetugas')

      <div class="col-md-10 p-4  bg-light">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

          <div class="flex-grow-1 me-3">
            <form action="{{ route('petugas.homepage') }}" method="GET">
              
              @if($aktif)
                <input type="hidden" name="status" value="{{ $aktif }}">
              @endif

              <div class="input-group">
                <input id="petugasSearch" type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Telusuri" >
                <button class="btn btn-outline-secondary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>

          <div class="col-12 col-md-3 mt-2 mt-md-0">
            <a href="{{ route('petugas.tambahpendaftaranbaru') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" >
              <i class="bi bi-plus-lg"></i>
              <span>Tambah Pendaftaran Baru</span>
            </a>
          </div>
        </div>


        <ul class="nav nav-tabs border-0 mb-2">
          @foreach ([
            'semua'      => 'Semua',
            'pending'    => 'Pending',
            'berlangsung'=> 'Berlangsung',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
          ] as $key => $label)
            <li class="nav-item">
              <a class="nav-link {{ $aktif === $key ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['status' => $key]) }}" >
                {{ $label }}
              </a>
            </li>
          @endforeach
        </ul>

        {{-- kita pakai forelse ya adik2 biar menghandle data kosong --}}
        @forelse ($dataPemeriksaans as $dp)
          @php
            $statusUtamaRaw   = $dp->statusUtama ?? 'Pending';
            $statusUtamaLower = strtolower($statusUtamaRaw);


            $pasien  = $dp->dataPasien;
            $rujukan = $dp->dataRujukan;
            $jenis   = $dp->jenisPemeriksaan;
            $noReg = $dp->noRegistrasi ?? ('REG-' . str_pad($dp->id, 6, '0', STR_PAD_LEFT));
            $tgl = $dp->tanggalPemeriksaan ? Carbon::parse($dp->tanggalPemeriksaan)->translatedFormat('d F Y') : '-';
            $jamMulai = $dp->rentangWaktuKedatangan ? Carbon::parse($dp->rentangWaktuKedatangan)->format('H : i') : '-';
            $jamAkhir = $dp->rentangWaktuKedatangan ? Carbon::parse($dp->rentangWaktuKedatangan)->addHour()->format('H : i') : '-';
            $pembayaran = $dp->pembayaran;

            $statusPetugasRaw   = $dp->statusPetugas ?? null;
            $statusPetugasLower = strtolower($statusPetugasRaw ?? '');

            $labelKanan = match ($statusPetugasLower) {
                'pendaftaran baru'          => 'PENDAFTARAN BARU',
                'menunggu registrasi ulang' => 'MENUNGGU REGISTRASI ULANG',
                'dalam antrian'             => 'DALAM ANTRIAN',
                'pemeriksaan berlangsung'   => 'PEMERIKSAAN BERLANGSUNG',
                'pendaftaran dibatalkan'    => 'PENDAFTARAN DIBATALKAN',
                default                     => strtoupper($statusPetugasRaw ?? ''),
            };

            $statusClass = match ($statusUtamaLower) {
                'draft'       => 'text-secondary',
                'pending'     => 'text-warning',
                'berlangsung' => 'text-primary',
                'selesai'     => 'text-success',
                'dibatalkan'  => 'text-danger',
                default       => 'text-secondary',
            };

            $isPending = $statusUtamaLower === 'pending';

          @endphp

          {{-- CARD --}}
          <div class="card border-0 shadow-sm mb-3 petugas-card">
            <div class="card-body p-0">

              <div class="px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
                <div class="small">
                  No : <span class="fw-semibold">{{ $noReg }}</span>
                </div>
                <div class="small fw-semibold text-muted">
                  {{ $labelKanan }}
                </div>
              </div>

              <hr class="my-0">

              <div class="row g-3 p-4 align-items-center ">
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                  <div class="{{ $statusClass }} fw-bold" style="font-size:1.1rem;">
                    {{ strtoupper($statusUtamaRaw) }}
                  </div>
                </div>

                {{-- DETAIL PASIEN & PEMERIKSAAN --}}
                <div class="col-md-8">
                  <div class="row gy-1">
                    <div class="col-5 text-muted">Nama Lengkap Pasien</div>
                    <div class="col-5 fw-semibold">
                      : {{ $pasien->namaLengkap ?? '-' }}
                    </div>
                    @if ($statusUtamaLower === 'pending')
                      <div class="col-5 text-muted">Dokter Perujuk</div>
                      <div class="col-5 fw-semibold">
                        : {{ $rujukan->namaDokterPerujuk ?? '-' }}
                      </div>
                    @elseif ($statusUtamaLower !== 'dibatalkan')
                      <div class="col-5 text-muted">Dokter Radiologi</div>
                      <div class="col-5 fw-semibold">
                        : {{ $dp->dokter->user->name ?? '-' }}
                      </div>
                    @endif
                    <div class="col-5 text-muted">Jenis Pemeriksaan</div>
                    <div class="col-6 fw-semibold">
                      : {{ $jenis->namaJenisPemeriksaan ?? '-' }}
                      {!! isset($jenis->namaPemeriksaanSpesifik)
                            ? ' - ' . e($jenis->namaPemeriksaanSpesifik)
                            : '' !!}
                    </div>
                    <div class="col-5 text-muted">Tanggal Pemeriksaan</div>
                    <div class="col-5 fw-semibold">
                      : {{ $tgl }}
                    </div>
                    <div class="col-5 text-muted">Rentang Waktu Kedatangan</div>
                    <div class="col-5 fw-semibold">
                      : {{ $jamMulai }} - {{ $jamAkhir }}
                    </div>

                    {{-- ini titip dulu -> BARU DITAMBAH. MIKIRINNYA NANTIAN --}}
                    @if ($pembayaran !== null)
                      <div class="col-5 text-muted">Biaya Pemeriksaan</div>
                      <div class="col-5 fw-semibold">
                        : {{ $pembayaran->harga }}
                      </div>
                    @endif
                  </div>
                </div>

                <div class="col-md-2 d-flex flex-column align-items-center gap-2">
                  @if ($dp->statusPasien === 'Pendaftaran Terkirim')
                    <a href="{{ route('petugas.pratinjaupemeriksaan', $dp) }}" class="btn btn-success w-100" >
                      PRATINJAU
                    </a>
                  @else
                    <a href="{{ route('petugas.detailpemeriksaan', $dp) }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                      <i class="bi bi-eye"></i> LIHAT DETAIL
                    </a>
                  @endif
                </div>
              </div>

              <hr class="my-0">

              <div class="px-4 py-2 d-flex justify-content-end">
                <a href="{{ asset('storage/' . $rujukan->formulirRujukan) }}" 
                  target="_blank"
                  class="btn btn-sm btn-light border">
                   <i class="bi bi-paperclip me-1"></i> Lampiran
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="text-center text-muted py-5">
            <i class="bi bi-inboxes me-1"></i> Belum ada data.
          </div>
        @endforelse

        {{-- Paginationnya --}}
        @if(method_exists($dataPemeriksaans, 'links') && $dataPemeriksaans->hasPages())
          <div class="">
            {{ $dataPemeriksaans->onEachSide(1)->links() }}
          </div>
        @endif

      </div>
    </div>
  </div>

@endsection
