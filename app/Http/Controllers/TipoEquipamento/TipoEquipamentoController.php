<?php

namespace App\Http\Controllers\TipoEquipamento;

use App\Http\Controllers\Controller;
use App\Models\TipoEquipamentoModel;
use Illuminate\Http\Request;

class TipoEquipamentoController extends Controller
{
    public  function cadastrar(Request $request)
    {
        try {
            $tipoEquipamento = TipoEquipamentoModel::create($request->all());
            return response()->json(['message' => 'Tipo de Equipamento cadastrado com sucesso!', 'tipo_equipamento' => $tipoEquipamento], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro ao cadastrar o tipo de equipamento: ' . $e->getMessage()], 500);
        }
    }

    public  function listar(Request $request)
    {
        try {
            $tipos_equipamentos = TipoEquipamentoModel::where('ativo', '1')->where('empresa_id', $this->user->empresa[0]->empresa_id)->get();
            return response()->json(['tipos_equipamentos' => $tipos_equipamentos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro ao listar os tipos de equipamento: ' . $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $tipo_equipamento = TipoEquipamentoModel::find($request->id_tipo_equipamento);
            if ($tipo_equipamento) {
                $tipo_equipamento->ativo = "0";
                $tipo_equipamento->save();
                return response()->json(['message' => 'Tipo de Equipamento excluído com sucesso!'], 200);
            } else {
                return response()->json(['error' => 'Tipo de Equipamento não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro ao excluir o tipo de equipamento: ' . $e->getMessage()], 500);
        }
    }
}
