@extends('layout.app')

@section('content')
<div class="container py-4">

  {{-- ================== LIST DATA PASIEN ================== --}}
  @php
    $hasPasien = isset($dataPasiens) && !$dataPasiens->isEmpty();
  @endphp

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h2 class="fw-bold mb-0" style="color:#173B7A;">List Data Pasien</h2>
      <div class="text-muted small mt-1">Untuk mendaftar pemeriksaan, tambahkan data pasien.</div>
    </div>

    @if($hasPasien)
      <a href="{{ route('pasien.datapasien.create') }}"
         class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2 px-3">
        <i class="bi bi-plus-lg"></i>
        <span>Data Pasien</span>
      </a>
    @endif
  </div>

  @if(!$hasPasien)
    {{-- EMPTY STATE: dibuat lebih ringkas (padding diperkecil) --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4 p-md-4 text-center">
        <div class="mx-auto mb-3" style="width:68px;height:68px;border-radius:50%;
             background:#EEF3FF;display:flex;align-items:center;justify-content:center;">
          <i class="bi bi-person-plus" style="font-size:1.6rem;color:#2f6fed;"></i>
        </div>
        <h5 class="fw-semibold mb-2">Belum ada data pasien</h5>
        <p class="text-muted mb-4">Tambahkan data pasien terlebih dahulu sebelum melakukan pendaftaran pemeriksaan.</p>
        <a href="{{ route('pasien.datapasien.create') }}"
           class="btn btn-primary d-inline-flex align-items-center gap-2 px-3">
          <i class="bi bi-plus-lg"></i> Tambah Data Pasien
        </a>
      </div>
    </div>
  @else
    <div class="row g-3">
      @foreach($dataPasiens as $p)
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <div class="d-flex align-items-start gap-2 mb-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:40px;height:40px;background:#EEF3FF;color:#2f6fed;">
                  <i class="bi bi-person"></i>
                </div>
                <div class="flex-grow-1">
                  @php
                    $nama   = $p->namaLengkap ?? '—';
                    $umur   = $p->tanggalLahir ? \Carbon\Carbon::parse($p->tanggalLahir)->age : null;
                    $gender = $p->jenisKelamin ?? '—';
                  @endphp
                  <div class="fw-bold" style="font-size:1.1rem;line-height:1.2;">{{ $nama }}</div>
                  <div class="text-muted small mt-1">{{ $umur !== null ? $umur . ' th' : '—' }} | {{ $gender }}</div>
                </div>
              </div>

              <div class="d-flex mt-auto justify-content-end gap-2">
                @if (Route::has('pasien.datapasien.edit'))
                  <a href="{{ route('pasien.datapasien.edit', $p) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil me-1"></i>Edit
                  </a>
                @endif
                @if (Route::has('pasien.datapasien.destroy'))
                  <form action="{{ route('pasien.datapasien.destroy', $p) }}" method="POST"
                        onsubmit="return confirm('Hapus data pasien &quot;{{ $p->namaLengkap }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif


  {{-- ================== PEMERIKSAAN BERLANGSUNG ================== --}}
  {{-- jarak antar section diperkecil --}}
  <hr class="my-4">

  @php
    $hasExam = isset($pemeriksaanBerlangsung) && !$pemeriksaanBerlangsung->isEmpty();
  @endphp

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="fw-bold mb-0" style="color:#173B7A;">Pemeriksaan Berlangsung</h4>
    
  </div>

  @if(!$hasExam)
    {{-- EMPTY STATE: tambah Bootstrap Icon + padding diperkecil --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4 p-md-4 text-center">
        <div class="mx-auto mb-3" style="width:68px;height:68px;border-radius:50%;
             background:#EEF3FF;display:flex;align-items:center;justify-content:center;">
          <i class="bi bi-clipboard-plus" style="font-size:1.6rem;color:#2f6fed;"></i>
        </div>
        <div class="text-muted mb-3">Belum ada pemeriksaan yang berjalan.</div>
        <a href="{{ route('pasien.homepage') }}"
           class="btn btn-primary d-inline-flex align-items-center gap-2 px-3">
          <i class="bi bi-plus-lg"></i> Daftar Pemeriksaan Baru
        </a>
      </div>
    </div>
  @else
    @foreach($pemeriksaanBerlangsung as $ex)
      @php
        $statusKey   = strtolower($ex->statusUtama ?? '');
        $statusLabel = match($statusKey) {
          'pending' => 'PENDING',
          'terkirim', 'terjadwal' => 'PENDAFTARAN TERKIRIM',
          'selesai' => 'SELESAI',
          'batal'   => 'DIBATALKAN',
          default   => strtoupper($ex->statusUtama ?? '—'),
        };
        $statusClass = match($statusKey) {
          'pending' => 'text-warning',
          'terkirim', 'terjadwal' => 'text-warning',
          'selesai' => 'text-success',
          'batal'   => 'text-danger',
          default   => 'text-muted',
        };
        $tgl   = $ex->tanggalPemeriksaan ? \Carbon\Carbon::parse($ex->tanggalPemeriksaan)->translatedFormat('d F Y') : '—';
        $jam   = $ex->rentangWaktuKedatangan ? \Carbon\Carbon::parse($ex->rentangWaktuKedatangan)->format('H:i') : '—';
        $noReg = 'REG-' . str_pad($ex->id, 6, '0', STR_PAD_LEFT);
      @endphp

      <div class="card border-0 shadow-sm mb-3" style="background:#F5F8FF;">
        <div class="card-body p-0">
          <div class="px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
            <div class="small">No : <span class="fw-semibold">{{ $noReg }}</span></div>
            <div class="small fw-semibold {{ $statusClass }}">{{ $statusLabel }}</div>
          </div>

          <hr class="my-0">

          <div class="row g-3 p-4">
            <div class="col-md-3 d-flex align-items-center justify-content-center">
              <div class="{{ $statusClass }} fw-bold" style="font-size:1.1rem;">{{ $statusLabel }}</div>
            </div>

            <div class="col-md-7">
              <div class="row gy-1">
                <div class="col-6 text-muted">Nama Lengkap Pasien</div>
                <div class="col-6 fw-semibold">: {{ optional($ex->dataPasien)->namaLengkap ?? '—' }}</div>

                <div class="col-6 text-muted">Dokter Perujuk</div>
                <div class="col-6 fw-semibold">: {{ optional($ex->dokter)->nama ?? '—' }}</div>

                <div class="col-6 text-muted">Jenis Pemeriksaan</div>
                <div class="col-6 fw-semibold">: {{ optional($ex->jenisPemeriksaan)->nama ?? '—' }}</div>

                <div class="col-6 text-muted">Tanggal Pemeriksaan</div>
                <div class="col-6 fw-semibold">: {{ $tgl }}</div>

                <div class="col-6 text-muted">Waktu Kedatangan</div>
                <div class="col-6 fw-semibold">: {{ $jam }}</div>
              </div>
            </div>

            <div class="col-md-2 d-flex flex-column align-items-end gap-2">
              <button class="btn btn-light border w-100" disabled>
                <i class="bi bi-paperclip me-1"></i> Lampiran
              </button>
            </div>
          </div>

          <hr class="my-0">
          <div class="px-4 py-2 d-flex justify-content-end gap-2">
            <a href="{{ route('pasien.homepage', $ex) }}" class="btn btn-sm btn-primary">
              <i class="bi bi-pencil-square me-1"></i> EDIT
            </a>
            {{-- <form action="{{ route('pasien.pemeriksaan.destroy', $ex) }}" method="POST"
                  onsubmit="return confirm('Hapus pendaftaran ini?');">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-trash me-1"></i> HAPUS
              </button>
            </form> --}}
          </div>
        </div>
      </div>
    @endforeach

    @if(method_exists($pemeriksaanBerlangsung, 'links'))
      <div class="mt-3">
        {{ $pemeriksaanBerlangsung->links() }}
      </div>
    @endif
  @endif

</div>
@endsection
