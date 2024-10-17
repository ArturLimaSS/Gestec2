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
use App\Http\Controllers\TipoAcesso\TipoAcessoController;
use App\Http\Controllers\TipoChave\TipoChaveController;
use App\Http\Controllers\TipoEquipamento\TipoEquipamentoController;
use App\Http\Controllers\TipoServico\TipoServicoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'cadastrarUser']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/check', [AuthController::class, 'check']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'empresa'], function () {
        Route::put('/cadastro', [EmpresaController::class, 'editar']);
        Route::post("/logo", [EmpresaController::class,  'logo']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('/cadastro', [UserController::class, 'cadastrar']);
        Route::put('/atualizar', [UserController::class, 'editar']);
        Route::get('/listar', [UserController::class, 'listar']);
    });

    Route::group(['prefix' => 'site'], function () {
        Route::post('/cadastro', [SiteController::class, 'cadastrar']);
        Route::get('/listar', [SiteController::class, 'listar']);

        Route::group(['prefix' => 'tipo-acesso'], function () {
            Route::get('/listar', [TipoAcessoController::class, 'listar']);
            Route::put('/editar', [TipoAcessoController::class, 'editar']);
            Route::post('/cadastro', [TipoAcessoController::class, 'cadastrar']);
            Route::put('/excluir', [TipoAcessoController::class, 'delete']);
        });

        Route::group(['prefix' => 'tipo-chave'], function () {
            Route::get('/listar', [TipoChaveController::class, 'listar']);
            Route::put('/editar', [TipoChaveController::class, 'editar']);
            Route::post('/cadastro', [TipoChaveController::class, 'cadastrar']);
            Route::put('/excluir', [TipoChaveController::class, 'delete']);
        });
    });

    Route::group(['prefix' => 'tipo-equipamento'], function () {
        Route::post('/cadastro', [TipoEquipamentoController::class, 'cadastrar']);
        Route::get('/listar', [TipoEquipamentoController::class, 'listar']);
        Route::delete('/excluir', [TipoEquipamentoController::class, 'delete']);
    });

    Route::group(['prefix' => 'cargo'], function () {
        Route::get('/listar', [CargoController::class, 'listar']);
    });

    Route::group(['prefix' => 'tipo-servico'], function () {
        Route::get('/listar', [TipoServicoController::class, 'listar']);
        Route::post('/cadastro', [TipoServicoController::class, 'cadastrar']);
        Route::put('/excluir', [TipoServicoController::class, 'delete']);
    });

    Route::group(['prefix' => 'questionario'], function () {
        /* Busca questionário */
        Route::get('/buscar', [QuestionarioController::class, 'getQUestionario']);

        /* Lista questionário */
        Route::get('/listar', [QuestionarioController::class, 'listar']);
        Route::get('/listar-por-tipo-servico', [QuestionarioController::class, 'getQuestionariosPorTipoServico']);
        /* Cadastro de questionário */
        Route::group(['prefix' => 'cadastro'], function () {
            Route::post('', [QuestionarioController::class, 'cadastrar']);
            Route::get('', [QuestionarioController::class, 'getQuestionarioEmCadastro']);
            Route::put('', [QuestionarioController::class, 'editar']);
            Route::put('/finalizar', [QuestionarioController::class, 'complete']);
            Route::delete('', [QuestionarioController::class, 'delete']);
        });

        /* Tarefas */
        Route::group(['prefix'  => 'tarefas'], function () {
            Route::get('listar',  [TarefasController::class, 'listar']);
            Route::post('adicionar', [TarefasController::class, 'cadastrar']);
            Route::put('atualizar',  [TarefasController::class, 'editar']);
            Route::delete('excluir',  [TarefasController::class, 'delete']);
        });

        /* Perguntas - Perguntas não estão agrupadas em tarefas pois a busca é por questionario_id */
        Route::group(['prefix' => 'perguntas'], function () {
            Route::post('adicionar', [PerguntasController::class, 'cadastrar']);
            Route::get('listar', [PerguntasController::class, 'listar']);
            Route::put('atualizar', [PerguntasController::class, 'editar']);
            Route::delete('excluir', [PerguntasController::class, 'delete']);
        });
    });

    Route::group(['prefix' => 'atividade'], function () {
        Route::post('/cadastro', [AtividadeController::class, 'cadastrar']);
        Route::get('/listar', [AtividadeController::class, 'listar']);
        Route::get('/detalhes', [AtividadeController::class, 'atividadeDetail']);
        Route::put('/concluir', [AtividadeController::class, 'complete']);

        Route::group(['prefix' => 'anexo'], function () {
            Route::post('/upload', [AtividadesAnexo::class, 'upload']);
            Route::get('/listar', [AtividadesAnexo::class,  'listar']);
            Route::put('/atualizar', [AtividadesAnexo::class, 'editar']);
            Route::put('/excluir', [AtividadesAnexo::class, 'delete']);
            Route::get('/relatorio',  [AtividadesAnexo::class, 'relatorio']);
        });
    });

    Route::group(['prefix' => 'respostas'], function () {
        Route::get('/listar', [RespostaController::class, 'listar']);
        Route::put('/atualizar', [RespostaController::class, 'editar']);
    });
});
