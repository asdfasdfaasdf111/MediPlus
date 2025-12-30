<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HasilLaporanDiterima extends Notification
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
            ->subject('Hasil Laporan Diterima')
            ->line('Pemeriksaan anda dengan detil:')
            ->line('Nama Pasien: ' . $dataPasien->namaLengkap)
            ->line('Rumah Sakit: ' . $rumahSakit->nama)
            ->line('Nama Jenis Pemeriksaan: ' . $jenisPemeriksaan->namaJenisPemeriksaan)
            ->line('Tanggal Pemeriksaan: ' . $dataPemeriksaan->tanggalPemeriksaan)
            ->line('Rentang Waktu: '.$jamMulai.' - '.$jamAkhir)
            ->line('Sudah terdapat hasil pemeriksaan yang dapat diakses di website');
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