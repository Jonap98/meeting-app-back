<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\game\RetosController;
use App\Http\Controllers\game\SalasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function() {

});


// =====================================================================
// Auth
// =====================================================================
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('usuarios', [AuthController::class, 'getUsers'])->name('usuarios');
Route::post('usuarios/update', [AuthController::class, 'update'])->name('usuarios.update');

// =====================================================================
// Retos
// =====================================================================
Route::get('retos', [RetosController::class, 'index'])->name('retos');
Route::post('retos/store', [RetosController::class, 'store'])->name('retos.store');

// =====================================================================
// Salas
// =====================================================================
Route::post('salas/by-id', [SalasController::class, 'getById'])->name('salas.by-id');
Route::post('salas/store', [SalasController::class, 'store'])->name('salas.store');
Route::post('salas/login-sala', [SalasController::class, 'loginSala'])->name('salas.login-sala');






