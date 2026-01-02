<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class PengingatPemeriksaan extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $dataPemeriksaan)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $dataPemeriksaan = $this->dataPemeriksaan;
        $rumahSakit = $dataPemeriksaan->rumahSakit;
        $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
        $dataPasien = $dataPemeriksaan->dataPasien;
        $jamMulai = Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H : i');
        $jump = $jenisPemeriksaan->getJump();
        $jamAkhir = Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour($jump)->format('H : i');
        $dataPemeriksaan->pengingatTerkirim = true;
        $dataPemeriksaan->save();
        return (new MailMessage)
            ->subject('Pengingat Jadwal Pemeriksaan Radiologi - ' . $dataPasien->namaLengkap)
            ->greeting('Yth. Bapak/Ibu ' . $notifiable->name . ',')
            ->line('Melalui email ini, kami ingin mengingatkan kembali mengenai jadwal pemeriksaan Anda.')

            ->line('Berikut adalah rincian pemeriksaan terkait:')
            ->line('**Rincian Jadwal:**')
            ->line('• **Nama Pasien:** ' . $dataPasien->namaLengkap)
            ->line('• **Rumah Sakit:** ' . $rumahSakit->nama)
            ->line('• **Jenis Pemeriksaan:** ' . $jenisPemeriksaan->namaJenisPemeriksaan)
            ->line('• **Tanggal Pemeriksaan:** ' . $dataPemeriksaan->tanggalPemeriksaan)
            ->line('• **Waktu Kedatangan:** ' . $jamMulai . ' - ' . $jamAkhir)
            
            ->line('Kami menyarankan Anda tiba tepat waktu sesuai rentang waktu kedatangan untuk keperluan registrasi ulang.')


            ->line('Terima kasih atas kepercayaan Anda terhadap layanan kesehatan kami.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}