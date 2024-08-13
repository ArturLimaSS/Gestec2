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
        Schema::create('tb_empresa_user', function (Blueprint $table) {
            $table->id('id_empresa_user');
            $table->integer('empresa_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('cargo_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_empresa_user');
    }
};
