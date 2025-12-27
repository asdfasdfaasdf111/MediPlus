@extends('layout.staff')

@section('title', 'Petugas | Kelola Jenis Pemeriksaan Petugas')

@section('content')

  <div class="container-fluid">
    <div class="row">
      @include('layout.sidebarpetugas')

      <div class="col-md-10 p-4 bg-light">

        @if (session('success'))
          <div class="alert alert-success alert-dismissible auto-dismiss fade show mx-1 mx-md-0 mt-2" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

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
            <table class="table align-middle mb-0">

              <thead class="table-light">
                <tr class="align-middle">
                  <th style="width:30%;" class="ps-4">Nama Jenis</th>
                  <th style="width:20%;">Kelompok Jenis</th>
                  <th class="text-center text-nowrap" style="width:110px;">Kontras</th>
                  <th class="text-nowrap" style="width:170px;">Durasi</th>
                  <th class="text-center text-nowrap" style="width:120px;">Didampingi</th>
                  <th class="text-center" style="width:170px;"></th>
                </tr>
              </thead>

              <tbody>
                @forelse($jenisPemeriksaans as $jenisPemeriksaan)
                <tr id="row-{{ $jenisPemeriksaan->id }}">

                  <td class="ps-4">
                    <span data-name="namaJenisPemeriksaan" class="view-field">{{ $jenisPemeriksaan->namaJenisPemeriksaan }}</span>
                    <input type="text" name="namaJenisPemeriksaan" class="form-control form-control-sm edit-field d-none"
                           value="{{ $jenisPemeriksaan->namaJenisPemeriksaan }}">
                  </td>

                  <td> 
                    <span data-name="kelompokJenisPemeriksaan" class="view-field">
                      {{ $jenisPemeriksaan->kelompokJenisPemeriksaan->namaKelompok }}
                    </span>
                    <select name="kelompokJenisPemeriksaan" class="form-control form-control-sm edit-field d-none">
                      @foreach($petugas->rumahSakit->kelompokJenisPemeriksaan as $kelompokJenisPemeriksaan)
                        <option value="{{ $kelompokJenisPemeriksaan->id }}" {{ $kelompokJenisPemeriksaan->id == $jenisPemeriksaan->kelompokJenisPemeriksaan->id ? 'selected' : '' }}>
                          {{ $kelompokJenisPemeriksaan->namaKelompok }}
                        </option>
                      @endforeach
                    </select>
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
                            class="btn btn-warning btn-sm d-flex align-items-center justify-content-center p-0 edit-btn"
                            style="width:40px;height:40px;border-radius:5px;"
                            data-route="{{ route('petugas.editJenisPemeriksaan', $jenisPemeriksaan->id) }}"
                            data-id="{{ $jenisPemeriksaan->id }}">
                      <i class="bi bi-pencil"></i>
                    </button>

                    <button type="button"
                            class="btn btn-success btn-sm d-none d-flex align-items-center justify-content-center p-0 save-btn"
                            style="width:40px;height:40px;border-radius:5px;"
                            data-route="{{ route('petugas.editJenisPemeriksaan', $jenisPemeriksaan->id) }}"
                            data-id="{{ $jenisPemeriksaan->id }}">
                      <i class="bi bi-check"></i>
                    </button>

                    <form action="{{ route('petugas.hapusJenisPemeriksaan', $jenisPemeriksaan->id) }}"
                          method="POST"
                          onsubmit="return confirm('Apakah anda yakin ingin menghapus jenis pemeriksaan ini?');"
                          class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                              style="width:40px;height:40px;border-radius:5px;">
                        <i class="bi bi-trash"></i>
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

      </div>
    </div>
  </div>


@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.alert').forEach(alertEl => {
      setTimeout(() => {
        bootstrap.Alert.getOrCreateInstance(alertEl).close();
      }, 3000);
    });
  });
</script>
@endpush