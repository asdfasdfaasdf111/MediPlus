@extends('layout.app')

@section('content')

<div class="container py-4 py-md-5">
  @php
    use Carbon\Carbon;
    $hasPasien = isset($dataPasiens) && !$dataPasiens->isEmpty();
  @endphp

  <section class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h4 class="fw-bold mb-0" style="color:#173B7A;">List Data Pasien</h4>
      </div>

      @if($hasPasien)
        <a href="{{ route('pasien.datapasien.create') }}"
          class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2 px-3">
          <i class="bi bi-plus-lg"></i>
          <span>Data Pasien</span>
        </a>
      @endif
    </div>
  </section>

  <section>
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

              <div class="d-flex mt-auto justify-content-end align-items-center gap-2">
                  @if (Route::has('pasien.datapasien.edit'))
                      <a href="{{ route('pasien.datapasien.edit', $p) }}" 
                        class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                          <i class="bi bi-pencil me-1"></i>Edit
                      </a>
                  @endif

                  @if (Route::has('pasien.datapasien.destroy'))
                      {{-- Tambahkan class m-0 agar tidak ada margin bawaan dari form --}}
                      <form action="{{ route('pasien.datapasien.destroy', $p) }}" method="POST" class="m-0"
                            onsubmit="return confirm('Hapus data pasien &quot;{{ $p->namaLengkap }}&quot;?');">
                          @csrf @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
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
  </section>


  <section>
  {{-- UNTUK TAB PEMERIKSAAN --}}
  <hr class="my-4">

  @php
    $aktif = $aktifStatusUtama ?? request('status', 'semua');
    $hasExam = isset($pemeriksaanBerlangsung) && !$pemeriksaanBerlangsung->isEmpty();
  @endphp

  <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
    <h4 class="fw-bold mb-2 mb-md-0" style="color:#173B7A;">Pemeriksaan</h4>
    <a href="{{ route('pasien.daftarpilihjadwal') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2 px-3">
      <i class="bi bi-plus-lg"></i>
      <span>Daftar Pemeriksaan Baru</span>
    </a>
    {{-- @if($hasExam)
      <a href="{{ route('pasien.pemeriksaan.create') }}"
         class="btn btn-outline-primary d-inline-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Daftar Pemeriksaan Baru
      </a>
    @endif --}}
  </div>

  {{-- <div class="overflow-x-auto"> itu Wrapper biar bisa discroll di mobile --}}
  <div class="overflow-x-auto">
    <ul class="nav nav-tabs flex-nowrap border-0 mb-3">
      @foreach ([
        'semua'      => 'Semua',
        'pending'    => 'Pending',
        'berlangsung'=> 'Berlangsung',
        'selesai'    => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
      ] as $key => $label)
        <li class="nav-item">
          <a class="nav-link {{ $aktif === $key ? 'active' : '' }}"
            href="{{ request()->fullUrlWithQuery(['status' => $key]) }}">
            {{ $label }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>

  @if(!$hasExam)
    {{-- EMPTY STATE: tambah Bootstrap Icon + padding diperkecil --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4 p-md-4 text-center">
        <div class="mx-auto mb-3" style="width:68px;height:68px;border-radius:50%;
             background:#EEF3FF;display:flex;align-items:center;justify-content:center;">
          <i class="bi bi-clipboard-plus" style="font-size:1.6rem;color:#2f6fed;"></i>
        </div>
        <div class="text-muted mb-3">Tidak ada data.</div>
      </div>
    </div>
  @else
    @foreach($pemeriksaanBerlangsung as $ex)
      @php
        $statusClassPasien = match($ex->statusPasien) {
          'Pendaftaran Terkirim', 'Menunggu Registrasi Ulang' => 'text-warning',
          'Dalam Antrian', 'Pemeriksaan Berlangsung', 'Hasil Tersedia' => 'text-success',
          'Pendaftaran Dibatalkan'   => 'text-danger',
          default   => 'text-muted',
        };
        $statusClassUtama = match($ex->statusUtama) {
          'Pending'=> 'text-warning',
          'Berlangsung' => 'text-primary',
          'Selesai' => 'text-success',
          'Dibatalkan'   => 'text-danger',
          default   => 'text-muted',
        };
        $tgl   = $ex->tanggalPemeriksaan ? \Carbon\Carbon::parse($ex->tanggalPemeriksaan)->translatedFormat('d F Y') : '—';
        $jam   = $ex->rentangWaktuKedatangan ? \Carbon\Carbon::parse($ex->rentangWaktuKedatangan)->format('H:i') : '—';
        $noReg = 'REG-' . str_pad($ex->id, 6, '0', STR_PAD_LEFT);
        $jump = $ex->jenisPemeriksaan->getJump();
        $pembayaran = $ex->pembayaran;
      @endphp

      <div class="card border-0 shadow-sm mb-3" style="background:#F5F8FF;">
        <div class="card-body p-0">
          <div class="px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
            <div class="fw-semibold">
              @if ($ex->statusPasien === 'Dalam Antrian')
                Antrian 
                {{ $ex->jenisPemeriksaan->kelompokJenisPemeriksaan->namaKelompok }}
                -{{ $ex->nomorAntrian }}
              @endif
            </div>

            <div class="small fw-semibold {{ $statusClassPasien }}">
              {{ $ex->statusPasien }}
            </div>
        </div>



          <hr class="my-0">

          <div class="row g-3 p-4">
            <div class="col-md-3 d-flex align-items-center justify-content-center">
              <div class="{{ $statusClassUtama }} fw-bold" style="font-size:1.1rem;">{{ $ex->statusUtama }}</div>
            </div>

            <div class="col-md-7">
              <div class="row gy-1">

                <div class="col-4 text-muted">Nomor Registrasi</div>
                <div class="col-6 fw-semibold">: {{ $noReg }}</div>

                <div class="col-4 text-muted">Nama Lengkap Pasien</div>
                <div class="col-6 fw-semibold">: {{ optional($ex->dataPasien)->namaLengkap ?? '—' }}</div>

                @if ($ex->statusUtama == 'Pending')
                  <div class="col-4 text-muted">Dokter Perujuk</div>
                  <div class="col-6 fw-semibold">: {{ $ex->dataRujukan->namaDokterPerujuk }}</div>
                @elseif ($ex->statusUtama != 'Dibatalkan')
                  <div class="col-4 text-muted">Dokter Radiologi</div>
                  <div class="col-6 fw-semibold">: {{ $ex->dokter->user->name }}</div>
                @endif

                <div class="col-4 text-muted">Jenis Pemeriksaan</div>
                <div class="col-6 fw-semibold">: {{ $ex->jenisPemeriksaan->namaJenisPemeriksaan }}</div>

                <div class="col-4 text-muted">Tanggal Pemeriksaan</div>
                <div class="col-6 fw-semibold">: {{ $tgl }}</div>

                <div class="col-4 text-muted">Waktu Kedatangan</div>
                <div class="col-6 fw-semibold">: {{ $jam }} - {{ Carbon::parse($jam)->addHour()->format('H:i') }}</div>             
                
                @if ($pembayaran !== null)
                  <div class="col-4 text-muted">Harga Pemeriksaan</div>
                  <div class="col-6 fw-semibold">: Rp {{ number_format($pembayaran->harga, 0, ',', '.') }}</div>  
                                
                @endif
              </div>
            </div>

            <div class="col-md-2 d-flex flex-column justify-content-center align-items-end gap-2 ">
              <a href="{{ asset('storage/' . $ex->dataRujukan->formulirRujukan) }}" 
                target="_blank"
                class="btn btn-light border w-100">
                 <i class="bi bi-paperclip me-1"></i> Lampiran
              </a>
            </div>
          </div>

          <hr class="my-0">
          <div class="px-4 py-2 d-flex justify-content-end gap-2">
            @if ($ex->bisaDiedit())
              <a href="{{ route('pasien.editpendaftaran', $ex) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil-square me-1"></i> EDIT
              </a>
              <form action="{{ route('pasien.hapusPendaftaran', $ex) }}" method="POST"
                    onsubmit="return confirm('Hapus pendaftaran ini?');">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash me-1"></i> HAPUS
                </button>
              </form>
            @elseif ($ex->statusUtama != "Pending")
              <a href="{{ route('pasien.detailpemeriksaan', $ex) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil-square me-1"></i> LIHAT DETAIL
              </a>
            @endif
            {{-- blm slsai, bru tombol doang --}}
            @if ($ex->statusPasien == "Hasil Tersedia" || $ex->statusUtama == "Selesai")
              <a href="{{ route('pasien.hasilpemeriksaan', $ex) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil-square me-1"></i> LIHAT HASIL
              </a>
            @endif

            {{-- TITIP DULU --}}
            @if ($ex->statusUtama === 'Pending' && $ex->statusPasien === 'Menunggu Pembayaran')
              <button
                  class="btn btn-sm btn-primary"
                  onclick="handlePayment({{ $ex->id }}, {{ $ex->jenisPemeriksaan->harga }})"
              >
                  <i class="bi bi-pencil-square me-1"></i> SELESAIKAN PEMBAYARAN
              </button>
            @endif
            
          </div>
        </div>
      </div>
    @endforeach

    {{-- paginatenya di set di pendaftarancontroller, pake bootstrap di appserviceprovider --}}
    @if(method_exists($pemeriksaanBerlangsung, 'links'))
      <div class="mt-3 d-flex justify-content-end">
        {{ $pemeriksaanBerlangsung->onEachSide(1)->links() }}
      </div>
    @endif

  @endif

</section>

</div>
@endsection


{{-- PEMBAYARAN REVISI --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="paymentModalLabel" style="color: #0A3A7A;">Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-4">
                <div class="text-center mb-4 p-3 rounded-3" style="background-color: #f8faff;">
                    <p class="text-muted mb-1 small text-uppercase fw-semibold">Total yang harus dibayar</p>
                    <h3 class="fw-bold text-primary mb-0" id="paymentPrice">Rp 0</h3>
                </div>

                <p class="text-center mb-4 text-muted small px-3">
                    Silakan pilih metode pembayaran untuk melanjutkan pendaftaran.
                </p>

                <div class="d-grid gap-3">
                    {{-- Buat Online --}}
                    <button type="button" class="btn btn-outline-primary py-3 px-4 text-start d-flex align-items-center justify-content-between shadow-sm hover-elevate" onclick="choosePayment('online')">
                        <div>
                            <div class="fw-bold">Bayar Sekarang (Online)</div>
                            <small class="text-muted">Transfer Bank, E-Wallet, atau VA</small>
                        </div>
                        <i class="bi bi-credit-card fs-4"></i>
                    </button>

                    {{-- Buat Offline --}}
                    <button type="button" class="btn btn-outline-secondary py-3 px-4 text-start d-flex align-items-center justify-content-between shadow-sm hover-elevate" onclick="choosePayment('offline')">
                        <div>
                            <div class="fw-bold">Bayar di Rumah Sakit</div>
                            <small class="text-muted">Tunai, Debit, Asuransi Kesehatan, atau BPJS</small>
                        </div>
                        <i class="bi bi-hospital fs-4"></i>
                    </button>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                <div class="bg-light p-2 rounded-2 d-flex align-items-start gap-2 mx-3">
                    <i class="bi bi-info-circle text-primary mt-1"></i>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        Khusus pengguna <strong>Asuransi</strong> dan <strong>BPJS</strong>, wajib memilih opsi <strong>"Bayar di Rumah Sakit"</strong> untuk verifikasi berkas saat kedatangan.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Sedikit sentuhan interaktif tanpa merusak bootstrap */
    .hover-elevate {
        transition: all 0.2s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-2px);
        background-color: #f0f4f8;
        border-color: #0d6efd;
    }
</style>


<script>
  function handlePayment(id, price) {
      fetch(`/pasien/pembayaran/check/${id}`)
          .then(res => res.json())
          .then(data => {
              if (data.status === 'belumPilih') {
                  showPaymentModal(id, price);
              }

              if (data.status === 'online') {
                  window.location.href = data.checkout_link;
              }
  
              if (data.status === 'offline') {
                  alert('Silakan lakukan pembayaran di rumah sakit.');
              }
  
          });
  }
</script>

<script>
  let currentDataId = null;
  let currentPrice = 0;

  function showPaymentModal(id, price) {
      currentDataId = id;
      currentPrice = price;

      document.getElementById('paymentPrice').innerText =
          'Rp ' + price.toLocaleString('id-ID');

      new bootstrap.Modal(document.getElementById('paymentModal')).show();
  }
  
  function choosePayment(method) {
      fetch('/pasien/pembayaran/create', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
              dataPemeriksaanId: currentDataId,
              metodePembayaran: method
          })
        })
      .then(res => res.json())
      .then(data => {
          if (data.status === 'error'){
            alert(data.message);
            return;
          }
          if (method === 'online') {
              window.location.href = data.redirect_url;
          } else {
              location.reload();
          }
      });
  }
  </script>