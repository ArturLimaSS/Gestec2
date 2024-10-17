<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoChaveModel extends Model
{
    use HasFactory;
    protected $table = "tb_tipo_chave";
    protected $primaryKey = 'tipo_chave_id';
    protected $fillable = [
        'tipo_chave_nome',
        'tipo_chave_descricao',
        'empresa_id'
    ];
}
