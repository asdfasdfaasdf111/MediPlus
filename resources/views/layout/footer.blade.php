<footer class="bg-white text-dark pt-5 mt-5 border-top">
  <div class="container">
    <div class="row gy-4">

      {{-- Brand & Kontak --}}
      <div class="col-12 col-md-3 border-end">
        <div class="mb-3 d-flex align-items-center">
          <img src="{{ asset('images/Mediplus.png') }}" alt="Mediplus Logo" height="40" class="me-2">
        </div>
        <p class="small text-muted">Mudah, Cepat, dan Tanpa Antri.</p>

        <p class="mb-1"><i class="bi bi-telephone me-2"></i>(+62)812-3456-7890</p>
        <p class="mb-3"><i class="bi bi-envelope me-2"></i>Mediplus987@gmail.com</p>

        <div class="d-flex gap-3">
          <a href="#" class="text-dark fs-5"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-dark fs-5"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-dark fs-5"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="text-dark fs-5"><i class="bi bi-telegram"></i></a>
        </div>
      </div>

      {{-- Menu --}}
      <div class="col-6 col-md-3 border-end">
        <h6 class="fw-bold mb-3" style="color:#0A3A7A;">Menu</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="bi bi-caret-right-fill me-1 text-primary"></i><a href="{{ url('/pasien/homepage') }}" class="text-dark text-decoration-none">Beranda</a></li>
          <li class="mb-2"><i class="bi bi-caret-right-fill me-1 text-primary"></i><a href="{{ url('/pasien/tentang') }}" class="text-dark text-decoration-none">Tentang Kami</a></li>
          <li class="mb-2"><i class="bi bi-caret-right-fill me-1 text-primary"></i><a href="{{ url('/pasien/pemeriksaan') }}" class="text-dark text-decoration-none">Pemeriksaan</a></li>
          <li class="mb-2"><i class="bi bi-caret-right-fill me-1 text-primary"></i><a href="{{ url('/pasien/faq') }}" class="text-dark text-decoration-none">FAQ</a></li>
        </ul>
      </div>

        {{-- RS Mitra --}}
    <div class="col-6 col-md-3 border-end">
    <h6 class="fw-bold mb-3" style="color:#0A3A7A;">RS Mitra</h6>
    <div class="overflow-auto" style="max-height: 120px;">
        <ul class="list-unstyled mb-0">
        @forelse(($rumahsakits ?? collect()) as $rs)
            <li class="mb-2">
            <i class="bi bi-hospital me-1 text-primary"></i> RS {{ $rs->nama }}
            </li>
        @empty
            <li class="text-muted small">Belum ada data rumah sakit.</li>
        @endforelse
        </ul>
    </div>
    </div>


      {{-- Kritik & Saran --}}
      <div class="col-12 col-md-3">
        <h6 class="fw-bold mb-3" style="color:#0A3A7A;">Kritik & Saran</h6>
        <form action="{{ route('kritik.saran') }}" method="POST" class="needs-validation" novalidate>
          @csrf
          <div class="mb-2">
            <input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama Anda" required>
          </div>
          <div class="mb-2">
            <input type="email" name="email" class="form-control form-control-sm" placeholder="Email Anda" required>
          </div>
          <div class="mb-2">
            <textarea name="pesan" rows="3" class="form-control form-control-sm" placeholder="Tulis pesan..." required></textarea>
          </div>
          <button type="submit" class="btn btn-sm w-100 text-white" style="background-color:#0A3A7A;">Kirim</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Copyright strip navy --}}
  <div class="text-center py-3 mt-4 text-white" style="background-color:#0A3A7A;">
    <p class="small mb-0">© Copyright 2025 | All Rights Reserved</p>
  </div>
</footer>
