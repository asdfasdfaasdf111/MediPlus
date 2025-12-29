<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataPemeriksaan;
use App\Models\Pembayaran;
use App\Notifications\PembayaranBerhasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function create(Request $request){
        try {
            $request->validate([
                'dataPemeriksaanId' => 'required|exists:data_pemeriksaans,id',
                'metodePembayaran' => 'required|in:online,offline',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi data gagal',
            ]);
        }
        
        $dataPemeriksaan = DataPemeriksaan::findOrFail($request->dataPemeriksaanId);
        $user = auth()->user();
        $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
        if ($dataPemeriksaan->masterPasien->user_id !== $user->id){
            return response()->json([
                'status' => 'error',
                'message' => 'Data pemeriksaan tidak sesuai dengan pasien Anda.',
            ]);
        }

        if ($dataPemeriksaan->pembayaran != null){
            return response()->json([
                'status' => 'error',
                'message' => 'Metode pembayaran sudah pernah dipilih.',
            ]);
        }
        
        if ($request->metodePembayaran === 'offline') {
            Pembayaran::create([
                'data_pemeriksaan_id' => $dataPemeriksaan->id,
                'status' => 'pending',
                'metodePembayaran' => 'offline',
                'harga' => $jenisPemeriksaan->harga,
                'namaJenisPemeriksaan' => $jenisPemeriksaan->namaJenisPemeriksaan,
                'namaPasien' => $user->name,
                'emailPasien' => $user->email,
            ]);
            $dataPemeriksaan->statusUtama = "Berlangsung";
            $dataPemeriksaan->statusPasien = "Menunggu Pembayaran Offline";
            $dataPemeriksaan->statusPetugas = "Menunggu Pembayaran Offline";
            $dataPemeriksaan->statusDokter = "Menunggu Pembayaran Offline";
            $dataPemeriksaan->save();
            return response()->json([
                'status' => 'offline',
                'message' => 'Silakan lakukan pembayaran di rumah sakit.'
            ]);
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => Str::uuid(),
                'gross_amount' => $jenisPemeriksaan->harga,
            ),
            'callbacks' => [
                'finish' => env('NGROK_FINISH_REDIRECT_URL'),
            ],
            'item_details' => array(
                array (
                    'price' => $jenisPemeriksaan->harga,
                    'quantity' => 1,
                    'name' => $jenisPemeriksaan->namaJenisPemeriksaan,
                    )
                ),
            'customer_details' => array(
                'first_name' => $user->name,
                'email' => $user->email,
            ),
        );
        
        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));
        

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Basic $auth",
        ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);
        $response = json_decode($response->body());

        if (empty($response->token)) {
            return back()->withErrors(['message' => 'Gagal membuat pembayaran']);
        }

        $pembayaran = Pembayaran::create([
            'data_pemeriksaan_id' => $dataPemeriksaan->id,
            'order_id' => $params['transaction_details']['order_id'],
            'status' => 'pending',
            'metodePembayaran' => 'online',
            'harga' => $jenisPemeriksaan->harga,
            'namaJenisPemeriksaan' => $jenisPemeriksaan->namaJenisPemeriksaan,
            'namaPasien' => $user->name,
            'emailPasien' => $user->email,
            'checkoutLink' => $response->redirect_url,
        ]);

        return response()->json($response);
    }

    public function check($id)
    {
        $data = DataPemeriksaan::findOrFail($id);
        
        if ($data->masterPasien->user_id !== auth()->user()->id) {
            abort(403);
        }

        $pembayaran = $data->pembayaran;

        if (!$pembayaran || !$pembayaran->metodePembayaran) {
            return response()->json([
                'status' => 'belumPilih'
            ]);
        }

        if ($pembayaran->metodePembayaran === 'online') {
            return response()->json([
                'status' => 'online',
                'checkout_link' => $pembayaran->checkoutLink
            ]);
        }
        
        
        //hrusny ga bakal pernah kepanggil
        return response()->json([
            'status' => 'offline'
        ]);
    }

    function normalizeMidtransStatus($transactionStatus, $fraudStatus = null)
    {
        // SUCCESS
        if (
            $transactionStatus === 'settlement' ||
            ($transactionStatus === 'capture' && $fraudStatus === 'accept')
        ) {
            return 'accept';
        }

        // PENDING
        if (
            $transactionStatus === 'pending' ||
            ($transactionStatus === 'capture' && $fraudStatus === 'challenge')
        ) {
            return 'pending';
        }

        // FAILED
        return 'deny';
    }

    public function webhook(Request $request){
        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Basic $auth",
        ])->get("https://api.sandbox.midtrans.com/v2/$request->order_id/status");

        $response = json_decode($response->body());

        $pembayaran = Pembayaran::where('order_id', $response->order_id)->first();

        if (!$pembayaran) {
            return response()->json(['message' => 'Order not found'], 200);
        }

        if ($pembayaran->status === 'deny'){
            return response()->json('Pembayaran ditolak');
        }
        
        if ($pembayaran->status === 'accept'){
            return response()->json('Pembayaran sudah diproses');
        }
        
        $normalizedStatus = $this->normalizeMidtransStatus(
            $response->transaction_status,
            $response->fraud_status ?? null
        );

        $pembayaran->status = $normalizedStatus;

        $dataPemeriksaan = $pembayaran->dataPemeriksaan;

        if ($normalizedStatus === 'accept'){
            $pembayaran->mediaPembayaran = $response->payment_type;
            $dataPemeriksaan->statusUtama = 'Berlangsung';
            $dataPemeriksaan->statusPasien = 'Menunggu Registrasi Ulang';
            $dataPemeriksaan->statusPetugas = 'Menunggu Registrasi Ulang';
            $dataPemeriksaan->statusDokter = 'Menunggu Registrasi Ulang';
            $userPasien = $dataPemeriksaan->masterPasien->user;
            $userPasien->notify(new PembayaranBerhasil($dataPemeriksaan));
        }
        else if ($normalizedStatus === 'deny'){
            $dataPemeriksaan->statusUtama = 'Dibatalkan';
            $dataPemeriksaan->statusPasien = 'Pembayaran Gagal';
            $dataPemeriksaan->statusPetugas = 'Pembayaran Gagal';
            $dataPemeriksaan->statusDokter = 'Pembayaran Gagal';
            $dataPemeriksaan->catatanPetugas = 'Pendaftaran otomatis dibatalkan karena pasien tidak melakukan pembayaran';
        }

        $dataPemeriksaan->save();
        $pembayaran->save();

        return response()->json('success');
    }
    
    public function bayarOffline(Request $request, $id){
        $dataPemeriksaan = DataPemeriksaan::findOrFail($id);
        $pembayaran = $dataPemeriksaan->pembayaran;

        $pembayaran->status = 'accept';
        $pembayaran->save();
        $dataPemeriksaan->statusUtama = 'Berlangsung';
        $dataPemeriksaan->statusPasien = 'Menunggu Registrasi Ulang';
        $dataPemeriksaan->statusPetugas = 'Menunggu Registrasi Ulang';
        $dataPemeriksaan->statusDokter = 'Menunggu Registrasi Ulang';
        $userPasien = $dataPemeriksaan->masterPasien->user;
        $userPasien->notify(new PembayaranBerhasil($dataPemeriksaan));
        $dataPemeriksaan->save();

        return redirect()->route('petugas.detailpemeriksaan', $dataPemeriksaan);
    }
}