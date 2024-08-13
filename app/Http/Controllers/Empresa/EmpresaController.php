<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\EmpresaModel;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function update(Request $request)
    {
        try {
            $empresa = EmpresaModel::find($request->empresa_id);
            if ($empresa) {
                $empresa->update($request->all());
                return response()->json(['message' => 'Empresa atualizada com sucesso!', 'empresa' => $empresa], 200);
            } else {
                return response()->json(['error' => 'Empresa não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
