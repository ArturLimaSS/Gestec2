<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarefasModel extends Model
{
    use HasFactory;
    protected $table = 'tb_tarefas';
    protected $primaryKey = 'tarefa_id';
    protected $fillable = [
        'questionario_id',
        'nome_tarefa',
        'descricao_tarefa'
    ];
}
