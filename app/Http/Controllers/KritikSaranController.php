<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KritikSaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:20',
            'email' => 'required|email',
            'pesan' => 'required|string|max:255'
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan

        ];

        //Buat kirim email ke Mediplus
        Mail::raw(
            "Pesan dari: {$data['nama']} <{$data['email']}>\n\n{$data['pesan']}", 
            function ($message) {
                $message->to('mediplus987@gmail.com')
                        ->subject('Kritik & Saran Baru dari Website Mediplus');
            }
        );

        return back()->with('success', 'Terima kasih, ' . $data['nama'] . '! Kritik & saran Anda sudah terkirim.');
    }
}
