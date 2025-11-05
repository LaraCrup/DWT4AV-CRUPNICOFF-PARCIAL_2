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
        Schema::table('tortas', function (Blueprint $table) {
            // Cambiar la restricción de clave foránea de cascade a restrict
            $table->dropForeign(['categoria_id']);
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tortas', function (Blueprint $table) {
            // Revertir al comportamiento anterior
            $table->dropForeign(['categoria_id']);
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }
};
