<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $primaryKey = 'id_payment';

    public $timestamps = false;

    protected $fillable = [
        'id_reservasi',
        'total_order',
        'total_tagihan',
        'status_pembayaran',
        'waktu_pembayaran',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi');
    }
}
