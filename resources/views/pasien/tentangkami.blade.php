@extends('layout.app')

@section('title', 'Tentang Kami - MediPlus')

@section('content')

<div class="container py-4 py-md-5">
  {{-- SECTION VISI --}}
  <section id="visi" class="mb-5">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <h2 class="fw-bold mb-3" style="color:#0A3A7A;">Visi</h2>
        <p class="text-muted mb-2" style="text-align: justify">
          Menjadi gerbang layanan radiologi yang
          <span class="fw-semibold">mudah diakses</span>,
          <span class="fw-semibold">transparan</span>, dan
          <span class="fw-semibold">andal</span> bagi pasien, petugas, dan rumah sakit.
        </p>
        <p class="text-muted mb-0" style="text-align: justify">
          MediPlus dikembangkan sebagai sistem antrian dan pendaftaran radiologi berbasis web
          yang membantu mengurangi penumpukan di lokasi dan mempermudah pemantauan proses pemeriksaan.
        </p>
      </div>
      <div class="col-lg-6">
        <div class="ratio ratio-16x9 rounded-4 overflow-hidden border">
          <img src="{{ asset('images/misi.jpg') }}"
               class="w-100 h-100 object-fit-cover"
               alt="Ilustrasi layanan radiologi MediPlus">
        </div>
      </div>
    </div>
  </section>

  {{-- SECTION MISI --}}
<section id="misi" class="mb-5">
  <div class="row g-4 align-items-center">

    {{-- Sebelah Kiri --}}
    <div class="col-lg-7 order-lg-1 order-2">
      <div class="bg-white border ">
        <ul class="list-group list-group-flush">
          @foreach ([
            ['bi-stopwatch', 'Mempermudah pasien mendaftar pemeriksaan radiologi tanpa perlu menunggu berjam-jam di rumah sakit.'],
            ['bi-diagram-3', 'Menjadi penghubung antara pasien, petugas, dan rumah sakit melalui satu sistem yang terintegrasi.'],
            ['bi-file-earmark-medical', 'Menyediakan akses hasil radiologi secara lebih terstruktur dan mudah ditemukan kembali.'],
          ] as $m)
            <li class="list-group-item py-3">
              <div class="d-flex align-items-center">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle me-3 flex-shrink-0"
                      style="width:40px;height:40px;background:#E7EFFB;color:#0A3A7A;">
                  <i class="bi {{ $m[0] }}"></i>
                </span>
                <span class="text-muted">{{ $m[1] }}</span>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    {{-- SECTION KANAN --}}
    <div class="col-lg-5 order-lg-2 order-1">
      <div class="bg-light rounded-4 p-4 border h-100"
           style="border-left:4px solid #0A3A7A;">
        <h2 class="fw-bold mb-2" style="color:#0A3A7A;">Misi</h2>
        <p class="text-muted mb-0" style="text-align: justify; text-justify: inter-word;">
          Menghadirkan alur pendaftaran dan antrian radiologi yang lebih tertata,
          sehingga tenaga kesehatan dapat fokus pada pelayanan medis,
          dan pasien merasa lebih terbantu selama proses pemeriksaan.
        </p>
      </div>
    </div>

  </div>
</section>


  {{-- Keunggulan --}}
  <section id="fitur" class="mb-5">
    <div class="p-4 p-md-5 rounded-4"
         style="background:#F8FAFC;border:1px solid #e9ecef;">
      <h2 class="fw-bold mb-3 text-center" style="color:#0A3A7A;">Keunggulan MediPlus</h2>
      <p class="text-muted text-center mb-4 small">
        Fitur-fitur berikut dirancang untuk mendukung proses pendaftaran dan antrian radiologi di rumah sakit mitra.
      </p>

      <div class="row g-3 justify-content-center">
        @foreach ([
          ['bi-calendar2-check', 'Pendaftaran Terstruktur', 'Data pasien diinput, lalu memilih jenis pemeriksaan dan jadwal yang tersedia.'],
          ['bi-cloud-arrow-up', 'Unggah Berkas Pemeriksaan', 'Pasien dapat mengunggah berkas pendukung dengan aman sesuai kebutuhan rumah sakit.'],
          ['bi-hospital', 'Jaringan Rumah Sakit Mitra', 'Sistem dapat dikembangkan untuk terhubung dengan beberapa rumah sakit mitra.'],
          ['bi-house-door', 'Pantau Hasil dari Rumah', 'Pasien dapat memantau status dan mengunduh hasil pemeriksaan secara online.'],
        ] as $f)
          <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                     style="width:46px;height:46px;background:#E7EFFB;color:#0A3A7A;">
                  <i class="bi {{ $f[0] }}"></i>
                </div>
                {{-- Judul Fitur --}}
                <h6 class="fw-semibold mb-1">{{ $f[1] }}</h6>
                {{-- Deskripsi Fitur --}}
                <p class="text-muted small mb-0">{{ $f[2] }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Cara kerjanya --}}
 <section id="alur" class="mb-3">
  <h2 class="fw-bold mb-3 text-center" style="color:#0A3A7A;">Cara Kerja MediPlus</h2>
 
  <div class="mx-auto p-4 p-md-4 position-relative"
       style="max-width:1200px;border:1px solid #e9ecef;border-radius:1rem;">
    <div class="row text-center g-5">
      @foreach ([
        ['1', 'Tambah Data Pasien', 'Petugas atau pasien menambahkan data pasien melalui halaman "Pemeriksaan".'],
        ['2', 'Daftar Pemeriksaan', 'Memilih jenis pemeriksaan serta jadwal yang diinginkan pada sistem.'],
        ['3', 'Registrasi Ulang di RS', 'Pasien melakukan registrasi ulang dan verifikasi data di rumah sakit.'],
        ['4', 'Pemeriksaan di Rumah Sakit', 'Pasien menjalani pemeriksaan radiologi sesuai jadwal yang telah ditentukan.'],
        ['5', 'Menunggu Hasil Dokter', 'Hasil pemeriksaan disusun dan diverifikasi dokter, lalu dapat diakses melalui sistem.'],
      ] as $step)
        <div class="col-6 col-md">
          <div class="d-flex flex-column align-items-center h-100">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                  style="width:44px;height:44px;background:#0A3A7A;color:#fff;">
              <span class="fw-bold">{{ $step[0] }}</span>
            </span>
            <div class="fw-semibold small">{{ $step[1] }}</div>
            <div class="text-muted small">{{ $step[2] }}</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>


</div>
@endsection
