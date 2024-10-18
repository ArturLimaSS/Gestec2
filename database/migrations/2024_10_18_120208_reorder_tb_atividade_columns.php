<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_atividade', function (Blueprint $table) {
            $table->renameColumn('status', 'ativo');
            $table->enum('atividade_tipo', ['ordem_servico', 'relatorio'])->after('etapa_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
