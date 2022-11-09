<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sep extends Model
{
    protected $connection = 'khanza';
    
    protected $table = 'bridging_sep';

    protected $fillable = [
        'no_sep',
        'no_rawat',
        'jnspelayanan',
        'nmpolitujuan',
        'nmdpjplayanan',
        'no_kartu',
        'tgl_sep'
    ];
}
