<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retos extends Model
{
    use HasFactory;
    protected $table = 'retos';
    protected $fillable = [
        'descripcion',
    ];
}
