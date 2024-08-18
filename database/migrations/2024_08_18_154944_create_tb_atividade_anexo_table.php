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
        Schema::create('tb_atividade_anexo', function (Blueprint $table) {
            $table->id('anexo_id');
            $table->integer("atividade_id")->nullable();
            $table->integer("user_id")->nullable();
            $table->string("nome_arquivo")->nullable();
            $table->string("caminho_arquivo")->nullable();
            $table->string("descricao")->nullable();
            $table->enum("status", ['0',  '1'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_atividade_anexo');
    }
};
