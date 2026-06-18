<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('reservasi')->get();

        return response()->json($payments);
    }

    public function show($id)
    {
        $payment = Payment::with('reservasi')->find($id);

        if (!$payment) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        return response()->json($payment);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'id_reservasi' => 'required|exists:reservasi,id_reservasi',
            'total_order' => 'required|numeric',
            'total_tagihan' => 'required|numeric',
        ]);

        $reservasi = Reservasi::find($request->id_reservasi);

        if (!$reservasi) {
            return response()->json(['message' => 'Reservasi tidak ditemukan'], 404);
        }

        $payment = Payment::create([
            'id_reservasi' => $request->id_reservasi,
            'total_order' => $request->total_order,
            'total_tagihan' => $request->total_tagihan,
            'status_pembayaran' => 'lunas',
            'waktu_pembayaran' => now(),
        ]);

        $reservasi->update(['status_reservasi' => 'dibayar']);

        return response()->json([
            'message' => 'Pembayaran berhasil',
            'payment' => $payment->load('reservasi')
        ], 201);
    }
}
