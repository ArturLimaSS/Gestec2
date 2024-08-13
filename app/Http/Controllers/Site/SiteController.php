<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SitesModel;
use Illuminate\Http\Request;

class SiteController extends Controller
{
  public function create(Request $request)
  {
    try {
      $site = SitesModel::create($request->all());
      return  response()->json(['message' => 'Site cadastrado com sucesso!', 'site' => $site], 201);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao cadastrar o site: ' . $e->getMessage()], 500);
    }
  }

  public function update(Request $request)
  {
    try {
      $site = SitesModel::find($request->id);
      $site->update($request->all());
      return  response()->json(['message' => 'Site atualizado com sucesso!', 'site' => $site], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao atualizar o site: ' . $e->getMessage()], 500);
    }
  }

  public function delete(Request $request)
  {
    try {
      $site = SitesModel::find($request->id);
      $site->ativo = "0";
      $site->save();
      return  response()->json(['message' => 'Site excluído com sucesso!'], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao excluir o site: ' . $e->getMessage()], 500);
    }
  }

  public function list(Request $request)
  {
    try {
      $sites = SitesModel::where('ativo', '1')->where('empresa_id', $request->empresa_id)->get();
      return  response()->json(['sites' => $sites], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Ocorreu um erro ao listar os sites: ' . $e->getMessage()], 500);
    }
  }
}
