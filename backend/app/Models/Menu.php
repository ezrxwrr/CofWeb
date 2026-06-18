<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $primaryKey = 'id_menu';

    protected $fillable = [
        //'id_kategori',
        'nama_item',
        'deskripsi',
        'harga',
        'pax'
    ];
}