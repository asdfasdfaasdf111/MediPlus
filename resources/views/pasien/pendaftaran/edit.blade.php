@extends('layout.app')
@section('title', 'Edit Data Pasien')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h2 class="fw-bold mb-0">Edit Data Pasien</h2>
          <small class="text-muted">{{ $pasien->namaLengkap }}</small>
        </div>
        <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
      </div>

      @include('pasien.pendaftaran._form', ['pasien' => $pasien])
    </div>
  </div>
</div>
@endsection
