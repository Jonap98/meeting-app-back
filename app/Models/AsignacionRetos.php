<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionRetos extends Model
{
    use HasFactory;
    protected $table = 'asignadion_reto';
    protected $fillable = [
        'reto',
        'id_usuario',
        'id_sala',
    ];
}
