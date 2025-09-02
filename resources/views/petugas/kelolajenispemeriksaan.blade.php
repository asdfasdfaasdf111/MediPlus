<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Jenis Pemeriksaan</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    {{-- Saya tidak tahu ini taruh dimana, ganti aja tempatnya kalo mau --}}
    @vite('resources/js/inline-edit.js')
</head>

<a href='kelolajenispemeriksaan'> Jenis Pemeriksaan </a>
<a href='kelolamodalitas'> Modalitas </a>
<a href='keloladicom'> DICOM </a>

<div class="col-md-2">
    <a href="{{ route('petugas.tambahjenispemeriksaanpage') }}" class="btn btn-primary w-100">
        <i class="bi bi-plus"></i> Tambah Jenis Pemeriksaan
    </a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Modalitas</th><th>Nama Jenis Pemeriksaan </th><th>Nama Pemeriksaan Spesifik </th><th>Kelompok Jenis Pemeriksaan </th><th>Memakai Kontras </th><th>Lama Pemeriksaan</th><th>Perlu Didampingi Dokter</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($petugas->rumahSakit->jenisPemeriksaan as $jenisPemeriksaan)
        <tr id="row-{{ $jenisPemeriksaan->id }}">
            <td>
                <span data-name="modalitasId" class="view-field">{{ $jenisPemeriksaan->modalitas->namaModalitas }}</span>
                <select name="modalitasId" class="form-control edit-field d-none">
                    @foreach($petugas->rumahSakit->modalitas as $modalitas)
                        <option value="{{ $modalitas->id }}" {{ $modalitas->id == $jenisPemeriksaan->modalitas->id ? 'selected' : '' }}> 
                            {{ $modalitas->namaModalitas }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <span data-name="namaJenisPemeriksaan" class="view-field">{{ $jenisPemeriksaan->namaJenisPemeriksaan }}</span>
                <input type="text" name="namaJenisPemeriksaan" class="form-control edit-field d-none" value="{{ $jenisPemeriksaan->namaJenisPemeriksaan }}">
            </td>
            <td>
                <span data-name="namaPemeriksaanSpesifik" class="view-field">{{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}</span>
                <input type="text" name="namaPemeriksaanSpesifik" class="form-control edit-field d-none" value="{{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}">
            </td>
            <td>
                <span data-name="kelompokJenisPemeriksaan" class="view-field">{{ $jenisPemeriksaan->kelompokJenisPemeriksaan }}</span>
                <input type="text" name="kelompokJenisPemeriksaan" class="form-control edit-field d-none" value="{{ $jenisPemeriksaan->kelompokJenisPemeriksaan }}">
            </td>
            <td>
                <span data-type="checkbox" data-name="pemakaianKontras" class="view-field">{{ ($jenisPemeriksaan->pemakaianKontras) ? "Ya" : "Tidak" }}</span>
                <input type="checkbox" name="pemakaianKontras" class="edit-field d-none" value="1" {{ ($jenisPemeriksaan->pemakaianKontras) ? 'checked' : '' }}>
            </td>

            <td>
                <span data-name="lamaPemeriksaan" class="view-field">{{ $jenisPemeriksaan->lamaPemeriksaan }}</span>
                <input type="number" name="lamaPemeriksaan" min="1" class="w-16 border p-1 text-center edit-field d-none" value="{{ $jenisPemeriksaan->lamaPemeriksaan }}">
                <span> Menit</span>
            </td>

            <td>
                <span data-type="checkbox" data-name="diDampingiDokter" class="view-field">{{ ($jenisPemeriksaan->diDampingiDokter) ? "Ya" : "Tidak" }}</span>
                <input type="checkbox" name="diDampingiDokter" class="edit-field d-none" value="1" {{ ($jenisPemeriksaan->diDampingiDokter) ? 'checked' : '' }}>
            </td>

            <td>
                <button class="btn btn-sm btn-primary edit-btn" data-route="{{ route('petugas.editJenisPemeriksaan', $jenisPemeriksaan->id) }}" data-id="{{ $jenisPemeriksaan->id }}">Edit</button>
                <button class="btn btn-sm btn-success save-btn d-none" data-route="{{ route('petugas.editJenisPemeriksaan', $jenisPemeriksaan->id) }}" data-id="{{ $jenisPemeriksaan->id }}">Save</button>
                <form action="{{ route('petugas.hapusJenisPemeriksaan', $jenisPemeriksaan->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus jenis pemeriksaan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>