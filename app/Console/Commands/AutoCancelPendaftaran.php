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
                        ->whereDate('tanggalPemeriksaan', today())
                        ->where('rentangWaktuKedatangan', '<', Carbon::now())
                        ->get();
        foreach ($semuaData as $data){
            $waktuSelesai = Carbon::parse($data->rentangWaktuKedatangan)->copy()
                                ->addHours($data->jenisPemeriksaan->getJump());
            Log::info('User data', ['user' => $waktuSelesai]);
            if ($waktuSelesai->lte(Carbon::now())) {
                $data->cancelPendaftaran('Pendaftaran dibatalkan karena tidak terdapat balasan dari petugas rumah sakit', 'Pendaftaran Dibatalkan');
            }
        }
    }
}
