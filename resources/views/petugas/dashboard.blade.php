{{-- resources/views/petugas/homepage.blade.php --}}
@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Petugas | Dashboard</title>

  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark">

  {{-- NAVBAR --}}
  @include('layout.navbar2')

  <div class="container-fluid">
    <div class="row">
      {{-- SIDEBAR (kiri) --}}
      <div class="col-md-2 min-vh-100 p-3 border-end">
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}"
               class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolajenispemeriksaan') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolajenispemeriksaan') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-clipboard2-check me-2"></i> Jenis Pemeriksaan
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolamodalitas') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolamodalitas') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-hdd-rack me-2"></i> Modalitas
            </a>
          </li>
        </ul>
      </div>

      {{-- KONTEN (kanan) --}}
      <div class="col-md-10 p-4">

        {{-- Header: Search + tombol Dashboard --}}
        <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
          <form action="" method="GET" class="flex-grow-1">
            <div class="input-group">
              <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Telusuri">
              <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </div>
          </form>

        
        </div>

        {{-- Status --}}
        @php $aktif = request('status','semua'); @endphp
        <ul class="nav nav-tabs border-0 mb-2">
          @foreach ([
            'semua' => 'Semua',
            'pending' => 'Pending',
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
          ] as $key => $label)
            <li class="nav-item">
              <a class="nav-link {{ $aktif===$key ? 'active' : '' }}"
                 href="{{ request()->fullUrlWithQuery(['status'=>$key]) }}">{{ $label }}</a>
            </li>
          @endforeach
        </ul>

        {{-- List Kartu Pemeriksaan --}}
        @forelse ($petugas->dataPemeriksaan as $dp)
          @php
            // Filter sesuai tab (opsional; jika sudah difilter di controller, hapus blok if ini)
            $s = strtolower($dp->statusUtama ?? '');
            if ($aktif !== 'semua') {
              $map = [
                'pending'     => 'pending',
                'berlangsung' => 'berlangsung',
                'selesai'     => 'selesai',
                'dibatalkan'  => 'dibatalkan',
              ];
              if (isset($map[$aktif]) && $s !== $map[$aktif]) continue;
            }

            $pasien  = $dp->dataPasien;
            $rujukan = $dp->dataRujukan;
            $jenis   = $dp->jenisPemeriksaan;

            $noReg   = $dp->noRegistrasi ?? ('REG-'.str_pad($dp->id,6,'0',STR_PAD_LEFT));
            $tgl     = $dp->tanggalPemeriksaan ? Carbon::parse($dp->tanggalPemeriksaan)->translatedFormat('d F Y') : '-';
            $jamMulai= $dp->rentangWaktuKedatangan ? Carbon::parse($dp->rentangWaktuKedatangan)->format('H : i') : '-';
            $jamAkhir= $dp->rentangWaktuKedatangan ? Carbon::parse($dp->rentangWaktuKedatangan)->addHour()->format('H : i') : '-';

            // Label kanan kecil
            $labelKanan = match (strtolower($dp->statusPetugas ?? '')) {
              'pendaftaran baru'   => 'PENDAFTARAN BARU',
              'menunggu konfirmasi'=> 'MENUNGGU KONFIRMASI',
              'siap diperiksa'     => 'SIAP DIPERIKSA',
              default              => strtoupper($dp->statusPetugas ?? ''),
            };

            // Warna status kiri
            $statusUtama = strtoupper($dp->statusUtama ?? 'PENDING');
            $statusClass = match (strtolower($statusUtama)) {
              'pending'     => 'text-warning',
              'berlangsung' => 'text-primary',
              'selesai'     => 'text-success',
              'dibatalkan'  => 'text-danger',
              default       => 'text-secondary',
            };

            $isPending = strtolower($statusUtama) === 'pending';
          @endphp

          {{-- CARD --}}
          <div class="card border-0 shadow-sm mb-3" style="background:#F5F8FF;">
            <div class="card-body p-0">

              {{-- Header --}}
              <div class="px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
                <div class="small">No : <span class="fw-semibold">{{ $noReg }}</span></div>
                @php $rightLabel = $labelKanan ?: $statusUtama; @endphp
                <div class="small fw-semibold {{ $labelKanan ? 'text-muted' : $statusClass }}">
                  {{ $rightLabel }}
                </div>
              </div>

              <hr class="my-0">

              {{-- Body (3 kolom) --}}
              <div class="row g-3 p-4 align-items-center">

                {{-- Kolom 1: status besar --}}
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                  <div class="{{ $statusClass }} fw-bold" style="font-size:1.1rem;">
                    {{ $statusUtama }}
                  </div>
                </div>

                {{-- Kolom 2: detail --}}
                <div class="col-md-8">
                  <div class="row gy-1">
                    <div class="col-5 text-muted">Nama Lengkap Pasien</div>
                    <div class="col-5 fw-semibold">: {{ $pasien->namaLengkap ?? '-' }}</div>

                    @if (strtolower($statusUtama) === 'pending')
                      <div class="col-5 text-muted">Dokter Perujuk</div>
                      <div class="col-5 fw-semibold">: {{ $rujukan->namaDokterPerujuk ?? '-' }}</div>
                    @elseif (strtolower($statusUtama) !== 'dibatalkan')
                      <div class="col-5 text-muted">Dokter Radiologi</div>
                      <div class="col-5 fw-semibold">: {{ $dp->dokter->user->name ?? '-' }}</div>
                    @endif

                    <div class="col-5 text-muted">Jenis Pemeriksaan</div>
                    <div class="col-6 fw-semibold">
                      : {{ $jenis->namaJenisPemeriksaan ?? '-' }}{!! isset($jenis->namaPemeriksaanSpesifik) ? ' - '.e($jenis->namaPemeriksaanSpesifik) : '' !!}
                    </div>

                    <div class="col-5 text-muted">Tanggal Pemeriksaan</div>
                    <div class="col-5 fw-semibold">: {{ $tgl }}</div>

                    <div class="col-5 text-muted">Rentang Waktu Kedatangan</div>
                    <div class="col-5 fw-semibold">: {{ $jamMulai }} - {{ $jamAkhir }}</div>
                  </div>
                </div>

                {{-- Kolom 3: tombol --}}
                <div class="col-md-2 d-flex flex-column align-items-center gap-2">
                  @if ($isPending)
                    <a href="{{ route('petugas.pratinjaupemeriksaan', $dp) }}" class="btn btn-success w-100">
                      PRATINJAU
                    </a>
                  @else
                    <a href="{{ route('petugas.detailpemeriksaan', $dp) }}"
                       class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                      <i class="bi bi-eye"></i> LIHAT DETAIL
                    </a>
                  @endif
                </div>
              </div>

              <hr class="my-0">

              {{-- Footer aksi ringan (opsional) --}}
              <div class="px-4 py-2 d-flex justify-content-end">
                <button class="btn btn-sm btn-light border" disabled>
                  <i class="bi bi-paperclip me-1"></i> Lampiran
                </button>
              </div>
            </div>
          </div>
        @empty
          <div class="text-center text-muted py-5">
            <i class="bi bi-inboxes me-1"></i> Belum ada data.
          </div>
        @endforelse

        {{-- Footer kecil --}}
        <div class="text-center text-muted small py-3">
          © {{ date('Y') }} MediPlus — Petugas Panel
        </div>

      </div>{{-- /col-md-10 --}}
    </div>{{-- /row --}}
  </div>{{-- /container-fluid --}}

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
