<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Models\RespostaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RespostaController extends Controller
{
    public  function listar(Request $request)
    {
        try {
            $respostas = RespostaModel::where('atividade_id', $request->atividade_id)->get();
            return response()->json(['respostas' => $respostas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public  function editar(Request $request)
    {
        DB::beginTransaction();
        try {
            $respostas = $request->respostas;
            $successCount = 0;
            foreach ($respostas as $resposta) {
                $respostaDb =  RespostaModel::find($resposta['resposta_id']);
                $respostaDb->resposta = $resposta['resposta'];
                $respostaDb->save();
                $successCount++;
            }
            if ($successCount  == count($respostas)) {
                DB::commit();
                return response()->json(['message' => 'Respostas salvas com sucesso!'], 200);
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Ocorreu um eror ao salvar respostas'], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
