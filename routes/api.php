<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cargo\CargoController;
use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\TipoEquipamento\TipoEquipamentoController;
use App\Http\Controllers\TipoServico\TipoServicoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/check', [AuthController::class, 'check']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'empresa'], function () {
        Route::put('/cadastro', [EmpresaController::class, 'update']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('/cadastro', [UserController::class, 'create']);
        Route::put('/atualizar', [UserController::class, 'update']);
        Route::get('/listar', [UserController::class, 'list']);
    });

    Route::group(['prefix' => 'site'], function () {
        Route::post('/cadastro', [SiteController::class, 'create']);
        Route::get('/listar', [SiteController::class, 'list']);
    });

    Route::group(['prefix' => 'tipo-equipamento'], function () {
        Route::post('/cadastro', [TipoEquipamentoController::class, 'create']);
        Route::get('/listar', [TipoEquipamentoController::class, 'list']);
        Route::delete('/excluir', [TipoEquipamentoController::class, 'delete']);
    });

    Route::group(['prefix' => 'cargo'], function () {
        Route::get('/listar', [CargoController::class, 'list']);
    });

    Route::group(['prefix' => 'tipo-servico'], function () {
        Route::get('/listar', [TipoServicoController::class, 'list']);
        Route::post('/cadastro', [TipoServicoController::class, 'create']);
        Route::put('/excluir', [TipoServicoController::class, 'delete']);
    });
});
