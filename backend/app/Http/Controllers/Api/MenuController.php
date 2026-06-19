<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item'   => 'required|string|max:255',
            'harga'       => 'required|numeric|min:1',
            'deskripsi'   => 'nullable|string',
            //'id_kategori' => 'nullable|integer',   // hapus exists:menu agar tidak error
            'pax'         => 'nullable|numeric|min:1',
        ]);

        $menu = Menu::create([
            'nama_item'   => $request->nama_item,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi ?? '',
            //'id_kategori' => $request->id_kategori,
            'pax'         => $request->pax ?? 1,
        ]);

        return response()->json([
            'message' => 'Menu berhasil ditambahkan',
            'menu'    => $menu,
        ], 201);
    }

    public function uploadImage(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu tidak ditemukan'], 404);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $image = $request->file('image');
        $filename = 'menu-' . $id . '-' . time() . '.webp';
        $path = $image->storeAs('public/menu', $filename);

        $menu->update(['gambar' => 'storage/menu/' . $filename]);

        return response()->json([
            'message' => 'Gambar berhasil diupload',
            'gambar'  => $menu->gambar,
        ]);
    }
}