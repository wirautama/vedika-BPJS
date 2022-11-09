<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pasien extends Model
{
    protected $connection = 'khanza';

    protected $table = 'pasien';
    
    protected $fillable = [
        'no_rkm_medis',
        'nm_pasien',
        'no_peserta',
        'alamat',
        'kd_kel',
        'kd_kec',
        'kd_kab',
        'jk',
        'umur',
    ];
}
