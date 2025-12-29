@extends('layout.staff')

@section('title', 'Kelola Kelompok Jenis Pemeriksaan')

@section('content')

<div class="container-fluid">
  <div class="row">
    @include('layout.sidebarpetugas')

    <div class="col-md-10 p-4 bg-light">

      @if (session('success'))
        <div class="alert alert-success alert-dismissible auto-dismiss fade show mx-1 mx-md-0 mt-2" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Search --}}
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="flex-grow-1 me-3">
          <form action="" method="GET">
            <div class="input-group">
              <input type="text"
                     class="form-control"
                     name="search"
                     value="{{ request('search') }}"
                     placeholder="Cari Kelompok Jenis Pemeriksaan">
              <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>

        <div class="col-12 col-md-2 mt-2 mt-md-0">
          <a href="{{ route('petugas.tambahkelompokjenispemeriksaanpage') }}"
             class="btn btn-primary w-100">
            <i class="bi bi-plus"></i> Tambah Kelompok
          </a>
        </div>
      </div>

      <div class="card">
        <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
          <span></span>
          <small class="text-muted">
            Total:
            {{ method_exists($kelompokJenisPemeriksaans,'total')
                ? $kelompokJenisPemeriksaans->total()
                : $kelompokJenisPemeriksaans->count() }}
          </small>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0 table-fixed">

            <thead class="table-light">
                <tr class="align-middle">
                    <th class="ps-4" style="width: 85%;">Nama Kelompok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>



            <tbody>
              @forelse($kelompokJenisPemeriksaans as $kelompokJenisPemeriksaan)
                <tr id="row-{{ $kelompokJenisPemeriksaan->id }}">
                  <td class="ps-4">
                    <span data-name="namaKelompok" class="view-field">
                      {{ $kelompokJenisPemeriksaan->namaKelompok }}
                    </span>

                    <input type="text" name="namaKelompok" class="form-control form-control-sm edit-field d-none" value="{{ $kelompokJenisPemeriksaan->namaKelompok }}">
                  </td>

                  <td class="justify-content-end">
                    <div class="d-flex justify-content-center gap-2">
                      <button type="button"
                              class="btn btn-warning btn-sm d-flex align-items-center justify-content-center p-0 edit-btn"
                              style="width:40px;height:40px;border-radius:5px;"
                              data-route="{{ route('petugas.editKelompokJenisPemeriksaan', $kelompokJenisPemeriksaan->id) }}"
                              data-id="{{ $kelompokJenisPemeriksaan->id }}">
                        <i class="bi bi-pencil"></i>
                      </button>

                      <button type="button"
                              class="btn btn-success btn-sm d-none d-flex align-items-center justify-content-center p-0 save-btn"
                              style="width:40px;height:40px;border-radius:5px;"
                              data-route="{{ route('petugas.editKelompokJenisPemeriksaan', $kelompokJenisPemeriksaan->id) }}"
                              data-id="{{ $kelompokJenisPemeriksaan->id }}">
                        <i class="bi bi-check"></i>
                      </button>

                      <form action="{{ route('petugas.hapusKelompokJenisPemeriksaan', $kelompokJenisPemeriksaan->id) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah anda yakin ingin menghapus kelompok jenis pemeriksaan ini? Semua data terkait akan terhapus.');"
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
                  <td colspan="2" class="text-center text-muted py-5">
                    <i class="bi bi-inboxes me-1"></i>
                    Belum ada data kelompok jenis pemeriksaan.
                    <a href="{{ route('petugas.tambahkelompokjenispemeriksaanpage') }}"
                       class="link-primary">Tambah sekarang</a>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer py-2">
            @if(method_exists($kelompokJenisPemeriksaans,'links'))
                {{ $kelompokJenisPemeriksaans->appends(request()->query())->links() }}
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
