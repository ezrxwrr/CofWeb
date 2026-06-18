<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::with('meja')->get();

        return response()->json($reservasi);
    }

    public function show($id)
    {
        $reservasi = Reservasi::with('meja')->find($id);

        if (!$reservasi) {
            return response()->json(['message' => 'Reservasi tidak ditemukan'], 404);
        }

        return response()->json($reservasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_meja' => 'required|exists:meja,id_meja',
            'nama_pelanggan' => 'required',
            'email' => 'nullable|string',
            'no_telp' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        $meja = Meja::find($request->id_meja);

        if ($meja->status_meja === 'terisi') {
            return response()->json([
                'message' => 'Meja sudah terisi, tidak bisa melakukan reservasi'
            ], 409);
        }

        $reservasi = Reservasi::create([
            'id_meja' => $request->id_meja,
            'nama_pelanggan' => $request->nama_pelanggan,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status_reservasi' => 'menunggu',
            'created_at' => now(),
        ]);

        $meja->update(['status_meja' => 'terisi']);

        return response()->json([
            'message' => 'Reservasi berhasil dibuat',
            'reservasi' => $reservasi->load('meja')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::find($id);

        if (!$reservasi) {
            return response()->json(['message' => 'Reservasi tidak ditemukan'], 404);
        }

        $request->validate([
            'id_meja' => 'sometimes|exists:meja,id_meja',
            'nama_pelanggan' => 'sometimes',
            'email' => 'sometimes|email',
            'no_telp' => 'sometimes',
            'tanggal' => 'sometimes|date',
            'jam' => 'sometimes',
            'status_reservasi' => 'sometimes',
        ]);

        $reservasi->update($request->only([
            'id_meja',
            'nama_pelanggan',
            'email',
            'no_telp',
            'tanggal',
            'jam',
            'status_reservasi',
        ]));

        if ($request->has('status_reservasi') && $request->status_reservasi === 'ditolak') {
            Meja::where('id_meja', $reservasi->id_meja)->update(['status_meja' => 'kosong']);
        }

        return response()->json([
            'message' => 'Reservasi berhasil diperbarui',
            'reservasi' => $reservasi->load('meja')
        ]);
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::find($id);

        if (!$reservasi) {
            return response()->json(['message' => 'Reservasi tidak ditemukan'], 404);
        }

        Meja::where('id_meja', $reservasi->id_meja)->update(['status_meja' => 'kosong']);

        $reservasi->delete();

        return response()->json([
            'message' => 'Reservasi berhasil dihapus'
        ]);
    }
}
