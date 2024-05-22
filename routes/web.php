<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CorridaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContaController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
Route::get('/criarcorrida', [CorridaController::class, 'CriarCorrida']);
Route::get('/cancelarcorrida', [CorridaController::class, 'CancelarCorrida']);
Route::get('/versaldo', [ContaController::class, 'CheckSaldo']);
Route::get('/inserirvalor', [ContaController::class, 'InserirValor']);
Route::get('/inserirusuario', [UserController::class, 'InserirUsuario']);
Route::get('/dadosusuario', [UserController::class, 'DadosUsuario']);
});
