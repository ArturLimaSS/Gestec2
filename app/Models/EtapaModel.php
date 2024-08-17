<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapaModel extends Model
{
    use HasFactory;

    protected $table = 'tb_etapa';
    protected $primaryKey = 'etapa_id';
    protected $fillable = [
        'etapa_nome',
        'etapa_descricao',
        'etapa_cor',
        'etapa_tipo',
        'empresa_id',
    ];
}
