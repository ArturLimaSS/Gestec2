<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Hashing\HashManager;

class EmpresaUserModel extends Model
{
    use HasFactory;

    protected $fillable = ['empresa_id', 'user_id', 'cargo_id'];
    protected $table = 'tb_empresa_user';
    protected $primaryKey = 'id_empresa_user';

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(EmpresaModel::class, 'empresa_id', 'empresa_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
