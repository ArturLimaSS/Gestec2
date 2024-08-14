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
        Schema::create('tb_tipo_servico', function (Blueprint $table) {
            $table->id('tipo_servico_id');
            $table->integer('empresa_id');
            $table->string('nome_tipo_servico');
            $table->string('descricao_tipo_servico');
            $table->enum('status', ['ativo', 'inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tipo_servico');
    }
};
