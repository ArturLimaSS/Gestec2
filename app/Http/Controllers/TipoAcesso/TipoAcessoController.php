<?php

namespace App\Http\Controllers\TipoAcesso;

use App\Http\Controllers\Controller;
use App\Models\TipoAcessoModel;
use Illuminate\Http\Request;

class TipoAcessoController extends Controller
{
    public function cadastrar(Request $request)
    {
        try {

            $request->validate([
                'tipo_acesso_nome' => 'required',
            ], [
                'tipo_acesso_nome.required' => 'O nome do tipo de Acesso é obrigatório',
            ]);

            $tipo_acesso = new TipoAcessoModel();
            $tipo_acesso->tipo_acesso_nome =  $request->tipo_acesso_nome;
            $tipo_acesso->tipo_acesso_descricao =  $request->tipo_acesso_descricao;
            $tipo_acesso->empresa_id =  $this->empresa->empresa_id;

            $tipo_acesso->save();
            return response()->json(['mensagem' => 'Tipo de Acesso criado com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 500);
        }
    }

    public  function listar()
    {
        $query = TipoAcessoModel::where('empresa_id', '=', $this->empresa->empresa_id)
            ->orWhere("empresa_id", "=", "null")
            ->where('ativo', '=', '1');

        $list_tipo_acesso = $query->get();
        return response()->json(['tipos_acesso' => $list_tipo_acesso], 200);
    }

    public function editar(Request $request)
    {
        try {
            $tipo_acesso = TipoAcessoModel::find($request->id);

            if (!$tipo_acesso) {
                return response()->json(['mensagem' => 'Tipo de Acesso não encontrado'], 404);
            }

            $request->validate([
                'tipo_acesso_nome' => 'required',
            ], [
                'tipo_acesso_nome.required' => 'O nome do tipo de Acesso é obrigatório',
            ]);

            $tipo_acesso->tipo_acesso_nome = $request->tipo_acesso_nome;
            $tipo_acesso->tipo_acesso_descricao = $request->tipo_acesso_descricao;

            $tipo_acesso->save();
            return response()->json(['mensagem' => 'Tipo de Acesso editado com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 500);
        }
    }

    public function excluir(Request $request)
    {
        try {
            $tipo_acesso = TipoAcessoModel::find($request->id);

            if (!$tipo_acesso) {
                return response()->json(['mensagem' => 'Tipo de Acesso não encontrado'], 404);
            }

            $tipo_acesso->ativo = '0';
            return response()->json(['mensagem' => 'Tipo de Acesso excluído com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], 500);
        }
    }
}
