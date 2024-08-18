<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeModel extends Model
{
    use HasFactory;
    protected $table = "tb_atividade";
    protected $primaryKey =  'atividade_id';
    protected $fillable  = [
        'tipo_servico_id',
        'ativo_id',
        'questionario_id',
        'atividade_nome',
        'atividade_descricao',
        'atividade_endereco',
        'atividade_conclusao',
        'atividade_tipo',
        'tipo_atividade',
        'empresa_id',
        'responsavel_id',
        'finalizado_em',
        'etapa_id',
        'status',
    ];
}
