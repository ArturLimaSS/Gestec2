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
        Schema::table('tb_perguntas', function (Blueprint $table) {
            $table->string('pergunta')->nullable()->change();
            $table->enum('tipo_resposta', ['checkbox', 'select', 'text', 'number', 'switch', 'radio'])->default('text')->nullable()->change();
            $table->string('opcoes')->default('N/A')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_perguntas', function (Blueprint $table) {
            //
        });
    }
};
