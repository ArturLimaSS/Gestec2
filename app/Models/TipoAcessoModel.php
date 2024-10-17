<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAcessoModel extends Model
{
    use HasFactory;
    protected $table = 'tb_tipo_acesso';
    protected $primaryKey = 'tipo_acesso_id';
    protected $fillable =  [
        'tipo_acesso_nome',
        'tipo_acesso_descricao',
        'empresa_id',
    ];
}
