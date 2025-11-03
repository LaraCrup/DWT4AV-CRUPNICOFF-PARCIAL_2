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
        Schema::create('torta_tamano', function (Blueprint $table) {
            $table->id();
            $table->foreignId('torta_id')->constrained('tortas')->onDelete('cascade');
            $table->foreignId('tamano_id')->constrained('tamanos')->onDelete('cascade');
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('torta_tamanos');
    }
};
