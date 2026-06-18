<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    protected $primaryKey = 'id_staff';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'nama_staff',
    ];
}
