<?php

namespace App\Http\Controllers;

use App\Models\DataPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user   = auth('web')->user();
        $master = $user->masterPasien()->firstOrCreate([]);   // pastikan master ada
        $pasien = $master->dataPasien()->first();             // ambil data pasien utama (jika ada)

        return view('pasien.profile.edit', compact('user', 'pasien'));
    }

    public function update(Request $request)
    {
        $user = auth('web')->user();

        // No. HP (buang non-digit, +62 -> 0)
        if ($request->has('noHP')) {
            $hp = preg_replace('/\D+/', '', $request->noHP ?? '');
            if (str_starts_with($hp, '62')) {
                $hp = '0' . substr($hp, 2);
            }
            $request->merge(['noHP' => $hp]);
        }

        $jenis = strtoupper($request->input('jenisIdentitas', ''));
        $noId  = (string) $request->input('noIdentitas', '');

        // Bersihkan nomor identitas sesuai jenis 
        if ($jenis === 'KTP' || $jenis === 'SIM') {
            $noId = preg_replace('/\D+/', '', $noId);          
        } elseif ($jenis === 'PASPOR') {
            $noId = preg_replace('/[^A-Z0-9]+/i', '', strtoupper($noId)); 
        }
        $request->merge([
            'jenisIdentitas' => $jenis,
            'noIdentitas'    => $noId,
        ]);


        $rules = [
            // users
            'name'     => ['required','string','max:100'],
            'email'    => ['required','email','unique:users,email,' . $user->id],
            'password' => ['nullable','min:6','confirmed'],

            // data_pasiens
            'alamatDomisili' => ['required','string','max:255'],
            'tanggalLahir'   => ['required','date'],
            'jenisIdentitas' => ['required','in:KTP,SIM,PASPOR'],
            'jenisKelamin'   => ['required','in:Laki-laki,Perempuan'],
            'noHP'           => ['required','regex:/^08[0-9]{8,11}$/'],
            'alergi'         => ['nullable','string','max:255'],
            'golonganDarah'  => ['nullable','in:A,B,AB,O'], // enum GD
        ];

        switch ($jenis) {
            case 'KTP':    // NIK: tepat 16 digit
                $rules['noIdentitas'] = ['required','digits:16'];
                break;
            case 'SIM':    // SIM: 12–16 digit (longgar & simpel)
                $rules['noIdentitas'] = ['required','digits_between:12,16'];
                break;
            case 'PASPOR': // Paspor: 1 huruf + 7–8 digit (contoh A12345678)
                $rules['noIdentitas'] = ['required','regex:/^[A-Z][0-9]{7,8}$/'];
                break;
            default:
                $rules['noIdentitas'] = ['required','string','max:50'];
        }

        $messages = [
            'noHP.regex'                 => 'Format no. HP harus diawali 08 dan 10–13 digit. Contoh: 081234567890',
            'noIdentitas.required'       => 'Nomor identitas wajib diisi.',
            'noIdentitas.digits'         => 'NIK harus 16 digit angka.',
            'noIdentitas.digits_between' => 'Nomor SIM harus 12–16 digit angka.',
            'noIdentitas.regex'          => 'Nomor paspor harus 1 huruf diikuti 7–8 digit (mis. A12345678).',
        ];

        $request->validate($rules, $messages);


        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if (is_null($user->status) || $user->status === '') {
            $user->status = 'aktif';
        }

        $user->save();


        $master = $user->masterPasien()->firstOrCreate([]);
        $pasien = $master->dataPasien()->first();

        if (!$pasien) {
            $pasien = new \App\Models\DataPasien();
            $pasien->master_pasien_id = $master->id;
        }


        $pasien->alamatDomisili = $request->alamatDomisili;
        $pasien->tanggalLahir   = $request->tanggalLahir;
        $pasien->noIdentitas    = $request->noIdentitas;   
        $pasien->jenisIdentitas = $request->jenisIdentitas;
        $pasien->jenisKelamin   = $request->jenisKelamin;
        $pasien->noHP           = $request->noHP;
        $pasien->alergi         = $request->alergi ?? '';
        $pasien->golonganDarah  = $request->golonganDarah ?? '';
        $pasien->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }


    public function editPassword(Request $request)
    {
        $user = auth('web')->user();
        return view('pasien.profile.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = auth('web')->user();

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required','string','min:8','confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password baru minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password baru tidak sesuai.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.password.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }

}
