<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = auth('web')->user();

        //edit profile cuman buat pasien
        if (!$user->masterPasien) {
            abort(403);
        }

        return view('pasien.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth('web')->user();

        if (!$user->masterPasien) {
            abort(403);
        }

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if (is_null($user->status) || $user->status === '') {
            $user->status = 'aktif';
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword(Request $request)
    {
        $user = auth('web')->user();

        if ($user->masterPasien) {
            // Pasien
            return view('pasien.profile.password', compact('user'));
        }

        if ($user->dokter) {
            // Dokter
            return view('dokter.password.edit', compact('user'));
        }

        if ($user->petugas) {
            // Petugas
            return view('petugas.password.edit', compact('user'));
        }

        abort(403);
    }


    public function updatePassword(Request $request)
    {
        $user = auth('web')->user();

        $request->validate(
            [
                'current_password' => ['required'],
                'password'         => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'password.required'         => 'Password baru wajib diisi.',
                'password.min'              => 'Password baru minimal 8 karakter.',
                'password.confirmed'        => 'Konfirmasi password baru tidak sesuai.',
            ]
        );


        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                ->withInput();
        }


        $user->password = Hash::make($request->password);
        $user->save();

        //ini buat redirect dinamis -> sesuaikan ama route yg manggil
        $currentRoute = $request->route()->getName();
        $editRoute = str_replace('.update', '.edit', $currentRoute);

        return redirect()
            ->route($editRoute)
            ->with('success', 'Password berhasil diperbarui!');
    }
}
