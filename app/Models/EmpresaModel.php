<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    use HasFactory;

    protected $table = 'tb_empresa';
    protected $primaryKey = 'empresa_id';
    protected $fillable = [
        'responsavel_id',
        "razao_social",
        "nome_fantasia",
        "logomarcar",
        "cnpj",
        "logradouro",
        "numero",
        "complemento",
        "bairro",
        "cidade",
        "estado",
        "cep",
        "email",
        "site",
        "inscricao_estadual",
        "telefone",
    ];
}
