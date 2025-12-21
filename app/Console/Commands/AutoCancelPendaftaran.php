<?php

namespace App\Console\Commands;

use App\Models\DataPemeriksaan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCancelPendaftaran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-cancel-pendaftaran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel Pendaftaran yang udah lewat jadwal(pending/menunggu registrasi ulang)';

    public function handle()
    {
        $semuaData = DataPemeriksaan::with('jenisPemeriksaan')
                        ->where('statusUtama', 'Pending')
                        ->whereDate('tanggalPemeriksaan', '<=', today())
                        ->get();
        foreach ($semuaData as $data){
            $waktuSelesai = Carbon::parse($data->tanggalPemeriksaan . ' ' . $data->rentangWaktuKedatangan)->copy()
            ->addHours($data->jenisPemeriksaan->getJump());

            if ($waktuSelesai->lte(Carbon::now())) {
                $data->cancelPendaftaran('Pendaftaran dibatalkan karena tidak terdapat balasan dari petugas rumah sakit', 'Pendaftaran Dibatalkan');
            }
        }

        $bufferAutoCancel = config('pendaftaran.regis_ulang_auto_cancel');
        $semuaData = DataPemeriksaan::with('jenisPemeriksaan')
                        ->where('statusPasien', 'Menunggu Registrasi Ulang')
                        ->get()
                        ->filter(function ($item) use ($bufferAutoCancel) {
                            $scheduled = Carbon::parse($item->tanggalPemeriksaan . ' ' . $item->rentangWaktuKedatangan);

                            return Carbon::now()->diffInHours($scheduled, false) <= -$bufferAutoCancel;
                        });
        foreach ($semuaData as $data){
            $data->cancelPendaftaran('Pendaftaran dibatalkan karena pasien tidak datang untuk registrasi ulang', 'Pendaftaran Dibatalkan');
        }
    }
}
