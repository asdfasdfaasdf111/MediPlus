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
            'CT-Scan Kepala Non Kontras (Stroke)' =>
                'CT scan kepala non kontras menunjukkan area hipodens pada regio ganglia basalis dan kapsula interna kanan yang mengarah ke infark iskemik. Tidak tampak perdarahan intrakranial. Sistem ventrikel simetris dan tidak melebar. Garis tengah tetap di posisi normal.',
            
            'MRI Otak Tanpa dan Dengan Kontras' =>
                'Pemeriksaan MRI otak dilakukan dengan sekuens T1, T2, FLAIR, dan DWI. Tampak struktur hemisfer serebri, serebelum, dan batang otak dalam batas normal. Tidak tampak lesi fokal, perdarahan, maupun restriksi difusi. Sistem ventrikel dan sulkus tampak normal.',
            'CT Abdomen dan Pelvis dengan Kontras' =>
                'CT scan abdomen dan pelvis dengan kontras intravena menunjukkan hati, limpa, pankreas, dan ginjal dalam batas normal. Tidak tampak massa, pembesaran organ, free fluid, maupun free air intraabdomen. Vesika urinaria terdistensi baik.',
            'MRI Pelvis' =>
                'MRI pelvis menunjukkan organ-organ pelvis dalam batas normal. Kandung kemih tampak terisi baik tanpa massa intraluminal. Tidak tampak limfadenopati pelvis maupun kelainan jaringan lunak sekitar.',
            'USG Abdomen Atas' =>
                'Pemeriksaan ultrasonografi abdomen atas menunjukkan hati berukuran normal dengan parenkim homogen. Kandung empedu tanpa batu. Ginjal kanan dan kiri dalam batas normal tanpa hidronefrosis.',
            'MRI Spine Lumbal' =>
                'MRI lumbal potongan sagittal dan axial menunjukkan diskus intervertebralis dalam batas normal. Tidak tampak herniasi diskus maupun stenosis kanalis spinalis. Medulla spinalis tampak normal.'
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
