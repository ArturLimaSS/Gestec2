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
            $table->field("atividade_id")->nullable();
            $table->field("user_id")->nullable();
            $table->field("file_name")->nullable();
            $table->field("file_path")->nullable();
            $table->field("file_description")->nullable();
            $table->field("status")->nullable();
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
