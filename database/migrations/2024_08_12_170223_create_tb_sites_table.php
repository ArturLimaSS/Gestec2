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
        Schema::create('tb_sites', function (Blueprint $table) {
            $table->id('site_id');
            $table->integer('empresa_id');
            $table->string('nome_site');
            $table->string('endereco_rua');
            $table->string('endereco_numero');
            $table->string('endereco_cidade');
            $table->string('endereco_estado', 2);
            $table->string('endereco_cep');
            $table->enum('tipo_acesso', ['restrito', 'publico', 'outro']);
            $table->enum('tipo_chave', ['fisica', 'eletronica', 'outro']);
            $table->text('tipo_equipamento');
            $table->enum('nivel_prioridade', ['alta', 'media', 'baixa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sites');
    }
};
