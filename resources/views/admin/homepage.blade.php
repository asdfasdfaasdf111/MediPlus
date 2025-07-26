<div>
    Jumlah Dokter: {{ $admin->rumahsakit->jumlahDokter()}}
</div>

<div>
    Jumlah Petugas: {{ $admin->rumahsakit->jumlahPetugas()}}
</div>

<div>
    Jadwal: 
    <div>Jam Buka: {{$admin->rumahsakit->jamBuka}}</div>
    <div>Jam Tutup: {{$admin->rumahsakit->jamTutup}}</div>
</div>

<div>
    log terbaru: 
    <ul>
        @foreach ($admin->rumahsakit->logTerbaru as $log)
            <li>{{$log}}</li>
        @endforeach
    </ul>
</div>

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