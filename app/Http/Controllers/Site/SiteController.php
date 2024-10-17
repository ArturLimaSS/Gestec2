<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SitesModel;
use Illuminate\Http\Request;

class SiteController extends Controller
{
  public function buscar(Request $request)
  {
    $sites = SitesModel::where('site_id', $request->site_id)->where('empresa_id', $this->empresa->empresa_id)->first();
    return response()->json(['site' => $sites], 200);
  }
  public  function cadastrar(Request $request)
  {
    try {

      $request->validate([
        'nome_site' => 'required|string',
        'endereco_rua' => 'required|string',
        'endereco_numero' => 'required|string',
        'endereco_cidade' => 'required|string',
        'endereco_estado' => 'required|string',
        'endereco_cep' => 'required|string',
        'tipo_acesso' => 'required',
        'tipo_chave' => 'required',
        'tipo_equipamento' => 'required',
        'nivel_prioridade' => 'required'
      ], [
        'nome_site.required' => 'O nome do site é obrigatório.',
        'endereco_rua.required' => 'A rua é obrigatório.',
        'endereco_numero.required' => 'O número é obrigatório.',
        'endereco_cidade.required' => 'A cidade é obrigatório.',
        'endereco_estado.required' => 'O estado é obrigatório.',
        'endereco_cep.required' => 'O cep é obrigatório.',
        'tipo_acesso.required' => 'O tipo de acesso é obrigatório.',
        'tipo_chave.required' => 'O tipo de chave é obrigatório.',
        'tipo_equipamento.required' => 'O tipo de equipamento é obrigatório.',
        'nivel_prioridade.required' => 'O nível de prioridade é obrigatório.'
      ]);

      $site = new SitesModel();

      $site->empresa_id = $this->empresa->empresa_id;
      $site->nome_site = $request->nome_site;
      $site->endereco_rua = $request->endereco_rua;
      $site->endereco_numero = $request->endereco_numero;
      $site->endereco_cidade = $request->endereco_cidade;
      $site->endereco_estado = $request->endereco_estado;
      $site->endereco_cep = $request->endereco_cep;
      $site->tipo_acesso = $request->tipo_acesso;
      $site->tipo_chave = $request->tipo_chave;
      $site->tipo_equipamento = $request->tipo_equipamento;
      $site->nivel_prioridade = $request->nivel_prioridade;

      $site->save();

      return  response()->json(['message' => 'Site cadastrado com sucesso!', 'site' => $site], 201);
    } catch (\Exception $e) {
      return response()->json(['message' =>  $e->getMessage()], 500);
    }
  }

  public function atualizar(Request $request)
  {
    try {
      $site = SitesModel::find($request->site_id);
      $site->update($request->all());
      return  response()->json(['message' => 'Site atualizado com sucesso!', 'site' => $site], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao atualizar o site: ' . $e->getMessage()], 500);
    }
  }

  public function excluir(Request $request)
  {
    try {
      $site = SitesModel::find($request->site_id);
      $site->ativo = "0";
      $site->save();
      return  response()->json(['message' => 'Site excluído com sucesso!'], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao excluir o site: ' . $e->getMessage()], 500);
    }
  }

  public  function listar(Request $request)
  {
    try {
      $sites = SitesModel::where('ativo', '1')
        ->where('empresa_id', $this->empresa->empresa_id)
        ->get();
      return  response()->json(['sites' => $sites], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao listar os sites: ' . $e->getMessage()], 500);
    }
  }
}
