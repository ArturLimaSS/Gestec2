<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\EmpresaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EmpresaController extends Controller
{
    public function update(Request $request)
    {
        try {
            $empresa = EmpresaModel::find($this->user->empresa[0]->empresa_id);
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

    public function logo(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');



                $empresa = EmpresaModel::find($this->user->empresa[0]->empresa_id);
                $extension = $file->getClientOriginalExtension();
                $razao_social = str_replace(' ', '_', $empresa->razao_social);
                $nome_arquivo = "logo_marca_" . $razao_social . '.' . $extension;

                // Redimensionar a imagem (ajuste conforme necessário)
                $image = Image::make($file)->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Caminho do diretório onde o arquivo será salvo
                $pasta = 'uploads/logo/' . $razao_social;

                // Armazenar a imagem redimensionada
                $filePath = $pasta . '/' . $nome_arquivo;
                Storage::put("public/$filePath", (string) $image->encode());

                // Armazenar o caminho da imagem no banco de dados (caminho relativo)
                $empresa->logomarcar = "storage/$filePath";
                $empresa->save();

                return response()->json([
                    'message' => 'Arquivo enviado com sucesso!',
                    'empresa' => $empresa
                ]);
            } else {

                return response()->json(['error' => 'Nenhum arquivo foi enviado'], 400);
            }
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
