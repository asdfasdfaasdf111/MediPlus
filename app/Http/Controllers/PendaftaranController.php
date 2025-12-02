<?php

namespace App\Http\Controllers;

use App\Models\DataPasien;
use App\Models\DataPemeriksaan;
use App\Models\JenisPemeriksaan;
use App\Models\MasterPasien;
use App\Models\RumahSakit;
use App\Models\JadwalRumahSakit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    private const HUBUNGAN_OPTS        = ['Diri Sendiri', 'Orang Tua', 'Saudara', 'Pasangan', 'Anak', 'Lainnya'];
    private const GOLONGAN_DARAH_OPTS  = ['A', 'B', 'AB', 'O', 'Tidak Tahu'];
    private const JENIS_IDENTITAS_OPTS = ['KTP', 'SIM', 'PASPOR'];
    private const JENIS_KELAMIN_OPTS   = ['Laki-laki', 'Perempuan'];


   public function index(Request $request)
    {
        $user   = $request->user();
        $master = $user->masterPasien ?: MasterPasien::create(['user_id' => $user->id]);

        $dataPasiens = $master->dataPasien()->latest()->get();

        $pemeriksaanBerlangsung = DataPemeriksaan::with(['dataPasien','dokter','jenisPemeriksaan'])
            ->whereHas('dataPasien', fn ($q) => $q->where('master_pasien_id', $master->id))
            ->ordered('statusPasien')
            ->paginate(5);

        return view('pasien.pendaftaran.index', compact('dataPasiens','pemeriksaanBerlangsung'));
    }

    public function createDataPasien()
    {
        return view('pasien.pendaftaran.create', [
            'hubunganOpts'       => self::HUBUNGAN_OPTS,
            'golonganDarahOpts'  => self::GOLONGAN_DARAH_OPTS,
            'jenisIdentitasOpts' => self::JENIS_IDENTITAS_OPTS,
            'jenisKelaminOpts'   => self::JENIS_KELAMIN_OPTS,
        ]);
    }

    public function storeDataPasien(Request $request)
    {
        $validated = $request->validate(
            [
                'namaLengkap'       => 'required|string|max:150',
                'hubunganKeluarga'  => 'required|in:' . implode(',', self::HUBUNGAN_OPTS),
                'alamatDomisili'    => 'required|string|max:255',
                'tanggalLahir'      => 'required|date',
                'noIdentitas'       => 'required|string|max:50',
                'jenisIdentitas'    => 'required|in:' . implode(',', self::JENIS_IDENTITAS_OPTS),
                'jenisKelamin'      => 'required|in:' . implode(',', self::JENIS_KELAMIN_OPTS),
                'noHP'              => 'required|string|max:30',
                'alergi'            => 'nullable|string|max:255',
                'golonganDarah'     => 'required|in:' . implode(',', self::GOLONGAN_DARAH_OPTS),
            ],
            [],
            [
                'namaLengkap'      => 'nama lengkap',
                'hubunganKeluarga' => 'hubungan dengan pasien',
                'noHP'             => 'nomor HP',
                'noIdentitas'      => 'nomor identitas',
            ]
        );


        $validated['namaLengkap'] = mb_strtoupper($validated['namaLengkap'], 'UTF-8');

        $user   = $request->user();
        $master = $user->masterPasien ?: MasterPasien::create(['user_id' => $user->id]);
        $validated['master_pasien_id'] = $master->id;

        $validated['alergi'] = $validated['alergi'] ?? '';

        DataPasien::create($validated);

        return redirect()->route('pasien.pendaftaran')->with('success', 'Data pasien berhasil ditambahkan!');
    }

    private function ensureOwned(DataPasien $pasien, Request $request): void
    {
        $master = $request->user()->masterPasien;
        abort_if(!$master || $pasien->master_pasien_id !== $master->id, 403);
    }

    public function editDataPasien(Request $request, DataPasien $pasien)
    {
        $this->ensureOwned($pasien, $request);

        return view('pasien.pendaftaran.edit', [
            'pasien'              => $pasien,
            'hubunganOpts'        => self::HUBUNGAN_OPTS,
            'jenisIdentitasOpts'  => self::JENIS_IDENTITAS_OPTS,
            'jenisKelaminOpts'    => self::JENIS_KELAMIN_OPTS,
            'golonganDarahOpts'   => self::GOLONGAN_DARAH_OPTS,
        ]);
    }

    public function updateDataPasien(Request $request, DataPasien $pasien)
    {
        $this->ensureOwned($pasien, $request);

        $validated = $request->validate(
            [
                'namaLengkap'       => 'required|string|max:150',
                'hubunganKeluarga'  => 'required|in:' . implode(',', self::HUBUNGAN_OPTS),
                'alamatDomisili'    => 'required|string|max:255',
                'tanggalLahir'      => 'required|date',
                'noIdentitas'       => 'required|string|max:50',
                'jenisIdentitas'    => 'required|in:' . implode(',', self::JENIS_IDENTITAS_OPTS),
                'jenisKelamin'      => 'required|in:' . implode(',', self::JENIS_KELAMIN_OPTS),
                'noHP'              => 'required|string|max:30',
                'alergi'            => 'nullable|string|max:255',
                'golonganDarah'     => 'required|in:' . implode(',', self::GOLONGAN_DARAH_OPTS),
            ],
            [],
            [
                'namaLengkap'      => 'nama lengkap',
                'hubunganKeluarga' => 'hubungan dengan pasien',
                'noHP'             => 'nomor HP',
                'noIdentitas'      => 'nomor identitas',
            ]
        );

        $validated['namaLengkap'] = mb_strtoupper($validated['namaLengkap'], 'UTF-8');
        $validated['alergi'] = $validated['alergi'] ?? '';
        $pasien->update($validated);

        return redirect()->route('pasien.pendaftaran')->with('success', 'Data pasien berhasil diperbarui!');
    }
}