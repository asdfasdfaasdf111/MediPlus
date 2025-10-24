@extends('layout.app')

@section('title', 'Tentang Kami - MediPlus')

@section('content')
<div class="container py-4 py-md-5">

  <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
    <a href="#visi" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"
       style="border-color:#0A3A7A;color:#0A3A7A">
      <i class="bi bi-bullseye me-1"></i> Visi
    </a>
    <a href="#misi" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"
       style="border-color:#0A3A7A;color:#0A3A7A">
      <i class="bi bi-flag me-1"></i> Misi
    </a>
    <a href="#fitur" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"
       style="border-color:#0A3A7A;color:#0A3A7A">
      <i class="bi bi-stars me-1"></i> Keunggulan
    </a>
    <a href="#alur" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"
       style="border-color:#0A3A7A;color:#0A3A7A">
      <i class="bi bi-diagram-3 me-1"></i> Cara Kerja
    </a>
  </div>
{{-- ====== VISI ====== --}}
<section id="visi" class="mb-5">
  <div class="row g-4 align-items-center">
    <div class="col-lg-6">
      <h2 class="fw-bold mb-3" style="color:#0A3A7A;">Visi</h2>
      <p class="text-muted mb-0">
        Menjadi gerbang layanan radiologi yang <span class="fw-semibold">mudah diakses</span>,
        <span class="fw-semibold">transparan</span>, dan <span class="fw-semibold">andal</span> bagi semua pihak.
      </p>
    </div>
    <div class="col-lg-6">
      <div class="ratio ratio-16x9 rounded-4 overflow-hidden">
        <img src="{{ asset('images/misi.jpg') }}" class="w-100 h-100 object-fit-cover" alt="Ilustrasi Visi MediPlus">
      </div>
    </div>
  </div>
</section>

{{-- ====== MISI ====== --}}
<section id="misi" class="mb-5">
  <div class="row g-4 align-items-center">

    <div class="col-lg-7 order-lg-1 order-2">
      <div class="bg-white rounded-4 border shadow-sm">
        {{-- list group buat yang garis2 terus pojokannya ada bolong hehe --}}
        <ul class="list-group list-group-flush"> 
          @foreach ([
            ['bi-stopwatch',' Memudahkan pemeriksaan radiologi tanpa antri berjam-jam.'],
            ['bi-diagram-3',' Menjadi penghubung antar pihak terkait.'],
            ['bi-file-earmark-medical',' Memberikan kemudahan akses hasil radiologi.'],
          ] as $m)
          <li class="list-group-item py-3">
            <div class="d-flex align-items-center">
              <span class="d-inline-flex align-items-center justify-content-center rounded-circle me-3 flex-shrink-0
                           bg-primary-subtle text-primary" style="width:40px;height:40px;">
                <i class="bi {{ $m[0] }}"></i>
              </span>
              <span class="fw-medium">{{ $m[1] }}</span>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>


    <div class="col-lg-5 order-lg-2 order-1">
      <div class="bg-light rounded-4 p-4 ps-lg-4 ms-lg-2 border-start">
        <h2 class="fw-bold mb-2" style="color:#0A3A7A;">Misi</h2>
        <p class="text-muted mb-0">Fokus pada kemudahan, konektivitas, dan akses hasil yang nyaman.</p>
      </div>
    </div>

  </div>
</section>





  {{-- ====== KEUNGGULAN ====== --}}
  <section id="fitur" class="mb-5 py-4" style="background:#F8FAFC; border-radius:1rem;">
    <h2 class="fw-bold mb-3 text-center" style="color:#0A3A7A;">Keunggulan</h2>
    <div class="row g-3 justify-content-center px-2 px-md-3">
      @foreach ([
        ['bi-calendar2-check','Pendaftaran Mudah','Data pasien → pilih pemeriksaan → jadwal.'],
        ['bi-cloud-arrow-up','Unggah Berkas Aman','Unggah berkas secara aman dan terstruktur.'],
        ['bi-hospital','Jaringan RS Mitra','Terhubung dengan berbagai rumah sakit.'],
        ['bi-house-door','Tunggu Hasil di Rumah','Pantau & unduh hasil dari rumah.'],
      ] as $f)
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="h-100 rounded-4 p-3 bg-white" style="border:1px solid #e9ecef;">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
               style="width:46px;height:46px;background:#E7EFFB;color:#0A3A7A;">
            <i class="bi {{ $f[0] }}"></i>
          </div>
          <div class="fw-semibold">{{ $f[1] }}</div>
          <div class="text-muted small">{{ $f[2] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  {{-- ====== CARA KERJA ====== --}}
  <section id="alur" class="mb-2">
    <h2 class="fw-bold mb-3 text-center" style="color:#0A3A7A;">Cara Kerja</h2>
    <div class="position-relative px-3 py-4 mx-auto" style="max-width:980px;border:1px solid #e9ecef;border-radius:1rem;">
      <div class="row text-center g-4 position-relative">
        @foreach ([
          ['1','Tambah Data Pasien','Tambah data pasien'],
          ['2','Daftar Pemeriksaan','Pilih jenis & jadwal'],
          ['3','Registrasi Ulang di RS','Verifikasi di RS'],
          ['4','Pemeriksaan Berlangsung','Datang sesuai jadwal'],
          ['5','Tunggu Hasil Dokter','Unduh hasil di rumah'],
        ] as $step)
          <div class="col-6 col-md">
            <div class="d-flex flex-column align-items-center">
              <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                    style="width:44px;height:44px;background:#0A3A7A;color:#fff;">
                <span class="fw-bold">{{ $step[0] }}</span>
              </span>
              <div class="mt-2 fw-semibold">{{ $step[1] }}</div>
              <div class="text-muted small">{{ $step[2] }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

</div>
@endsection
