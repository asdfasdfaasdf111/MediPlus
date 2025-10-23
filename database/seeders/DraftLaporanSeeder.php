<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\RumahSakit;
use App\Models\DraftLaporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DraftLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahsakit = RumahSakit::first();
        $dokter = $rumahsakit->dokter->first();

        $drafts = [
            'MRI Otak dengan Kontras' =>
                'Pemeriksaan MRI otak dilakukan dengan teknik T1, T2, FLAIR, dan DWI. Tampak struktur hemisfer serebri, serebelum, dan batang otak dalam batas normal. Tidak tampak lesi fokal, perdarahan, atau edema. Ventricular system simetris dan tidak melebar.',

            'CT Abdomen dan Pelvis' =>
                'CT scan abdomen dan pelvis dilakukan dengan kontras intravena. Tampak hati, ginjal, pankreas, dan limpa dalam batas normal. Tidak tampak massa atau pembesaran organ. Tidak tampak free fluid maupun free air dalam rongga abdomen.',

            'Rontgen Thorax PA' =>
                'Foto thorax proyeksi PA memperlihatkan paru-paru tampak bersih, tidak tampak infiltrat, efusi pleura, atau kelainan kardiomegali. Diafragma tampak normal. Trakea di posisi sentral.',

            'USG Abdomen Atas' =>
                'Pemeriksaan ultrasonografi abdomen atas menunjukkan hati berukuran normal, homogen, tanpa massa. Kandung empedu tampak normal tanpa batu. Ginjal kanan dan kiri tampak normal dalam ukuran dan echogenicity.',

            'MRI Spine Lumbal' =>
                'MRI lumbal dilakukan dengan potongan sagittal dan axial. Tampak diskus intervertebralis dalam batas normal. Tidak tampak herniasi diskus atau stenosis kanal. Medulla spinalis tampak normal tanpa kelainan signal.'
        ];

        foreach ($drafts as $judul => $deskripsi) {
            DraftLaporan::create([
                'dokter_id' => $dokter->id,
                'judul' => $judul,
                'deskripsi' =>$deskripsi
            ]);
        }
    }
}
