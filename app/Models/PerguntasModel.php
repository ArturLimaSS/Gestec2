<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerguntasModel extends Model
{
    use HasFactory;
    protected $table = 'tb_perguntas';

    protected $primaryKey = 'pergunta_id';

    protected $fillable = [
        'tarefa_id',
        'empresa_id',
        'pergunta',
        'tipo_resposta',
        'checklist_id',
        'opcoes',
        'status',
        'created_at',
        'updated_at',
    ];
}
