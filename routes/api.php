<?php

use App\Http\Controllers\Atividade\AtividadeController;
use App\Http\Controllers\Atividades\AtividadesAnexo;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cargo\CargoController;
use App\Http\Controllers\Questionario\QuestionarioController;
use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\Perguntas\PerguntasController;
use App\Http\Controllers\Resposta\RespostaController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Tarefas\TarefasController;
use App\Http\Controllers\TipoEquipamento\TipoEquipamentoController;
use App\Http\Controllers\TipoServico\TipoServicoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
        Route::post("/logo", [EmpresaController::class,  'logo']);
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

    Route::group(['prefix' => 'questionario'], function () {
        /* Busca questionário */
        Route::get('/buscar', [QuestionarioController::class, 'getQUestionario']);

        /* Lista questionário */
        Route::get('/listar', [QuestionarioController::class, 'list']);
        Route::get('/listar-por-tipo-servico', [QuestionarioController::class, 'getQuestionariosPorTipoServico']);
        /* Cadastro de questionário */
        Route::group(['prefix' => 'cadastro'], function () {
            Route::post('', [QuestionarioController::class, 'create']);
            Route::get('', [QuestionarioController::class, 'getQuestionarioEmCadastro']);
            Route::put('', [QuestionarioController::class, 'update']);
            Route::put('/finalizar', [QuestionarioController::class, 'complete']);
            Route::delete('', [QuestionarioController::class, 'delete']);
        });

        /* Tarefas */
        Route::group(['prefix'  => 'tarefas'], function () {
            Route::get('listar',  [TarefasController::class, 'list']);
            Route::post('adicionar', [TarefasController::class, 'create']);
            Route::put('atualizar',  [TarefasController::class, 'update']);
            Route::delete('excluir',  [TarefasController::class, 'delete']);
        });

        /* Perguntas - Perguntas não estão agrupadas em tarefas pois a busca é por questionario_id */
        Route::group(['prefix' => 'perguntas'], function () {
            Route::post('adicionar', [PerguntasController::class, 'create']);
            Route::get('listar', [PerguntasController::class, 'list']);
            Route::put('atualizar', [PerguntasController::class, 'update']);
            Route::delete('excluir', [PerguntasController::class, 'delete']);
        });
    });

    Route::group(['prefix' => 'atividade'], function () {
        Route::post('/cadastro', [AtividadeController::class, 'create']);
        Route::get('/listar', [AtividadeController::class, 'list']);
        Route::get('/detalhes', [AtividadeController::class, 'atividadeDetail']);
        Route::put('/concluir', [AtividadeController::class, 'complete']);

        Route::group(['prefix' => 'anexo'], function () {
            Route::post('/upload', [AtividadesAnexo::class, 'upload']);
            Route::get('/listar', [AtividadesAnexo::class,  'list']);
            Route::put('/atualizar', [AtividadesAnexo::class, 'update']);
            Route::put('/excluir', [AtividadesAnexo::class, 'delete']);
            Route::get('/relatorio',  [AtividadesAnexo::class, 'relatorio']);
        });
    });

    Route::group(['prefix' => 'respostas'], function () {
        Route::get('/listar', [RespostaController::class, 'list']);
        Route::put('/atualizar', [RespostaController::class, 'update']);
    });
});
