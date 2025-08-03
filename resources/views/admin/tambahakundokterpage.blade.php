<a href="{{ route('admin.homepage')}}">
    Homepage
</a>

<a href="{{ route('admin.keloladokterpage')}}">
    Kelola Dokter
</a>

<a href="{{ route('admin.kelolapetugaspage')}}">
    Kelola Petugas
</a>

<a href="{{ route('admin.kelolajadwalpage')}}">
    Kelola Jadwal
</a>

<a href="{{ route('admin.logaktivitaspage')}}">
    Log Aktivitas
</a>

<form method="POST" action="{{ route('admin.tambahAkunDokter') }}">
    @csrf

    {{-- Sebagian besar copas dari yg register, kalo ad yg aneh ganti aj --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               name="name" id="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="spesialis" class="form-label">Spesialis</label>
        <input type="text" class="form-control @error('spesialis') is-invalid @enderror" 
               name="spesialis" id="spesialis" value="{{ old('spesialis') }}" required>
        @error('spesialis')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               name="email" id="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               name="password" id="password" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" 
               name="password_confirmation" id="password_confirmation" required>
    </div>

    <a href="{{ route('admin.keloladokterpage') }}">
        Kembali
    </a>
    <button type="submit" class="btn btn-primary w-100">Daftar</button>
</form>