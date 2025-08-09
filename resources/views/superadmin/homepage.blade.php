<form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
<form action="{{ route('superadmin.addnew') }}" method="GET">
    <button type="submit" class="btn btn-primary">+ Tambah RS Baru</button>
</form>
@if($rumahSakit->isEmpty())
    <p>Belum ada Rumah Sakit yang terdaftar</p>
@else
    @foreach($rumahSakit as $rs)
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src=".../100px180/?text=Gambar RS" alt="Gambar RS">
            <div class="card-body">
                <h3>{{ $rs->nama }}</h3>
                <p class="">{{ $rs->alamat }}</p>
                <p class="">{{ $rs->noTelepon }}</p>
                <a href="{{ route('superadmin.edit', $rs->id) }}" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
    @endforeach
@endif
