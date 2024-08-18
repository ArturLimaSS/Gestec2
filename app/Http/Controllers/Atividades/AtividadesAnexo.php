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
        $anexos = AtividadeAnexoModel::where("atividade_id", $request->atividade_id)
            ->where("status", "1")
            ->get();
        return response()->json([
            "anexos" => $anexos
        ]);
    }
    public function upload(Request $request)
    {
        try {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();

                $atividade_id = $request->atividade_id;
                $razao_social = strtolower(str_replace(' ', '_', self::tirarAcentos($this->user->empresa[0]->razao_social)));

                $date = now()->format('d_m_Y');
                $time = now()->format('H_i_s');

                $nome_arquivo = "anexo_atividade_id_{$atividade_id}_{$date}_{$time}_" . str_replace(' ', '_', $razao_social) . '.' . $extension;

                // Caminho do diretório onde o arquivo será salvo
                $pasta = storage_path('app/public/uploads/' . str_replace(' ', '_', $razao_social));

                // Verifica se o diretório existe, se não, cria o diretório
                if (!File::exists($pasta)) {
                    File::makeDirectory($pasta, 0755, true);
                }

                // Redimensionar a imagem
                $image = Image::make($file);
                $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Salvar a imagem redimensionada
                $filePath = $pasta . '/' . $nome_arquivo;
                $image->save($filePath);

                // Armazenar no banco de dados
                $atividade_anexo = AtividadeAnexoModel::create([
                    "atividade_id" => $atividade_id,
                    "user_id" => auth()->user()->id,
                    "nome_arquivo" => $nome_arquivo,
                    "caminho_arquivo" => "storage/uploads/" . str_replace(' ', '_', $razao_social) . '/' . $nome_arquivo,
                    "descricao" => $request->descricao,
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
        try {
            $arquivo = AtividadeAnexoModel::find($request->arquivo_id);
            $arquivo->update(["status" => '0']);
            File::delete($arquivo->nome_arquivo);
            return response()->json([
                "message" => "Arquivo deletado com sucesso!",
                "osFiles" => $arquivo
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao deletar o arquivo.', "error" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $arquivo = AtividadeAnexoModel::find($request->anexo_id);
            $arquivo->update(["descricao" => $request->descricao]);
            return response()->json([
                "message" => "Arquivo atualizado com sucesso!",
                "arquivo" => $arquivo
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao atualizar o arquivo.', "error" => $e->getMessage()], 500);
        }
    }
}
