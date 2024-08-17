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
        Schema::create('tb_atividade', function (Blueprint $table) {
            $table->id('atividade_id');
            $table->integer("tipo_servico_id")->nullable();
            $table->integer("questionario_id")->nullable();
            $table->string("atividade_nome")->nullable();
            $table->string("atividade_descricao")->nullable();
            $table->integer("tipo_atividade")->nullable();
            $table->integer("empresa_id");
            $table->integer("responsavel_id")->nullable();
            $table->integer("etapa_id")->nullable();
            $table->enum("status", ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_atividade');
    }
};
