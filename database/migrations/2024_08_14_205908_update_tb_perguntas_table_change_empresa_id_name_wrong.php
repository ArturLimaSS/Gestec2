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
        Schema::table("tb_perguntas", function (Blueprint $table) {
            $table->renameColumn("emrpesa_id", "empresa_id");
            $table->enum('status', ['ativo', 'inativo'])->default('ativo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
