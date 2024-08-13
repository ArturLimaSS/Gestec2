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
        Schema::create('tb_empresa', function (Blueprint $table) {
            $table->id('empresa_id');
            $table->integer('responsavel_id');
            $table->string("razao_social")->nullable();
            $table->string("nome_fantasia")->nullable();
            $table->string("cnpj")->nullable();
            $table->string("logradouro")->nullable();
            $table->string("numero")->nullable();
            $table->string("complemento")->nullable();
            $table->string("bairro")->nullable();
            $table->string("cidade")->nullable();
            $table->string("estado")->nullable();
            $table->string("cep")->nullable();
            $table->string("email")->nullable();
            $table->string("site")->nullable();
            $table->string("inscricao_estadual")->nullable();
            $table->string("telefone")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_empresa');
    }
};
