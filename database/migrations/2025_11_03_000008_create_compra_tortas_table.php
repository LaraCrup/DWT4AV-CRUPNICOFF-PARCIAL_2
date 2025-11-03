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
    Schema::create('compra_torta', function (Blueprint $table) {
        $table->id();

        $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
        $table->foreignId('torta_id')->constrained('tortas')->onDelete('cascade');
        $table->foreignId('tamano_id')->constrained('tamanos')->onDelete('cascade');

        $table->integer('cantidad')->default(1);
        $table->decimal('precio_unitario', 10, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_torta');
    }
};
