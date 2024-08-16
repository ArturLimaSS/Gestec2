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
            $table->enum("status", ["pendente", "ativo", "inativo"])->default("pendente")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_column_tb_checklists', function (Blueprint $table) {
            //
        });
    }
};
