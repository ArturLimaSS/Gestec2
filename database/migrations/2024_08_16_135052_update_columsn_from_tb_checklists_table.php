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
        Schema::table('tb_checklists', function (Blueprint $table) {
            $table->string("nome")->nullable()->change();
            $table->string("descricao")->nullable()->change();
            $table->integer("tipo_serviço_id")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_checklists', function (Blueprint $table) {
            //
        });
    }
};
