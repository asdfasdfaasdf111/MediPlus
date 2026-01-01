<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranDiterima extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject('Konfirmasi Pendaftaran Layanan Radiologi - ' . $dataPasien->namaLengkap)
            ->greeting('Yth. Bapak/Ibu ' . $notifiable->name . ',')
            ->line('Terima kasih telah melakukan pendaftaran layanan radiologi melalui sistem kami.')
            ->line('Kami menginformasikan bahwa pendaftaran Anda telah diterima dengan rincian sebagai berikut:')
            

            ->line('**Rincian Pemeriksaan:**')
            ->line('• **Nama Pasien:** ' . $dataPasien->namaLengkap)
            ->line('• **Rumah Sakit:** ' . $rumahSakit->nama)
            ->line('• **Jenis Pemeriksaan:** ' . $jenisPemeriksaan->namaJenisPemeriksaan)
            ->line('• **Tanggal Pemeriksaan:** ' . $dataPemeriksaan->tanggalPemeriksaan)
            ->line('• **Waktu Kedatangan:** ' . $jamMulai . ' - ' . $jamAkhir)
            
            ->line('Untuk melanjutkan proses administrasi dan mengamankan nomor antrean Anda, mohon segera melakukan penyelesaian pembayaran melalui website Mediplus.')
            
           
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