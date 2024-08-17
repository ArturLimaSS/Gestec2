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
        Schema::create('tb_etapa', function (Blueprint $table) {
            $table->id('etapa_id');
            $table->string("etapa_nome")->nullable();
            $table->string("etapa_descricao")->nullable();
            $table->string("etapa_cor")->nullable();
            $table->enum("etapa_tipo", ["cadastrada", "em_andamento", "concluida",  "cancelada"])->default("cadastrada")->nullable();
            $table->integer("empresa_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_etapa');
    }
};
