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

<div>
    Log Aktivitas: 
    <ul>
        @foreach ($admin->rumahsakit->log as $log)
            <li>{{$log}}</li>
        @endforeach
    </ul>
</div>

