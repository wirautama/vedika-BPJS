<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BerkasDigitalPerawatan extends Model
{
    protected $connection = 'khanza';

    protected $table = 'berkas_digital_perawatan';
    
    protected $fillabel = [
        'no_rawat',
        'kode',
        'lokasi_file',
    ];

}
