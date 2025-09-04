<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola DICOM</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    {{-- Saya tidak tahu ini taruh dimana, ganti aja tempatnya kalo mau --}}
    @vite('resources/js/inline-edit.js')
</head>

<a href='kelolajenispemeriksaan'> Jenis Pemeriksaan </a>
<a href='kelolamodalitas'> Modalitas </a>
<a href='keloladicom'> DICOM </a>

<div class="col-md-2">
    <a href="{{ route('petugas.tambahdicompage') }}" class="btn btn-primary w-100">
        <i class="bi bi-plus"></i> Tambah DICOM
    </a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Alamat IP</th><th>Net Mask</th><th>Layanan DICOM</th><th>Peran</th><th>AET</th><th>Port</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($petugas->rumahSakit->dicom as $dicom)
        <tr id="row-{{ $dicom->id }}">
            <td>
                <span data-name="modalitasId" class="view-field">{{ $dicom->modalitas->alamatIP }}</span>
                <select name="modalitasId" class="form-control edit-field d-none">
                    @foreach($petugas->rumahSakit->modalitas as $modalitas)
                        <option value="{{ $modalitas->id }}" {{ $modalitas->id == $dicom->modalitas->id ? 'selected' : '' }}> 
                            {{ $modalitas->alamatIP }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <span data-name="netMask" class="view-field">{{ $dicom->netMask }}</span>
                <input type="text" name="netMask" class="form-control edit-field d-none" value="{{ $dicom->netMask }}">
            </td>
            <td>
                <span data-name="layananDicom" class="view-field">{{ $dicom->layananDicom }}</span>
                <input type="text" name="layananDicom" class="form-control edit-field d-none" value="{{ $dicom->layananDicom }}">
            </td>
            <td>
                <span data-name="peran" class="view-field">{{ $dicom->peran }}</span>
                <input type="text" name="peran" class="form-control edit-field d-none" value="{{ $dicom->peran }}">
            </td>
            <td>
                <span data-name="AET" class="view-field">{{ $dicom->AET }}</span>
                <input type="text" name="AET" class="form-control edit-field d-none" value="{{ $dicom->AET }}">
            </td>
            <td>
                <span data-name="port" class="view-field">{{ $dicom->port }}</span>
                <input type="text" name="port" class="form-control edit-field d-none" value="{{ $dicom->port }}">
            </td>

            <td>
                <button class="btn btn-sm btn-primary edit-btn" data-route="{{ route('petugas.editDicom', $dicom->id) }}" data-id="{{ $dicom->id }}">Edit</button>
                <button class="btn btn-sm btn-success save-btn d-none" data-route="{{ route('petugas.editDicom', $dicom->id) }}" data-id="{{ $dicom->id }}">Save</button>
                <form action="{{ route('petugas.hapusDicom', $dicom->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus dicom ini?');">
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