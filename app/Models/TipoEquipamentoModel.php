<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipamentoModel extends Model
{
    use HasFactory;

    protected $table = 'tb_tipo_equipamento';
    protected $primaryKey = 'id_tipo_equipamento';
    protected $fillable = [
        'empresa_id',
        'nome_tipo_equipamento',
        'ativo'
    ];
}
