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
        Schema::create('tb_questionario_resposta', function (Blueprint $table) {
            $table->id('resposta_id');
            $table->integer('questionario_id');
            $table->integer('atividade_id');
            $table->integer('pergunta_id');
            $table->text('resposta')->nullable();
            $table->integer('atualizado_por')->nullable();
            $table->enum('status', ['ativo', 'inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_questionario_resposta');
    }
};
