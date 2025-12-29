@extends('layout.app')

@section('title', 'Homepage Pasien')

@section('content')

  {{-- HERO SECTION --}}
  <div class="container-fluid p-0">
    <div class="position-relative">
      {{-- Bikin buat mobile, masih trial and error sih -> custom cssnya aku taroh di public/css/custom --}}
      <img src="{{ asset('images/HeroSection.jpg') }}" alt="Hero Background" class="img-fluid w-100 hero-img">
      <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
        <div class="container px-4 px-md-5">
          <div class="col-12 col-md-6 text-center text-md-start">
            <h2 class="display-6 fw-bold text-dark">Mudah, Cepat, dan Tanpa Antri.</h2>
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

{{-- STEP TANPA ANTRI --}}
  <section class="py-5 bg-white">
    <div class="container text-center">
      <h2 class="fw-bold mb-5" style="color:#0A3A7A;">Tanpa Antri, Hanya 3 Langkah!</h2>

      <div class="position-relative">
        <div class="row g-5 position-relative" style="z-index:1;">
          <!-- Step 1 -->
          <div class="col-12 col-md-4 step-item">
            <div class="d-flex flex-column align-items-center text-center">
              <div class="step-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow">
                <i class="bi bi-file-earmark"></i>
              </div>
              <h5 class="fw-bold mt-3">Pendaftaran <span class="fst-italic">Online</span></h5>
              <p class="text-muted mb-0">
                Lakukan pendaftaran secara 
                <span class="fst-italic">online</span> 
                dan pilih jadwal pemeriksaan yang Anda inginkan.
              </p>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="col-12 col-md-4 step-item">
            <div class="d-flex flex-column align-items-center text-center">
              <div class="step-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow">
                <i class="bi bi-calendar2-check"></i>
              </div>
              <h5 class="fw-bold mt-3">Lakukan Pemeriksaan</h5>
              <p class="text-muted mb-0">
                Datang ke rumah sakit pilihan Anda di jadwal yang telah ditentukan untuk melakukan pemeriksaan.
              </p>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="col-12 col-md-4 step-item">
            <div class="d-flex flex-column align-items-center text-center">
              <div class="step-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow">
                <i class="bi bi-person-badge"></i>
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

{{-- RUMAH SAKIT MITRA --}}
<section class="py-5 bg-white" id="mitra">
    <div class="container-fluid px-md-5"> {{-- Menggunakan container-fluid agar lebih lebar di desktop --}}
        <h2 class="fw-bold mb-5 text-center" style="color:#0A3A7A;">
            Rumah Sakit Mitra
        </h2>

        {{-- Carousel Desktop --}}
        <div id="rsCarouselDesktop" class="carousel slide d-none d-md-block" data-bs-ride="false" data-bs-wrap="false">
            <div class="carousel-inner px-md-5">
                @foreach ($rumahsakits->chunk(4) as $i => $chunk)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        {{-- Hapus justify-content-center agar kartu mulai dari kiri --}}
                        <div class="row g-4"> 
                            @foreach ($chunk as $rs)
                                <div class="col-md-3"> {{-- col-md-3 memastikan 4 kartu per baris --}}
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="ratio ratio-16x9">
                                            <img src="{{ $rs->foto ? asset('storage/' . $rs->foto) : asset('images/nophoto.png') }}"
                                                 class="img-fluid object-fit-cover rounded-top" alt="Foto {{ $rs->nama }}">
                                        </div>
                                        <div class="card-body text-center d-flex flex-column">
                                            <h5 class="fw-bold text-primary mb-2">RS {{ $rs->nama }}</h5>
                                            <p class="text-muted small mb-3">{{ Str::limit($rs->alamat, 60) }}</p>
                                            <div class="mt-auto">
                                                <a href="{{ route('pasien.pendaftaran', ['rs' => $rs->id]) }}" 
                                                   class="btn btn-outline-primary w-100 fw-bold">
                                                    Daftar Pemeriksaan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Navigasi Desktop --}}
            <button class="carousel-control-prev custom-nav-btn" type="button" data-bs-target="#rsCarouselDesktop" data-bs-slide="prev">
                <span class="nav-icon-wrapper"><i class="bi bi-chevron-left"></i></span>
            </button>
            <button class="carousel-control-next custom-nav-btn" type="button" data-bs-target="#rsCarouselDesktop" data-bs-slide="next">
                <span class="nav-icon-wrapper"><i class="bi bi-chevron-right"></i></span>
            </button>
        </div>

        {{-- Carousel Mobile --}}
        <div id="rsCarouselMobile" class="carousel slide d-block d-md-none" data-bs-ride="false" data-bs-wrap="false">
            <div class="carousel-inner">
                @foreach ($rumahsakits as $i => $rs)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        <div class="px-4"> {{-- Memberi ruang agar card tidak mentok layar hp --}}
                            <div class="card shadow-sm border-0">
                                <div class="ratio ratio-16x9">
                                    <img src="{{ $rs->foto ? asset('storage/' . $rs->foto) : asset('images/nophoto.png') }}"
                                         class="img-fluid object-fit-cover rounded-top" alt="Foto {{ $rs->nama }}">
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="fw-bold text-primary mb-2">RS {{ $rs->nama }}</h5>
                                    <p class="text-muted small">{{ $rs->alamat }}</p>
                                    <a href="{{ route('pasien.pendaftaran', ['rs' => $rs->id]) }}" 
                                       class="btn btn-outline-primary w-100 fw-bold">
                                        Daftar Pemeriksaan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev custom-nav-btn" type="button" data-bs-target="#rsCarouselMobile" data-bs-slide="prev">
                <span class="nav-icon-wrapper"><i class="bi bi-chevron-left"></i></span>
            </button>
            <button class="carousel-control-next custom-nav-btn" type="button" data-bs-target="#rsCarouselMobile" data-bs-slide="next">
                <span class="nav-icon-wrapper"><i class="bi bi-chevron-right"></i></span>
            </button>
        </div>
    </div>
</section>

<style>

/* Ini buat button carouselnya */
    .custom-nav-btn {
        width: 50px;
    }
    .nav-icon-wrapper {
        background: white;
        color: #0A3A7A;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .nav-icon-wrapper:hover {
        background: #0A3A7A;
        color: white;
    }

    /* Ini biar ga nutupin kartu */
    .carousel-control-prev.custom-nav-btn { left: 0; }
    .carousel-control-next.custom-nav-btn { right: 0; }

  /* Ini kalau udah card 6 biji, di next slide carouselnya hilang*/
    .nav-disabled {
        display: none !important;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousels = document.querySelectorAll('.carousel');

        carousels.forEach(carousel => {
            const prevBtn = carousel.querySelector('.carousel-control-prev');
            const nextBtn = carousel.querySelector('.carousel-control-next');
            
            function updateNav() {
                const activeItem = carousel.querySelector('.carousel-item.active');
                if (!activeItem) return;

                const isFirst = !activeItem.previousElementSibling;
                const isLast = !activeItem.nextElementSibling;

                if (prevBtn) prevBtn.classList.toggle('nav-disabled', isFirst);
                if (nextBtn) nextBtn.classList.toggle('nav-disabled', isLast);
            }

            carousel.addEventListener('slid.bs.carousel', updateNav);
            updateNav();
        });
    });
</script>

@endsection
