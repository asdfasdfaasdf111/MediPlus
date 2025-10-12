@extends('layout.app')
@section('title', 'FAQ Pemeriksaan Radiologi')

@section('content')
<div class="container py-4">

  {{-- Header --}}
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h2 class="fw-bold mb-1 text-primary">FAQ Pemeriksaan Radiologi</h2>
      <p class="text-muted mb-0">Pertanyaan umum sebelum, saat, dan setelah pemeriksaan.</p>
    </div>
    <a href="{{ route('pasien.homepage') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
  </div>

  {{-- Search + actions (tanpa card) --}}
  <div class="d-flex flex-column flex-lg-row align-items-lg-end gap-2 mb-4">
    <div class="flex-grow-1">
      <label for="faqSearch" class="form-label mb-1">Cari pertanyaan</label>
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input id="faqSearch" type="text" class="form-control" placeholder="Ketik kata kunci: kontras, puasa, hamil, MRI...">
      </div>
      <div class="form-text">Filter berlaku pada judul &amp; jawaban.</div>
    </div>
  </div>

  {{-- FAQ list --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-3 p-md-4">
      <div class="accordion" id="faqAcc">

        {{-- 1 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c1">
              <span class="fw-semibold">1) Bagaimana cara mendaftar pemeriksaan radiologi melalui website?</span>
            </button>
          </div>
          <div id="c1" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Pilih <strong>jenis pemeriksaan</strong>, <strong>lokasi/rumah sakit</strong>, <strong>tanggal &amp; rentang waktu</strong>,
              isi <strong>data diri</strong> dan <strong>informasi klinis</strong> (alergi, kehamilan/menyusui, implan), unggah
              <strong>surat rujukan</strong> bila diminta, lalu konfirmasi. Bukti pendaftaran dikirim ke email/portal pasien.
            </div>
          </div>
        </div>

        {{-- 2 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c2">
              <span class="fw-semibold">2) Dokumen atau informasi apa yang perlu saya siapkan saat mendaftar?</span>
            </button>
          </div>
        <div id="c2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              <strong>Kartu identitas</strong>, <strong>surat rujukan</strong> (bila ada), daftar <strong>obat &amp; alergi</strong>,
              riwayat reaksi <strong>bahan kontras</strong>, kondisi khusus (mis. <strong>hamil/menyusui</strong>), dan info
              <strong>implan/perangkat logam</strong>.
            </div>
          </div>
        </div>

        {{-- 3 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c3">
              <span class="fw-semibold">3) Apakah ada persiapan khusus (misalnya puasa atau aturan pakaian)?</span>
            </button>
          </div>
          <div id="c3" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              <strong>Bergantung jenis pemeriksaan.</strong> CT/CT-kontras sering memerlukan <strong>puasa beberapa jam</strong>.
              MRI biasanya melepas <strong>benda/logam</strong> (perhiasan, pakaian ber-zip) dan menghindari riasan tertentu.
            </div>
          </div>
        </div>

        {{-- 4 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c4">
              <span class="fw-semibold">4) Saya memiliki alat/implan logam. Apakah aman menjalani MRI?</span>
            </button>
          </div>
          <div id="c4" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Banyak implan modern bersifat <em>MRI-conditional</em> sehingga dapat dipindai dengan protokol khusus.
              Cantumkan <strong>detail perangkat</strong> saat pendaftaran untuk dinilai keamanannya.
            </div>
          </div>
        </div>

        {{-- 5 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c5">
              <span class="fw-semibold">5) Saya sedang hamil atau menyusui. Apakah aman menjalani pemeriksaan?</span>
            </button>
          </div>
          <div id="c5" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Pada kehamilan, <strong>USG</strong> dan <strong>MRI tanpa kontras</strong> biasanya menjadi pilihan; X-ray/CT dipertimbangkan bila
              <strong>manfaat klinis jelas</strong>. Saat menyusui, keputusan penggunaan kontras mengikuti pedoman klinis dokter.
            </div>
          </div>
        </div>

        {{-- 6 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c6">
              <span class="fw-semibold">6) Apakah saya akan mendapatkan bahan kontras? Untuk apa, dan apa risikonya?</span>
            </button>
          </div>
          <div id="c6" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Kontras membantu <strong>memperjelas struktur</strong> agar diagnosis lebih akurat. Efek umum biasanya sementara
              (mis. rasa hangat, mual ringan). Reaksi alergi <strong>jarang</strong>. Keputusan pemakaian berdasarkan <strong>manfaat–risiko</strong>.
            </div>
          </div>
        </div>

        {{-- 7 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c7">
              <span class="fw-semibold">7) Saya punya riwayat alergi/asma atau pernah bereaksi terhadap kontras. Apa yang harus saya lakukan?</span>
            </button>
          </div>
          <div id="c7" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Cantumkan semua riwayat alergi/asma/reaksi kontras saat mendaftar. Dokter dapat mempertimbangkan <strong>premedikasi</strong>
              atau <strong>alternatif</strong> sesuai kebutuhan.
            </div>
          </div>
        </div>

        {{-- 8 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c8">
              <span class="fw-semibold">8) Saya memiliki gangguan ginjal/diabetes. Apakah aman mendapatkan kontras?</span>
            </button>
          </div>
          <div id="c8" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Penggunaan kontras—terutama iodinated—mempertimbangkan <strong>fungsi ginjal (eGFR)</strong> dan kebutuhan klinis,
              mengikuti pedoman yang berlaku.
            </div>
          </div>
        </div>

        {{-- 9 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c9">
              <span class="fw-semibold">9) Berapa lama proses pemeriksaan dan apa yang akan saya rasakan?</span>
            </button>
          </div>
          <div id="c9" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              <strong>CT</strong> umumnya beberapa menit (lebih lama bila perlu minum/infus kontras).
              <strong>MRI</strong> rata-rata 15–45 menit; mesin bising dan Anda perlu berbaring diam. Staf memantau &amp; berkomunikasi selama prosedur.
            </div>
          </div>
        </div>

        {{-- 10 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-2">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c10">
              <span class="fw-semibold">10) Kapan dan bagaimana saya menerima hasilnya (laporan &amp; gambar)?</span>
            </button>
          </div>
          <div id="c10" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Radiolog menyusun <strong>laporan</strong>. Pada sistem ini, <strong>dokter mengunggah laporan</strong> ke
              <strong>website radiologi</strong> dan pasien dapat <strong>membuka/mengunduh</strong> laporan serta citra sesuai kebijakan fasilitas.
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

{{-- JS: toggle warna judul + filter + expand/collapse --}}
<script>
  (function () {
    const acc         = document.getElementById('faqAcc');
    const items       = acc.querySelectorAll('.accordion-item');
    const search      = document.getElementById('faqSearch');
    const btnExpand   = document.getElementById('btnExpandAll');
    const btnCollapse = document.getElementById('btnCollapseAll');

    // Bar judul: ganti warna & teks saat show/hide
    items.forEach(item => {
      const title    = item.querySelector('.faq-title');
      const button   = item.querySelector('.faq-title .accordion-button');
      const chevron  = item.querySelector('.faq-title i');
      const collapse = item.querySelector('.accordion-collapse');

      collapse.addEventListener('show.bs.ccollapse', () => {}); // placeholder to avoid typo
    });

    // Correct listeners (the line above is only to avoid accidental typo in some editors)
    items.forEach(item => {
      const title    = item.querySelector('.faq-title');
      const button   = item.querySelector('.faq-title .accordion-button');
      const chevron  = item.querySelector('.faq-title i');
      const collapse = item.querySelector('.accordion-collapse');

      collapse.addEventListener('show.bs.collapse', () => {
        title.style.backgroundColor = '#0A3A7A';
        title.classList.add('text-white');
        button.classList.add('text-white');
        chevron?.classList.add('text-white');
      });

      collapse.addEventListener('hide.bs.collapse', () => {
        title.style.backgroundColor = '';
        title.classList.remove('text-white');
        button.classList.remove('text-white');
        chevron?.classList.remove('text-white');
      });
    });

    // Filter sederhana
    const norm = s => (s || '').toLowerCase().trim();
    search?.addEventListener('input', () => {
      const v = norm(search.value);
      items.forEach(item => {
        const text = norm(item.textContent);
        item.style.display = text.includes(v) ? '' : 'none';
      });
    });

    // Expand / Collapse semua
    btnExpand?.addEventListener('click', e => {
      e.preventDefault();
      items.forEach(item => {
        const c = item.querySelector('.accordion-collapse');
        if (!c.classList.contains('show')) new bootstrap.Collapse(c, { toggle: true });
      });
    });

    btnCollapse?.addEventListener('click', e => {
      e.preventDefault();
      items.forEach(item => {
        const c = item.querySelector('.accordion-collapse');
        if (c.classList.contains('show')) new bootstrap.Collapse(c, { toggle: true });
      });
    });
  })();
</script>
@endsection
