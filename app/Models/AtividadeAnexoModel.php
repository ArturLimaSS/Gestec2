<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeAnexoModel extends Model
{
    use HasFactory;
    protected  $table = 'tb_atividade_anexo';
    protected $primaryKey = 'anexo_id';
    protected $fillable = [
        'atividade_id',
        'user_id',
        'nome_arquivo',
        'caminho_arquivo',
        'descricao',
        'status',
    ];
}
