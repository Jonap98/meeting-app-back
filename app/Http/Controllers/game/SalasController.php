<?php

namespace App\Http\Controllers\game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Salas;
use App\Models\User;

use App\Events\TestEvent;

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

        if( !$sala ) {
            return response([
                'msg' => 'Favor de revisar los datos nuevamente'
            ]);
        }

        $players_id = $sala->ids_jugadores;

        array_push($players_id, intval($request->jugador));

        $current_players = User::select(
            'id',
            'nombre',
            'usuario',
        )
        ->whereIn('id', $players_id)
        ->get();

        Salas::where(
            'id', $sala->id
        )
        ->update([
            'ids_jugadores' => $players_id
        ]);

        $new_sala = Salas::select(
            'id',
            'ids_jugadores',
        )
        ->where('id', $sala->id)
        ->first();

        // broadcast( new TestEvent('Eventoooo del loco del barrio') );
        broadcast( new TestEvent($current_players) );

        return response([
            'msg' => 'Bienvenido a la sala '.$sala->nombre,
            'data' => $sala,
            'jugadores' => $current_players
        ]);

    }

    public function getCurrentPlayers( $id_sala ) {
        $sala = Salas::select(
            'id',
            'nombre',
            'ids_jugadores',
        )
        ->where('id', $id_sala)
        ->first();

        if( !$sala ) {
            return response([
                'msg' => 'Ha ocurrido un error'
            ]);
        }

        // $current_players = $sala->ids_jugadores;
        $players_id = $sala->ids_jugadores;

        $current_players = User::select(
            'id',
            'nombre',
            'usuario',
        )
        ->whereIn('id', $players_id)
        ->get();

        return response([
            'msg' => 'Sala actual',
            'data' => $current_players
        ]);
    }
}
