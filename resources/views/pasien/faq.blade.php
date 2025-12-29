@extends('layout.app')

@section('title', 'FAQ Pemeriksaan Radiologi')

@section('content')
<div class="container py-4">

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h2 class="fw-bold mb-1" style="color:#0A3A7A;" >FAQ Pemeriksaan Radiologi</h2>
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
              Pendaftaran pemeriksaan diawali dengan menambahkan <strong>data diri pasien</strong>.
              Selanjutnya, lakukan <strong>pendaftaran pemeriksaan</strong> dengan memilih
              <strong>rumah sakit mitra</strong>, <strong>jenis pemeriksaan</strong>, serta
              <strong>jadwal pemeriksaan</strong>.
              Setelah itu, lengkapi <strong>data rujukan dokter</strong>,
              kemudian lakukan konfirmasi data pendaftaran.
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
              <strong>Kartu identitas</strong>, <strong>surat rujukan</strong> , daftar <strong>obat &amp; alergi</strong>,
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
              Persiapan pemeriksaan <strong>bergantung pada jenis pemeriksaan radiologi</strong> yang dilakukan.
              Beberapa pemeriksaan seperti <strong>CT Scan dengan kontras</strong> umumnya memerlukan
              <strong>puasa selama beberapa jam</strong> sebelum tindakan.
              Pada pemeriksaan <strong>MRI</strong>, pasien diwajibkan <strong>melepaskan seluruh benda logam</strong> dan mengenakan pakaian yang sesuai demi keselamatan dan kualitas hasil pemeriksaan.
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
              Keamanan pemeriksaan <strong>MRI pada pasien dengan alat atau implan logam</strong>
              bergantung pada jenis dan spesifikasi perangkat yang digunakan.
              Untuk kondisi khusus atau apabila terdapat keraguan, pasien disarankan <strong>menghubungi rumah sakit tujuan melalui kontak yang tersedia</strong> untuk memperoleh
              informasi dan konfirmasi lebih lanjut sebelum pemeriksaan.
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
                Keamanan pemeriksaan radiologi pada <strong>ibu hamil atau menyusui</strong>
                bergantung pada jenis pemeriksaan yang dilakukan. Pada kehamilan, pemeriksaan <strong>USG</strong> dan
                <strong>MRI tanpa kontras</strong> umumnya dianggap aman. Pemeriksaan yang menggunakan <strong>radiasi</strong>, seperti X-ray atau CT Scan,
                hanya dilakukan apabila <strong>manfaat klinis dinilai lebih besar</strong> dibandingkan risikonya. Pada ibu menyusui, penggunaan zat kontras akan disesuaikan dengan
                <strong>pertimbangan dan rekomendasi dokter</strong>.
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
              Pada beberapa pemeriksaan radiologi, dokter dapat menggunakan <strong>bahan kontras</strong> untuk membantu <strong>memperjelas struktur organ atau jaringan</strong> sehingga hasil pemeriksaan lebih akurat.
              Sebagian besar pasien hanya mengalami <strong>efek samping ringan dan sementara</strong>, seperti rasa hangat atau mual ringan.
              Reaksi alergi berat <strong>sangat jarang terjadi</strong>.
              Keputusan penggunaan bahan kontras selalu didasarkan pada <strong>pertimbangan manfaat dan risiko</strong> oleh dokter sesuai kondisi pasien.
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
              Apabila pasien memiliki <strong>riwayat alergi, asma, atau pernah mengalami reaksi terhadap bahan kontras</strong>, informasi tersebut wajib <strong>dicantumkan secara lengkap saat proses pendaftaran</strong>.
              Data ini akan menjadi bahan pertimbangan petugas medis sebelum pemeriksaan dilakukan.
              Bila diperlukan, pemeriksaan dapat disesuaikan dengan <strong>protokol khusus atau alternatif yang lebih aman</strong> sesuai kondisi pasien.
            </div>
          </div>
        </div>

        {{-- 8 --}}
        <div class="accordion-item faq-item border-0 rounded-3 shadow-sm mb-3">
          <div class="faq-title px-4 py-3">
            <button class="accordion-button p-0 bg-transparent shadow-none collapsed w-100 text-start"
                    type="button" data-bs-toggle="collapse" data-bs-target="#c8">
              <span class="fw-semibold">8) Saya memiliki kondisi medis tertentu (misalnya gangguan ginjal atau diabetes). Apakah aman mendapatkan bahan kontras?</span>
            </button>
          </div>
          <div id="c8" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
            <div class="accordion-body px-4 py-3">
              Penggunaan <strong>bahan kontras</strong> pada pasien dengan <strong>kondisi medis tertentu</strong>, seperti gangguan fungsi ginjal atau diabetes,
              memerlukan <strong>pertimbangan khusus</strong>.
              Informasi mengenai kondisi kesehatan tersebut wajib <strong>dicantumkan saat proses pendaftaran</strong> agar pemeriksaan dapat disesuaikan dengan <strong>protokol yang aman</strong> sesuai pedoman yang berlaku.
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
              Lama proses pemeriksaan radiologi <strong>bervariasi sesuai jenis pemeriksaan</strong>.
              Pemeriksaan seperti <strong>X-ray, USG, dan mammografi</strong> umumnya berlangsung sekitar <strong>5–15 menit</strong>.
              <strong>CT Scan</strong> biasanya memerlukan waktu sekitar <strong>10–20 menit</strong>, dan dapat lebih lama apabila menggunakan bahan kontras.
              <strong>MRI</strong> memerlukan waktu yang lebih panjang, yaitu sekitar <strong>20–45 menit</strong>, dan mengharuskan pasien berbaring diam selama pemeriksaan.
              Selama prosedur, pasien akan dipantau oleh petugas medis dan dapat berkomunikasi apabila diperlukan.
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
              Setelah pemeriksaan selesai, <strong>citra radiologi akan dianalisis oleh dokter radiologi</strong>.
              Hasil analisis kemudian disusun dalam bentuk <strong>laporan pemeriksaan</strong>.
              Pada sistem ini, hasil pemeriksaan akan <strong>diunggah ke aplikasi/website radiologi</strong>
              sehingga pasien dapat <strong>mengakses dan mengunduh laporan, citra, atau ringkasan hasil</strong>
              sesuai dengan kebijakan fasilitas.
              Pasien disarankan untuk <strong>memantau status pemeriksaan secara berkala melalui aplikasi</strong>.
          </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

@vite(['resources/js/searchfaq.js'])
@endsection
