<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBerkas extends Model
{
    protected $connection = 'khanza';

    protected $table = 'master_berkas_digital';
    
    protected $fillable = [
        'kode',
        'nama',
    ];
}
