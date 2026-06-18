<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $primaryKey = 'id_reservasi';

    public $timestamps = false;

    protected $fillable = [
        'id_meja',
        'nama_pelanggan',
        'email',
        'no_telp',
        'tanggal',
        'jam',
        'status_reservasi',
        'created_at',
    ];

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja', 'id_meja');
    }
}
