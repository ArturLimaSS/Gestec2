<?php

namespace App\Http\Controllers\Atividade;

use App\Http\Controllers\Controller;
use App\Models\AtividadeModel;
use App\Models\PerguntasModel;
use App\Models\RespostaModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtividadeController extends Controller
{

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->all();
            $data['empresa_id'] =  $this->user->empresa[0]->empresa_id;

            $atividade  = AtividadeModel::create($data);

            if (isset($request->questionario_id)) {
                $perguntas = PerguntasModel::where('questionario_id', $request->questionario_id)->get();
                foreach ($perguntas as $pergunta) {
                    $resposta = RespostaModel::create([
                        'questionario_id' => $request->questionario_id,
                        'atividade_id' => $atividade->atividade_id,
                        'pergunta_id' => $pergunta->pergunta_id,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['atividade' =>   $atividade], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function list(Request $request)
    {
        try {

            $query = DB::table("tb_atividade")
                ->select(
                    "tb_atividade.atividade_id",
                    "tb_atividade.atividade_nome",
                    "tb_atividade.created_at AS atividade_created_at",
                    "tb_atividade.atividade_descricao",
                    "tb_atividade.responsavel_id",
                    "tb_atividade.etapa_id",
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
                ->where('tb_atividade.empresa_id', $this->user->empresa[0]->empresa_id);

            if ($this->user->empresaUser[0]->cargo_id  == 2) {
                $query->where('tb_atividade.responsavel_id', $this->user->id);
            }
            $atividades  = $query->get();

            return response()->json(['atividades' =>  $atividades], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function atividadeDetail(Request $request)
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

            if ($atividade) {
                return response()->json(['atividade' => $atividade], 200);
            } else {
                return response()->json(['error' => 'Atividade não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
