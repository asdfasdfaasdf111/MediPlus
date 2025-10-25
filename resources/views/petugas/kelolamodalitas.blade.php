<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Modalitas</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    {{-- Saya tidak tahu ini taruh dimana, ganti aja tempatnya kalo mau --}}
    @vite('resources/js/inline-edit.js')
</head>

<a href="{{ route('petugas.homepage') }}"> Homepage </a>
<a href="{{ route('petugas.kelolajenispemeriksaan') }}"> Jenis Pemeriksaan </a>
<a href="{{ route('petugas.kelolamodalitas') }}"> Modalitas </a>

<div class="col-md-10 p-4 bg-light">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="flex-grow-1 me-3">
            <form action="" method="GET"> 
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari Modalitas">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-2">
            <a href="{{ route('petugas.tambahmodalitaspage') }}" class="btn btn-primary w-100">
                <i class="bi bi-plus"></i> Tambah Modalitas
            </a>
        </div>
    </div>

<table class="table">
    <thead>
        <tr>
            <th>Nama Modalitas</th><th>Jenis Modalitas</th><th>Kode Ruang</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modalitass as $modalitas)
        <tr id="row-{{ $modalitas->id }}">
            <td>
                <span data-name="namaModalitas" class="view-field">{{ $modalitas->namaModalitas }}</span>
                <input type="text" name="namaModalitas" class="form-control edit-field d-none" value="{{ $modalitas->namaModalitas }}">
            </td>
            <td>
                <span data-name="jenisModalitas" class="view-field">{{ $modalitas->jenisModalitas }}</span>
                <input type="text" name="jenisModalitas" class="form-control edit-field d-none" value="{{ $modalitas->jenisModalitas }}">
            </td>
            <td>
                <span data-name="kodeRuang" class="view-field">{{ $modalitas->kodeRuang }}</span>
                <input type="text" name="kodeRuang" class="form-control edit-field d-none" value="{{ $modalitas->kodeRuang }}">
            </td>

            <td>
                <button class="btn btn-sm btn-primary edit-btn" data-route="{{ route('petugas.editModalitas', $modalitas->id) }}" data-id="{{ $modalitas->id }}">Edit</button>
                <button class="btn btn-sm btn-success save-btn d-none" data-route="{{ route('petugas.editModalitas', $modalitas->id) }}" data-id="{{ $modalitas->id }}">Save</button>
                <form action="{{ route('petugas.hapusModalitas', $modalitas->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus modalitas ini? Semua data yang terhubung dengan modalitas ini akan terhapus');">
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