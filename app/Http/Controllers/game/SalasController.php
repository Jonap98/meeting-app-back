<?php

namespace App\Http\Controllers\game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Salas;

class SalasController extends Controller
{
    public function getById(Request $request) {
        $sala = Salas::select(
            'nombre',
            'codigo_sala',
            'password',
            'cantidad_retos',
            'retos_asignados',
            'owner',
            'ids_jugadores',
        )
        ->where('id', $request->id_sala)
        ->get();

        return response([
            'data' => $sala
        ]);
    }

    public function store(Request $request) {

        $codigoAcceso = random_int(1, 6000000);
        // return response([
        //     'data' => $codigoAcceso
        // ]);

        $sala = Salas::create([
            'nombre' => $request->nombre,
            // 'codigo_sala' => Str::uuid(),
            'codigo_sala' => $codigoAcceso,
            'password' => $request->password,
            'cantidad_retos' => $request->cantidad_retos,
            // 'retos_asignados' => $request->retos_asignados,
            'owner' => $request->owner,
            // 'ids_jugadores' => $request->ids_jugadores,
            'ids_jugadores' => [$request->owner],
            // 'jugadores' => $request->jugadores,
        ]);

        if( $sala ) {
            return response([
                'msg' => '¡Sala creada exitosamente!',
                'data' => $sala,
            ]);
        }

        return response([
            'msg' => 'No se pudo crear la sala'
        ]);
    }

    public function loginSala(Request $request) {

        $sala = Salas::select(
            'id',
            'nombre',
            // 'codigo_sala',
            // 'password',
            // 'cantidad_retos',
            // 'retos_asignados',
            // 'owner',
            'ids_jugadores',
        )
        ->where('codigo_sala', $request->codigo_sala)
        ->where('password', $request->password)
        ->first();

        if( $sala ) {
            $current_players = $sala->ids_jugadores;

            array_push($current_players, $request->jugador);

            Salas::where(
                'id', $sala->id
            )
            ->update([
                'ids_jugadores' => $current_players
            ]);

            $new_sala = Salas::select(
                'id',
                // 'nombre',
                // 'codigo_sala',
                // 'password',
                // 'cantidad_retos',
                // 'retos_asignados',
                // 'owner',
                'ids_jugadores',
            )
            ->where('id', $sala->id)
            ->first();


            return response([
             'msg' => 'Bienvenido a la sala '.$sala->nombre,
             'data' => $sala
            ]);
        }

        return response([
            'msg' => 'Favor de revisar los datos nuevamente'
        ]);
    }
}
