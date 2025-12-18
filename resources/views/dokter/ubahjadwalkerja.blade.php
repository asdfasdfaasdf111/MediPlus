@php use Carbon\Carbon;@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Homepage Dokter</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body class="bg-white text-dark">

    @include('layout.navbar2')
    <div class="col-md-10 p-4 bg-light">
        {{-- w asal tempel tempatnya, jadiny designny aga rusak, mohon bantuannya terima kasih --}}
        @include('layout.sidebardokter')

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
          
          <form action="{{ route('dokter.updateJadwal') }}" method="POST">
            @csrf
            
            @php
          // $rows diharapkan dikirim dari controller@index.
          // Fallback aman kalau lupa compact('rows'):
          $rows = $dokter->jadwalDokter;
          @endphp
          

        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 20%">Hari</th>
                <th style="width: 15%" class="text-center">Kerja</th>
                <th style="width: 30%">Jam Mulai Kerja</th>
                <th style="width: 30%">Jam Selesai Kerja</th>
                <th style="width: 5%"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rows as $jadwal)
                @php
                  // gunakan indexJadwal (1..7) agar cocok dgn model updateJadwal()
                  $key = $jadwal->indexJadwal;
                  $rowKey = "jadwal.$key";
                  $jb = $jadwal->jamMulai ? Carbon::parse($jadwal->jamMulai) : null;
                  $jt = $jadwal->jamSelesai ? Carbon::parse($jadwal->jamSelesai) : null;
                  $isBuka = old("$rowKey.buka", $jadwal->kerja) ? 1 : 0;
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
                      <span class="badge bg-success">Kerja</span>
                    @else
                      <span class="badge bg-secondary">Tidak Kerja</span>
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
</html>