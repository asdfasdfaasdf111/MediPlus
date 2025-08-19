<a href='kelolajenispemeriksaan'> Jenis Pemeriksaan </a>
<a href='kelolamodalitas'> Modalitas </a>
<a href='keloladicom'> DICOM </a>

<div class="col-md-2">
    <a href="{{ route('petugas.tambahjenispemeriksaanpage') }}" class="btn btn-primary w-100">
        <i class="bi bi-plus"></i> Tambah Jenis Pemeriksaan
    </a>
</div>

<div class="row">
    @foreach ($petugas->rumahSakit->jenisPemeriksaan as $jenisPemeriksaan)
        <div>
            {{ $jenisPemeriksaan->modalitas->namaModalitas }} {{ $jenisPemeriksaan->namaJenisPemeriksaan }}, {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}
            <form action="{{ route('petugas.hapusJenisPemeriksaan', $jenisPemeriksaan->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus jenis pemeriksaan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    @endforeach
</div>