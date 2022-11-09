<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kelurahan extends Model
{
    protected $connection = 'khanza';

    protected $table = 'kelurahan';

    protected $fillable = [
        'kd_kel',
        'nm_kel',
    ];
}
