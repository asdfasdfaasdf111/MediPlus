<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemeriksaan Petugas</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
    use Carbon\Carbon;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $kelompokJenisPemeriksaan = $jenisPemeriksaan->kelompokJenisPemeriksaan;
    $jump = $jenisPemeriksaan->getJump();
@endphp

<script>
    window.rumahSakit = {
        id: {{ $rumahSakit->id }}
    };
    window.dataPemeriksaan = {
        id: {{ $dataPemeriksaan->id }}
    };
</script>

<body class="bg-light text-dark">

    <div class="container-fluid py-3 py-md-4">
        <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 min-vh-100 d-flex flex-column">

            <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
            <div>
                <h4 class="mb-1" style="color:#173B7A;">Pilih Jadwal Pemeriksaan</h4>
                <div class="text-muted small">
                Lengkapi pilihan rumah sakit, jenis pemeriksaan, tanggal, dan jam kedatangan.
                </div>
            </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('updateJadwal', ['dataPemeriksaan' => $dataPemeriksaan, 'draft' => "false"]) }}" class="bg-white border rounded-4 shadow-sm flex-grow-0">

                @csrf
                @method('PUT')

                <div class="border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-hospital fs-5 text-primary"></i>
                    <div>
                    <div class="fw-semibold">
                        {{ 'Rumah Sakit ' . $rumahSakit->nama }}
                    </div>
                    </div>
                </div>
                </div>


                <div class="row g-3 px-4 py-3">

                {{-- Jenis & Spesifik ud bikin responsive. col-12 full, yg md bagi 2--}}
                <div class="col-12 col-md-6">
                    <label for="kelompokJenisPemeriksaan" class="form-label fw-semibold">Kelompok Jenis Pemeriksaan</label>
                    <select id="kelompokJenisPemeriksaan" name="kelompokJenisPemeriksaan" class="form-select rounded-3" required>
                        @foreach($rumahSakit->kelompokJenisPemeriksaan as $kelompok)
                            <option value="{{ $kelompok->id }}" {{ $kelompok->id == $kelompokJenisPemeriksaan->id ? 'selected' : '' }}>
                                {{ $kelompok->namaKelompok }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Pilih kategori pemeriksaan.</div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="jenisPemeriksaan" class="form-label fw-semibold">Jenis Pemeriksaan</label>
                    <select id="jenisPemeriksaan" name="jenisPemeriksaan" class="form-select rounded-3" required>
                        <option value="-" disabled>
                            -
                        </option>
                        @foreach($rumahSakit->namaJenisPemeriksaan($kelompokJenisPemeriksaan->id) as $jenis)
                            <option value="{{ $jenis->id }}" {{ $jenis->id == $jenisPemeriksaan->id ? 'selected' : '' }}>
                                {{ $jenis->namaJenisPemeriksaan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Pilih tindakan spesifik sesuai rujukan.</div>
                </div>

                </div>

                {{-- Kalender & Waktu --}}
                <div class="row g-3 px-4 pb-3">

                <div class="col-12 col-md-6">
                    <div class="h-100 bg-white border rounded-3">
                    <div class="border-bottom px-3 py-2">
                        <label class="form-label fw-bold mb-0">Tanggal Pemeriksaan</label>
                    </div>
                    <div class="p-3">
                        <input type="hidden" name="tanggalPemeriksaan" id="tanggalPemeriksaanInput"
                        value="{{ $dataPemeriksaan->tanggalPemeriksaan }}">

                        <x-calendar
                                :disabled-dates="$rumahSakit->jadwalPenuh($jenisPemeriksaan)"
                                :default-date="$dataPemeriksaan->tanggalPemeriksaan"
                                id="tanggalPemeriksaan"
                                name="tanggalPemeriksaan"
                                required/>

                        <div class="small text-muted mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Pilih tanggal yang tersedia. Tanggal abu-abu menandakan jadwal penuh.
                        </div>
                    </div>
                    </div>
                </div>

                {{-- Waktu --}}
                <div class="col-12 col-md-6">
                    <div class="h-100 bg-white border rounded-3">
                    <div class="border-bottom d-flex align-items-center justify-content-between px-3 py-2"> <label class="form-label fw-bold mb-0">Rentang Waktu Kedatangan</label> <span id="slotInfo" class="badge text-bg-light rounded-pill">1 jam/slot</span>
                    </div>

                    <div class="p-3">
                        <div id="rentangWaktuKedatangan" class="row row-cols-1 row-cols-md-2 g-3">
                            @php
                                $result = $rumahSakit->jamTersedia(
                                $jenisPemeriksaan,
                                $dataPemeriksaan->tanggalPemeriksaan,
                                $dataPemeriksaan
                                );
                                $timeSlots = $result['listJam'] ?? [];
                                $jump = $result['jump'];
                            @endphp

                            @foreach ($timeSlots as $slot)
                                <div class="col">
                                <input type="radio" class="btn-check" name="rentangWaktuKedatangan" id="slot-{{ $loop->index }}" value="{{ $slot }}" autocomplete="off"
                                        {{ Carbon::parse($slot)->format('H:i') == Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i') ? 'checked' : '' }}
                                        required>

                                <label class="btn btn-outline-primary rounded-pill w-100 py-2 fw-semibold" for="slot-{{ $loop->index }}">
                                    {{ Carbon::parse($slot)->format('H:i') }}
                                    –
                                    {{ Carbon::parse($slot)->addHour($jump)->format('H:i') }}
                                </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="small text-muted mt-2">
                        Slot yang tidak tampil berarti sudah tidak tersedia pada tanggal tersebut.
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="border-top text-center px-4 py-3">
                <div class="d-inline-flex gap-2">
                    <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
                        Kembali
                    </a>
                    <button id="submitBtn" type="submit" class="btn btn-primary px-4 px-md-5 rounded-pill">
                        Simpan
                    </button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>

