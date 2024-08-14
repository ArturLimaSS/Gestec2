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
        Schema::create('tb_tarefas', function (Blueprint $table) {
            $table->id('tarefa_id');
            $table->integer('checklist_id');
            $table->string('nome_tarefa');
            $table->string('descricao_tarefa');
            $table->enum('status', ['ativo', 'inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tarefas');
    }
};
