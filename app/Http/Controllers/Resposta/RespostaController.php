<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Models\RespostaModel;
use Illuminate\Http\Request;

class RespostaController extends Controller
{
    public function list(Request $request)
    {
        try {
            $respostas = RespostaModel::where('atividade_id', $request->atividade_id)->get();
            return response()->json(['respostas' => $respostas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $resposta = RespostaModel::find($request->resposta_id);
            $resposta->update($request->all());
            return response()->json(['resposta' => $resposta], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
