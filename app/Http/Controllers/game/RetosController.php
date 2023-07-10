<?php

namespace App\Http\Controllers\game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Retos;

class RetosController extends Controller
{
    public function index() {
        $retos = Retos::select(
            'descripcion'
        )->get();

        return response([
            'data' => $retos
        ]);
    }

    public function store(Request $request) {
        $reto = Retos::create([
            'descripcion' => $request->descripcion
        ]);

        if( $reto ) {
            return response([
                'msg' => '¡Reto creado exitosamente!'
            ]);
        } else {
            return response([
                'msg' => 'Error: no se pudo crear el reto'
            ]);
        }
    }
}
