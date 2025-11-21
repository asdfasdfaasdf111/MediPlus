<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Petugas | Kelola Modalitas</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  @vite('resources/js/inline-edit.js')
</head>

<body class="bg-white text-dark">
  @include('layout.navbar2')

  <div class="container-fluid">
    <div class="row">
      @include('layout.sidebarpetugas')

      {{-- CONTENT --}}
      <div class="col-md-10 p-4 bg-light">

        {{-- Search --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
          <div class="flex-grow-1 me-3">
            <form action="" method="GET">
              <div class="input-group">
                <input type="text"
                       class="form-control"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari Modalitas">
                <button class="btn btn-outline-secondary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>

          <div class="col-12 col-md-2 mt-2 mt-md-0">
            <a href="{{ route('petugas.tambahmodalitaspage') }}" class="btn btn-primary w-100">
              <i class="bi bi-plus"></i> Tambah Modalitas
            </a>
          </div>
        </div>

        {{-- TABLE --}}
        <div class="card">
          <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
            <span></span>
            <small class="text-muted">
              Total: {{ method_exists($modalitass,'total') ? $modalitass->total() : $modalitass->count() }}
            </small>
          </div>

         <div class="table-responsive">
            <table class="table align-middle mb-0"  style="table-layout: fixed;">
              <colgroup>
                <col style="width:30%;">  
                <col style="width:36%;">   
                <col style="width:31%;">  
                <col style="width:160px;">
              </colgroup>

              <thead class="table-light">
                <tr class="align-middle">
                  <th>Nama Modalitas</th>
                  <th>Jenis Modalitas</th>
                  <th>Kode Ruang</th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody>
                @forelse($modalitass as $modalitas)
                  <tr id="row-{{ $modalitas->id }}">
                    <td>
                      <span data-name="namaModalitas" class="view-field">{{ $modalitas->namaModalitas }}</span>
                      <input type="text" name="namaModalitas"
                             class="form-control form-control-sm edit-field d-none"
                             value="{{ $modalitas->namaModalitas }}">
                    </td>

                    <td>
                      <span data-name="jenisModalitas" class="view-field">{{ $modalitas->jenisModalitas }}</span>
                      <input type="text" name="jenisModalitas"
                             class="form-control form-control-sm edit-field d-none"
                             value="{{ $modalitas->jenisModalitas }}">
                    </td>

                    <td>
                      <span data-name="kodeRuang" class="view-field">{{ $modalitas->kodeRuang }}</span>
                      <input type="text" name="kodeRuang"
                             class="form-control form-control-sm edit-field d-none"
                             value="{{ $modalitas->kodeRuang }}">
                    </td>

                    <td class="text-center">
                      <div class="d-flex justify-content-center gap-2">
                        <button type="button"
                                class="btn btn-sm btn-primary edit-btn"
                                data-route="{{ route('petugas.editModalitas', $modalitas->id) }}"
                                data-id="{{ $modalitas->id }}">
                          Edit
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-success save-btn d-none"
                                data-route="{{ route('petugas.editModalitas', $modalitas->id) }}"
                                data-id="{{ $modalitas->id }}">
                          Simpan
                        </button>

                        <form action="{{ route('petugas.hapusModalitas', $modalitas->id) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah anda yakin ingin menghapus modalitas ini? Semua data terkait akan terhapus.');"
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
                    <td colspan="4" class="text-center text-muted py-5">
                      <i class="bi bi-inboxes me-1"></i> Belum ada data modalitas.
                      <a href="{{ route('petugas.tambahmodalitaspage') }}" class="link-primary">Tambah sekarang</a>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if(method_exists($modalitass,'links'))
            <div class="card-footer">
              {{ $modalitass->appends(request()->query())->links() }}
            </div>
          @endif
        </div>

        <div class="text-center text-muted small py-3">
          © {{ date('Y') }} MediPlus — Petugas Panel
        </div>

      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
