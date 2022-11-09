<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registrasi extends Model
{
    protected $connection = 'khanza';

    protected $table = 'reg_periksa';
    
    protected $fillable = [
        'no_rawat',
        'tgl_registrasi',
        'jam_reg',
        'no_rkm_medis',
        'kd_poli',
        'kd_pj',
        'umurdaftar',
    ];
}
