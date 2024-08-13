<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitesModel extends Model
{
    use HasFactory;

    protected $table = 'tb_sites';
    protected $primaryKey = 'site_id';

    protected $fillable = [
        'empresa_id',
        'nome_site',
        'endereco_rua',
        'endereco_numero',
        'endereco_cidade',
        'endereco_estado',
        'endereco_cep',
        'tipo_acesso',
        'tipo_chave',
        'tipo_equipamento',
        'nivel_prioridade',
    ];
}
