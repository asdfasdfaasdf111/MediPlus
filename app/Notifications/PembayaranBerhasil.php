<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PembayaranBerhasil extends Notification implements ShouldQueue
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
        $pembayaran = $dataPemeriksaan->pembayaran;
        return (new MailMessage)
            ->subject('Konfirmasi Pembayaran Berhasil - ' . $dataPasien->namaLengkap)
            ->greeting('Yth. Bapak/Ibu ' . $notifiable->name . ',')
            ->line('Pembayaran pendaftaran pemeriksaan Anda telah berhasil. Saat ini Anda telah terdaftar dalam antrian.')
            ->line('Kami menginformasikan bahwa pendaftaran Anda telah diterima dengan rincian sebagai berikut:')
            
            ->line('Berikut adalah rincian pemeriksaan terkait:')
            ->line('**Rincian Pembayaran:**')
            ->line('• **Nama Pasien:** ' . $dataPasien->namaLengkap)
            ->line('• **Rumah Sakit:** ' . $rumahSakit->nama)
            ->line('• **Jenis Pemeriksaan:** ' . $jenisPemeriksaan->namaJenisPemeriksaan)
            ->line('• **Tanggal Pemeriksaan:** ' . $dataPemeriksaan->tanggalPemeriksaan)
            ->line('• **Waktu Kedatangan:** ' . $jamMulai . ' - ' . $jamAkhir)
            ->line('• **Total Pembayaran:** Rp ' . number_format($pembayaran->harga, 0, ',', '.'))

            ->line('Mohon hadir sesuai dengan waktu kedatangan yang telah ditentukan.')


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