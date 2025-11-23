<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-white text-dark">

    @include('layout.navbar2')

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 min-vh-100 p-2 mt-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.homepage') }}" class="nav-link {{ request()->routeIs('admin.homepage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-calendar-week me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.keloladokterpage') }}" class="nav-link {{ request()->routeIs('admin.keloladokterpage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-person-badge me-2"></i> Kelola Akun Dokter
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.kelolapetugaspage') }}" class="nav-link {{ request()->routeIs('admin.kelolapetugaspage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Kelola Akun Petugas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.kelolajadwalpage') }}" class="nav-link {{ request()->routeIs('admin.kelolajadwalpage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-calendar-check me-2"></i> Kelola Jadwal
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logaktivitaspage') }}" class="nav-link {{ request()->routeIs('admin.logaktivitaspage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-file-earmark-text me-2"></i> Log Aktivitas
                    </a>
                </li>
            </ul>
        </div>

<div class="col-md-10 p-4 bg-light">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">

        <div class="container my-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <div class="fw-semibold mb-1">Periksa kembali input:</div>
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body mt-2">

      <form action="{{ route('admin.updateJadwal') }}" method="POST">
        @csrf

        @php
          use Carbon\Carbon;
          // $rows diharapkan dikirim dari controller@index.
          // Fallback aman kalau lupa compact('rows'):
          $rows = $rows ?? ($admin->rumahSakit->jadwalRumahSakit()->orderBy('indexJadwal')->get());
        @endphp

        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 20%">Hari</th>
                <th style="width: 15%" class="text-center">Buka</th>
                <th style="width: 30%">Jam Buka</th>
                <th style="width: 30%">Jam Tutup</th>
                <th style="width: 5%"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rows as $jadwal)
                @php
                  // gunakan indexJadwal (1..7) agar cocok dgn model updateJadwal()
                  $key = $jadwal->indexJadwal;
                  $rowKey = "jadwal.$key";
                  $jb = $jadwal->jamBuka ? Carbon::parse($jadwal->jamBuka) : null;
                  $jt = $jadwal->jamTutup ? Carbon::parse($jadwal->jamTutup) : null;
                  $isBuka = old("$rowKey.buka", $jadwal->buka) ? 1 : 0;
                @endphp

                <tr>
                  <td class="fw-semibold">{{ $jadwal->namaHari }}</td>

                  <td class="text-center">
                    {{-- hidden supaya saat uncheck tetap kirim 0 --}}
                    <input type="hidden" name="jadwal[{{ $key }}][buka]" value="0">
                    <div class="form-check d-inline-block">
                      <input class="form-check-input"
                             type="checkbox"
                             name="jadwal[{{ $key }}][buka]"
                             value="1"
                             {{ $isBuka ? 'checked' : '' }}>
                    </div>
                  </td>

                  <td>
                    <div class="input-group">
                      <input type="number"
                             name="jadwal[{{ $key }}][jamBukaJam]"
                             value="{{ old("$rowKey.jamBukaJam", $jb ? $jb->format('H') : '08') }}"
                             min="0" max="23"
                             class="form-control text-center @error("$rowKey.jamBukaJam") is-invalid @enderror"
                             placeholder="HH">
                      <span class="input-group-text">:</span>
                      <input type="number"
                             name="jadwal[{{ $key }}][jamBukaMenit]"
                             value="{{ old("$rowKey.jamBukaMenit", $jb ? $jb->format('i') : '00') }}"
                             min="0" max="59"
                             class="form-control text-center @error("$rowKey.jamBukaMenit") is-invalid @enderror"
                             placeholder="MM">
                    </div>
                    @error("$rowKey.jamBukaJam")<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error("$rowKey.jamBukaMenit")<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                  </td>

                  <td>
                    <div class="input-group">
                      <input type="number"
                             name="jadwal[{{ $key }}][jamTutupJam]"
                             value="{{ old("$rowKey.jamTutupJam", $jt ? $jt->format('H') : '16') }}"
                             min="0" max="23"
                             class="form-control text-center @error("$rowKey.jamTutupJam") is-invalid @enderror"
                             placeholder="HH">
                      <span class="input-group-text">:</span>
                      <input type="number"
                             name="jadwal[{{ $key }}][jamTutupMenit]"
                             value="{{ old("$rowKey.jamTutupMenit", $jt ? $jt->format('i') : '00') }}"
                             min="0" max="59"
                             class="form-control text-center @error("$rowKey.jamTutupMenit") is-invalid @enderror"
                             placeholder="MM">
                    </div>
                    @error("$rowKey.jamTutupJam")<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error("$rowKey.jamTutupMenit")<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                  </td>

                  <td class="text-end">
                    @if($isBuka)
                      <span class="badge bg-success">Buka</span>
                    @else
                      <span class="badge bg-secondary">Tutup</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Simpan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

    </div>    
</div>
<script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>

