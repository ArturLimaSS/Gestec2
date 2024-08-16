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
        Schema::table('tb_tarefas', function (Blueprint $table) {
            $table->integer('checklist_id')->nullable()->change();
            $table->string('nome_tarefa')->nullable()->change();
            $table->string('descricao_tarefa')->nullable()->change();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_tarefas', function (Blueprint $table) {
            //
        });
    }
};
