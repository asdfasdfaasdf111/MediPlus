{{-- @extends('layout.app')
@section('title', 'Tambah Data Pasien')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h3 class="fw-bold mb-0">Tambah Data Pasien</h3>
          <small class="text-muted">Isi data pasien yang akan didaftarkan.</small>
        </div>
        <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
      </div>

      @include('pasien.pendaftaran.form')
    </div>
  </div>
</div>
@endsection --}}

@extends('layout.app')
@section('title', 'Tambah Data Pasien')

@section('content')
<div class="bg-light min-vh-100 py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 col-xl-7">
        <div class="bg-white rounded shadow-sm p-4 p-md-5">

          <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
              <h3 class="fw-bold mb-0" style="color:#173B7A;">Tambah Data Pasien</h3>
              <small class="text-muted">
                Isi data pasien yang akan didaftarkan.
              </small>
            </div>
            <a href="{{ route('pasien.pendaftaran') }}"
               class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
          </div>

          @include('pasien.pendaftaran.form')

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
