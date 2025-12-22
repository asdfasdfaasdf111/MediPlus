@php use Carbon\Carbon; @endphp

@extends('layout.staff')

@section('title', 'Ubah Jadwal Dokter')

@section('content')

<div class="container-fluid">
    <div class="row">

        @include('layout.sidebardokter')

        <div class="col-md-10 p-4 bg-light min-vh-100">

            @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
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

                    <h5 class="fw-semibold mb-3">
                        <i class="bi bi-calendar-week me-1"></i>
                        Kelola Jadwal Praktik
                    </h5>

                    <form action="{{ route('dokter.updateJadwal') }}" method="POST">
                        @csrf

                        @php
                            $rows = $dokter->jadwalDokter;
                        @endphp

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:20%">Hari</th>
                                        <th style="width:15%" class="text-center">Kerja</th>
                                        <th style="width:30%">Jam Mulai</th>
                                        <th style="width:30%">Jam Selesai</th>
                                        <th style="width:5%"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ($rows as $jadwal)
                                    @php
                                        $key = $jadwal->indexJadwal;
                                        $rowKey = "jadwal.$key";
                                        $jb = $jadwal->jamMulai ? Carbon::parse($jadwal->jamMulai) : null;
                                        $jt = $jadwal->jamSelesai ? Carbon::parse($jadwal->jamSelesai) : null;
                                        $isBuka = old("$rowKey.buka", $jadwal->kerja) ? 1 : 0;
                                    @endphp

                                    <tr>
                                        <td class="fw-semibold">{{ $jadwal->namaHari }}</td>

                                        <td class="text-center">
                                            <input type="hidden" name="jadwal[{{ $key }}][buka]" value="0">
                                            <input class="form-check-input" type="checkbox" name="jadwal[{{ $key }}][buka]" value="1"
                                                   {{ $isBuka ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            <div class="input-group">
                                                <input type="number" name="jadwal[{{ $key }}][jamBukaJam]" value="{{ old("$rowKey.jamBukaJam", $jb ? $jb->format('H') : '08') }}" min="0" max="23" class="form-control text-center">
                                                <span class="input-group-text">:</span>
                                                <input type="number" name="jadwal[{{ $key }}][jamBukaMenit]" value="{{ old("$rowKey.jamBukaMenit", $jb ? $jb->format('i') : '00') }}" min="0" max="59" class="form-control text-center">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group">
                                                <input type="number"
                                                       name="jadwal[{{ $key }}][jamTutupJam]"
                                                       value="{{ old("$rowKey.jamTutupJam", $jt ? $jt->format('H') : '16') }}"
                                                       min="0" max="23"
                                                       class="form-control text-center">
                                                <span class="input-group-text">:</span>
                                                <input type="number" name="jadwal[{{ $key }}][jamTutupMenit]" value="{{ old("$rowKey.jamTutupMenit", $jt ? $jt->format('i') : '00') }}" min="0" max="59" class="form-control text-center">
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <span class="badge {{ $isBuka ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $isBuka ? 'Kerja' : 'Libur' }}
                                            </span>
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

{{-- Biar alert success hilang after 3 detik --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 3000); // 3 detik
        }
    });
</script>


@endsection
