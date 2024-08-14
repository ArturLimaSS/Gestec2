<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoModel extends Model
{
    use HasFactory;

    protected $table = 'tb_cargo';
    protected $primaryKey = 'id_cargo';
    protected $fillable = [
        'empresa_id',
        'descricao_cargo',
        'nome_cargo',
    ];
}
