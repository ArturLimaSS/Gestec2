<?php

namespace App\Http\Controllers\Atividades;

use App\Http\Controllers\Controller;
use App\Models\AtividadeAnexoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AtividadesAnexo extends Controller
{
    public function list(Request $request)
    {
        $osFiles = AtividadeAnexoModel::where("atividade_id", $request->atividade_id)
            ->where("status", "1")
            ->get();
        return response()->json([
            "files" => $osFiles
        ]);
    }
    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();

                $atividade_id = $request->atividade_id;
                $empresa = $this->user->empresa[0]->empresa_nome;
                $date = now()->format('d_m_Y');
                $time = now()->format('H_i_s');

                $fileName = "anexo_atividade_id_{$atividade_id}_{$date}_{$time}_" . str_replace(' ', '_', $empresa) . '.' . $extension;

                // Redimensionar a imagem
                $image = Image::make($file);
                $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Salvar a imagem redimensionada
                $filePath = 'uploads/' . $fileName;
                $image->save(storage_path('app/public/' . $filePath));

                $atividade_anexo = AtividadeAnexoModel::create([
                    "atividade_id" => $atividade_id,
                    "user_id" => auth()->user()->id,
                    "file_name" => $fileName,
                    "file_path" => "storage/" . $filePath,
                    "file_description" => $request->description,
                    "status" => '1'
                ]);

                return response()->json([
                    'message' => 'Arquivo enviado com sucesso!',
                    'anexo' => $atividade_anexo
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao enviar o arquivo.', "error" => $e->getMessage()], 500);
        }
    }
    public function delete(Request $request)
    {
        $osFiles = AtividadeAnexoModel::find($request->id);
        $osFiles->update(["status" => '0']);
        File::delete($osFiles->file_name);
        return response()->json([
            "message" => "Arquivo deletado com sucesso!",
            "osFiles" => $osFiles
        ]);
    }

    public function update(Request $request)
    {
        $osFiles = AtividadeAnexoModel::find($request->id);
        $osFiles->update(["file_description" => $request->file_description]);
        return response()->json([
            "message" => "Arquivo atualizado com sucesso!",
            "osFiles" => $osFiles
        ], 200);
    }
}
