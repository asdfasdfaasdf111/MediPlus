@extends('layout.app')

@section('title', 'Homepage Pasien')

@section('content')

  <!-- Hero Section -->
  <div class="container-fluid p-0">
    <div class="position-relative">
      <img src="{{ asset('images/HeroSection.jpg') }}" alt="Hero Background"
           class="img-fluid w-100" style="height: 70vh; object-fit: cover;">
      <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
        <div class="container px-5">
          <div class="col-md-6">
            <h2 class="display-4 fw-bold text-dark">Mudah, Cepat, dan Tanpa Antri.</h2>
            <p class="lead text-dark mb-3">
              Pilih jadwal pemeriksaan, daftar online, dan langsung datang sesuai waktu yang Anda tentukan.
            </p>
            <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-lg mt-2 text-white fw-semibold" style="background-color:#ff9900;">
              Daftar Pemeriksaan
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- === Section: Cara Kerja (3 Langkah) === -->
  <section class="py-5 bg-white">
    <div class="container text-center">
      <h2 class="fw-bold mb-5" style="color:#0A3A7A;">Tanpa Antri, Hanya 3 Langkah!</h2>

      <div class="position-relative">
        <div class="row g-5 position-relative" style="z-index:1;">
          <!-- Step 1 -->
          <div class="col-12 col-md-4">
            <div class="d-flex flex-column align-items-center text-center">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow"
                   style="width:120px; height:120px;">
                <i class="bi bi-file-earmark" style="font-size:2.5rem;"></i>
              </div>
              <h5 class="fw-bold mt-3">Pendaftaran <span class="fst-italic">Online</span></h5>
              <p class="text-muted mb-0">
                Lakukan pendaftaran secara <span class="fst-italic">online</span> dan pilih jadwal pemeriksaan yang Anda inginkan.
              </p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="col-12 col-md-4">
            <div class="d-flex flex-column align-items-center text-center">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow"
                   style="width:120px; height:120px;">
                <i class="bi bi-calendar2-check" style="font-size:2.5rem;"></i>
              </div>
              <h5 class="fw-bold mt-3">Lakukan Pemeriksaan</h5>
              <p class="text-muted mb-0">
                Datang ke rumah sakit pilihan Anda di jadwal yang telah ditentukan untuk melakukan pemeriksaan.
              </p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="col-12 col-md-4">
            <div class="d-flex flex-column align-items-center text-center">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow"
                   style="width:120px; height:120px;">
                <i class="bi bi-person-badge" style="font-size:2.5rem;"></i>
              </div>
              <h5 class="fw-bold mt-3">Unduh Hasil</h5>
              <p class="text-muted mb-0">
                Anda dapat membaca dan mengunduh hasil analisa dokter secara <span class="fst-italic">online</span>.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Section: Rumah Sakit Mitra --}}
  <section class="py-5 bg-white" id="mitra">
    <h2 class="fw-bold mb-5 text-center" style="color:#0A3A7A;">Rumah Sakit Mitra</h2>
    <div id="rsCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner px-5 px-md-5">
        @foreach ($rumahsakits->chunk(4) as $i => $chunk)
          <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <div class="row g-4">
              @foreach ($chunk as $rs)
                <div class="col-12 col-sm-6 col-lg-3">
                  <div class="card h-100 shadow-sm">
                    <div class="ratio ratio-16x9">
                      @if($rs->gambar)
                        <img src="{{ asset('storage/' . $rs->gambar) }}" class="img-fluid object-fit-cover" alt="">
                      @else
                        <img src="{{ asset('images/nophoto.png') }}" class="img-fluid object-fit-cover" alt="">
                      @endif
                    </div>

                    <div class="card-body text-center d-flex flex-column">
                      <h5 class="card-title fw-bold text-primary mb-2">RS {{ $rs->nama }}</h5>
                      <p class="card-text text-muted small mb-3">{{ $rs->alamat }}</p>
                      <div class="d-flex justify-content-center flex-wrap gap-2">
                        {{-- <span class="badge bg-light text-primary border"> --}}
                          {{-- <i class="bi bi-clock me-1"></i> --}}
                          {{-- {{ \Carbon\Carbon::createFromFormat('H:i:s', (string)$rs->jamBuka)->format('H:i') }}
                          –
                          {{ \Carbon\Carbon::createFromFormat('H:i:s', (string)$rs->jamTutup)->format('H:i') }} --}}
                        {{-- </span> --}}
                        <span class="badge bg-light text-secondary border">
                          <i class="bi bi-telephone me-1"></i>{{ $rs->noTelepon }}
                        </span>
                      </div>
                    </div>

                    <div class="card-footer bg-white border-0 text-center">
                      <a href="{{ route('pasien.pendaftaran', ['rs' => $rs->id]) }}" class="btn btn-outline-primary w-100">
                        Daftar Pemeriksaan
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>

      <div class="position-absolute top-50 start-0 translate-middle-y ms-1">
        <button class="btn btn-light rounded-circle" data-bs-target="#rsCarousel" data-bs-slide="prev">
          <i class="bi bi-chevron-left"></i>
        </button>
      </div>

      <div class="position-absolute top-50 end-0 translate-middle-y me-1">
        <button class="btn btn-light rounded-circle" data-bs-target="#rsCarousel" data-bs-slide="next">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </section>

@endsection
