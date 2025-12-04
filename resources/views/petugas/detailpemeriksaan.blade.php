<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petugas | Detail Pemeriksaan</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

@php
  use Carbon\Carbon;
  $rumahSakit       = $dataPemeriksaan->rumahSakit;
  $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
  $dokter           = $dataPemeriksaan->dokter;
  $dataPasien       = $dataPemeriksaan->dataPasien;
  $dataRujukan      = $dataPemeriksaan->dataRujukan;

  $jamAkhir = Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString();

@endphp

<body class="bg-white text-dark">
  @include('layout.navbar2')

  <div class="container-fluid">
    <div class="row">
        @include('layout.sidebarpetugas')

      {{-- KONTEN --}}
      <main class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
          <div class="mb-2 mb-md-0">
            <h3 class="mb-1" style="color:#173B7A;">Detail Pemeriksaan</h3>
          </div>
        </div>

        <div class="row g-3">

          {{-- Ringkasan Pemeriksaan --}}
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header fw-semibold">
                <i class="bi bi-calendar2-week me-2"></i> Ringkasan Pemeriksaan
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="small text-muted">Rumah Sakit</div>
                    <div class="fw-semibold">{{ $rumahSakit->nama }}</div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted">Jenis Pemeriksaan</div>
                    <div class="fw-semibold">
                      {{ $jenisPemeriksaan->namaJenisPemeriksaan }}
                      @if(!empty($jenisPemeriksaan->namaPemeriksaanSpesifik)) - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}
                      @endif
                    </div>
                  </div>

                  @if ($dataPemeriksaan->statusUtama != 'Dibatalkan')
                    <div class="col-md-6">
                      <div class="small text-muted">Dokter Radiologi</div>
                      <div class="fw-semibold">{{ $dokter->user->name }}</div>
                    </div>
                  @endif

                  <div class="col-md-6">
                    <div class="small text-muted">Tanggal Pemeriksaan</div>
                    <div class="fw-semibold">{{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted">Rentang Waktu Kedatangan</div>
                    <div class="fw-semibold">
                      {{ $dataPemeriksaan->rentangWaktuKedatangan }} - {{ $jamAkhir }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Tipe Pasien --}}
          <div class="col-12">
            <div class="card shadow-sm h-100">
              <div class="card-header fw-semibold">
                <i class="bi bi-people me-2"></i> Tipe Pasien
              </div>
              <div class="card-body">
                <div class="vstack gap-3">
                  <div>
                    <div class="small text-muted">Hubungan dengan Pasien</div>
                    <div class="fw-semibold">{{ $dataPasien->hubunganKeluarga }}</div>
                  </div>

                  <div>
                    <div class="small text-muted">Nama Pendamping</div>
                    <div class="fw-semibold">
                      @if (!empty($dataPemeriksaan->namaPendamping))
                        {{ $dataPemeriksaan->namaPendamping }}
                      @else
                        -
                      @endif
                    </div>
                  </div>

                  <div>
                    <div class="small text-muted">Nomor Telepon Pendamping</div>
                    <div class="fw-semibold">
                      @if (!empty($dataPemeriksaan->nomorPendamping))
                        {{ $dataPemeriksaan->nomorPendamping }}
                      @else
                        -
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- FORMULIR DATA DIRI --}}
          <div class="col-12">
            <div class="card shadow-sm h-100">
              <div class="card-header fw-semibold">
                <i class="bi bi-person-vcard me-2"></i> Formulir Data Diri
              </div>

              <div class="card-body">
                <div class="row g-4">
                  {{-- KIRI --}}
                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Nama Lengkap</div>
                      <div class="fw-semibold">{{ $dataPasien->namaLengkap }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Tanggal Lahir</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatTanggalLahir }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Jenis Kartu Identitas</div>
                      <div class="fw-semibold">{{ $dataPasien->jenisIdentitas }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Nomor Identitas</div>
                      <div class="fw-semibold">{{ $dataPasien->noIdentitas }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Nomor Telepon Aktif</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatNoHP }}</div>
                    </div>
                  </div>

                  {{-- KANAN --}}
                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Alamat Domisili</div>
                      <div class="fw-semibold text-break">{{ $dataPemeriksaan->riwayatAlamatDomisili }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Jenis Kelamin</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatJenisKelamin }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Golongan Darah</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatGolonganDarah }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Alergi</div>
                      <div class="fw-semibold">
                        @if (!empty($dataPemeriksaan->riwayatAlergi))
                          Ya
                        @else
                          Tidak
                        @endif
                      </div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Deskripsi Alergi</div>
                      <div class="fw-semibold text-break">
                        @if (!empty($dataPemeriksaan->riwayatAlergi))
                          {{ $dataPemeriksaan->riwayatAlergi }}
                        @else
                          -
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Data Rujukan --}}
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header fw-semibold">
                <i class="bi bi-hospital me-2"></i> Data Rujukan
              </div>
              <div class="card-body">
                <div class="row g-4">
                  {{-- KIRI --}}
                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Nama Fasilitas Kesehatan</div>
                      <div class="fw-semibold">{{ $dataRujukan->namaFaskes }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Tanggal Pemeriksaan di Klinik</div>
                      <div class="fw-semibold">{{ $dataRujukan->tanggalPemeriksaanFaskes }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Nama Dokter Perujuk</div>
                      <div class="fw-semibold">{{ $dataRujukan->namaDokterPerujuk }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Diagnosa Kerja</div>
                      <div class="fw-semibold">{{ $dataRujukan->diagnosaKerja }}</div>
                    </div>
                  </div>

                  {{-- KANAN --}}
                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Alasan Rujukan</div>
                      <div class="fw-semibold text-break">{{ $dataRujukan->alasanRujukan }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Permintaan Pemeriksaan</div>
                      <div class="fw-semibold text-break">{{ $dataRujukan->permintaanPemeriksaan }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Formulir Rujukan</div>
                      <a class="fw-semibold text-break" href="{{ asset('storage/' . $dataRujukan->formulirRujukan) }}" target="_blank">
                          {{ $dataRujukan->namaFile }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div> 

       <div class="d-flex justify-content-center gap-2 gap-md-3 pt-4">
          <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
                Kembali
          </a>
          @if ($dataPemeriksaan->statusPasien === 'Menunggu Registrasi Ulang')
              {{-- hanya bisa regis ulang kalo <= 6 jam, klo ud > 6 jam lewat atau masih lebih dri 6 jam sblum jadwal, gbs regis ulang  --}}
            @php
              $date = $dataPemeriksaan->tanggalPemeriksaan;
              $time = $dataPemeriksaan->rentangWaktuKedatangan;

              $pemeriksaanDateTime = Carbon::parse("$date $time", 'Asia/Jakarta');
              $pemeriksaanDateTime->setTimezone('Asia/Jakarta');
              $diff = now('Asia/Jakarta')->diffInHours($pemeriksaanDateTime);
            @endphp
            @if ($diff <= 6 && $diff >= -6)
              <form action="{{ route('petugas.registrasiUlang', $dataPemeriksaan) }}"
                    method="POST"
                    onsubmit="return checkWaktu();">
                  @csrf
                  <button type="submit" class="btn btn-primary">Registrasi Ulang</button>
              </form>
            @endif
          @endif
          
        </div>

      </main>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    function checkWaktu() {
        const pemeriksaanIso = @json(
            Carbon::parse(
                $dataPemeriksaan->tanggalPemeriksaan . ' ' . $dataPemeriksaan->rentangWaktuKedatangan
            )->toIso8601String()
        );
        const pemeriksaanTime = new Date(pemeriksaanIso);
        const now = new Date();
    
        const diffMs = pemeriksaanTime - now;
        const diffHours = diffMs / (1000 * 60 * 60);
    
        if (diffHours > 1) {
            return confirm("Waktu pemeriksaan masih lebih dari 1 jam. Apakah Anda yakin?");
        }
    
        return true;
    }
    </script>
</body>
</html>
