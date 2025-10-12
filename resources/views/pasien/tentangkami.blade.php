@extends('layout.app')

@section('content')
<div class="container py-4 py-md-5">

  {{-- SUBNAV (anchor ke tiap section) --}}
  <div class="d-flex flex-wrap gap-2 justify-content-start align-items-center mb-4">
    <a href="#visi" class="btn btn-outline-primary btn-sm"><i class="bi bi-bullseye me-1"></i> Visi</a>
    <a href="#misi" class="btn btn-outline-primary btn-sm"><i class="bi bi-flag me-1"></i> Misi</a>
    <a href="#fitur" class="btn btn-outline-primary btn-sm"><i class="bi bi-stars me-1"></i> Keunggulan</a>
    <a href="#angka" class="btn btn-outline-primary btn-sm"><i class="bi bi-123 me-1"></i> Angka</a>
    <a href="#alur" class="btn btn-outline-primary btn-sm"><i class="bi bi-diagram-3 me-1"></i> Cara Kerja</a>
    <a href="#nilai" class="btn btn-outline-primary btn-sm"><i class="bi bi-heart-pulse me-1"></i> Nilai</a>
    <a href="#tim" class="btn btn-outline-primary btn-sm"><i class="bi bi-people me-1"></i> Tim</a>
  </div>

  {{-- ====== VISI (HERO MINI, CENTER) ====== --}}
  <section id="visi" class="mb-5">
    <div class="bg-body-tertiary rounded-4 p-4 p-md-5 shadow-sm">
      <div class="row g-4 align-items-center">
        <div class="col-lg-7">
          <div class="d-flex align-items-center mb-2">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary me-2" style="width:44px;height:44px">
              <i class="bi bi-bullseye"></i>
            </span>
            <h2 class="fw-bold mb-0 text-primary">Visi</h2>
          </div>
          <p class="text-muted mb-0">
            Menjadi gerbang layanan radiologi yang <span class="fw-semibold">mudah diakses</span>,
            <span class="fw-semibold">transparan</span>, dan <span class="fw-semibold">andal</span> bagi semua pihak.
          </p>
        </div>
        
      </div>
    </div>
  </section>

  {{-- ====== MISI (ACCORDION + ILLUSTRATION) ====== --}}
  <section id="misi" class="mb-5">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6 order-lg-1 order-2">
        <div class="accordion shadow-sm rounded-4" id="misiAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="misi1">
              <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#misi1c" aria-expanded="true" aria-controls="misi1c">
                <i class="bi bi-caret-right-fill me-2"></i> Menyederhanakan alur pendaftaran
              </button>
            </h2>
            <div id="misi1c" class="accordion-collapse collapse show" aria-labelledby="misi1" data-bs-parent="#misiAccordion">
              <div class="accordion-body text-muted">
                Pendaftaran pemeriksaan radiologi yang ringkas dan terarah dari awal sampai akhir.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="misi2">
              <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#misi2c" aria-expanded="false" aria-controls="misi2c">
                <i class="bi bi-caret-right-fill me-2"></i> Menghubungkan pihak terkait
              </button>
            </h2>
            <div id="misi2c" class="accordion-collapse collapse" aria-labelledby="misi2" data-bs-parent="#misiAccordion">
              <div class="accordion-body text-muted">
                Pasien, dokter, dan RS terhubung <em>real-time</em> untuk keputusan yang lebih cepat.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="misi3">
              <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#misi3c" aria-expanded="false" aria-controls="misi3c">
                <i class="bi bi-caret-right-fill me-2"></i> Keamanan & privasi data
              </button>
            </h2>
            <div id="misi3c" class="accordion-collapse collapse" aria-labelledby="misi3" data-bs-parent="#misiAccordion">
              <div class="accordion-body text-muted">
                Kontrol akses berbasis role dengan audit trail yang jelas.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 order-lg-2 order-1">
        <div class="bg-light rounded-4 p-4 h-100 d-flex align-items-center justify-content-center">
          <img src="{{ asset('images/about/misi.png') }}" class="img-fluid rounded-3 shadow-sm" alt="Misi MediPlus">
        </div>
      </div>
    </div>
  </section>

  {{-- ====== KEUNGGULAN (MASONRY-LIKE GRID) ====== --}}
  <section id="fitur" class="mb-5">
    <div class="text-center mb-4">
      <span class="badge text-bg-primary rounded-pill px-3 py-2"><i class="bi bi-stars me-1"></i> Keunggulan</span>
    </div>
    <div class="row g-3">
      @php
        $features = [
          ['bi-calendar2-check','Pendaftaran Mudah','Data pasien → pilih pemeriksaan → jadwal dalam beberapa klik.'],
          ['bi-hospital','Integrasi Multi-RS','Terhubung dengan berbagai rumah sakit & modalitas.'],
          ['bi-bell','Status & Notifikasi','Pantau REG, jadwal, dan pengingat kedatangan.'],
          ['bi-shield-lock','Keamanan Data','Role-based access & audit trail.'],
          ['bi-cloud-arrow-up','Lampiran & Rujukan','Unggah berkas secara aman dan terstruktur.'],
          ['bi-graph-up','Monitoring & Insight','Laporan ringkas untuk pengambilan keputusan.'],
        ];
      @endphp
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-stars display-6 text-primary me-2"></i>
              <h3 class="h5 fw-bold mb-0">Mengapa MediPlus?</h3>
            </div>
            <p class="text-muted mb-0">Kombinasi kemudahan, integrasi, dan keamanan untuk pengalaman pendaftaran radiologi yang nyaman.</p>
          </div>
          <div class="ratio ratio-16x9">
            <img src="{{ asset('images/about/fitur.png') }}" class="w-100 h-100 object-fit-cover rounded-bottom-2" alt="Keunggulan">
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="row g-3">
          @foreach ($features as $f)
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex">
                  <span class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary me-3" style="width:44px;height:44px">
                    <i class="bi {{ $f[0] }}"></i>
                  </span>
                  <div>
                    <div class="fw-semibold">{{ $f[1] }}</div>
                    <div class="text-muted small">{{ $f[2] }}</div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- ====== ANGKA (STATS STRIP) ====== --}}
  <section id="angka" class="mb-5">
    <div class="bg-body-tertiary rounded-4 p-4 p-md-5 shadow-sm">
      <div class="text-center mb-4">
        <h2 class="fw-bold text-primary mb-1"><i class="bi bi-123 me-2"></i>Angka Singkat</h2>
        <p class="text-muted mb-0">Dampak yang mulai terlihat dari penggunaan MediPlus.</p>
      </div>
      <div class="row g-3">
        @foreach ([
          ['bi-hospital','12+','Rumah Sakit'],
          ['bi-cpu','20+','Modalitas'],
          ['bi-stopwatch','< 3 mnt','Rata-rata Daftar'],
          ['bi-emoji-smile','98%','Kepuasan'],
        ] as $s)
        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm h-100 text-center">
            <div class="card-body">
              <div class="mb-1"><i class="bi {{ $s[0] }}"></i></div>
              <div class="fw-bold fs-5">{!! $s[1] !!}</div>
              <div class="text-muted small">{{ $s[2] }}</div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ====== CARA KERJA (STEPPER HORIZONTAL) ====== --}}
  <section id="alur" class="mb-5">
    <div class="text-center mb-4">
      <h2 class="fw-bold text-primary"><i class="bi bi-diagram-3 me-2"></i>Cara Kerja</h2>
      <p class="text-muted mb-0">Empat langkah ringkas dari registrasi hingga pemantauan.</p>
    </div>

    <div class="row g-4 align-items-center">
      <div class="col-lg-7">
        <div class="row row-cols-1 row-cols-md-2 g-3">
          @foreach ([
            ['1','Buat Data Pasien','Profil sekali, pakai ulang.'],
            ['2','Pilih RS & Jadwal','Tentukan jenis pemeriksaan & waktu.'],
            ['3','Unggah Lampiran','Surat rujukan/dokumen bila perlu.'],
            ['4','Konfirmasi & Lacak','Dapat REG, pantau status real-time.'],
          ] as $i => $step)
          <div class="col">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                  <span class="badge text-bg-primary rounded-pill me-2">{{ $step[0] }}</span>
                  <div class="fw-semibold">{{ $step[1] }}</div>
                </div>
                <div class="text-muted small">{{ $step[2] }}</div>
              </div>
              <div class="progress rounded-0" role="progressbar" aria-label="progress" aria-valuenow="{{ ($i+1)*25 }}" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: {{ ($i+1)*25 }}%"></div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-lg-5">
        <div class="bg-light rounded-4 p-4 text-center h-100 d-flex align-items-center justify-content-center">
          <img src="{{ asset('images/about/alur.png') }}" class="img-fluid rounded-3 shadow-sm" alt="Cara Kerja">
        </div>
      </div>
    </div>
  </section>

  {{-- ====== NILAI (LIST GROUP ICONIC) ====== --}}
  <section id="nilai" class="mb-5">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <div class="bg-body-tertiary rounded-4 p-4 h-100 shadow-sm">
          <h2 class="fw-bold text-primary mb-3"><i class="bi bi-heart-pulse me-2"></i>Nilai yang Kami Pegang</h2>
          <ul class="list-group list-group-flush">
            @foreach ([
              ['bi-shield-check','Aman','Privasi & keamanan data.'],
              ['bi-lightning-charge','Cepat','Alur sederhana & minim langkah.'],
              ['bi-badge-ad','Akurat','Data rujukan & jadwal rapi.'],
              ['bi-people','Kolaboratif','Pasien, dokter, dan admin RS.'],
            ] as $v)
            <li class="list-group-item d-flex">
              <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary me-3" style="width:40px;height:40px">
                <i class="bi {{ $v[0] }}"></i>
              </span>
              <div>
                <div class="fw-semibold">{{ $v[1] }}</div>
                <div class="text-muted small">{{ $v[2] }}</div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <img src="{{ asset('images/about/nilai.png') }}" class="img-fluid rounded-4 shadow-sm" alt="Nilai">
      </div>
    </div>
  </section>

  {{-- ====== TIM (CARDS + AVATAR PLACEHOLDER) ====== --}}
  <section id="tim" class="mb-2">
    <div class="text-center mb-4">
      <h2 class="fw-bold text-primary"><i class="bi bi-people me-2"></i>Tim MediPlus</h2>
      <p class="text-muted mb-0">Kolaborasi lintas peran untuk pelayanan terbaik.</p>
    </div>
    <div class="row g-3 align-items-stretch">
      @foreach ([
        ['Admin RS','Operasional Rumah Sakit','bi-hospital','images/about/tim-admin.png'],
        ['Dokter Perujuk','Klinisi','bi-person-vcard','images/about/tim-dokter.png'],
        ['Tim Pengembang','Produk & Teknologi','bi-cpu','images/about/tim-dev.png'],
      ] as $t)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary me-3" style="width:44px;height:44px">
              <i class="bi {{ $t[2] }}"></i>
            </span>
            <div class="flex-grow-1">
              <div class="fw-semibold">{{ $t[0] }}</div>
              <div class="text-muted small mb-2">{{ $t[1] }}</div>
              <div class="ratio ratio-21x9 rounded-3 overflow-hidden">
                <img src="{{ asset($t[3]) }}" class="w-100 h-100 object-fit-cover" alt="{{ $t[0] }}">
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

</div>
@endsection
