<?php

namespace App\Http\Controllers\Perguntas;

use App\Http\Controllers\Controller;
use App\Models\PerguntasModel;
use Illuminate\Http\Request;

class PerguntasController extends Controller
{
    public  function cadastrar(Request $request)
    {
        try {
            $pergunta = PerguntasModel::create($request->all());
            return response()->json(['pergunta' => $pergunta], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function listar(Request $request)
    {
        try {
            $perguntas = PerguntasModel::where('questionario_id',  $request->questionario_id)->get();
            return response()->json(['perguntas' => $perguntas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function editar(Request $request)
    {
        try {
            $pergunta = PerguntasModel::find($request->pergunta_id);
            if ($pergunta) {
                $pergunta->update($request->all());
                return response()->json(['message' => 'Pergunta atualizada com sucesso!', 'pergunta' => $pergunta], 200);
            } else {
                return response()->json(['error' => 'Pergunta não encontrada!'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $pergunta = PerguntasModel::find($request->pergunta_id);
            if ($pergunta) {
                $pergunta->delete();
                return response()->json(['message' => 'Pergunta excluída com sucesso!'], 200);
            } else {
                return response()->json(['error' => 'Pergunta não encontrada!'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
