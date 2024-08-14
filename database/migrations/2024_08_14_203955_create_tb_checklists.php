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
        Schema::create('tb_checklists', function (Blueprint $table) {
            $table->id('checklist_id');
            $table->string("nome");
            $table->string("descricao");
            $table->integer("tipo_serviço_id");
            $table->integer("empresa_id");
            $table->enum('status', ['ativo', 'inativo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_checklists');
    }
};
