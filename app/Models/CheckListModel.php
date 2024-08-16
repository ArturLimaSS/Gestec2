<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListModel extends Model
{
    use HasFactory;

    protected $table = 'tb_checklists';
    protected $primaryKey = 'checklist_id';
    protected $fillable = [
        "nome",
        "descricao",
        "tipo_serviço_id",
        "empresa_id",
        "status"
    ];
}
