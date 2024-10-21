<?php

namespace App\Http\Controllers\Tarefas;

use App\Http\Controllers\Controller;
use App\Models\TarefasModel;
use Illuminate\Http\Request;

class TarefasController extends Controller
{
    public function listar(Request $request)
    {
        try {
            $tarefas = TarefasModel::where('questionario_id',  $request->questionario_id)->get();
            return response()->json(['tarefas' => $tarefas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function cadastrar(Request $request)
    {
        try {
            $tarefa = TarefasModel::create($request->all());
            return response()->json($tarefa, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function update(Request $request)
    {
        try {
            $tarefa = TarefasModel::find($request->tarefa_id);
            if ($tarefa) {
                $tarefa->update($request->all());
                return response()->json($tarefa, 200);
            } else {
                return response()->json(['error' => 'Tarefa não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function delete(Request  $request)
    {
        try {
            $tarefa = TarefasModel::find($request->tarefa_id);
            if ($tarefa) {
                $tarefa->delete();
                return response()->json(['message' => 'Tarefa excluída com sucesso!'], 200);
            } else {
                return response()->json(['error' => 'Tarefa não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
