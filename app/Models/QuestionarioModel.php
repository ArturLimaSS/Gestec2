<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionarioModel extends Model
{
    use HasFactory;

    protected $table = 'tb_questionario';
    protected $primaryKey = 'questionario_id';
    protected $fillable = [
        "nome",
        "descricao",
        "tipo_servico_id",
        "empresa_id",
        "status"
    ];
}
