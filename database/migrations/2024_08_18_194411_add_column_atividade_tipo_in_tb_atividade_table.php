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
        Schema::table('tb_atividade', function (Blueprint $table) {
            $table->enum("atividade_tipo",  ['relatorio', 'ordem_servico']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_atividade', function (Blueprint $table) {
            //
        });
    }
};
