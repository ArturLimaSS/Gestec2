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
        Schema::create('tb_perguntas', function (Blueprint $table) {
            $table->id('pergunta_id');
            $table->integer('tarefa_id');
            $table->integer('emrpesa_id');
            $table->string('pergunta');
            $table->enum('tipo_resposta', ['checkbox', 'select', 'text', 'number', 'switch', 'radio']);
            $table->string('opcoes')->default('N/A')->nullable();
            $table->enum('status', ['ativo', 'inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_perguntas');
    }
};
