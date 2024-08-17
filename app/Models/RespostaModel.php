<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespostaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_questionario_resposta';
    protected $primaryKey = 'resposta_id';
    protected $fillable =  [
        'questionario_id',
        'atividade_id',
        'pergunta_id',
        'resposta',
        'atualizado_por',
        'status'
    ];
}
