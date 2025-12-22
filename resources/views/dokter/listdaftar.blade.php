@extends('layout.staff')

@section('title', 'List Draft Laporan')

@section('content')

<div class="container-fluid">
    <div class="row">

        @include('layout.sidebardokter')

        <div class="col-md-10 bg-light min-vh-100 px-4 pt-4">

                @if (session('success'))
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

            <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
            


                <form action="{{ route('dokter.listdaftar') }}" method="GET" class="flex-grow-1">
                    <div class="input-group">
                        <input type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Cari Draft">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>


                <form action="{{ route('dokter.addnew') }}" method="GET">
                    <button type="submit"
                        class="btn btn-primary fw-semibold px-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus"></i>
                        Tambah Draft Baru
                    </button>
                </form>
            </div>

            @if($drafts->isEmpty())
                <p class="text-muted text-center py-4 mb-0">
                    Tidak ada data.
                </p>
            @else
                @foreach($drafts as $draft)
                    <div class="card border-0 shadow-sm mb-3 draft-item">
                        <div class="card-body">

                            <strong class="d-block mb-1">
                                {{ $draft->judul }}
                            </strong>

                            <hr class="my-2">

                            <p class="mb-3 text-break"
                               style="max-height:200px; overflow:auto; ">
                                {{ $draft->deskripsi }}
                            </p>

                            <div class="d-flex justify-content-end gap-2">

                                <form action="{{ route('dokter.edit', $draft) }}" method="GET">
                                    <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-2">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </button>
                                </form>

                                <form action="{{ route('dokter.delete', $draft->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                                        <i class="bi bi-trash"></i>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                @if(method_exists($drafts, 'links') && $drafts->hasPages())
                <div class="mt-4 d-flex justify-content-end">
                    {{ $drafts->onEachSide(1)->links() }}
                </div>
                @endif


            @endif

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 3000);
        }
    });
</script>


@endsection

{{-- hapus JS search list draft karna kalau JS itu misalnya search "MRI" tapi ternyata ada di page 2, dia ga ke search --}}
