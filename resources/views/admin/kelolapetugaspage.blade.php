<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Petugas Page</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
</head>

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

{{-- Buat class dll nya w masih copas punya gemini, nanti ubah" aja kalo mau --}}
<div>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari petugas..." value="{{ request('search') }}">
        <button type="submit">Cari</button>
    </form>
    <a href="{{ route('admin.tambahakunpetugaspage') }}" class="btn btn-primary">
        Tambah Akun
    </a>
    <div class="row">
        @foreach ($petugass as $ptg)
            <div class="col-12 col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $ptg->user->name }}</h5>
                        <p class="card-text">{{ $ptg->user->email }}</p>
                        <form action="{{ route('admin.hapusAkunPetugas', $ptg->user->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>