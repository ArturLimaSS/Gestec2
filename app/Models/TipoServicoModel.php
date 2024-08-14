<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicoModel extends Model
{
    use HasFactory;

    protected $table = 'tb_tipo_servico';
    protected $primaryKey = 'tipo_servico_id';
    protected $fillable = [
        'empresa_id',
        'nome_tipo_servico',
        'descricao_tipo_servico',
        'status',
    ];
}
