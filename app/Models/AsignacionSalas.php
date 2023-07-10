<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionSalas extends Model
{
    use HasFactory;
    protected $table = 'asignadion_sala';
    protected $fillable = [
        'id_user',
        'id_sala',
    ];
}
