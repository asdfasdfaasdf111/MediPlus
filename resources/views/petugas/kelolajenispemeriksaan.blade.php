<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Petugas | Kelola Jenis Pemeriksaan</title>

  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  @vite('resources/js/inline-edit.js')
</head>
<body class="bg-white text-dark">

  @include('layout.navbar2')

  <div class="container-fluid">
    <div class="row">
      {{-- SIDEBAR --}}
      <div class="col-md-2 min-vh-100 p-3 border-end">
        <ul class="nav flex-column">
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}"
               class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolajenispemeriksaan') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolajenispemeriksaan') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-clipboard2-check me-2"></i> Jenis Pemeriksaan
            </a>
          </li>
          <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolamodalitas') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolamodalitas') ? 'text-primary fw-bold' : 'text-dark' }}">
              <i class="bi bi-hdd-rack me-2"></i> Modalitas
            </a>
          </li>
        </ul>
      </div>

      {{-- CONTENT --}}
      <div class="col-md-10 p-4 bg-light">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="flex-grow-1 me-3">
            <form action="" method="GET">
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari Jenis Pemeriksaan">
                <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i>
                </button>
            </div>
            </form>
        </div>

        <div class="col-12 col-md-2 mt-2 mt-md-0">
            <a href="{{ route('petugas.tambahjenispemeriksaanpage') }}" class="btn btn-primary w-100">
            <i class="bi bi-plus"></i> Jenis Pemeriksaan
            </a>
        </div>
        </div>


        {{-- TABEL--}}
        <div class="card">
          <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
            <span></span>
            <small class="text-muted">
              Total: {{ method_exists($jenisPemeriksaans,'total') ? $jenisPemeriksaans->total() : $jenisPemeriksaans->count() }}
            </small>
          </div>

          <div class="table-responsive">
            <table class="table align-middle mb-0" style="table-layout: fixed;">
              <colgroup>
                <col style="width:10%;">  {{-- Modalitas --}}
                <col style="width:20%;">  {{-- Nama Jenis --}}
                <col style="width:20%;">  {{-- Spesifik --}}
                <col style="width:10%;">  {{-- Kelompok --}}
                <col style="width:15%;">  {{-- Kontras --}}
                <col style="width:12%;">  {{-- Lama --}}
                <col style="width:10%;">  {{-- Didampingi --}}
                <col style="width:160px;">
              </colgroup>

              <thead class="table-light">
                <tr class="align-middle">
                  <th>Modalitas</th>
                  <th>Nama Jenis</th>
                  <th>Spesifik</th>
                  <th>Kelompok</th>
                  <th class="text-center">Kontras</th>
                  <th>Durasi</th>
                  <th class="text-center">Didampingi</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                @forelse($jenisPemeriksaans as $jenisPemeriksaan)
                <tr id="row-{{ $jenisPemeriksaan->id }}">
                  <td>
                    <span data-name="modalitasId" class="view-field">
                      {{ $jenisPemeriksaan->modalitas->namaModalitas }}
                    </span>
                    <select name="modalitasId" class="form-control form-control-sm edit-field d-none">
                      @foreach($petugas->rumahSakit->modalitas as $modalitas)
                        <option value="{{ $modalitas->id }}" {{ $modalitas->id == $jenisPemeriksaan->modalitas->id ? 'selected' : '' }}>
                          {{ $modalitas->namaModalitas }}
                        </option>
                      @endforeach
                    </select>
                  </td>

                  <td>
                    <span data-name="namaJenisPemeriksaan" class="view-field">{{ $jenisPemeriksaan->namaJenisPemeriksaan }}</span>
                    <input type="text" name="namaJenisPemeriksaan" class="form-control form-control-sm edit-field d-none"
                           value="{{ $jenisPemeriksaan->namaJenisPemeriksaan }}">
                  </td>

                  <td>
                    <span data-name="namaPemeriksaanSpesifik" class="view-field">{{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</span>
                    <input type="text" name="namaPemeriksaanSpesifik" class="form-control form-control-sm edit-field d-none"
                           value="{{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}">
                  </td>

                  <td>
                    <span data-name="kelompokJenisPemeriksaan" class="view-field">{{ $jenisPemeriksaan->kelompokJenisPemeriksaan }}</span>
                    <input type="text" name="kelompokJenisPemeriksaan" class="form-control form-control-sm edit-field d-none"
                           value="{{ $jenisPemeriksaan->kelompokJenisPemeriksaan }}">
                  </td>

                  <td class="text-center align-middle">
                    <span data-type="checkbox" data-name="pemakaianKontras" class="view-field ">
                      {{ $jenisPemeriksaan->pemakaianKontras ? 'Ya' : 'Tidak' }}
                    </span>
                    <input type="checkbox" name="pemakaianKontras" class="edit-field d-none" value="1"
                           {{ $jenisPemeriksaan->pemakaianKontras ? 'checked' : '' }}>
                  </td>

                  <td>
                    <span data-name="lamaPemeriksaan" class="view-field">{{ $jenisPemeriksaan->lamaPemeriksaan }}</span>
                    <input type="number" name="lamaPemeriksaan" min="1"
                           class="form-control form-control-sm text-center edit-field d-none"
                           value="{{ $jenisPemeriksaan->lamaPemeriksaan }}" style="max-width:70px">
                    <span> Menit</span>
                  </td>

                  <td class="text-center align-middle">
                    <span data-type="checkbox" data-name="diDampingiDokter" class="view-field">
                      {{ $jenisPemeriksaan->diDampingiDokter ? 'Ya' : 'Tidak' }}
                    </span>
                    <input type="checkbox" name="diDampingiDokter" class="edit-field d-none" value="1"
                           {{ $jenisPemeriksaan->diDampingiDokter ? 'checked' : '' }}>
                  </td>

                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                      <button type="button"
                              class="btn btn-sm btn-primary edit-btn"
                              data-route="{{ route('petugas.editJenisPemeriksaan', $jenisPemeriksaan->id) }}"
                              data-id="{{ $jenisPemeriksaan->id }}">
                        Edit
                      </button>

                      <button type="button"
                              class="btn btn-sm btn-success save-btn d-none"
                              data-route="{{ route('petugas.editJenisPemeriksaan', $jenisPemeriksaan->id) }}"
                              data-id="{{ $jenisPemeriksaan->id }}">
                        Simpan
                      </button>

                      <form action="{{ route('petugas.hapusJenisPemeriksaan', $jenisPemeriksaan->id) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah anda yakin ingin menghapus jenis pemeriksaan ini?');"
                            class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class=""></i> Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                      <i class="bi bi-inboxes me-1"></i> Belum ada data. 
                      <a href="{{ route('petugas.tambahjenispemeriksaanpage') }}" class="link-primary">Tambah sekarang</a>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if(method_exists($jenisPemeriksaans,'links'))
            <div class="card-footer">
              {{ $jenisPemeriksaans->appends(request()->query())->links() }}
            </div>
          @endif
        </div>

        {{-- FOOTER --}}
        <div class="text-center text-muted small py-3">
          © {{ date('Y') }} MediPlus — Petugas Panel
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
