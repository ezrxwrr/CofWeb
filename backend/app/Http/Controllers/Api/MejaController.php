<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::all();

        return response()->json($meja);
    }

    public function show($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan'], 404);
        }

        return response()->json($meja);
    }

    public function occupy($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan'], 404);
        }

        if ($meja->status_meja === 'terisi') {
            return response()->json([
                'message' => 'Meja sudah terisi, silakan pilih meja lain'
            ], 409);
        }

        $meja->update(['status_meja' => 'terisi']);

        return response()->json([
            'message' => 'Meja berhasil dipesan',
            'meja' => $meja
        ]);
    }

    public function vacate($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan'], 404);
        }

        $meja->update(['status_meja' => 'kosong']);

        return response()->json([
            'message' => 'Meja berhasil dikosongkan',
            'meja' => $meja
        ]);
    }
}
