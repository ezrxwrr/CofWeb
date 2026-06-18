<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $staff = Staff::where('username', $request->username)->first();

        if (!$staff || $staff->password !== $request->password) {
            return response()->json([
                'message' => 'Username atau password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'staff' => [
                'id_staff' => $staff->id_staff,
                'username' => $staff->username,
                'nama_staff' => $staff->nama_staff,
            ]
        ]);
    }
}
