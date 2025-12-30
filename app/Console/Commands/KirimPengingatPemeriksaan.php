<?php

namespace App\Console\Commands;

use App\Models\DataPemeriksaan;
use App\Notifications\PengingatPemeriksaan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KirimPengingatPemeriksaan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pengingat-pemeriksaan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim reminder kalo pemeriksaan udah dekat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $delayPengingat = config('notifikasi.delay_pengingat');

        $semuaData = DataPemeriksaan::where('pengingatTerkirim', false)
                ->whereDate('tanggalPemeriksaan', '<=', today()->addDay())
                ->where('statusUtama', 'Berlangsung')
                ->get()
                ->filter(function ($item) use ($delayPengingat) {
                    $scheduled = Carbon::parse($item->tanggalPemeriksaan . ' ' . $item->rentangWaktuKedatangan);

                    return Carbon::now()->diffInHours($scheduled, false) <= $delayPengingat;
                });
        foreach ($semuaData as $data){
            $user = $data->masterPasien->user;
            $user->notify(new PengingatPemeriksaan($data));
        }
    }
}