<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class diagnosa extends Model
{ 
    protected $connection = 'khanza';    
    
    protected $table = 'diagnosa_pasien';
}
