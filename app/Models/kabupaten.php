<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kabupaten extends Model
{
    protected $connection = 'khanza';

    protected $table = 'kabupaten';

    protected $fillable = [
        'kd_kab',
        'nm_kab',
    ];
}