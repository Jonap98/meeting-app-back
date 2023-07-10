<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    use HasFactory;
    protected $table = 'salas';
    protected $fillable = [
        'nombre',
        'codigo_sala',
        'password',
        'cantidad_retos',
        'retos_asignados',
        'owner',
        'ids_jugadores',
        'jugadores',
    ];

    protected $casts = [
        'ids_jugadores' => 'array'
    ];
}
