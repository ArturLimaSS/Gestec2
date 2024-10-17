<?php

namespace App\Http\Controllers\TipoChave;

use App\Http\Controllers\Controller;
use App\Models\TipoChaveModel;
use Illuminate\Http\Request;

class TipoChaveController extends Controller
{
    public function cadastrar(Request $request)
    {
        try {

            $request->validate([
                'tipo_chave_nome' => 'required|string'
            ], [
                'tipo_chave_nome.required' => 'O nome do tipo de chave é obrigatório',
                'tipo_chave_nome.string' => 'O nome do tipo de chave deve ser um texto'
            ]);

            $tipo_chave = new TipoChaveModel();
            $tipo_chave->tipo_chave_nome = $request->tipo_chave_nome;
            $tipo_chave->tipo_chave_descricao = $request->tipo_chave_descricao;
            $tipo_chave->empresa_id = $this->empresa->empresa_id;

            $tipo_chave->save();
            return response()->json(['mensagem' => 'Tipo de Chave criado com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 500);
        }
    }

    public  function listar()
    {
        $query = TipoChaveModel::where('empresa_id', '=', $this->empresa->empresa_id)
            ->orWhere('empresa_id', '=', 'null')
            ->where('ativo', '=', '1');

        $lista_tipo_chave = $query->get();
        return response()->json(['tipos_chaves' => $lista_tipo_chave], 200);
    }

    public function editar(Request $request)
    {
        try {
            $tipo_chave = TipoChaveModel::find($request->id);

            if (!$tipo_chave) {
                return response()->json(['mensagem' => 'Tipo de Chave não encontrado'], 404);
            }

            $request->validate([
                'tipo_chave_nome' => 'required|string'
            ], [
                'tipo_chave_nome.required' => 'O nome do tipo de chave é obrigatório',
                'tipo_chave_nome.string' => 'O nome do tipo de chave deve ser um texto'
            ]);

            $tipo_chave->tipo_chave_nome = $request->tipo_chave_nome;
            $tipo_chave->tipo_chave_descricao = $request->tipo_chave_descricao;

            $tipo_chave->save();
            return response()->json(['mensagem' => "Tipo Chave atualizada com sucesso!"], 200);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 500);
        }
    }

    public function excluir(Request $request)
    {
        try {
            $tipo_chave = TipoChaveModel::find($request->id);

            if (!$tipo_chave) {
                return response()->json(['mensagem' => 'Tipo de Chave não encontrado'], 404);
            }

            $tipo_chave->ativo = '0';
            $tipo_chave->save();
            return response()->json(['mensagem' => 'Tipo de Chave excluído com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 500);
        }
    }
}
