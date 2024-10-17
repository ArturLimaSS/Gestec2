<?php

namespace App\Http\Controllers\Questionario;

use App\Http\Controllers\Controller;
use App\Models\QuestionarioModel;
use Illuminate\Http\Request;

class QuestionarioController extends Controller
{
    public  function listar()
    {
        try {
            $questionarios = QuestionarioModel::where('empresa_id', $this->user->empresa[0]->empresa_id)->where("status", "ativo")->get();
            return response()->json(['questionarios' => $questionarios], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public  function cadastrar(Request $request)
    {
        try {
            $questionario = QuestionarioModel::create($request->all());
            return response()->json($questionario, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function editar(Request $request)
    {
        try {
            $questionario = QuestionarioModel::find($request->questionario_id);
            if ($questionario) {
                $questionario->update($request->all());
                return response()->json($questionario, 200);
            } else {
                return response()->json(['error' => 'CheckList não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getQuestionario(Request $request)
    {
        try {
            $questionario = QuestionarioModel::where('questionario_id', $request->questionario_id)
                ->latest()
                ->first();
            return response()->json(['questionario' => $questionario], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getQuestionarioEmCadastro(Request $request)
    {
        try {
            $questionario = QuestionarioModel::where('empresa_id',  $this->user->empresa[0]->empresa_id)
                ->where('status', 'pendente')
                ->latest()
                ->first();

            if (!$questionario) {
                $questionario = QuestionarioModel::create(['empresa_id' =>  $this->user->empresa[0]->empresa_id]);
                return response()->json(['questionario' => $questionario], 201);
            } else {
                return response()->json(['questionario' => $questionario], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function complete(Request $request)
    {
        try {
            $questionario = QuestionarioModel::find($request->questionario_id);
            if ($questionario) {
                $questionario->update(['status' => 'ativo']);
                return response()->json(['message' => 'CheckList concluído com sucesso!'], 200);
            } else {
                return response()->json(['error' => 'CheckList não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $questionario = QuestionarioModel::find($request->questionario_id);
            if ($questionario) {
                $questionario->update(['status' => 'inativo']);
                return response()->json(['message' => 'CheckList excluído com sucesso!'], 200);
            } else {
                return response()->json(['error' => 'CheckList não encontrado'], 404);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getQuestionariosPorTipoServico(Request $request)
    {
        try {
            $questionarios = QuestionarioModel::where('empresa_id', $this->user->empresa[0]->empresa_id)
                ->where('status', 'ativo')
                ->where('tipo_servico_id', $request->tipo_servico_id)
                ->get();
            return response()->json(['questionarios' => $questionarios], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
