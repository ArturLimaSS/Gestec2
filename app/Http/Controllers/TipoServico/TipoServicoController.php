<?php

namespace App\Http\Controllers\TipoServico;

use App\Http\Controllers\Controller;
use App\Models\TipoServicoModel;
use Illuminate\Http\Request;

class TipoServicoController extends Controller
{
    public function list(Request  $request)
    {
        $lista  = TipoServicoModel::where('status', 'ativo')
            ->where('empresa_id', $request->empresa_id)
            ->get();
        return response()->json(['tipos_servicos' => $lista], 200);
    }

    public function create(Request $request)
    {
        try {
            $dados = $request->all();
            $dados['empresa_id'] = $request->empresa_id;
            TipoServicoModel::create($dados);
            return response()->json(['message' => 'Tipo de Serviço cadastrado com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao cadastrar o tipo de Serviço'], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $servico = TipoServicoModel::find($request->tipo_servico_id);
            if ($servico) {
                $servico->status = "inativo";
                $servico->save();
                return response()->json(['message' => 'Tipo de Serviço excluído com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Tipo de Serviço não encontrado!'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao excluir o tipo de Serviço'], 500);
        }
    }
}
