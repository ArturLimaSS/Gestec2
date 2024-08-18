<?php

namespace App\Http\Controllers\Atividades;

use App\Http\Controllers\Controller;
use App\Models\AtividadeAnexoModel;
use App\Models\QuestionarioModel;
use App\Models\TarefasModel;
use App\Models\TipoServicoModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    public  function  relatorio(Request $request)
    {
        try {
            $atividade = DB::table("tb_atividade")->select(
                "tb_atividade.atividade_id",
                "tb_atividade.atividade_nome",
                "tb_atividade.created_at AS atividade_created_at",
                "tb_atividade.atividade_descricao",
                "tb_atividade.responsavel_id",
                "tb_atividade.etapa_id",
                "tb_atividade.questionario_id",

                "tb_atividade.finalizado_em",
                "tb_atividade.atividade_conclusao",
                "tb_atividade.atividade_tipo",

                "tb_sites.site_id",
                "tb_sites.nome_site",
                "tb_sites.endereco_cep",
                "tb_sites.endereco_cidade",
                "tb_sites.endereco_estado",
                "tb_sites.endereco_numero",
                "tb_sites.endereco_rua",
                "tb_sites.nivel_prioridade",
                "tb_sites.tipo_acesso",
                "tb_sites.tipo_chave",
                "tb_sites.tipo_equipamento",
                "tb_tipo_equipamento.nome_tipo_equipamento",
                "tb_etapa.etapa_cor",
                "tb_etapa.etapa_descricao",
                "tb_etapa.etapa_id",
                "tb_etapa.etapa_nome",
                "tb_tipo_servico.nome_tipo_servico",
                "tb_tipo_servico.descricao_tipo_servico",
                "users.name as responsavel_nome"
            )
                ->leftJoin('tb_sites', 'tb_atividade.ativo_id', '=', 'tb_sites.site_id')
                ->leftJoin('tb_tipo_equipamento', 'tb_sites.tipo_equipamento', '=', 'tb_tipo_equipamento.id_tipo_equipamento')
                ->leftJoin('tb_etapa', 'tb_atividade.etapa_id', '=', 'tb_etapa.etapa_id')
                ->leftJoin('users', 'tb_atividade.responsavel_id', '=', 'users.id')
                ->leftJoin('tb_tipo_servico', 'tb_atividade.tipo_servico_id', '=', 'tb_tipo_servico.tipo_servico_id')
                ->where('tb_atividade.empresa_id', $this->user->empresa[0]->empresa_id)
                ->where('tb_atividade.atividade_id', $request->atividade_id)
                ->first();

            $anexos = AtividadeAnexoModel::where("atividade_id", $request->atividade_id)->get();





            // Dados agrupados
            $data = [
                "atividade" => $atividade,
                "endereco" => $atividade->endereco_cep . " " . $atividade->endereco_cidade . " " . $atividade->endereco_estado . " " . $atividade->endereco_numero . " " . $atividade->endereco_rua,
                "anexos" => $anexos,
                "empresa" =>  $this->user->empresa[0],
                "responsavel" => $atividade->responsavel_nome,
            ];

            if ($atividade->atividade_tipo == "ordem_servico") {
                // Dados  de  Questionário

                $questionario = QuestionarioModel::where("questionario_id", $atividade->questionario_id)->first();

                $tarefas = TarefasModel::where("questionario_id", $atividade->questionario_id)->get();

                $perguntas_respostas =
                    DB::table("tb_perguntas")
                    ->select(
                        "tb_perguntas.pergunta",
                        "tb_perguntas.tipo_resposta",
                        "tb_questionario_resposta.resposta",
                        "tb_perguntas.tarefa_id"
                    )
                    ->join("tb_questionario_resposta", "tb_perguntas.pergunta_id", "=", "tb_questionario_resposta.pergunta_id")
                    ->where("tb_questionario_resposta.atividade_id", $request->atividade_id)
                    ->get();

                $data["questionario"] = $questionario;
                $data["tarefas"] = $tarefas;
                $data["perguntas_respostas"] = $perguntas_respostas;
            }
            // return response()->json($data);

            $pdf = Pdf::loadView('pdfTemplate', $data);

            $pdf->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'setDpi' => 1000,
                ])
                ->setOption('margin-top', 0)
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0);


            $nome_arquivo = "atividade_" . $atividade->atividade_id . "_" . date('d_m_Y') . ".pdf";
            Storage::put('public/pdf/atividades/' . self::tirarAcentos(strtolower(str_replace(" ", "_", $this->user->empresa[0]->razao_social))) . $nome_arquivo, $pdf->output());

            $url = asset('https://apigestec2.qtsys.com.br/storage/pdf/atividades/' . self::tirarAcentos(strtolower(str_replace(" ", "_", $this->user->empresa[0]->razao_social))) . $nome_arquivo);
            return response()->json([
                "url" => $url,
                "message" => "PDF gerado com sucesso!"
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao gerar o relatório.', "error" => $e->getMessage()], 500);
        }
    }
}
