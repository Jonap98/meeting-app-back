<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Tyumon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

class AuthController extends Controller
{
    public function getUsers() {
        $usuarios = User::select(
            'id',
            'name',
            'email',
            'password',
        )
        ->where('role', 'Lobby-admin')
        ->get();

        return response([
            'usuarios' => $usuarios
        ]);

    }

    public function login(Request $request) {
        $credentials = $request->only('usuario', 'password');

        try {
            if( !$token = JWTAuth::attempt($credentials) ) {
                return response([
                    'error' => 'Porfavor revise nuevamente sus credenciales'
                ]);
            }
        } catch( JWTException $e ) {
            return response([
                'error' => 'No se pudo crear el token de acceso'
            ]);
        }

        $user = User::select(
            'nombre',
            'usuario',
        )
        ->where('usuario', $request->usuario)
        ->first();

        return response([
            'msg' => '¡Bienvenido!',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function getAuthUser() {
        try {
            if( !$user = JWTAuth::parseToken()->authenticate() ) {
                return response([
                    'msg' => 'Usuario no encontrado'
                ]);
            }
        } catch( Tymon\JWTAuth\Exceptions\TokenExpiredException $e ) {
            return response([
                'msg' => 'Su sesión ha expirado'
            ]);
        } catch( Tymon\JWTAuth\Exceptions\TokenInvalidException $e ) {
            return response([
                'msg' => 'Token de acceso inválido'
            ]);
        } catch( Tymon\JWTAuth\Exceptions\JWTException $e ) {
            return response([
                'msg' => 'Token exception'
            ]);
        }

        return response([
            'data' => $user
        ]);
    }

    public function register(Request $request) {
        // $validator = Validator::make($request->all(), [
        //     'nombre' => 'required|string|max:255',
        //     'usuario' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6'
        // ]);

        // if( $validator->fails() ) {
        //     return response([
        //         'msg' => $validator->errors()->toJson()
        //     ]);
        // }
        // return response([
        //     'data' => $request->all()
        // ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response([
            'msg' => '¡Usuario creado exitosamente!',
            'data' => $user
        ]);
    }

    public function update(Request $request) {
        User::where(
            'id', $request->id
        )
        ->update([
            'nombre' => $request->name,
            'email' => $request->email
        ]);

        $usuario = User::select(
            'id',
            'nombre',
            'email',
        )
        ->where('id', $request->id)
        ->first();

        return response([
            'msg' => '¡Usuario actualizaco exitosamente!',
            'usuario' => $usuario
        ]);
    }
}
